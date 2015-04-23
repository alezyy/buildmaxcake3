<?php
App::uses('AppHelper', 'View/Helper');
App::uses('Inflector', 'Utility');
/*
 * ImageHelper
 * Generates a nice <img> tag with the image embeded
 * that way we have less requests going to the server.
 * That and it looks prettier.
 *
 */
class ImageHelper extends AppHelper {

	public $helpers = array('Html', 'Form', 'Session');

/**
 * beforeRender - load up our JS before the view renders
 * @param  string $viewFile
 * @return void
 */
	public function beforeRender($viewFile) {

//		$this->Html->script('file_helper', array('inline' => false));
//		$this->Html->script('holder', array('inline' => false));
		parent::beforeRender($viewFile);
	}
/**
 * Returns an image tag (html) containing the image
 * Image is taken from app/Uploads/images
 * @param  string $image 		UUID of the image
 * @param  string $dimensions 	dimensions of the image.<br>
 *								Set to 'original' to retrieve the original image (that has not been process)
 * @param  bool   $embed 		True: Base64 encode and embed in page, False: return
 *                         			a URL where the image can be found
 * @param  bool   $noWrap		True: outputs the Base64 code without HTML wrapping<br/>
 *								False: will wrap the Base 64 code in an <img> tag
 * @param  bool	  $placeholder  True: if no image where found a default placeholder image wil be inserted<br/>
 *								False: if no image where found null will be returned
 * @param  array  $options		Array of html properties for the img tag.
 * @return string        		<img> tag or Base64 encoding
 * 
 */
	public function out($image, $dimensions = null, $embed = false, $noWrap = false, $placeholder = true, $options = array(), $slug = NULL) {
		
		if ($dimensions === null) {
			$dimensions = '64x64';
		}
		
		if($dimensions === 'original'){
			$image_path_array = glob(Configure::read('Topmenu.images') . DS . $image . '_original.*');			
			$image_path = array_shift($image_path_array);
		}else{
			$image_path = Configure::read('Topmenu.images') . $image . '_' . $dimensions . '.jpg';
		}
		if (file_exists($image_path)) {
			if ($embed) {
				$source = $this->_getBase64ImageSource($image_path);
			} else {
				
				$urlArray = array(
					'controller' => 'images',
					'action' => 'get_image',
					'id' => $image,
					'size' => $dimensions,					
					'ext' => 'jpg',					
					'admin' => false,
					'language' => false);
				
				if($slug){
					$urlArray['slug'] = $slug;
				}
				
				$source = Router::url($urlArray);
			
			}			
			
				// display the url to the image
				if($noWrap){ return $source; }

			// Display image in html tag
			$options['src'] = $source;		// add src propertie to html options
			return $this->Html->tag('img', null, $options);
		}
				
		// no images and no placeholder wanted so do not display anything
		if(!$placeholder){return null;}	
		
		// no image so display placeholder
        return $this->Html->image("placeholder_{$this->_View->viewVars['langSuffix']}_$dimensions.png", $options);
		
	}

/**
 * Returns a form element built to handle our images
 * Will automatically include a preview and a remove button if there
 * is an existing file
 * @param  string $field  field name
 * @param  array  $option options to pass to FormHelper
 * @return string         Tag to be inserted into the view
 */
	public function input($field, $option = array()) {
		$modelKey = Inflector::singularize($this->_View->name);
		$options = array(
			'type' => 'file'
		);

		$route = Router::parse($this->request->url);

		$admin = false;

		if (array_key_exists('admin', $route)) {
			$admin = $route['admin'];
		}

		$link = array(
			'controller' => $route['controller'],
			'action' => $route['action'],
			'admin' => $admin,
			'delete_image' => $field
		);

		foreach ($route['pass'] as $pass) {
			$link[] = $pass;
		}

		if (
			isset($this->request->data[$modelKey][$field])
			&& !empty($this->request->data[$modelKey][$field]
		)) {
			$options['prepend'] = $this->out(
				$this->request->data[$modelKey][$field]
			);
			$options['prepend'] .= $this->Html->link(
				'x',
				$link,
				array(
					'class' => 'btn btn-danger delete-file',
					'message' =>  __('Are you sure you want to delete this image?')
				)
			);
		}
		$options = array_merge($options, $option);
		return $this->Form->input(
			$field,
			$options
		);
	}

/**
 * Read the image, and output a base64 string we can include in the tag	
 * @param  string $image Path to the image
 * @return string        The image, base64 encoded
 */
	private function _getBase64ImageSource($image) {
		$mime = 'image/jpg';
		$image = file_get_contents($image);

		$base64_image = "data:" . $mime . ";base64," . base64_encode($image);
		return $base64_image;
	}

}