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
App::uses('Rating', 'Model');
App::uses('SessionComponent', 'Controller/Component');
App::uses('ComponentCollection', 'Controller');

/**
 * Location Model
 *
 * @property Sector $Sector
 * @property Coupon $Coupon
 * @property DeviceOrder $DeviceOrder
 * @property Device $Device
 * @property Invoice $Invoice
 * @property LocationGallery $LocationGallery
 * @property Menu $Menu
 * @property Order $Order
 * @property PhoneClick $PhoneClick
 * @property Rating $Rating
 * @property Review $Review
 * @property Schedule $Schedule
 * @property Cuisine $Cuisine
 * @property Feature $Feature
 * @property User $User
 */
class Location extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Default sorting order
 * @var array
 */
	public $order = array('Location.name' => 'ASC');


	public $actsAs = array(
		'Distance',
		'SlugGenerator',
        'Containable',
		'Elasticsearch.Searchable' => array(
			'index_find_params' => array(
				'contain' => array(
					'Cuisine' => array(
						'fields' => array(
							'id',
							'name_en',
							'name_fr',
							'url'
						)
					),
					'DeliveryArea' => array(
						'fields' => array(
							'id',
							'postal_code',
							'delivery_charge',
							'featured'
						)
					),
					'Schedule' => array(
					),
					'Menu' => array(
						'MenuCategory' => array(
							'MenuItem'
						)
					)
				)
			)
		)
	);


