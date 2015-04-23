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

App::uses('ImageComponent', 'Controller/Component');
App::uses('ComponentCollection', 'Controller');

/**
 * Resizes images
 *
 * @extends AppShell
 */
class ImageResizeShell extends AppShell {
	/**
	 * uses
	 *
	 * @var mixed
	 * @access public
	 */
	public $uses = array(
		'UploadedFile'
	);

	/**
	 * main function.
	 *
	 * @access public
	 * @return void
	 */
	public function main() {

		$new_x = $this->args[0];
		$new_y = $this->args[1];

		if ($new_x === null || $new_y === null) {
			$this->out('Usage: image_resize <new_x> <new_y>');
			exit;
		}
		$Image = new ImageComponent(new ComponentCollection());
		$files = $this->UploadedFile->find('all', array(
			'conditions' => array(
				'type' => 'image'
			)
		));

		foreach ($files as $file) {
			$Image->resizeImage(
				$file['UploadedFile']['id'],
				$file['UploadedFile']['original_extension'],
				$new_x,
				$new_y
			);
		}

		return true;
	}
}