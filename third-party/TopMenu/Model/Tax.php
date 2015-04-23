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
 * Tax Model
 *
 */
class Tax extends AppModel {	

	public $actsAs = array('Diacritics');

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name_';
	
	/**
 * Array of virtual fields.
 * @var array
 */
	public $virtualFields = array();

/**
 * Construct -- Build our virtual fields, and set the display name based
 * on language
 *
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->virtualFields['name'] = 'Tax.name_' . $this->langSuffix;
		$this->displayField .= (empty($this->langSuffix) ? 'fr' : $this->langSuffix);
	}


/**
 * Before we save, if the _en field isn't set (on a new record)
 * set it to the same as _fr
 * 
 */
	public function beforeSave($options = array()) {
		parent::beforeSave($options);
		if (!$this->id) {
			if (empty($this->data['Tax']['name_en']) && !empty($this->data['Tax']['name_fr'])) {
				$this->data['Tax']['name_en'] = $this->data['Tax']['name_fr'];
			}
		}
	}
	
	/**
	 * Get the tax informations for a specific canadian province
	 * 
	 * @param string $province full name of province in english
	 * @return array return tax name, is compound, and percentage if not 0 or false if no matches was found
	 */
	public function getTaxesByProvince($province){
		
		// parse province string
		$province = strtolower($province);				// to lower string
		$province = str_replace('-', ' ', $province);	// remove dashes (no dashes in databasse)   
		$province = $this->remove_accents($province);	// remove's diacritics
		
		// retrieve data
		$results = $this->find('first', array(
			'conditions' => array('Tax.province', $province),
			'fields' => array('hst', 'gst', 'pst', 'compound', 'name')
		));
		
		if(!empty($results)){		
			return $results;
		}else{
			return false;
		}
	}

}
