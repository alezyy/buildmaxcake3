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
 * Domains Controller
 *
 * @property Domain $Domain
 * @property PaginatorComponent $Paginator
 */
class DomainsController extends AppController {

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
	public function admin_index($restaurant_id) {
		$this->Domain->recursive = 0;
		$this->Paginator->settings = array(
			'conditions' => array(
				'Domain.restaurant_id' => $restaurant_id
			)
		);
		$domains = $this->Paginator->paginate();
		$this->set('restaurant_name', $this->Domain->Restaurant->getRestaurantName($restaurant_id));
		$this->set(compact('domains', 'restaurant_id'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($restaurant_id, $id = null) {
		if (!$this->Domain->exists($id)) {
			throw new NotFoundException(__('Invalid domain'));
		}
		$options = array(
			'conditions' => array(
				'Domain.id' => $id,
				'Domain.restaurant_id' => $restaurant_id
			),
			'recursive' => 0
		);
		$this->set('restaurant_id', $restaurant_id);
		$this->set('restaurant_name', $this->Domain->Restaurant->getRestaurantName($restaurant_id));
		$this->set('domain', $this->Domain->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add($restaurant_id) {
		if ($this->request->is('post')) {
			$this->Domain->create();
			$this->request->data['Domain']['restaurant_id'] = $restaurant_id;
			if ($this->Domain->save($this->request->data)) {
				$this->Session->setFlash(__('The domain has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index', $restaurant_id));
			} else {
				$this->Session->setFlash(__('The domain could not be saved. Please, try again.'));
			}
		}
		$restaurants = $this->Domain->Restaurant->find('list');
		$themes = $this->Domain->Theme->find('list');
		$this->set('restaurant_name', $this->Domain->Restaurant->getRestaurantName($restaurant_id));
		$this->set(compact('restaurants', 'themes', 'restaurant_id'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($restaurant_id, $id = null) {
		if (!$this->Domain->exists($id)) {
			throw new NotFoundException(__('Invalid domain'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Domain->save($this->request->data)) {
				$this->Session->setFlash(__('The domain has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index', $restaurant_id));
			} else {
				$this->Session->setFlash(__('The domain could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Domain.' . $this->Domain->primaryKey => $id));
			$this->request->data = $this->Domain->find('first', $options);
		}
		$restaurants = $this->Domain->Restaurant->find('list');
		$themes = $this->Domain->Theme->find('list');
		$this->set('restaurant_name', $this->Domain->Restaurant->getRestaurantName($restaurant_id));
		$this->set(compact('restaurants', 'themes', 'restaurant_id'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($restaurant_id, $id = null) {
		$this->Domain->id = $id;
		if (!$this->Domain->exists()) {
			throw new NotFoundException(__('Invalid domain'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Domain->delete()) {
			$this->Session->setFlash(__('Domain deleted'), 'default', array('class' => 'flash_success'));
			return $this->redirect(array('action' => 'index', $restaurant_id));
		}
		$this->Session->setFlash(__('Domain was not deleted'));
		return $this->redirect(array('action' => 'index', $restaurant_id));
	}
}
