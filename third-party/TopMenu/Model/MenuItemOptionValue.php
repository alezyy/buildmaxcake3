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
 * MenuItemOptionValue Model
 *
 * @property MenuItemOption $MenuItemOption
 */
class MenuItemOptionValue extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name_';

	/**
     * @var actsAs
     */

    public $actsAs = array('Containable', 'Tree');


    public $order = array('MenuItemOptionValue.lft' => 'ASC');
		

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'menu_item_option_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name_fr' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'absenceOf' => array(
				'rule' => array('absenceOf', '~'),
				'message' => "The wave caracter ('~') is not allowed"
			)
		),
		'name_fr' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'absenceOf' => array(
				'rule' => array('absenceOf', '~'),
				'message' => "The wave caracter ('~') is not allowed"
			)
		),
		'status' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'MenuItemOption' => array(
			'className' => 'MenuItemOption',
			'foreignKey' => 'menu_item_option_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
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
		$this->virtualFields['name'] = 'MenuItemOptionValue.name_' . $this->langSuffix;
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
			if (empty($this->data['MenuItemOptionValue']['name_en']) && !empty($this->data['MenuItemOptionValue']['name_fr'])) {
				$this->data['MenuItemOptionValue']['name_en'] = $this->data['MenuItemOptionValue']['name_fr'];
			}
		}
	}

/**
 * Attaches a tree and scopes by menu_id
 *
 * @access private
 * @return void
 */
	public function attachTree($menu_item_option_id) {
		$scope = array(
	        "MenuItemOptionValue.menu_item_option_id" => $menu_item_option_id
	    );

		$this->Behaviors->load('Tree', array(
	        'scope' => $scope
	    ));
	}
	
	/**
	 * Validates the absence of a character in a fields value
	 * 
	 * @param	array		$check	field => value array of the field being validated
	 * @param	char		$char	the char that should not be present in the string
	 * @return	boolean			is valid?
	 * @todo					Put in a behavior
	 */
	public function absenceOf($check, $char){
		
		foreach ($check as $c){
			if (strstr($c, $char)){
				return FALSE;
			}
		}
		
		return true;
	}
	
}
