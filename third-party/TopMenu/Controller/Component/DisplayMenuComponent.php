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
 * @version       2
 *                                                                   
 */


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP Component
 * @author pechartrand
 */
class DisplayMenuComponent extends Component {

    public $components = array();
    public $settings = array();



    public function display($locationId) {

        $menuModel = ClassRegistry::init('Menu');
        $menuItemModel = ClassRegistry::init('MenuItem');
        $menuCategoryModel = ClassRegistry::init('MenuCategory');
        $tipOptionModel = ClassRegistry::init('TipOption');
        
        $menuId = $menuModel->getActiveMenuForLocation($locationId);                         // Active menu id
        
                        
        if (!empty($menuId)) {
            $result['items'] = $menuItemModel->getItemsAndCategoriesByLocationId($menuId['Menu']['id']);    // list of items mapped with there category                
			
            $itemIdArray = array();                                                                         // converted MenuItem object into an array of items
            foreach ($result['items'] as $m) {
                $itemIdArray[] = $m['MenuItem']['id'];
            }                       
			$result['categories2'] = $menuItemModel->find('all', array(
				'fields' => array( 
					'MenuCategory.id', 
					'MenuCategory.start_time', 
					'MenuCategory.end_time', 
					'MenuCategory.name_en', 
					'MenuCategory.description_en'),
				'contain' => 'MenuCategory',
				'conditions' => array('MenuItem.menu_id' => $menuId['Menu']['id']),
				'group' => array('MenuItem.id')
				)
			);
            $result['categories'] = $menuCategoryModel->getGroupsInItemList($itemIdArray);          // list of categories associated             
            $result['tipOtions'] = $tipOptionModel->getTipOptions($locationId);                     // to add a tip to order            
        } else {
            $result['categories'] = null;
            $result['items'] = $items;
            $result['tipOtions'] = null;
        }

        return $result;
    }

}