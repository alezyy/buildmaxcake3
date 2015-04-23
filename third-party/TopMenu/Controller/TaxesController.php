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
 * Taxes Controller
 *
 * @property Tax $Tax
 * @property PaginatorComponent $Paginator
 */
class TaxesController extends AppController {

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
		$this->Tax->recursive = 0;
		$this->set('taxes', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Tax->exists($id)) {
			throw new NotFoundException(__('Invalid tax'));
		}
		$options = array('conditions' => array('Tax.' . $this->Tax->primaryKey => $id));
		$this->set('tax', $this->Tax->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		// if ($this->request->is('post')) {
		// 	$this->Tax->create();
		// 	if ($this->Tax->save($this->request->data)) {
		// 		$this->Session->setFlash(__('The tax has been saved'));
		// 		return $this->redirect(array('action' => 'index'));
		// 	} else {
		// 		$this->Session->setFlash(__('The tax could not be saved. Please, try again.'));
		// 	}
		// }
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Tax->exists($id)) {
			throw new NotFoundException(__('Invalid tax'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Tax->save($this->request->data)) {
				$this->Session->setFlash(__('The tax has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tax could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Tax.' . $this->Tax->primaryKey => $id));
			$this->request->data = $this->Tax->find('first', $options);
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
		// $this->Tax->id = $id;
		// if (!$this->Tax->exists()) {
		// 	throw new NotFoundException(__('Invalid tax'));
		// }
		// $this->request->onlyAllow('post', 'delete');
		// if ($this->Tax->delete()) {
		// 	$this->Session->setFlash(__('Tax deleted'));
		// 	return $this->redirect(array('action' => 'index'));
		// }
		// $this->Session->setFlash(__('Tax was not deleted'));
		// return $this->redirect(array('action' => 'index'));
	}
}
