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
 * Features Controller
 *
 * @property Feature $Feature
 * @property PaginatorComponent $Paginator
 */
class FeaturesController extends AppController {

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
		$this->Feature->recursive = 0;
		$this->set('features', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Feature->exists($id)) {
			throw new NotFoundException(__('Invalid feature'));
		}
		$options = array('conditions' => array('Feature.' . $this->Feature->primaryKey => $id));
		$this->set('feature', $this->Feature->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Feature->create();
			if ($this->Feature->save($this->request->data)) {
				$this->Session->setFlash(__('The feature has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The feature could not be saved. Please, try again.'));
			}
		}
		$locations = $this->Feature->Location->find('list');
		$this->set(compact('locations'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Feature->exists($id)) {
			throw new NotFoundException(__('Invalid feature'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Feature->save($this->request->data)) {
				$this->Session->setFlash(__('The feature has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The feature could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Feature.' . $this->Feature->primaryKey => $id));
			$this->request->data = $this->Feature->find('first', $options);
		}
		$locations = $this->Feature->Location->find('list');
		$this->set(compact('locations'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Feature->id = $id;
		if (!$this->Feature->exists()) {
			throw new NotFoundException(__('Invalid feature'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Feature->delete()) {
			$this->Session->setFlash(__('Feature deleted'), 'default', array('class' => 'flash_success'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Feature was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
}
