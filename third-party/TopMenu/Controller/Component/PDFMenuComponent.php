<?php
/**
 *   _____                                                                       
 *  /__   \  ___   _ __     /\/\    ___  _ __   _   _      ___   ___   _ __ ___  
 *    / /\/ / _ \ | '_ \   /    \  / _ \| '_ \ | | | |    / __| / _ \ | '_ ` _ \ 
 *   / /   | (_) || |_) | / /\/\ \|  __/| | | || |_| | _ | (__ | (_) || | | | | |
 *   \/     \___/ | .__/  \/    \/ \___||_| |_| \__,_|(_) \___| \___/ |_| |_| |_|
 *                |_|                                                                                           
 *               
 * @copyright     Copyright (c) Top Menu Web, Inc. (https://www.topmenu.com) & Respective Owners
 * @link          https://www.topmenu.com/ Top Menu Web Inc.
 * @version 	  2
 *                                                                   
 */

App::uses('Component', 'Controller');
App::uses('ClassRegistry', 'Utility');

/**
 * PDFMenuComponent
 * Processes uploaded PDF Menus
 */
class PDFMenuComponent extends Component {

/**
 * Components we'll be using
 * @var array
 */
	public $components = array('Session', 'Image', 'Pdf');


/**
 * If set to true, don't actually process any files
 * @var boolean
 */
	public $dry_run = false;

/**
 * Instance of the model we're dealing with
 * @var Model
 */
	private $model;

/**
 * Instance of the controller
 * @var Controller
 */
	private $controller;

/**
 * Instance of the request
 * @var CakeRequest
 */
	private $request;


/**
 * Instance of the File model which acts
 * as a registry we can compare against for 
 * files with no home. this will make keeping our hdd clean
 * much easier.
 */
	private $FileModel = false;

/**
 * Initializes some member properties
 * The initialize method is called before the controller’s beforeFilter method.
 * @param  Controller $controller Instance of the controller, passed automatically
 * @return void
 */
	public function initialize(Controller $controller, $dry_run = false) {
		parent::initialize($controller);

		$model_name       = Inflector::singularize($controller->name);
		$this->model      = $controller->{$model_name};
		$this->controller = $controller;
		$this->request    = $controller->request;
		$this->FileModel  = ClassRegistry::init('UploadedFile');
		
		if ($dry_run !== null)
			$this->dry_run  = $dry_run;
	}

/**
 * Startup function gets run after the controller's beforeFilter, but before
 * the controller code gets called. 
 * See: http://book.cakephp.org/2.0/en/controllers/components.html#callbacks
 * @param  Controller $controller Instance of Controller
 * @return void
 */
	public function beforeRender(Controller $controller) {
		$named = $controller->request->params['named'];

		if (array_key_exists('delete_pdf', $named)) {
			if (!$controller->request->is('post') && !$controller->request->is('put')) {
				$model_name = Inflector::singularize($controller->name);
				if ($this->delete($named['delete_pdf'])) {
					$this->Session->setFlash(
						__('PDF Deleted!'),
						'default',
						array('class' => 'flash_success')
					);
				}
			}
		}
		parent::beforeRender($controller);
	}

/**
 * Helps a controller process an uploaded file
 * The idea is that it's reusable and callable in any
 * Controller action where this Component is included
 * @param  string      $field   field name in the database
 * @return boolean               True on success, False on failure
 */
	public function process($field) {
		if (strpos($field, '.')) {
			$field = explode('.', $field);
			$this->model = $this->controller->{$field[0]};
			$field = $field[1];
		}
		$model_name = $this->model->name;

		if ($this->dry_run) {
			if (isset($this->request->data[$model_name][$field])) {
				unset($this->request->data[$model_name][$field]);
			}
			return true;
		}

		if (isset($this->request->data[$model_name][$field]['error'])) {
			$error = $this->request->data[$model_name][$field]['error'];
		} else {
			$error = false;
		}

		if ($this->model->id && $this->model->exists()) {
			$edit = true;
		} else { 
			$edit = false;
		}

		if ($edit) {
			$old_pdf = $this->model->read($field);
			$old_pdf = $old_pdf[$model_name][$field];
		} else {
			$old_pdf = null;
		}


		if (!empty($this->request->data[$model_name][$field]['tmp_name'])) {
			if (!file_exists($this->request->data[$model_name][$field]['tmp_name'])) {

				$this->model->invalidate($field, __('File does not exist!'));
				unset($this->request->data[$model_name][$field]);
				return false;

			} elseif ( is_dir($this->request->data[$model_name][$field]['tmp_name']) ) {

				$this->model->invalidate($field, __('Directory encountered'));
				unset($this->request->data[$model_name][$field]);
				return false;

			}

			if ($error) {
				$this->model->invalidate($field, __('There was an error uploading your PDF! Is it too big?'));
				if ($edit) {
					$this->request->data[$model_name][$field] = $old_pdf;
				} else {
					$this->request->data[$model_name][$field] = ''; 
				}
				return false;
			}


			$file = $this->request->data[$model_name][$field];
			unset($this->request->data[$model_name][$field]);

			$new_name = $this->processPDF($file['tmp_name'], $old_pdf);
			
			if (!$new_name) {
				if ($edit) {
					$this->request->data[$model_name][$field] = $old_pdf;
				} else {
					$this->request->data[$model_name][$field] = ''; 
				}
				$this->model->invalidate($field, __('There was a problem validating your PDF.'));
				return false;
			}
			$this->request->data[$model_name][$field] = $new_name;
			$this->FileModel->addFile($new_name, 'pdf', $model_name . '.' . $field, $this->model->id);


			if ($this->model->id && $this->model->exists())
				$this->model->saveField($field, $new_name);


		} else {
			if ($edit) {
				$this->request->data[$model_name][$field] = $old_pdf;
			} else {
				unset($this->request->data[$model_name][$field]);
			}			
		}
		return true;
	}

/**
 * Call this after successfully creating a record.
 * This will set the forign key of the record related to the PDF
 * in the File registry
 * 
 * @param  string $id          UUID of the PDF
 * @param  string $foreign_key UUID of the record
 */
	public function finishCreate($id, $foreign_key) {
		$this->FileModel->setForeignKey($id, $foreign_key);
	}

/**
 * Function to handle deleting a file, and removing the entry
 * from the request object
 * @param  Model       $model   Instance of the model
 * @param  string      $field   field name in question
 * @param  CakeRequest $request Instance of the request object
 * @return bool             	true on success, false on failure
 */
	public function delete($field) {
		if ($this->dry_run) {
			return true;
		}
		if (strpos($field, '.')) {
			$field = explode('.', $field);
			$this->model = $this->controller->{$field[0]};
			$field = $field[1];
		}
		$model_name = $this->model->name;
		$id = '';

		if (
			isset($this->request->data[$model_name])
			&& array_key_exists($field, $this->request->data[$model_name]
		)) {
			$id = $this->request->data[$model_name][$field];
		} else {
			return false;
		}
		

		if ($this->_deletePDF($id)) {
			if ($this->model->id && $this->model->exists())
				$this->model->saveField($field, null);
			unset($this->request->data[$model_name][$field]);
			return true;
		}

		return false;
	}

/**
 * Processes an uploaded pdf
 * @param  string $pdf     location of pdf
 * @param  string $old_pdf location of old pdf
 * @param  string $prefix    prefix to prepend to new filename
 * @return string            new filename
 */
	private function processPDF($pdf, $old_pdf = null, $prefix = null) {
		$generate_pdf = false;
		if (!$this->verify_pdf($pdf)) {
			if (!$this->Image->verify_image($pdf)) {
				return false;
			} else {
				$generate_pdf = true;
			}
		}

		
		if ($prefix === null) {
			$prefix = Configure::read('Topmenu.pdfs');
		}
		$new_name_uuid = $this->generate_name($prefix);
		$new_name      = $prefix . $new_name_uuid . '.pdf';
		$old_pdf_name  = $prefix . $old_pdf . '.pdf';

		if (!$generate_pdf) {
			copy($pdf, $new_name);
		} else {
			$pdf = file_get_contents($pdf);
			$pdf = $this->_generatePdf($pdf);

			$this->_writePdf($new_name, $pdf);
		}

		if (file_exists($old_pdf_name) && $old_pdf != '') {
			$this->FileModel->deleteFile($old_image_name);
			unlink($old_pdf_name);
		}
		
		return $new_name_uuid;

	}





/**
 * Verifies that an uploaded file is actually a pdf
 * @param  string $pdf location of pdf
 * @return bool        true on success, false on fail
 */
	public function verify_pdf($pdf) {

		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mime = finfo_file($finfo, $pdf); 

		if ($mime == 'application/pdf')
			return true;
		return false;
	}




/**
 * Generates a unique filename for storing pdfs
 * @param  string $prefix optional prefix to prepend to the filename
 * @return string         filename
 */
	private function generate_name($prefix = null) {
		$path = '';
		if ($prefix !== null) {
			$path .= $prefix;
		}

		while(1) {
			$string = String::uuid();
			$found = false;
			$filename = $path . $string . '.pdf';
			if (!file_exists($filename)) {
				break;
			}

		}
		return $string;
	}


/**
 * Deletes a PDF from disk
 * @param  uuid   $id  	  PDF's UUID
 * @param  path   $prefix optional, uses core.php value if not set
 * @return bool   true on success, false on failure
 */
	private function _deletePDF($id, $prefix = null) {
		
		if ($prefix === null) {
			$prefix = Configure::read('Topmenu.pdfs');
		}
		
		$extention = '.pdf';
		$name_dimentions = $prefix . $id . $extention;
		
		
		if (file_exists($name_dimentions)) {
			if (!unlink($name_dimentions)) {
				return false;
			}
			$this->FileModel->deleteFile($id);
			return true;
		} else {
			return false;
		}
		return false;
	}

/**
 * Writes a PDF to disk
 * @param  string $destination Full path
 * @param  string $data        Data to write
 * @return bool              True on success, False on failure
 */
	private function _writePdf($destination, $data) {
		if (file_put_contents($destination, $data) !== false) {
			return true;
		}
		return false;
	}

/**
 * Handles generating a PDF
 * @param  string $image Raw image data
 * @return string        PDF Data
 */
	private function _generatePdf($image) {

		 

		$size  = getimagesizefromstring($image);
		$image = imagecreatefromstring($image);

		ob_start();
		imagejpeg($image);		
		$image = ob_get_clean();



  
		$width       = $size[0];  
		$height      = $size[1]; 
		 
		$this->Pdf->create($height, $width)
				  ->addPage()
				  ->setJPEGQuality(100)
				  ->image($image);
		
 

		return $this->Pdf->output(); 
	}
	
	
}
