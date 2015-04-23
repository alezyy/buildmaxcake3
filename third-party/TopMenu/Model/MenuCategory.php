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
 * MenuCategory Model
 *
 * @property Menu $Menu
 */
class MenuCategory extends AppModel {

	
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name_';


/**
 * actsAs
 *
 * (default value: array('Tree'))
 *
 * @var string
 * @access public
 */
	public $actsAs = array('Tree');

/**
 * Default order
 * @var array
 */
	public $order = array('MenuCategory.lft' => 'ASC');

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
		'name_fr' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
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
		),
		// 'description_en' => array(
		// 	'notempty' => array(
		// 		'rule' => array('notempty'),
		// 		'message' => 'Must not be empty!',
		// 		//'allowEmpty' => false,
		// 		//'required' => false,
		// 		//'last' => false, // Stop validation after this rule
		// 		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		// 	),
		// ),
		// 'description_fr' => array(
		// 	'notempty' => array(
		// 		'rule' => array('notempty'),
		// 		'message' => 'Must not be empty!',
		// 		//'allowEmpty' => false,
		// 		//'required' => false,
		// 		//'last' => false, // Stop validation after this rule
		// 		//'on' => 'create', // Limit validation to 'create' or 'update' operations
		// 	),
		// ),
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
		'Menu' => array(
			'className' => 'Menu',
			'foreignKey' => 'menu_id',
			'conditions' => '',
			'fields' => '',
		)
	);
	
	    /**
     * $hasAndBelongsToMany associations
     * 
     * @var array
     */
    public $hasMany = array(
        'MenuItem' => array(
        	'order' => array(
        		'MenuItem.lft' => 'ASC'
        	)
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
		$this->virtualFields['name'] = 'MenuCategory.name_' . $this->langSuffix;
		$this->virtualFields['description'] = 'MenuCategory.description_' . $this->langSuffix;
		$this->displayField .= (empty($this->langSuffix) ? 'fr' : $this->langSuffix);
	}


/**
 * Before we save, if the _en field isn't set (on a new record)
 * set it to the same as _fr
 * 
 */
	public function beforeSave($options = array()) {
		parent::beforeSave($options);

	}

	/**
	 * Attaches a tree and scopes by menu_id
	 *
	 * @access private
	 * @return void
	 */
	public function attachTree($menu_id) {
		$scope = array(
	        "MenuCategory.menu_id" => $menu_id
	    );

		$this->Behaviors->load('Tree', array(
	        'scope' => $scope
	    ));
	}

    
    /**
     * Find all the categories assiociated wit a list of items
     * 
     * @param array $itemsId Array of the items id
     * @return array/false list categories wit all there fields false if no record where found
     * 
     */
    public function getGroupsInItemList($itemsId){
        $itemsIdString = "";
        foreach ($itemsId as    $id){
             $itemsIdString .= "'".$id."',";  // wrap uuid in quotes for sql query and add comma to seperat them
        }
        $itemsIdString = substr($itemsIdString, 0, -1);
        
        if (!empty($itemsIdString)){
        return $this->query(
            "SELECT 
                `MenuCategory`.`start_time`, 
                `MenuCategory`.`end_time`, 
                (`MenuCategory`.`name_en`) AS `MenuCategory__name`, 
                (`MenuCategory`.`description_en`) AS `MenuCategory__description`, 
                `MenuCategoriesMenuItem`.`id`, 
                `MenuCategoriesMenuItem`.`menu_item_id`, 
                `MenuCategoriesMenuItem`.`menu_category_id` 
            FROM `topmenu2`.`menu_categories` AS `MenuCategory` 
            JOIN `topmenu2`.`menu_categories_menu_items` AS `MenuCategoriesMenuItem` 
            ON (`MenuCategoriesMenuItem`.`menu_item_id` 
            IN ({$itemsIdString})
            AND `MenuCategoriesMenuItem`.`menu_category_id` = `MenuCategory`.`id`)
            GROUP BY `MenuCategory`.`id`"            
            );
        }else{
         return FALSE;   
        }
    }
	
		public function findActiveByMenuId($menuId) {
		return $this->find('all', array(
				'fields' => array(
					'MenuCategory.id',
					'MenuCategory.start_time',
					'MenuCategory.end_time',
					'MenuCategory.name',
					'MenuCategory.image',
					'MenuCategory.description'),
				'conditions' => array('MenuCategory.menu_id' => $menuId, 'MenuCategory.status' => 'active'),
				'group' => array('MenuCategory.id')
				)
		);
	}
	
	/**
	 * Takes an existing category and all of it's relations and duplicates it
	 * @param	string	$categoryId		UUID of the category to duplicate
	 * @param	string	$newName		Name of the new category<br>
	 *									If no name is given, this appends "-new" to the old name to create the new one	
	 * @return	bool					TRUE/FALSE	
	 */
	public function duplicate($categoryId, $newName_en = NULL, $newName_fr = NULL) {

		App::import('Model', 'MenuItem');
		$menuItemModel = new MenuItem();
		App::import('Model', 'MenuItemOption');
		$menuItemOptionModel = new MenuItemOption();
	;

		// Get original category
		$this->recursive = 2;
		$oldCat = $this->findById($categoryId);
		$oldCatId = $oldCat['MenuCategory']['id'];

		// change cat name
		$newName_en = ($newName_en === NULL) ? $oldCat['MenuCategory']['name_en'] . '-new' : $newName_en;
		$oldCat['MenuCategory']['name_en'] = $newName_en;
		$newName_fr = ($newName_fr === NULL) ? $oldCat['MenuCategory']['name_fr'] . '-nouveau' : $newName_fr;
		$oldCat['MenuCategory']['name_fr'] = $newName_fr;


		// CREATE NEW CAT
		// create cate
		unset($oldCat['MenuCategory']['id']); // remove the old id 
		$this->create();		
		$this->save($oldCat['MenuCategory']);
		$newCatId = $this->getLastInsertID();

		// recreate all the items
		$menuId = $oldCat['Menu']['id'];
		foreach ($oldCat['Menu']['MenuItem'] as &$mi) {
			
			if($mi['menu_category_id'] === $oldCatId ){
				unset($mi['id']);
				$mi['menu_category_id'] = $newCatId;
				$mi['menu_id'] = $menuId;
			
				$menuItemModel->create();			
				$menuItemModel->save($mi);
				$miId = $menuItemModel->getLastInsertID();
			}
		}
		
		$menuItemOptionModel->recursive = 2;
		$thisCatItemsOptions = $this->find('all', array(
			'conditions' => array(
				'MenuCategory.id' => $categoryId)));
		foreach ($thisCatItemsOptions as &$tcio) {
			unset($tcio['id']);
			$tcio['menu_category_id'] = $newCatId;
			$menuItemOptionModel->create();
			$menuItemOptionModel->save($tcio);						
		}
				
		return TRUE;
	}
	
}
