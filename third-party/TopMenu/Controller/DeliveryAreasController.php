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
 * DeliveryAreas Controller
 *
 * @property DeliveryArea $DeliveryArea
 * @property PaginatorComponent $Paginator
 */
class DeliveryAreasController extends AppController {

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
	public function admin_index($location_id) {
		$this->DeliveryArea->recursive = 0;
		$this->Paginator->settings = array(
			'conditions' => array(
				'DeliveryArea.location_id' => $location_id
			)
		);
		$this->set(compact('location_id'));
		$this->set('deliveryAreas', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($location_id, $id) {
		if (!$this->DeliveryArea->exists($id)) {
			throw new NotFoundException(__('Invalid delivery area'));
		}
		$options = array(
			'conditions' => array(
				'DeliveryArea.id'          => $id,
				'DeliveryArea.location_id' => $location_id
			),
			'recursive' => 0
		);
		$this->set(compact('location_id'));
		$this->set('deliveryArea', $this->DeliveryArea->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add($location_id) {
		if ($this->request->is('post')) {
			$this->DeliveryArea->create();
			$this->request->data['DeliveryArea']['location_id'] = $location_id;
			if ($this->DeliveryArea->save($this->request->data)) {
				$this->Session->setFlash(
					__('The delivery area has been saved'),
					'default',
					array('class' => 'flash_success')
				);
				return $this->redirect(array('action' => 'admin_add', $location_id));
			} else {
				$this->Session->setFlash(__('The delivery area could not be saved. Please, try again.'));
			}
		}
		$locations = $this->DeliveryArea->Location->find('list');
		$this->set(compact('locations', 'location_id'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($location_id, $id = null) {
		if (!$this->DeliveryArea->exists($id)) {
			throw new NotFoundException(__('Invalid delivery area'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->DeliveryArea->save($this->request->data)) {
				$this->Session->setFlash(
					__('The delivery area has been saved'),
					'default',
					array('class' => 'flash_success')
				);
				return $this->redirect(array('action' => 'index', $location_id));
			} else {
				$this->Session->setFlash(__('The delivery area could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('DeliveryArea.' . $this->DeliveryArea->primaryKey => $id));
			$this->request->data = $this->DeliveryArea->find('first', $options);
		}
		$locations = $this->DeliveryArea->Location->find('list');
		$this->set(compact('locations', 'location_id'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($location_id, $id = null) {
		$this->DeliveryArea->id = $id;
		if (!$this->DeliveryArea->exists()) {
			throw new NotFoundException(__('Invalid delivery area'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DeliveryArea->delete()) {
			$this->Session->setFlash(__('Delivery area deleted'), 'default', array('class' => 'flash_success'));
			return $this->redirect(array('action' => 'index', $location_id));
		}
		$this->Session->setFlash(__('Delivery area was not deleted'));
		return $this->redirect(array('action' => 'index', $location_id));
	}
}
