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
 * Article Model
 *
 * @property BlogCategory $BlogCategory
 */
class Article extends AppModel {

/**
 * Behaviors
 * @var array
 */
	public $actsAs = array(
		'SlugGenerator'
	);
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name_';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name_en' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Name En must not be empty!',
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
		'name_fr' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Name Fr must not be empty!',
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
		'published' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Must be numeric!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);

/**
 * Virtual fields
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
		$this->virtualFields['name'] = 'Article.name_' . $this->langSuffix;
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
			if (empty($this->data['Article']['name_en']) && !empty($this->data['Article']['name_fr'])) {
				$this->data['Article']['name_en'] = $this->data['Article']['name_fr'];
			}

		}
		if (!empty($this->data['Article']['name_en'])) {
			$this->data['Article']['url'] = $this->generateUrlFromName($this->data['Article']['name_en']);
		}
	}

}
