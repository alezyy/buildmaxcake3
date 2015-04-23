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
 * Contests Controller
 *
 * @property Contest $Contest
 * @property PaginatorComponent $Paginator
 */
class ContestsController extends AppController {

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
		$this->Contest->recursive = 0;
		$this->set('contests', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Contest->exists($id)) {
			throw new NotFoundException(__('Invalid contest'));
		}
		$options = array('conditions' => array('Contest.' . $this->Contest->primaryKey => $id));
		$this->set('contest', $this->Contest->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Contest->create();
			if ($this->Contest->save($this->request->data)) {
				$this->Session->setFlash(__('The contest has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contest could not be saved. Please, try again.'));
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
		if (!$this->Contest->exists($id)) {
			throw new NotFoundException(__('Invalid contest'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Contest->save($this->request->data)) {
				$this->Session->setFlash(__('The contest has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contest could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Contest.' . $this->Contest->primaryKey => $id));
			$this->request->data = $this->Contest->find('first', $options);
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
		$this->Contest->id = $id;
		if (!$this->Contest->exists()) {
			throw new NotFoundException(__('Invalid contest'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Contest->delete()) {
			$this->Session->setFlash(__('Contest deleted'), 'default', array('class' => 'flash_success'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Contest was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
}
