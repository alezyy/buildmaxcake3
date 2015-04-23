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
 * Responsible for reading PDFs and getting any needed information
 * about them
 */
class Pdf extends AppModel {

/**
 * We don't use a db table for this model
 * @var boolean
 */
	public $useTable = false;

/**
 * Contains the PDF we read from the file
 * @var string
 */
	public $pdf = '';

/**
 * Contains the size of the PDF
 * @var integer
 */
	public $size = 0;

/**
 * Path to PDF folder, set in construct
 * @var string
 */
	private $path = '';

	public $belongsTo = array(
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => false,
			'dependent' => false,
		)
	);

/**
 * Construct
 */
	public function __construct() {
		$this->path = Configure::read('Topmenu.pdfs');
		parent::__construct();
	}

/**
 * Gets a PDF
 * @return void
 */
	public function getPDF() {
		$this->pdf = file_get_contents($this->_filename($this->id));
		$this->size = strlen($this->pdf);
	}

/**
 * Checks to see if a PDF exists
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
 * Decides what to name a PDF when serving it for download
 * It first checks to see if the user's current language choice url
 * for the Location is available, then the opposite
 * If neither are found then the Location's name is used. If none of this
 * information is available, the UUID will be used.
 * @return [type] [description]
 */
	public function getDownloadName() {
		$results = $this->Location->find('first', array(
			'fields' => array(
				'url'
			),
			'conditions' => array(
				'Location.pdf_menu' => $this->id
			)
		));
		if ($results) {
			return $results['Location']['url'];
		}
		return $this->id;
		
	}

/**
 * Returns the full filename (e.g.: /some/absolute/path/to/the/pdf/we/want.pdf )
 * @return string Full path
 */
	private function _filename() {
		return $this->path . $this->id . '.pdf';
	}
}