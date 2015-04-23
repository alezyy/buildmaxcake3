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
 * Cuisine Model
 *
 * @property Specialty $Specialty
 * @property Location $Location
 */
class Cuisine extends AppModel {

	public $actsAs = array('SlugGenerator');
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name_';

/**
 * Default sorting order
 * @var array
 */
	public $order = array('Cuisine.name_fr' => 'ASC', 'Cuisine.name_en' => 'ASC');

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
				'rule' => array('isUnique'),
				'message' => 'Must be unique!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
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
				'rule' => array('isUnique'),
				'message' => 'Must be unique!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */

    public $hasMany = array(
		'Specialty' => array(
			'className' => 'Specialty',
			'foreignKey' => 'id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Location' => array(
			'className' => 'Location',
			'joinTable' => 'cuisines_locations',
			'foreignKey' => 'cuisine_id',
			'associationForeignKey' => 'location_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
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
        $this->virtualFields['name']        = 'Cuisine.name_' . $this->langSuffix;
        $this->virtualFields['description'] = 'Cuisine.description_' . $this->langSuffix;
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
			if (empty($this->data['Cuisine']['name_en']) && !empty($this->data['Cuisine']['name_fr'])) {
				$this->data['Cuisine']['name_en'] = $this->data['Cuisine']['name_fr'];
			}
		}
		if (!empty($this->data['Cuisine']['name_en'])) {
			$this->data['Cuisine']['url'] = $this->generateUrlFromName($this->data['Cuisine']['name_en']);
		}
	}

/**
 * Gets a list of cuisines from the database, or from cache if exists
 * @param  string $langSuffix Language suffix, grab from $this->langSuffix in AppController
 * @return array
 */
	public function getCuisineList() {
		$result = Cache::read('cuisines_' . $this->langSuffix);
        if (!$result) {
        	$result = $this->find(
				'all',
				array(
					'order' => array('Cuisine.name' => 'asc')
				)
			);
            Cache::write('cuisines_' . $this->langSuffix, $result);
        }
        return $result;
	}

/**
 * Gets the count of cuisines available
 * @return int
 */
	public function getCuisineCount() {
		$result = Cache::read('cuisine_count');
		if (!$result) {
			$result = $this->find(
				'count'
			);
			Cache::write('cuisine_count', $result);
		}
		return $result;
	}

}
