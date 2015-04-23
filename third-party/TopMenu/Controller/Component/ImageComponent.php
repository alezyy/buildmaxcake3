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
 * ImageComponent
 * Processes uploaded images
 */
class ImageComponent extends Component {

/**
 * Components we'll be using
 * @var array
 */
	public $components = array('Session');

/**
 * If set to true, don't actually process any files
 */
	private $dry_run = false;
/**
 * Sizes we're going to resize images into by default.
 * Also what we look for when deleting images.
 * @var array
 */
	private $sizes = array(
		'64x64',
		'72x123',		
		'120x120',
		'250x250',
		'331x331',
		'514x514',
		'700x700',
		'1280x1280'
	);

/**
 * Instance of the model we're dealing with
 * @var Model
 */
	private $model = false;

/**
 * Instance of the controller
 * @var Controller
 */
	private $controller = false;

/**
 * Instance of the request
 * @var CakeRequest
 */
	private $request = false;

/**
 * Instance of the File model which acts
 * as a registry we can compare against for 
 * files with no home. this will make keeping our hdd clean
 * much easier.
 */
	private $FileModel = false;

/**
 * Original Extension of the file
 * @var [type]
 */
	private $original_extension;


/**
 * Initializes some member properties
 * The initialize method is called before the controller’s beforeFilter method.
 * @param  Controller $controller Instance of the controller, passed automatically
 * @return void
 */
	public function initialize(Controller $controller, $dry_run = null) {
		parent::initialize($controller);

		$model_name       = Inflector::singularize($controller->name);
		$this->model      = $controller->{$model_name};
		$this->controller = $controller;
		$this->request    = $controller->request;
		$this->FileModel  = ClassRegistry::init('UploadedFile');


		if ($dry_run !== null) {
			$this->dry_run  = $dry_run;
		}

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

		if (array_key_exists('delete_image', $named)) {
			if (!$this->controller->request->is('post') && !$this->controller->request->is('put')) {
				
				if ($this->delete($named['delete_image'])) {
					$this->Session->setFlash(
						__('Image Deleted!'),
						'flash_success'
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
 * 
 * @param  string	$field      field name in the database
 * @param  array	$sizes      add another to size to the default images size<br/>
 *                              array key is the dimension ex.: '514x514'
 *                              array value is the name of the dimension
 * @param string    $fullPath   Path where file will be save (defaults to Uploads)
 * @return boolean			True on success, False on failure
 */
	public function process($field, $sizes = array(), $fullPath = "") {
		if (strpos($field, '.')) {
			$field = explode('.', $field);
			$this->model = $this->controller->{$field[0]};
			$field = $field[1];
		}
		$model_name = $this->model->name;

		foreach ($sizes as $size) {
			$this->sizes[] = $size;
		}

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
			$old_image = $this->model->read($field);
			$old_image = $old_image[$model_name][$field];
		} else {
			$old_image = null;
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

				$this->model->invalidate($field, __('There was an error uploading your image! Is it too big?'));
				if ($edit) {
					$this->request->data[$model_name][$field] = $old_image;
				} else {
					$this->request->data[$model_name][$field] = ''; 
				}
				return false;

			}


			$file = $this->request->data[$model_name][$field];
			unset($this->request->data[$model_name][$field]);
			
			$new_name = $this->processImage($file['tmp_name'], $old_image, null, $fullPath);
			
			if (!$new_name) {
				if ($edit) {
					$this->request->data[$model_name][$field] = $old_image;
				} else {
					$this->request->data[$model_name][$field] = ''; 
				}
				$this->model->invalidate($field, __('There was a problem validating your image.'));
				return false;
			}
			$this->request->data[$model_name][$field] = $new_name;
			$this->FileModel->addFile(
				$new_name,
				'image',
				$model_name . '.' . $field, $this->model->id,
				$this->original_extension
			);

			if ($this->model->id && $this->model->exists())
				$this->model->saveField($field, $new_name);


			
		} else {
			if ($edit) {
				$this->request->data[$model_name][$field] = $old_image;
			} else {
				unset($this->request->data[$model_name][$field]);
			}			
		}
		return true;
	}

/**
 * Call this after successfully creating a record.
 * This will set the forign key of the record related to the image
 * in the File registry
 * 
 * @param  string $id          UUID of the image
 * @param  string $foreign_key UUID of the record
 */
	public function finishCreate($id, $foreign_key) {
		$this->FileModel->setForeignKey($id, $foreign_key);
	}

/**
 * Function to handle deleting a file, and removing the entry
 * from the request object
 * 
 * @param  string      $field   field name in question
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
			array_key_exists($model_name, $this->request->data)
			&& array_key_exists($field, $this->request->data[$model_name])
		) {
			$id = $this->request->data[$model_name][$field];
		} else {
			return false;
		}
		
		$this->model->id = $this->request->data[$model_name]['id'];

		if ($this->_deleteImage($id)) {
			if ($this->model->id && $this->model->exists()) {
				$this->model->saveField($field, '');
			}
			unset($this->request->data[$model_name][$field]);
			return true;
		}

		return false;
	}

/**
 * Processes an uploaded image
 * @param  string $image     location of image
 * @param  string $old_image location of old image
 * @param  string $prefix    prefix to prepend to new filename
 * @return string            new filename
 * @todo Check if the prefix argument is really needed
 */
	public function processImage($image, $old_image = null, $prefix = null, $fullPath) {
		$imageMime = $this->verify_image($image);
		if (!$imageMime) {
			return false;
		}
		$extension = explode('/', $imageMime);
		$extension = $extension[1];

		$this->original_extension = $extension;
		

		$new_name = $this->generate_name($prefix);
     //   $new_name = $fullPath;

		if ($prefix === null) {
			$prefix = Configure::read('Topmenu.images');
		}

		$original_image = $prefix . $new_name . '_original.' .$extension;

		copy($image, $original_image);


		$this->autoRotate($original_image);

		foreach ($this->sizes as $dimension) {
			if ($dimension !== 'original') {
				$dimensions = explode('x', $dimension);

				if (sizeof($dimensions) < 2) {
					return false;
				}

				$x = $dimensions[0];
				$y = $dimensions[1];
			}

			
			
			$extention           = '.jpg';
		//	$new_name_dimensions = DS .$fullPath . '_' . $dimension . $extention;  
		//	$new_name_dimensions = "/home/topmenu2/topmenu/app/webroot/img" . $new_name_dimensions;
                        $new_name_dimensions = $prefix . $new_name . '_' . $dimension . $extention;
			$old_image_name      = $prefix . $old_image . '_' . $dimension . $extention;
			
            $this->log($original_image);    
            $this->log($new_name_dimensions);    

			$this->resize_image($original_image, $x, $y, $new_name_dimensions); // this resizes and then save the images with the dimension as a suffix
			$this->convertTojpeg($new_name_dimensions, $new_name_dimensions);
				

			

			if (file_exists($old_image_name) && $old_image != '') {
				$this->FileModel->deleteFile($old_image_name);
				unlink($old_image_name);
			}
		}
		return $new_name;

	}

/**
 * Resizes an existing image
 * @param  string $image              UUID of the image
 * @param  string $original_extension Original file extension
 * @param  int    $new_x              New X dimension
 * @param  int    $new_y              New Y dimension
 * @return void
 */
	public function resizeImage($image, $original_extension , $new_x, $new_y) {


		$prefix = Configure::read('Topmenu.images');


		$original_image = $prefix . $image . '_original.' . $original_extension;


		$extention           = '.jpg';
		$new_name_dimensions = $prefix . $image . '_' . $new_x . 'x' . $new_y . '.' . $extention;


		$this->resize_image($original_image, $new_x, $new_y, $new_name_dimensions);
		$this->convertTojpeg($new_name_dimensions, $new_name_dimensions);


	}


/**
 * Rotates an image if it's orientation data has been set
 * @param  string $image path to file
 */
	private function autoRotate($image) {
		$exif = @exif_read_data($image);
		if ($exif && is_array($exif) && isset($exif['Orientation'])) {
			$orientation = $exif['Orientation'];
			switch($orientation)
			{
				case 8: 
                    $this->rotateImage($image, 90, 0); 
                    break; 
                case 3: 
                    $this->rotateImage($image, 180, 0); 
                    break; 
                case 6: 
                    $this->rotateImage($image, -90, 0); 
                    break; 
			}
		}

	}


/**
 * Does the actual rotation
 * @param  string $image    path to file
 * @param  int $rotation    Degree of rotation
 * @param  int $colour      Specifies the color of the uncovered zone after the rotation
 * @return string           image path
 */
	private function rotateImage($image, $angle, $colour) {
		// Processing jpegs is very expensive
		// Unfortunately we have no choice, iOS devices will
		// upload images rotated 90 degrees if we don't rotate them
		// based on the exif data
		// 
		// This only happens if we have a jpeg anyway.
		ini_set('memory_limit', '512M');

		$source  = imagecreatefromjpeg($image);
		$rotated = imagerotate($source, $angle, $colour);

		imagejpeg($rotated, $image);
		return $image;
	}


/**
 * Resizes an image and returns a base64 encoded string
 * @param  mixed  $image
 * @param  integer $x     x-dimension
 * @param  integer $y     y-dimension
 * @return void
 */
	private function resize_image($image, $x = 64, $y = 64, $new_image = null) {
		if ($new_image === null) {
			$new_image = $image;
		}
		$original_image = $image;
		$size = getimagesize( $original_image );

        exec("convert -resize {$x}x{$y} -quality 100% -units PixelsPerInch '$original_image' '$new_image'");
	}



/**
 * Verifies that an uploaded file is actually an image
 * @param  string $image location of image
 * @return bool        true on success, false on fail
 */
	public function verify_image($image) {
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$mime = finfo_file($finfo, $image); 

		$accepted_mime = false;

		switch ($mime) {
			case 'application/pdf':
			case 'image/png':
			case 'image/jpeg':
			case 'image/jpg':
			case 'image/gif':
			case 'image/gd2':
			case 'image/wbmp':
				$accepted_mime = true;
			break;
		}

		$size = @getimagesize($image);
		if ($size && $accepted_mime)
			return $mime;
		return false;
	}

/**
 * Converts an image to PNG
 * @param  string $file_name path to file
 * @param  string $output    Output filename, if null it will overwrite the original
 * @return void
 */
	private function convertToPng($file_name, $output = null) {
		if ($output === null) {
			$output = $file_name;
		}
		if (empty($file_name) || !file_exists($file_name)) {
			return false;
		}
		$im = imagecreatefromstring(file_get_contents($file_name));
		// integer representation of the color black (rgb: 0,0,0)
        $background = imagecolorallocate($im, 0, 0, 0);
        // removing the black from the placeholder
        imagecolortransparent($im, $background);

		imagepng($im, $output);
	}
	
/**
 * Converts an image to jpeg
 * @param  string $file_name path to file
 * @param  string $output    Output filename, if null it will overwrite the original
 * @return void
 */
	private function convertToJpeg($file_name, $output = null) {
		if ($output === null) {
			$output = $file_name;
		}
		if (empty($file_name) || !file_exists($file_name)) {
			return false;
		}
		$im = imagecreatefromstring(file_get_contents($file_name));
		// integer representation of the color black (rgb: 0,0,0)
        $background = imagecolorallocate($im, 0, 0, 0);
        // removing the black from the placeholder
        imagecolortransparent($im, $background);

		imagejpeg($im, $output);
	}



/**
 * Generates a unique filename for storing images
 * @param  string $prefix optional prefix to prepend to the filename
 * @return string         filename
 */
	private function generate_name($prefix = null, $extention = '.jpg') {
		$filename = '';
		if ($prefix !== null) {
			$filename .= $prefix;
		}

		while(1) {
			$string = String::uuid();
			$found = false;
			foreach ($this->sizes as $dimensions) {
				if (file_exists($filename . $string . '_' . $dimensions . $extention)) {
					$found = true;
					break;
				}
			}
			if (!$found) {
				$filename = $filename . $string;
				break;
			}

		}
		return $filename;
	}




/**
 * Deletes an image from disk
 * @param  uuid   $id  images UUID
 * @param  path   $prefix optional, uses core.php value if not set
 * @return bool   true on success, false on failure
 */
	private function _deleteImage($id, $prefix = null) {
		if ($prefix === null) {
			$prefix = Configure::read('Topmenu.images');
		}

		$files = glob($prefix . $id . '_*.jpg');

		$original_extension = $this->FileModel->getOriginalExtension($id);
		if ($original_extension !== false) {
			$original_file = $prefix . $id . '_original.' . $original_extension;
			if (file_exists($original_file)) {
				unlink($original_file);
			}
		}

		$failed = false;

		foreach ($files as $file) {
			if (file_exists($file)) {
				if (unlink($file)) {
					$this->FileModel->deleteFile($id);
				} else {
					$failed = true;
				}
			} else {
				$failed = true;
			}
		}
		return ($failed === false) ? true : false;
	}
}
