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
 * Specialty Model
 *
 * @property Cuisine $Cuisine
 */
class Specialty extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name_';

/**
 * Behaviors
 * @var array
 */
	public $actsAs = array(
		'SlugGenerator'
	);
/**
 * Default Display Order
 * @var array
 */
	public $order = array('Specialty.name_fr' => 'ASC', 'Specialty.name_en' => 'ASC');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name_fr' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Must be unique!'
			)
		),
		'name_en' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Must be unique!'
			)
		),

	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Restaurant',
		'Location'
	);

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
		$this->virtualFields['name'] = 'Specialty.name_' . $this->langSuffix;
		$this->displayField .= (empty($this->langSuffix) ? 'fr' : $this->langSuffix);
	}


/**
 * Before we save, if the _en field isn't set (on a new record)
 * set it to the same as _fr
 * 
 */
	public function beforeSave($options = array()) {
		parent::beforeSave($options);
		if (!empty($this->data['Specialty']['name_en'])) {
			$this->data['Specialty']['url'] = $this->generateUrlFromName($this->data['Specialty']['name_en']);
		}
	}

}
