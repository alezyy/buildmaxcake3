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
 * TipOptions Controller
 *
 * @property TipOption $TipOption
 * @property PaginatorComponent $Paginator
 */
class TipOptionsController extends AppController {

	public $uses = array('Order');

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'OrderSession');

	/**
	 * beforeFilter
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow(
			'add_to_order',
			'remove_tip'
		);

		$this->Security->unlockedActions = array(
            'add_to_order',
            'remove_tip'
        );
	}

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this->TipOption->recursive = 0;
		$this->set('tipOption', $this->Paginator->paginate());
	}

	/**
	 * admin_view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->TipOption->exists($id)) {
			throw new NotFoundException(__('Invalid tipOption'));
		}
		$options = array('conditions' => array('TipOption.' . $this->TipOption->primaryKey => $id));
		$this->set('tipOption', $this->TipOption->find('first', $options));
	}

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->TipOption->create();
			if ($this->TipOption->save($this->request->data)) {
				$this->Session->setFlash(__('The tip has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tipOption could not be saved. Please, try again.'));
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
		if (!$this->TipOption->exists($id)) {
			throw new NotFoundException(__('Invalid tipOption'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->TipOption->save($this->request->data)) {
				$this->Session->setFlash(__('The tipOption has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tipOption could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('TipOption.' . $this->TipOption->primaryKey => $id));
			$this->request->data = $this->TipOption->find('first', $options);
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
		$this->TipOption->id = $id;
		if (!$this->TipOption->exists()) {
			throw new NotFoundException(__('Invalid tipOption'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->TipOption->delete()) {
			$this->Session->setFlash(__('TipOption deleted'), 'default', array('class' => 'flash_success'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('TipOption was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * Add the selected tip to the session, updates the order's totals and refresh the order sidebar
	 * 
	 * @param string $amount tip amount in dollars
	 * @param string $locationId UUID of the current location
	 */
	public function add_to_order($amount, $locationId) {
		
		$amountAdded = $amount;
		$this->autoRender = false;
		
		if ($this->OrderSession->validateEdit($locationId) && $amount > 0) {
			// update data
			$currentTip = ($this->Session->read('Order.Order.tip')) ? $this->Session->read('Order.Order.tip') : 0;
			$amount += $currentTip;			 // add tip to current tip
			$this->Session->write('Order.Order.tip', $amount);	  // write data to session
			$update = $this->Order->updateCurrent($this->Session->read('Order')); // calculate totals
			$this->Session->write('Order', $update);

			// render cart element
			$location = array();
			$location['Location']['id'] = $locationId;
			$this->set(compact('location'));
			$this->layout = 'ajax';
			$this->render('/Elements/cart');
		}
	}
	
	public function remove_tip() {
		$this->autoRender = false;
		$this->OrderSession->validateEdit($this->Session->read('Order.Order.location_id'));
		$this->Session->write('Order.Order.tip', 0);
		$update = $this->Order->updateCurrent($this->Session->read('Order')); // recalculate order
		$this->Session->write('Order', $update);		// update session
		
		// render cart element
		$this->layout = 'ajax';
		$this->render('/Elements/cart');
	}
	
	
	/**
	 * Strips anything after a interogation point in a url<br/>
	 * this:    http://domain.com/param1/param2?bbb&aaa=aaa#ccc<br/>
	 * becomes: http://domain.com/param1/param2
	 * 
	 * @param string $url
	 * @return string url
	 * @todo Put in component
	 */
	private function _stripGetParemeterFromUrl($url){
		return substr($url, 0, strpos($url, "?"));	// remove all the parameters from the string	
	}
}