/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
				// 'allowEmpty' => false,
				// 'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Location name must be unique!'
			)
		),
		'street' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'city' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'province' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'postal_code' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'postal_code' => array(
				'rule' => '',
				'message' => 'Postal code format must be: H0H 0H0',
				'allowEmpty' => false,
				'required' => false
			)
		),
		'country' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'phone' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'use_fax' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Must be either true or false.',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Enter a valid email address!',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'delivey' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Must be numeric!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'pickup' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Must be numeric!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'delivery_commission' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'pickup_commission' => array(
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
     * HasOne Associations
     */
    public $hasOne = array(
        'Sector'           => array(
            'className'  => 'Sector',
            'foreignKey' => 'url',
        ),
        'LocationAddress'  => array(
            'className'  => 'Sector',
            'foreignKey' => 'id',
        )
    );

    /**
 * hasMany associations
 *
 * @var array
 */
	
	public $hasMany = array(
		'Coupon' => array(
			'className' => 'Coupon',
			'foreignKey' => 'location_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'DeviceOrder' => array(
			'className' => 'DeviceOrder',
			'foreignKey' => 'location_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Device' => array(
			'className' => 'Device',
			'foreignKey' => 'location_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'DeliveryArea' => array(
			'className' => 'DeliveryArea',
			'foreignKey' => 'location_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Invoice' => array(
			'className' => 'Invoice',
			'foreignKey' => 'location_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'LocationGallery' => array(
			'className' => 'LocationGallery',
			'foreignKey' => 'location_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Menu' => array(
			'className' => 'Menu',
			'foreignKey' => 'location_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'location_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'PhoneClick' => array(
			'className' => 'PhoneClick',
			'foreignKey' => 'location_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Rating' => array(
			'className' => 'Rating',
			'foreignKey' => 'location_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Review' => array(
			'className' => 'Review',
			'foreignKey' => 'location_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Schedule' => array(
			'className' => 'Schedule',
			'foreignKey' => 'location_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => 'day ASC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
        'LocationDocument' => array(
            'className'  => 'LocationDocument',
            'foreignKey' => 'location_id',
        ),
        
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Cuisine' => array(
			'className' => 'Cuisine',
			'joinTable' => 'cuisines_locations',
			'foreignKey' => 'location_id',
			'associationForeignKey' => 'cuisine_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Specialty' => array(
			'className' => 'Specialty',
			'joinTable' => 'locations_specialties',
			'foreignKey' => 'location_id',
			'associationForeignKey' => 'specialty_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Feature' => array(
			'className' => 'Feature',
			'joinTable' => 'features_locations',
			'foreignKey' => 'location_id',
			'associationForeignKey' => 'feature_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'User' => array(
			'className' => 'User',
			'joinTable' => 'locations_users',
			'foreignKey' => 'location_id',
			'associationForeignKey' => 'user_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		'Sector' => array(
			'className' => 'Sector',
			'joinTable' => 'locations_sectors',
			'foreignKey' => 'location_id',
			'associationForeignKey' => 'sector_id',
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
 * Virtual Fields
 */
	public $virtualFields = array(
		'postal_code1' => 'SUBSTR(Location.postal_code, 1, 3)',
		'postal_code2' => 'SUBSTR(Location.postal_code, 5, 3)',
		'location' => 'CONCAT(Location.latitude, ",", Location.longitude)',
		'short_address' => 'CONCAT(Location.building_number, " ", Location.street, ", ", Location.city)'
	);


/**
 * Construct -- Build our virtual fields, and set the display name based
 * on language
 *
 */	
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);		

$this->virtualFields['description']      = 'Location.description_' . $this->langSuffix;
		$this->Rating = new Rating();
		$this->Session = new SessionComponent(new ComponentCollection());
	}


	public function forceUpdate($id) {
		$this->id = $id;
		if (!$this->exists()) {
			throw new NotFoundException(__('Location not found...'));
		}
		$this->saveField('modified', date('Y-m-d H:i:s'));
	}


/**
 * Before we save, if the _en field isn't set (on a new record)
 * set it to the same as _fr
 * 
 */
	public function beforeSave($options = array()) {
		parent::beforeSave($options);
		if (!$this->id) {
			if (empty($this->data['Location']['description_en']) && !empty($this->data['Location']['description_fr'])) {
				$this->data['Location']['description_en'] = $this->data['Location']['description_fr'];
			}		

		}
		if (!empty($this->data['Location']['name'])) {
			$this->data['Location']['url'] = $this->generateUrlFromName($this->data['Location']['name']);
		}

		if (!isset($this->data['Location']['postal_code']) || empty($this->data['Location']['postal_code'])) {
			$this->data['Location']['postal_code'] = 'H0H 0H0';
		}
	}
		
/**
 * Returns an array of locations filtered by sector and cuisine         
 * @param array $cuisineId - array of the cuisines id to be put in the where operation
 * @param array $sectorId - array of the sectors id to be put in the where operation
 * @param string $sectorOperator - 'and' or 'or' operator to concatenate the "where" cuisine conditions
 * @param string $cuisineOperator - 'and' or 'or' operator to concatenate the "where" cuisine conditions
 * @param  array $fieldList array of all the fields needed, null output all fields
 * @return boolean includeInactives True = will include the the records flagued as inactive in the status field of the database
 * @return Location or false on faillur
 */
	public function filterLocations($cuisineId, $code = 'all', $sectorOperator = 'and', $cuisineOperator = 'and',$fieldsList = null, $includeInactives = false) {

        $codeCSV = implode(',',$code);

		
        // converts $includeInatives to active/inactive
        $includeInactives = ($includeInactives) ? '%' : 'active';
		$fieldsList = ($fieldsList === null) ? array('*') : $fieldsList;


		if (!empty($cuisineId)) {


            // BUILD THE "CONDITIONS" ARRAY
            $conditionsCuisines = array();
            $conditionsSector = array();

            // Cuisines
            foreach ($cuisineId as $c) {
                array_push($conditionsCuisines, array('c.id' => $c));
            }

			// Sectors
			foreach ($sectorId as $s) {
				array_push($conditionsSector, array('s.sector_id' => $s));
			}


            // RETRIEVE DATA                        
            $result = $this->find(
				'all',
				array(
                'joins' => array(
                    array(
                        'table' => 'cuisines_locations',
                        'alias' => 'cl',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Location.id = cl.location_id')),
                    array(
                        'table' => 'cuisines',
                        'alias' => 'c',
                        'type' => 'INNER',
                        'conditions' => array(
                            'c.id = cl.cuisine_id ')
                ),
						array(
							'table' => 'locations_sectors',
							'alias' => 's',
							'type' => 'INNER',
							'conditions' => array(
								'Location.id = s.location_id')),
					),
                'fields' => $fieldsList,
                    'conditions' => array(
                        array($cuisineOperator => $conditionsCuisines),
                        '(FIND_IN_SET(SUBSTR(postal_code, 1, 3), \''. $codeCSV .'\') > 0)',
						'Location.status like' => $includeInactives
					)
				)
			);

			// RETURN
      if ($result !== null) {
				return $result; // return dataset
      } else {
				throw new NotFoundException(__('Sorry, something went wrong with your filtering request'));
      }
		} else {
			throw new NotFoundException(__('Sorry, your cuisines filter is empty'));
		}
	}
		
 /**
 * Gets a list of locations for a given sector
 * @param  string $code Comman seperated list of area codes to match (first 3 character only)
 * @param  array $fieldList array of all the fields needed, null output all fields
 * @param  boolean includeInactives True = will include the records flagued as inactive in the status field of the database
 *
 * @return mixe Array of locations or false if no result where found
 */
public function findBySector($code, $fieldsList = null, $includeInactives = false) {

    // parse arguments for sql 
    $includeInactives = ($includeInactives) ? '%' : 'active';         // % = all, 
    $fieldsList = ($fieldsList === null) ? array('*') : $fieldsList;  // * = all
    if (is_array($code)) {    
      $code = implode(',', $code);            // convert array to CSV
    } else {
      $code = str_replace(';', ',', $code);   // replace semi colons with commas
    }


        // fetch results
        $result = $this->find('all', array(
            'fields' => $fieldsList,
            'conditions' => array(
				'Location.status LIKE' => $includeInactives,
				'(FIND_IN_SET(SUBSTR(Location.postal_code, 1, 3), ?) > 0)' => $code
        )));

    if (!empty($result)) {
            return $result;
    } else {
            return false;
        }
    }
    
    
    /**
     * Builds a virtual locations table containing 
     * only a subset of locations located inside one of the 
     * given postal code
     * 
     * @param string $code First 3 characters of a postal code
     * @param array $fieldsList array of all the fields needed, null output all fields
     * @param bool $includeInactives True = will include the records flagued as inactive in the status field of the database
     */
    public function locationsSubset($code, $fieldsList = null, $includeInactives = false){
        
        // converts $includeInatives to active/inactive
        $includeInactives = ($includeInactives) ? '%' : 'active';
        $fieldsList = ($fieldsList === null) ? array('*') : $fieldsList;
    }

  /**
 * Gets a list of locations for a given cuisine type
 * @param string $id Cuisines UUID
 * @param array $fieldList array of all the fields needed, null output all fields
 * @param boolean includeInactives True = will include the the records flagued as inactive in the status field of the database
 *
 * @return mixe Array of locations or false if no result where found
 */
	public function findByCuisine($id, $fieldsList = null, $includeInactives = false) {

        // converts $includeInatives to active/inactive
        $includeInactives = ($includeInactives) ? '%' : 'active';
        $fieldsList = ($fieldsList === null) ? array('*') : $fieldsList;

        // fetch results
       $result = $this->find(
                'all', array(
                'joins' => array(
                    array(
                        'table' => 'cuisines_locations',
                        'alias' => 'cl',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Location.id = cl.location_id')),
                    array(
                        'table' => 'cuisines',
                        'alias' => 'c',
                        'type' => 'INNER',
                        'conditions' => array(
                            'c.id = cl.cuisine_id ')
                    )
                ),
                'fields' => $fieldsList,
                    'conditions' => array(
                        'c.id' => $id,
                        'Location.status like' => $includeInactives)));

       if(!empty($result)){
        return $result;
       }  else {
        return false;
       }
    }

	/**
	 * Gets the locations url field from the databse
	 * @param type $id location's id
	 * @return array Cakephp find result array. Use: $var['Location']['url'];
	 */
    public function getLocationUrl($id) {
		$result = $this->find(
			'first',
			array(
				'conditions' => array('Location.id' => $id),
				'fields' => array('Location.url')
			)
		);
		return $result;
	}

	/**
	 * Gets a location sector_slug field
	 * @param type $id location's id
	 * @return array Cakephp find result array. Use: $var['Location']['sector_slug'];
	 */
	public function getLocationSectorSlug($id) {
		$result = $this->find(
			'first',
			array(
				'conditions' => array('Location.id' => $id),
				'fields' => array('Location.sector_slug')
			)
		);
		return $result;
	}
	
	/**
	 * Gets a location sector_slug field using it's url field as the condition
	 * @param type $id location url field
	 * @return string
	 */
	public function getLocationSectorSlugByUrl($url) {
		$result = $this->find(
			'first',
			array(
				'conditions' => array('Location.url' => $url),
				'fields' => array('Location.sector_slug')
			)
		);
		return $result['Location']['sector_slug'];
	}


	public function getPdfMenuByUrl($url) {
		$result = $this->find('first', array(
			'conditions' => array(
				'Location.url' => $url
			),
			'fields' => array('Location.pdf_menu')
		));
		return $result;
	}
    
    /**
     * 
     * @param string $url url field in the database or full url
     * @param array $fields array of all the fields needed. Defaults to: all fields
     * @return array Query's result in an array
	 * @todo remove since it's overridding cake's identical function 
     */
    public function findByUrl($url, $fields = '*'){
		
		// get location's url from full url
		$urlArray = explode('/', $url);
		$url = end($urlArray);
		
        $result = $this->find(
			'first',
			array(
				'conditions' => array('Location.url' => $url),
				'fields' => $fields)
			);
		return $result;
    }

	/**
	 * @deprecated Is kept here only if we decide to use elastic search to search for location again (this could also be use for geolocalisation base search)
	 * @param string $type delivery or pickup
	 * @param string $query data to search for
	 * @param array $options options for cakephp find method
	 * @param array $searchFields fields to search in
	 * @param array $returnFields fields wanted in the result array
	 * @return array Set of locations
	 */
	public function search(
		$type = 'query',
		$query,
		$options = array(),
		$searchFields = array(),
		$returnFields = array()
	) {
		
		if ($returnFields === array()){
			$returnFields = array(
                'Location.name',
                'Location.id',
                'Location.url',
                'Location.logo',
                'Location.building_number',
                'Location.street',
                'Location.postal_code',
                'Location.location',
                'Location.delivery_average_time',
                'Location.latitude',
                'Location.longitude',
                'Location.description_' . $this->langSuffix,
                'Cuisine.name_' . $this->langSuffix,
                'DeliveryArea.postal_code',
                'DeliveryArea.delivery_charge',
                'DeliveryArea.featured'
            );
		}
		
		if ($options === array()){
			$options = array('limit' => 100);
		}

		$this->Behaviors->attach('Elastic.Indexable');
		$this->useDbConfig = 'index';
		$this->useTable = 'location';

		$conditions = array();

		if (isset($options['conditions'])) {
			$conditions = $options['conditions'];
		}
		$conditions[] = array('Location.status' => 'active');

		$block_pdf_areas = Configure::read('Topmenu.block_pdf_menus');

		if (is_array($query)) {
			$postal_code = $query['postal_code'];
		} else {
			$postal_code = $query;
		}

		if (array_search(strtoupper($postal_code), $block_pdf_areas) !== false) {
			$conditions[] = array('Location.online_ordering' => 1);
		}


		if (!empty($returnFields)) {
			$options['fields'] = $returnFields;
		}

		if ($type == 'query') {
			foreach ($searchFields as $field) {
				$conditions[] = array(
					'common' => array(
						$field => array(
							'query'                => $query,
							'cutoff_frequency'     => 0.0001,
							'minimum_should_match' => array(
								'low_freq'  => 1,
								'high_freq' => 3
							)
						)
					)
				);
			}
			$options['conditions'] = $conditions;
		} elseif ($type == 'geo') {
			$options['conditions'] = array_merge($conditions, array(
				'Location.location' => array(
					'lat' => $query['lat'],
					'lon' => $query['lon'],
					'distance' => $query['distance'],
					'distance_type' => 'arc'
				)
			));
			$options['latitude'] = $query['lat'];
			$options['longitude'] = $query['lon'];
			$options['order'] = array(
				'Location.location' => 'asc'
			);
		} elseif ($type == 'postal') {
			$options['conditions'] = array_merge($conditions, array(
				'query_string' => array(
					'fields' => array('DeliveryArea.postal_code'),
					'query' => $query
				)
			));
		}				
		$results = $this->find('all', $options);
		foreach ($results as $key => $result) {
			if ($type == 'geo') {
	            $results[$key]['Location']['distance'] = $this->distance(
	                $query['lat'],
	                $query['lon'],
	                $result['Location']['latitude'],
	                $result['Location']['longitude']
	            );
	        }
        }


		// Store search options in session
		$this->Session->write('Search.type', $type);
		$this->Session->write('Search.Location.type', $type);
		$this->Session->write('Search.Location.type', $type);
		$this->Session->write('Search.query', $query);
		$this->Session->write('Search.options', $options);
		$this->Session->write('Search.searchFields', $searchFields);
		$this->Session->write('Search.returnFields', $returnFields );				

		return $results;
	}

    
    /**
     * find function specific to the detail view of restaurant without the menus
     * @param string $url url of the location
     * @param array $fields array of fields to be included in the result. <br/>
     *                      Defaults to array('*') to display all fields
     * @return mixe All the information and no more to find on the location's details. False on empty set
     * @todo filter out unneeded fields
     */
    public function findForDisplayingDetailedView($url, $fields = array('*') ){
         
        
        $result = $this->find(
			'first',
			array(
                'contain' => array(
                    'Cuisine'=> array(
                        'fields' => array('*')),
                    'Device' => array(
                        'fields' => array('*'))
                    ),                                                                             
				'conditions' => array(
					'Location.url' => $url,
					'Location.status' => 'active'
				),
				'fields' => $fields
			)
        );
        
        if(!empty($result)) {
            return $result;        
        }else{
            return false;
        }
        

    }

/**
 * Gets a location's province
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
	public function getProvince($id){
		return $this->find('first', array(
			'conditions' => array('Location.id' => $id),
			'fields' => array('province')			
		));
	}

/**
  * Gets the language for a location
  * @param  [type] $id [description]
  * @return [type]     [description]
  */
    public function getLanguage($id) {
    	$result = $this->find('first', array(
    		'conditions' => array(
    			'Location.id' => $id
    		),
    		'fields' => array(
    			'Location.language'
    		)
    	));
    	if ($result) {
    		return $result['Location']['language'];
    	}
    	return false;
    }

	/*
	 * @param	array	$order	Full order session
	 * @return	bool			True if the restaurant is available to deliver at thant moment<br/>
	 *							False if it cant
	 */
	public function canDeliver($locationId, $timeOfReception){

	}

/**
 * Checks to see if a location is in testing mode.
 * @param  string   $id
 */
	public function isTestMode($id) {
		$result = $this->find('first', array(
			'conditions' => array(
				'Location.id' => $id,
			),
			'fields' => array(
				'Location.test_mode'
			)
		));

		if ($result) {
			return $result['Location']['test_mode'];
		} else {
			return false;
		}
	}	

	/**
     * Produce the data for the search page. 
     * 
     * @param mixe $sectorPostalCodeList String or Array. One or many postal code in which restaurnats may deliver. <br/>
     *                                  <b>'*' will look in all postal codes</b> 
     * @param string $fields fields to be included in the results
     * @param boolean $onlineOrdering 
     * @param boolean $open True: get restaurant currently open False: get restaurants currently closed
     * @param int $page 0 means no pagination, any other number represent the page of the result set.
     * @return array The result set
     */
    public function findRestaurantsByPostalCode($sectorPostalCodeList, $fields, $onlineOrdering, $open, $page = 0){
		        
        $fieldCSV               = $this->_arrayToMysqlCsv($fields);
        $onlineOrdering         = $onlineOrdering ? '1' : '0';
        $open                   = ($open) ? '' : ' = FALSE';
        $day                    = date("w", time()); // current day of the week
        $inSectorPostalCodeList = ($sectorPostalCodeList === '*') ? '' : "AND DeliveryArea.postal_code IN ('$sectorPostalCodeList')";   //        

        $sql = "
			SELECT DISTINCT(Location.id), $fieldCSV FROM `locations` AS Location
			JOIN delivery_areas AS DeliveryArea
				ON DeliveryArea.location_id = Location.id
			JOIN schedules AS Schedule
				ON Schedule.location_id = Location.id		
            JOIN menus AS Menu
                ON Menu.location_id = Location.id
                AND Menu.status = 'active'
			WHERE online_ordering = $onlineOrdering
		    	AND Location.status = 'active'
			$inSectorPostalCodeList
			AND Schedule.day = $day
			AND 
			(
				(CURTIME() BETWEEN Schedule.delivery_start1 AND Schedule.delivery_end1)
				OR
				(
					(CURTIME() BETWEEN Schedule.delivery_start2 AND Schedule.delivery_end2)
					AND
					Schedule.split_delivery_time = 1
				 )
			) $open 
			GROUP BY Location.id
			ORDER BY Location.rating DESC, RAND()".
            $this->paginationHomeMade($page);

		$db     = $this->getDataSource();
        $result = $db->fetchAll($sql);

        // Add cuisine types
		return $this->_getRestaurantsCuisinesType($result);
	}
    
	/**
     * Produce the data for the search page for PDF only.
     * 
     * @param mixe $sectorPostalCodeList String or Array. One or many postal code in which restaurnats may deliver
     * @param string $fields fields to be included in the results
     * @param boolean $onlineOrdering 
     * @param boolean $open True: get restaurant currently open False: get restaurants currently closed
     * @return array The result set
     */
    public function findRestaurantsByPostalCodePDF($sectorPostalCodeList, $fields, $page = 0){        
		
		$fieldCSV       = $this->_arrayToMysqlCsv($fields);       

        $sql = "
			SELECT DISTINCT(Location.id), $fieldCSV FROM `locations` AS Location
			JOIN delivery_areas AS DeliveryArea
				ON DeliveryArea.location_id = Location.id
			JOIN schedules AS Schedule
				ON Schedule.location_id = Location.id
            LEFT JOIN menus AS Menu
                ON Menu.location_id = Location.id
                AND Menu.status = 'active'
			WHERE online_ordering = 0
		    AND Location.status = 'active'
            AND DeliveryArea.postal_code IN ('$sectorPostalCodeList')
			GROUP BY Location.id
			ORDER BY Location.rating DESC, RAND()".
            $this->paginationHomeMade($page);

		$db     = $this->getDataSource();
        $result = $db->fetchAll($sql);
        
        // Add cuisine types
		return $this->_getRestaurantsCuisinesType($result);
	}
	
	public function findRestaurantsByCuisineType($cuisineType, $page = 0){
		
        $fields ="Location.name,
                Location.id,
                Location.url,
                Location.sector_slug,
                Location.logo,
                Location.building_number,
                Location.street,
                Location.city,
                Location.postal_code,
                Location.latitude,
                Location.rating,
                Location.longitude,
                Location.delivery_average_time,
                Location.description_{$this->langSuffix},
                Location.online_ordering,
                Location.old_pdf_only,
                DeliveryArea.postal_code,
                DeliveryArea.delivery_charge,
                Menu.created,
                DeliveryArea.featured";
        
		$day = date( "w", time());	// current day of the week

        // here the cuisine type comes from the url and urls are unilingual so it's normal to filter the results only by the french cuisine type
		$sql = "
			SELECT DISTINCT(Location.id), $fields FROM `locations` AS Location
			JOIN cuisines_locations AS cl
				ON cl.location_id = Location.id
			JOIN cuisines AS Cuisine
				ON Cuisine.id = cl.cuisine_id
			JOIN delivery_areas AS DeliveryArea
				ON DeliveryArea.location_id = Location.id
			LEFT JOIN menus AS Menu
                ON Menu.location_id = Location.id
                AND Menu.status = 'active'
			JOIN schedules AS Schedule
				ON Schedule.location_id = Location.id
			AND Schedule.day = $day
            AND Cuisine.name_fr = '$cuisineType'
            AND Location.status = 'active'
			AND 
			(
				(CURTIME() BETWEEN Schedule.delivery_start1 AND Schedule.delivery_end1)
				OR
				(
					(CURTIME() BETWEEN Schedule.delivery_start2 AND Schedule.delivery_end2)
					AND
					Schedule.split_delivery_time = 1
				 )
			)
			GROUP BY Location.id
			ORDER BY Location.online_ordering DESC, Location.rating DESC, RAND()
            {$this->paginationHomeMade($page)}";

		$db = $this->getDataSource();
		$result =  $db->fetchAll($sql);
		
		// Add cuisine types
		return $this->_getRestaurantsCuisinesType($result);
		
	}
	
	/**
	 * Transform an array or a string into a comma separated list escaped to be inserted into a sql statement
	 * @param array/string array of $fields or string. If it's a string nothing is changed
	 * @return string
	 */
	private function _arrayToMysqlCsv($fields){
		// Manage multiple type $fieles Parameter
		if(is_array($fields)){
			$fieldCSV = implode(',', $fields);			
		}else{
			$fieldCSV = $fields;
		}
		return $fieldCSV ;
	}
	
	/**
	 * add cuisine types to the result set of locations provided in $data
	 * @param array $data array of locations 
	 * @return array The array pass to function with the cuisine type added for each restaurants
	 */
	private function _getRestaurantsCuisinesType($data) {
				
		foreach ($data as $key => $value) {
			$this->contain('Cuisine');
			$tmp = $this->findById($value['Location']['id']);
			$data[$key]['Cuisine'] = $tmp['Cuisine'];
		}
		
		return $data;
	}
    
    /**
     * This create a snippet of mysql code that will be inserted in the query to paginate the result
     * 
     * @param int $page current page number
     * @param int $maxResultPerPage How many result should be display per page <br/><b>defaults to 10</b>
     * @return string sql to be injected in the query to enable pagination
     */
    private function paginationHomeMade($page, $maxResultPerPage = 10){
                
        if ($page > 0) {
            $start            = ($maxResultPerPage * $page) - $maxResultPerPage ;
            $pagination       = "LIMIT $start,$maxResultPerPage";
        } else {
            $pagination = '';
        }       
        
        return $pagination;
        
    }
}
