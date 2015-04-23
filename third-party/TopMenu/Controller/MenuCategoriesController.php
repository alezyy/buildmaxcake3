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
 * MenuCategories Controller
 *
 * @property MenuCategory $MenuCategory
 * @property PaginatorComponent $Paginator
 */
class MenuCategoriesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Image', 'UploadValidation');
    public $helpers = array('Image');



/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add($location_id, $menu_id) {
		if ($this->request->is('post')) {
			$this->MenuCategory->attachTree($menu_id);
			$this->MenuCategory->create();
			$this->request->data['MenuCategory']['menu_id'] = $menu_id;
			$this->Image->process('image', array('700x700'));
			$save = $this->UploadValidation->validate();
			if ($save && $this->MenuCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The menu item group has been saved'), 'default', array('class' => 'flash_success'));
				if (isset($this->request->data['MenuCategory']['image'])) {
                    $this->Image->finishCreate(
                        $this->request->data['MenuCategory']['image'], $this->MenuCategory->getLastInsertID()
                    );
                }
				return $this->redirect(array(
					'controller' => 'menus',
					'action' => 'view',
					$location_id,
					$menu_id,
                    '#' => $id
				));
			} else {
				$this->Session->setFlash(__('The menu item group could not be saved. Please, try again.'));
				$this->Image->delete('image');
			}
		}
		$menus = $this->MenuCategory->Menu->find('list');
		$this->set(compact('menus', 'location_id', 'menu_id'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($location_id, $menu_id, $id = null) {
		if (!$this->MenuCategory->exists($id)) {
			throw new NotFoundException(__('Invalid menu item group'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->MenuCategory->attachTree($menu_id);
			$this->Image->process('image', array('700x700'));
			$save = $this->UploadValidation->validate();

			if ($save && $this->MenuCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The menu item group has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array(
					'controller' => 'menus',
					'action' => 'view',
					$location_id,
					$menu_id,
                    '#' => $id
				));
			} else {
				$this->Session->setFlash(__('The menu item group could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('MenuCategory.' . $this->MenuCategory->primaryKey => $id));
			$this->request->data = $this->MenuCategory->find('first', $options);
		}
		$menus = $this->MenuCategory->Menu->find('list');
		$this->set(compact('menus', 'location_id', 'menu_id'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($location_id, $menu_id, $id = null) {
		$this->MenuCategory->id = $id;
		$this->MenuCategory->attachTree($menu_id);
		if (!$this->MenuCategory->exists()) {
			throw new NotFoundException(__('Invalid menu item group'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->MenuCategory->delete(null, true)) {
			$this->Session->setFlash(__('Menu item group deleted'), 'default', array('class' => 'flash_success'));
		} else {
			$this->Session->setFlash(__('Menu item group was not deleted'));
		}
		return $this->redirect(array(
			'controller' => 'menus',
			'action' => 'view',
			$location_id,
			$menu_id
		));
	}


	public function admin_move_up($location_id, $menu_id, $id = null, $delta = 1) {
		$this->MenuCategory->attachTree($menu_id);
		$this->MenuCategory->id = $id;
		if ($this->MenuCategory->moveUp($this->MenuCategory->id, abs($delta))) {
			$this->Session->setFlash(__('The category has been moved up!'), 'default', array('class' => 'flash_success'));
			$this->redirect(array(
				'controller' => 'menus',
				'action' => 'view',
				$location_id,
				$menu_id,
	            '#' => $id
			));
		}
		$this->Session->setFlash(__('I can\'t move the Category any higher than that!'));
		$this->redirect(array(
			'controller' => 'menus',
			'action' => 'view',
			$location_id,
			$menu_id,
            '#' => $id
		));
	}

	public function admin_move_down($location_id, $menu_id, $id = null, $delta = 1) {
		$this->MenuCategory->id = $id;
		$this->MenuCategory->attachTree($menu_id);
		if ($this->MenuCategory->moveDown($this->MenuCategory->id, abs($delta))) {
			$this->Session->setFlash(__('The category has been moved down!'), 'default', array('class' => 'flash_success'));
			$this->redirect(array(
				'controller' => 'menus',
				'action' => 'view',
				$location_id,
				$menu_id,
	            '#' => $id
			));
		}
		$this->Session->setFlash(__('I can\'t move the Category any lower than that!'));
		$this->redirect(array(
			'controller' => 'menus',
			'action' => 'view',
			$location_id,
			$menu_id,
            '#' => $id
		));
	}
	
	/**
	 * Takes an existing category and all of it's relations and duplicates it
	 * @param type $categoryId
	 */
	public function admin_duplicate($categoryId){
		$this->loadModel('MenuCategory');
		$result = $this->MenuCategory->duplicate($categoryId);
		if (!$result){
			$this->Session->setFlash(__('Could not duplicate the category'));			
		}else{
			$this->Session->setFlash(__('Category duplication done'), 'default', array('class' => 'flash_success'));
		}
		
		$this->redirect($this->referer());
	}
}
