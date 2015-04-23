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

App::uses('AppController', 'Controller', 'Item');
/**
 * MenuItemOptions Controller
 *
 * @property MenuItemOption $MenuItemOption
 * @property PaginatorComponent $Paginator
 */
class MenuItemOptionsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index($location_id, $menu_id, $category_id) {
		$this->MenuItemOption->recursive = 0;

		$this->Paginator->settings = array(
			'conditions' => array(
				'MenuItemOption.menu_id' => $menu_id,
				'MenuItemOption.menu_category_id' => $category_id
			)
		);

		$this->set('menuItemOptions', $this->Paginator->paginate());
		$this->set(compact('location_id', 'menu_id', 'category_id'));
	}


/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($location_id, $menu_id, $category_id, $id = null) {
		if (!$this->MenuItemOption->exists($id)) {
			throw new NotFoundException(__('Invalid menu item option'));
		}
		$options = array('conditions' => array('MenuItemOption.' . $this->MenuItemOption->primaryKey => $id));
		$this->set('menuItemOption', $this->MenuItemOption->find('first', $options));

		$menuItemOptionValues = $this->MenuItemOption->MenuItemOptionValue->find('all', array(
			'conditions' => array(
				'MenuItemOptionValue.menu_item_option_id' => $id
			)
		));
		$this->set('menuItemOptionValues', $menuItemOptionValues);
		$this->set(compact('location_id', 'menu_id', 'category_id'));
	}


/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add($location_id, $menu_id, $category_id) {
		if ($this->request->is('post')) {
			$this->MenuItemOption->create();
			$this->MenuItemOption->attachTree($category_id);
			$this->request->data['MenuItemOption']['menu_id'] = $menu_id;
			$this->request->data['MenuItemOption']['menu_category_id'] = $category_id;
			if ($this->MenuItemOption->save($this->request->data)) {
				$this->Session->setFlash(__('The menu item option has been saved. <b>ADD SOME VALUES</b>'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array(
					'controller' => 'menu_item_option_values',
					'action' => 'admin_add',
					$location_id,
					$menu_id,
					$category_id,
                    $this->MenuItemOption->getLastInsertID()
				));
			} else {
				$this->Session->setFlash(__('The menu item option could not be saved. Please, try again.'));
			}
		}
		// $menus = $this->MenuItemOption->Menu->find('list');
		// $menuItems = $this->MenuItemOption->Menu->MenuItem->find('list');
		// $this->set(compact('menus', 'menuItems'));
		$this->set(compact('location_id', 'menu_id', 'category_id'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($location_id, $menu_id, $category_id, $id = null) {
		if (!$this->MenuItemOption->exists($id)) {
			throw new NotFoundException(__('Invalid menu item option'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->MenuItemOption->attachTree($category_id);
			if ($this->MenuItemOption->save($this->request->data)) {
				$this->Session->setFlash(__('The menu item option has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array(
					'action' => 'index',
					$location_id,
					$menu_id,
					$category_id,
                    '#' => $category_id
				));
			} else {
				$this->Session->setFlash(__('The menu item option could not be saved. Please, try again.'));
			}
		} else {
			$options = array(
				'conditions' => array('MenuItemOption.' . $this->MenuItemOption->primaryKey => $id)
			);
			$this->request->data = $this->MenuItemOption->find('first', $options);
		}
		// $menus = $this->MenuItemOption->Menu->find('list');
		// $menuItems = $this->MenuItemOption->Menu->MenuItem->find('list');
		//$this->set(compact('menus', 'menuItems'));
		$this->set(compact('location_id', 'menu_id', 'category_id'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($location_id, $menu_id, $category_id, $id = null) {
		$this->MenuItemOption->id = $id;
		if (!$this->MenuItemOption->exists()) {
			throw new NotFoundException(__('Invalid menu item option'));
		}
		$this->request->onlyAllow('post', 'delete');
		$this->MenuItemOption->attachTree($category_id);
		if ($this->MenuItemOption->delete()) {
			$this->Session->setFlash(__('Menu item option deleted'), 'default', array('class' => 'flash_success'));
			return $this->redirect(array(
				'action' => 'index',
				$location_id,
				$menu_id,
				$category_id,
                '#' => $category_id
			));
		}
		$this->Session->setFlash(__('Menu item option was not deleted'));
		return $this->redirect(array(
			'action' => 'index',
			$location_id,
			$menu_id,
			$category_id,
            '#' => $category_id
		));
	}

	public function admin_move_up($location_id, $menu_id, $category_id, $id = null, $delta = 1) {
        $this->MenuItemOption->attachTree($category_id);
        $this->MenuItemOption->id = $id;
        if ($this->MenuItemOption->moveUp($this->MenuItemOption->id, abs($delta))) {
            $this->Session->setFlash(__('The option has been moved up!'), 'default', array('class' => 'flash_success'));
            return $this->redirect(array(
				'action' => 'index',
				$location_id,
				$menu_id,
				$category_id,
	            '#' => $category_id
			));
        }
        $this->Session->setFlash(__('I can\'t move the option any higher than that!'));
        return $this->redirect(array(
			'action' => 'index',
			$location_id,
			$menu_id,
			$category_id,
            '#' => $category_id
		));
    }

    public function admin_move_down($location_id, $menu_id, $category_id, $id = null, $delta = 1) {
        $this->MenuItemOption->attachTree($category_id);
        $this->MenuItemOption->id = $id;
        if ($this->MenuItemOption->moveDown($this->MenuItemOption->id, abs($delta))) {
            $this->Session->setFlash(__('The option has been moved down!'), 'default', array('class' => 'flash_success'));
            return $this->redirect(array(
				'action' => 'index',
				$location_id,
				$menu_id,
				$category_id,
                '#' => $category_id
			));
        }
        $this->Session->setFlash(__('I can\'t move the option any lower than that!'));
        return $this->redirect(array(
			'action' => 'index',
			$location_id,
			$menu_id,
			$category_id,
            '#' => $category_id
		));
    }
	
	public function add_option($itemId){
		
		
	}
}