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
 * MenuItem Model
 *
 * @property Menu $Menu
 * @property MenuCategory $MenuCategory
 * @property OrderDetail $OrderDetail
 */
class MenuItem extends AppModel {

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

    public $order = array('MenuItem.lft' => 'ASC');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'menu_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'menu_item_group_id' => array(
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
		'name_en' => array(
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
		'number_of_instance' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'price' => array(
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
		'Menu' => array(
			'className' => 'Menu',
			'foreignKey' => 'menu_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'MenuCategory'
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'OrderDetail' => array(
			'className' => 'OrderDetail',
			'foreignKey' => 'menu_item_id',
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
     * $hasAndBelongsToMany associations
     * 
     * @var array
     */
   	public $hasAndBelongsToMany = array(
		'MenuItemOption' => array(
			'className' => 'MenuItemOption',
			'joinTable' => 'menu_item_options_menu_items',
			'foreignKey' => 'menu_item_id',
			'associationForeignKey' => 'menu_item_option_id'
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
		$this->virtualFields['name'] = 'MenuItem.name_' . $this->langSuffix;
		$this->virtualFields['description'] = 'MenuItem.description_' . $this->langSuffix;
		$this->virtualFields['no_price_text'] = 'MenuItem.no_price_text_' . $this->langSuffix;
		$this->displayField .= (empty($this->langSuffix) ? 'fr' : $this->langSuffix);
	}

/**
 * After Find
 * @param  array   $results
 * @param  boolean $primary
 * @return array
 */
	public function afterFind($results = array(), $primary = false) {
		
		foreach ($results as $key => $result) {
			if (isset($result['MenuItem']['id'])) {
				$results[$key]['MenuItem']['has_options'] = $this->hasOptions($result['MenuItem']['id']);
			}
		}
		return parent::afterFind($results, $primary);
	}

	/**
	 * Attaches a tree and scopes by menu_id
	 *
	 * @access private
	 * @return void
	 */
	public function attachTree($menu_category_id) {
		$scope = array(
	        "MenuItem.menu_category_id" => $menu_category_id
	    );

		$this->Behaviors->load('Tree', array(
	        'scope' => $scope
	    ));
	}


/**
 * Before we save, if the _en field isn't set (on a new record)
 * set it to the same as _fr
 * 
 */
	public function beforeSave($options = array()) {
		parent::beforeSave($options);
		if (!$this->id) {
			if (empty($this->data['MenuItem']['name_en']) && !empty($this->data['MenuItem']['name_fr'])) {
				$this->data['MenuItem']['name_en'] = $this->data['MenuItem']['name_fr'];
			}

			if (empty($this->data['MenuItem']['description_en']) && !empty($this->data['MenuItem']['description_fr'])) {
				$this->data['MenuItem']['description_en'] = $this->data['MenuItem']['description_fr'];
			}						
		}
	}
    

    /**
     * Gets all items and there category for the given location <br/> Items belonging to multiple categories will be 
     * returned multiple time, each time mapped with the different location
     * 
     * @param string $menuId UUID of the location 
     * 
     * @return array array with all fields of all 
     */
    public function getItemsAndCategoriesByLocationId($menuId){     
        $res = $this->find('all', array(
            'contain' => array(
                'MenuCategory' => array(
                    'fields' => array('id'),
                    )),
            'fields' => array('MenuItem.id', 'MenuItem.name', 'MenuItem.description', 'MenuItem.price'),
            'conditions' => array('MenuItem.menu_id' => $menuId, 'MenuItem.status' => 'active')));         
        return $res;
    }
	
	/**
     * Fetches a menu with only the right fields to be displayed on the restaurant page. 
     * Also allows admins to see the menu even if it's inactive.
     * @param type $menuId
     * @param type $group_id user level of the user null means not loged in
     * @return Cake data array of the menu
     */
	public function getToDisplayAsMenu($menuId, $group_id = null){
        
        $conditions = array('MenuItem.menu_id' => $menuId);
        
        // Admin can see inactive menu but users should not
        if ($group_id === 5 || $group_id === null) {            
            $conditions['MenuItem.status'] = 'active';
            
        }
		return $this->find('all', array(
			'conditions' => $conditions,
			'fields' => array(
				'MenuItem.id', 
				'MenuItem.name', 
				'MenuItem.description', 
				'MenuItem.price', 
				'MenuItem.menu_category_id', 
				'MenuItem.no_price_text',
				'MenuItem.image')));
	}
	
	/**
	 * Check which items in a array have size to check if the items categories needs a to group items by size 
	 * and the each size name found.
	 * 
	 * @param array		$items	Array of items
	 * @return array			Map of categories and size names
     * @deprecated since version 2.0.62
	 */
	public function getCategoriesWithSizes($items){
		
		$result = array();
		
		// Get sizes by categories
		foreach ($items as $item) {
	
			$size = $item['MenuItem']['size'];
			$weight = $item['MenuItem']['size_weight'];
			$cat = $item['MenuItem']['menu_category_id'];
			
			if(!empty($size)){				
				if(empty($result[$cat])){
					$result[$cat] = array(); 
				}
				
				if(!in_array(array($size, $weight), $result[$cat])){
					$result[$cat][] = array($size, $weight);
				}
				
			}			
		}
		
		// Sort size insid categories		
		foreach ($result as $r) {
			usort($r, function($a, $b) {
				return $a[1] - $b[1];
			});
			
		}
		
		
		return $result;
	}
	
	/**
	 * Get the id of the location to which this menu item belongs
	 * 
	 * @param	string	$id		item id
	 * 
	 * @return	string			UUID of the location corresponding to this item
	 */
	public function getLocationId($id){
		
		$menu = ClassRegistry::init('Menu');
		
		// get category id
		$item = $this->findById($id);
		
		// get location id
		$menuData = $menu->findById($item['MenuItem']['menu_id']);
		
		return $menuData['Menu']['location_id'];
	}

/**
 * Checks to see if an item has options
 * @param  [type]  $id [description]
 * @return boolean     [description]
 */
	public function hasOptions($id) {
		$MenuItemOptionMenuItem = ClassRegistry::init('MenuItemOptionMenuItem');

		$MenuItemOptionMenuItem->useTable = 'menu_item_options_menu_items';

		$count = $MenuItemOptionMenuItem->find('count', array(
			'conditions' => array(
				'MenuItemOptionMenuItem.menu_item_id' => $id
			)
		));

		if ($count) {
			return $count;
		}
		return false;
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
