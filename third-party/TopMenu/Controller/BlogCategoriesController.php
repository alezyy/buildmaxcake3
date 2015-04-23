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
 * BlogCategories Controller
 *
 * @property BlogCategory $BlogCategory
 * @property PaginatorComponent $Paginator
 */
class BlogCategoriesController extends AppController {

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
	public function admin_index() {
		$this->BlogCategory->recursive = 0;
		$this->set('blogCategories', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->BlogCategory->exists($id)) {
			throw new NotFoundException(__('Invalid blog category'));
		}
		$options = array('conditions' => array('BlogCategory.' . $this->BlogCategory->primaryKey => $id));
		$this->set('blogCategory', $this->BlogCategory->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->BlogCategory->create();
			if ($this->BlogCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The blog category has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The blog category could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->BlogCategory->exists($id)) {
			throw new NotFoundException(__('Invalid blog category'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->BlogCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The blog category has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The blog category could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('BlogCategory.' . $this->BlogCategory->primaryKey => $id));
			$this->request->data = $this->BlogCategory->find('first', $options);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->BlogCategory->id = $id;
		if (!$this->BlogCategory->exists()) {
			throw new NotFoundException(__('Invalid blog category'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->BlogCategory->delete()) {
			$this->Session->setFlash(__('Blog category deleted'), 'default', array('class' => 'flash_success'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Blog category was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
}
