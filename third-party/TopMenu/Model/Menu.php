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
 * Menu Model
 *
 * @property Location $Location
 * @property ItemGroup $ItemGroup
 * @property MenuItemOption $MenuItemOption
 * @property MenuItem $MenuItem
 */
class Menu extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
    
    public $actsAs = array('Containable');

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
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
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
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'location_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'MenuCategory' => array(
			'className' => 'MenuCategory',
			'foreignKey' => 'menu_id',
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
		'MenuItem' => array(
			'className' => 'MenuItem',
			'foreignKey' => 'menu_id',
			'dependent' => true,
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
     * Gets the currently active menu for a given location (or for the restaurant if no menu at this location)
     * 
     * @param string $locationId uuid of the location
     * @param type $group_id user level of the user null means not loged in
     * @returns string UUID of the active menu
     */
    public function getActiveMenuForLocation($locationId, $group_id = null){
        
        $conditions = array('Menu.location_id' => $locationId);
        
        // Admin can see inactive menu but users should not
        if ($group_id === 5 || $group_id === null) {            
            $conditions['Menu.status'] = 'active';            
        }
        
         // Get all items for this menu
    	$menu_id = false;
        $menuId = $this->find('first', array(
            'conditions' => $conditions,
            'fields' => array('id')));  // find menu id
         
        // if no restults check with restaurant id
        if (empty($menuId)){
            $menu_id = false;
        } else {
        	$menu_id = $menuId['Menu']['id'];
        }
        return $menu_id;
         
    }		
}
