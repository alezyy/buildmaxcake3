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

App::uses('AppModel', 'Model', 'Location');
/**
 * Sector Model
 *
 */
class Sector extends AppModel {

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
 * Default order to sort in
 * @var array
 */
	public $order = array('Sector.name' => 'ASC');


/**
 * Has and belongs to many relationship
 * 
 * @var array
 */
	public $belongsTo = array(
		'Location' => array(
            'className' => 'Location',
            'foreignKey' => 'code'
        )
	);
   

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
		'code' => array(
			'postal_prefix' => array(
				'rule' => '/^([A-Za-z]{1}[1-9]{1}[A-Za-z]{1}[,]{0,1})+$/',
				'message' => 'Please enter a comma separated list of postal code prefixes, no spaces.',
				'allowEmpty' => false
			),
			'trailing_comma' => array(
				'rule' => '/[^,]$/',
				'message' => 'Please remove the trailing comma',
				'allowEmpty' => false
			)
		)
	);
/**
 * Array of virtual fields.
 * @var array
 */
	public $virtualFields = array(
        'name_with_codes' => 'CONCAT(Sector.name_fr, " - ", Sector.code)'
    );

/**
 * Construct -- Build our virtual fields, and set the display name based
 * on language
 *
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->virtualFields['name'] = 'Sector.name_' . $this->langSuffix;
		$this->displayField .= (empty($this->langSuffix) ? 'fr' : $this->langSuffix);
	}


/**
 * Before we save, if the _en field isn't set (on a new record)
 * set it to the same as _fr
 * 
 */
	public function beforeSave($options = array()) {
		parent::beforeSave($options);
		if (!empty($this->data['Sector']['name_en'])) {
			$this->data['Sector']['url'] = $this->generateUrlFromName($this->data['Sector']['name_en']);
		}
	}
/**
 * Grabs a list of sectors
 * @param bool $mustHaveLocation wheter the sectors returned have to belong to a location or not
 * @return array
 * @todo implement the $mustHaveLocation function
 */
	public function getSectorList($mustHaveLocation = false) {

		$result = Cache::read('sectors_' . $this->langSuffix);
//                if ($mustHaveLocation) {
//                        if (!$result) {
//                                $result = $this->find(
//                                        'all', array(
//                                    'order' => array('Sector.title' => 'asc'),
//                                            'fields' => array('Sector.title', 'DISTINCT Model.field2'),   
//                                            'conditions' => array('Location.sector_id' => 
//                                            
//                                        )
//                                );
//                                Cache::write('sectors', $result);
//                        }
//                        return $result;
//                } else {

		if (!$result) {
				$result = $this->find(
					'all', array(
						'order' => array('Sector.title' => 'asc')
					)
				);
				Cache::write('sectors_' . $this->langSuffix, $result);
		}
		return $result;
//                }
	}

/**
 * Gets a sector's ID by it's url
 * @param  string $sector Sector's URL
 * @return array         UUID of the sector
 */
	public function getSectorId($sector) {
		$result = $this->find(
			'first', array(
				'conditions' => array('Sector.url' => $sector),
				'fields'     => array('id', 'title')
			)
		);
		return $result;
	}

/**
 * Gets the name of a sectory by it's id
 * @param  string $sector UUID of the sector
 * @return string         Sector's name
 */
	public function getSectorName($sector) {
		$result = $this->find(
			'first', array(
				'conditions' => array('Sector.id' => $sector),
				'fields'     => array('title')
			)
		);
		return $result;
	}
	

/**
 * Gets a sector name, by postal code
 * @param  string $code First 3 digits of the postal code
 * @return string|bool       Name of the sector on true, false on failure
 */
	public function getSectorByPostal($code) {
		$result = $this->find(
			'first', array(
				'conditions' => array('Sector.code LIKE' => '%' . $code . '%'),
				'fields'     => array('name')
			)
		);

		if ($result) {
			return $result['Sector']['name'];
		}
		return false;
	}


/**
 * Gets a count of sectors from the db, or cache if it exists
 * @return int
 */
	public function getSectorCount() {

		$result = Cache::read('sector_count');
		if (!$result) {
			$result = $this->find('count');
			Cache::write('sector_count', $result);
		}
		return $result;
	}
}
