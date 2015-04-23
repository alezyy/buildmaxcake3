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

App::uses('AppModel', 'Model');
/**
 * Responsible for reading Images and getting any needed information
 * about them
 */
class Image extends AppModel {

/**
 * We don't use a db table for this model
 * @var boolean
 */
	public $useTable = false;

/**
 * Contains the Image we read from the file
 * @var string
 */
	public $image = '';

/**
 * Contains the size of the Image
 * @var integer
 */
	public $size = 0;

/**
 * Dimentions of the file
 * @var string
 */
	public $dimentions = '64x64';

/**
 * Path to Image folder, set in construct
 * @var string
 */
	private $path = '';




/**
 * Construct
 */
	public function __construct() {
		$this->path = Configure::read('Topmenu.images');
		parent::__construct();
	}

/**
 * Gets a Image
 * @return void
 */
	public function getImage() {
		$this->Image = file_get_contents($this->_filename($this->id));
		$this->size = strlen($this->Image);
	}

/**
 * Checks to see if a Image exists
 * @param  string $file full path to the file
 * @return bool       TRUE on success, FALSE on failure
 */
	public function exists($id = null) {
		if ($id === null)
			return file_exists($this->_filename($this->id));
		else
			return file_exists($id);
	}

/**
 * Checks to see if the string provided is a valid UUID
 * @param  string $uuid
 * @return bool       TRUE if valid, FALSE if invalid
 */
	public function validateUUID($uuid) {
		$valid = preg_match(
			'/^\{?[A-Za-z0-9]{8}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{12}\}?$/',
			$uuid
		);
		if ($valid) {
			return true;
		}
		return false;
	}


/**
 * Returns the full filename (e.g.: /some/absolute/path/to/the/Image/we/want.Image )
 * @return string Full path
 */
	private function _filename() {
		return $this->path . $this->id . '_' . $this->dimentions . '.jpg';
	}
}