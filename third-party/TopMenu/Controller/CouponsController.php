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
 * Coupons Controller
 *
 * @property Coupon $Coupon
 * @property PaginatorComponent $Paginator
 */
class CouponsController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator');
    
    public function beforeFilter() {
        parent::beforeFilter();
        
         switch ($this->request->action) {
            case 'admin_add':
            case 'admin_edit':
                $this->Security->csrfCheck    = FALSE;
                $this->Security->validatePost = FALSE;
                break;
        }
    }

    /**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this->Coupon->recursive = 0;
		$paginate = $this->Paginator->paginate();
		
		// Check if the coupon is in effecct
		foreach ($paginate as $key => $value) {
			try{
				$paginate[$key]['isInEffect'] = $this->Coupon->isInEffect($value['Coupon']['id']);	
			} catch (CouponException $e) {
				$paginate[$key]['isInEffect'] = false;
			}
		}
			
		$this->set('coupons', $paginate);
	}

	/**
	 * admin_view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->Coupon->exists($id)) {
			throw new NotFoundException(__('Invalid coupon'));
		}
		$options = array('conditions' => array('Coupon.' . $this->Coupon->primaryKey => $id));
		$this->set('coupon', $this->Coupon->find('first', $options));
		}

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Coupon->create();
			$this->request->data['Coupon']['code'] = strtoupper($this->request->data['Coupon']['code']);
			try {
				if ($this->Coupon->save($this->request->data)) {
					$this->Session->setFlash(__('The coupon has been saved'), 'default', array('class' => 'flash_success'));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The coupon could not be saved. Please, try again.'));
				}
			} catch (CouponException $e) {
				$this->Session->setFlash($e->getMessage());
			}
		}
		$users = $this->Coupon->User->find('list');
		$locations = $this->Coupon->Location->find('list');
		$this->set(compact('users', 'locations'));
	}

	/**
	 * admin_edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		if (!$this->Coupon->exists($id)) {
			throw new NotFoundException(__('Invalid coupon'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			try {
				if ($this->Coupon->save($this->request->data)) {
					$this->Session->setFlash(__('The coupon has been saved'), 'default', array('class' => 'flash_success'));
					return $this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The coupon could not be saved. Please, try again.'));
				}
			} catch (CouponException $e) {
				$this->Session->setFlash($e->getMessage());
			}
		} else {
			$options = array('conditions' => array('Coupon.' . $this->Coupon->primaryKey => $id));
			$this->request->data = $this->Coupon->find('first', $options);
		}
		$users = $this->Coupon->User->find('list');
		$locations = $this->Coupon->Location->find('list');
		$this->set(compact('users', 'locations'));
	}

	/**
	 * admin_delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		$this->Coupon->id = $id;
		if (!$this->Coupon->exists()) {
			throw new NotFoundException(__('Invalid coupon'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Coupon->delete()) {
			$this->Session->setFlash(__('Coupon deleted'), 'default', array('class' => 'flash_success'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Coupon was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}

}
