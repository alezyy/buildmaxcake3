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

App::uses('AppController', 'Controller');
/**
 * MenuItemOptionValues Controller
 *
 * @property MenuItemOptionValue $MenuItemOptionValue
 * @property PaginatorComponent $Paginator
 */
class MenuItemOptionValuesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');


/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add($location_id, $menu_id, $category_id, $menu_item_option_id) {
		if ($this->request->is('post')) {
			$this->MenuItemOptionValue->create();
			$this->request->data['MenuItemOptionValue']['menu_id'] = $menu_id;
			$this->request->data['MenuItemOptionValue']['menu_category_id'] = $category_id;
			$this->request->data['MenuItemOptionValue']['menu_item_option_id'] = $menu_item_option_id;
			$this->MenuItemOptionValue->attachTree($menu_item_option_id);
			if ($this->MenuItemOptionValue->save($this->request->data)) {
				$this->Session->setFlash(__('The menu item option value has been saved.'), 'default', array('class' => 'flash_success'));
			} else {
				$this->Session->setFlash(__('The menu item option value could not be saved. Please, try again.'));
			}
		}
		$this->set(compact('menuItemOptions'));
		$this->set(compact('location_id', 'menu_id', 'category_id', 'menu_item_option_id'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($location_id, $menu_id, $category_id, $menu_item_option_id, $id = null) {
		if (!$this->MenuItemOptionValue->exists($id)) {
			throw new NotFoundException(__('Invalid menu item option value'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->MenuItemOptionValue->attachTree($menu_item_option_id);
			if ($this->MenuItemOptionValue->save($this->request->data)) {
				$this->Session->setFlash(__('The menu item option value has been saved.'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array(
					'controller' => 'menu_item_options',
					'action' => 'view',
					$location_id,
					$menu_id,
					$category_id,
					$menu_item_option_id,
                    '#' => $category_id
				));
			} else {
				$this->Session->setFlash(__('The menu item option value could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('MenuItemOptionValue.' . $this->MenuItemOptionValue->primaryKey => $id));
			$this->request->data = $this->MenuItemOptionValue->find('first', $options);
		}
		$this->set(compact('menuItemOptions'));
		$this->set(compact('location_id', 'menu_id', 'category_id', 'menu_item_option_id'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($location_id, $menu_id, $category_id, $menu_item_option_id, $id = null) {
		$this->MenuItemOptionValue->id = $id;
		if (!$this->MenuItemOptionValue->exists()) {
			throw new NotFoundException(__('Invalid menu item option value'));
		}
		$this->MenuItemOptionValue->attachTree($menu_item_option_id);
		$this->request->onlyAllow('post', 'delete');
		if ($this->MenuItemOptionValue->delete()) {
			$this->Session->setFlash(__('The menu item option value has been deleted.'), 'default', array('class' => 'flash_success'));
		} else {
			$this->Session->setFlash(__('The menu item option value could not be deleted. Please, try again.'));
		}
		return $this->redirect(array(
			'controller' => 'menu_item_options',
			'action' => 'view',
			$location_id,
			$menu_id,
			$category_id,
			$menu_item_option_id,
            '#' => $category_id
		));
	}

	public function admin_move_up($location_id, $menu_id, $category_id, $menu_item_option_id, $id = null, $delta = 1) {
        $this->MenuItemOptionValue->attachTree($menu_item_option_id);
        $this->MenuItemOptionValue->id = $id;

        if ($this->MenuItemOptionValue->moveUp($this->MenuItemOptionValue->id, abs($delta))) {
            $this->Session->setFlash(__('The option has been moved up!'), 'default', array('class' => 'flash_success'));
            return $this->redirect(array(
				'controller' => 'menu_item_options',
				'action' => 'view',
				$location_id,
				$menu_id,
				$category_id,
				$menu_item_option_id,
	            '#' => $category_id
			));
        }
        $this->Session->setFlash(__('I can\'t move the option any higher than that!'));
        return $this->redirect(array(
			'controller' => 'menu_item_options',
			'action' => 'view',
			$location_id,
			$menu_id,
			$category_id,
			$menu_item_option_id,
            '#' => $category_id
		));
    }

    public function admin_move_down($location_id, $menu_id, $category_id, $menu_item_option_id, $id = null, $delta = 1) {
        $this->MenuItemOptionValue->attachTree($menu_item_option_id);
        $this->MenuItemOptionValue->id = $id;
        if ($this->MenuItemOptionValue->moveDown($this->MenuItemOptionValue->id, abs($delta))) {
            $this->Session->setFlash(__('The option has been moved down!'), 'default', array('class' => 'flash_success'));
            return $this->redirect(array(
				'controller' => 'menu_item_options',
				'action' => 'view',
				$location_id,
				$menu_id,
				$category_id,
				$menu_item_option_id,
                '#' => $category_id
			));
        }
        $this->Session->setFlash(__('I can\'t move the option any lower than that!'));
        return $this->redirect(array(
			'controller' => 'menu_item_options',
			'action' => 'view',
			$location_id,
			$menu_id,
			$category_id,
			$menu_item_option_id,
            '#' => $category_id
		));
    }
}