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

App::uses('AppController', 'Controller');

/**
 * ImagesController
 * Responsible for fetching Image files and serving them up
 */
class ImagesController extends AppController {


/**
 * beforeFilter
 * @return void
 */
	public function beforeFilter() {
		$this->Auth->allow('get_image');
		parent::beforeFilter();
	}

/**
 * Gets a Image from our store
 * Fetch either by UUID, or a restaurants url
 * Return the file to be downloaded named properly
 * @param  string $id UUID, or a url
 * @return void
 */
	public function get_image($size, $id) {

		$this->autoRender = false;

		if (!isset($this->request->params['ext']) || $this->request->params['ext'] != 'jpg') {
			throw new NotFoundException(__('Image Not Found!'));
		}

		if ($this->Image->validateUUID($id)) {
			// We found a valid UUID, push the file
			$this->_pushFile($id, $size);
		} 

	}

/**
 * Pushes a file to the browser
 * @param  uuid   $id            UUID of the Image
 * @param  string $download_name what we want to call the download
 * @return void
 */
	private function _pushFile($id, $size) {

		$this->Image->id = $id;
		$this->Image->dimentions = $size;


		if (!$this->Image->exists()) {
			throw new NotFoundException(__('Image Not Found!'));
		}

		$this->Image->getImage();


		$this->response->header('Content-length', $this->Image->size);

		$this->response->type('image/jpg');
		$this->response->body($this->Image->Image);

	}

}