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
App::uses('CakeNumber', 'Utility');
App::uses('ValidationException', 'Lib/Error/Exception');

/**
 * TransactionLogs Controller
 *
 * @property TransactionLog $TransactionLog
 * @property PaginatorComponent $Paginator
 */
class TransactionLogsController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator',);
	public $helpers = array('ES');

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$query = array();
		$conditions = array();
		$order = array('Order.created DESC');

		if ($this->request->is('post')) {
			if (isset($this->request->data['Query'])) {
				$query = $this->request->data['Query'];
			}	
			$this->request->data['Query']['from'] = '';
			$this->request->data['Query']['to'] = '';
		}

		$this->TransactionLog->recursive = 1;
		$this->TransactionLog->order = array('TransactionLog.created' => 'DESC');
		$this->Paginator->settings = array('conditions' => $conditions);
		$this->set('transactionLogs', $this->Paginator->paginate());
	}

	/**
	 * admin_view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->TransactionLog->exists($id)) {
			throw new NotFoundException(__('Invalid TransactionLog 1382473296'));
		}
		$options = array(
			'conditions' => array('TransactionLog.' . $this->TransactionLog->primaryKey => $id),
			'recursive' => 2,
			'contain' => array('TransactionLogDetail', 'User', 'Location')
		);

		$this->set('transactionLog', $this->TransactionLog->find('first', $options));
	}

	/**
	 * admin_edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		if (!$this->TransactionLog->exists($id)) {
			throw new NotFoundException(__('Invalid TransactionLog 1382473306'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->TransactionLog->save($this->request->data)) {
				$this->Session->setFlash(__('The TransactionLog has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(__('The TransactionLog could not be saved. Please, try again.'));
			}
		} else {
			$options = array(
				'conditions' => array('TransactionLog.' . $this->TransactionLog->primaryKey => $id),
				'recursive' => 1
			);
			$this->request->data = $this->TransactionLog->find('first', $options);
		}
	}

	public function admin_send($id) {
		$this->TransactionLog->id = $id;
		if (!$this->TransactionLog->exists()) {
			throw new NotFoundException(__('Can\'t find that TransactionLog...'));
		}
		$device_TransactionLogs = $this->TransactionLog->DeviceTransactionLog->find('count', array(
			'conditions' => array(
				'DeviceTransactionLog.TransactionLog_id' => $id
			)
		));
		if ($device_TransactionLogs > 0) {
			$this->Session->setFlash(__('TransactionLog was already sent to the device!'));
			$this->redirect(array(
				'controller' => 'TransactionLogs',
				'action' => 'index'
			));
		}
		$TransactionLog = $this->TransactionLog->find('first', array(
			'conditions' => array(
				'TransactionLog.id' => $id
			),
			'contain' => array(
				'TransactionLogDetail',
				'Location',
				'User'
			),
			'recursive' => 0
		));
		$this->TransactionLog->DeviceTransactionLog->sendTransactionLog($TransactionLog);
		$this->Session->setFlash(__('TransactionLog sent to device!'), 'default', array('class' => 'flash_success'));
		$this->redirect(array(
			'controller' => 'TransactionLogs',
			'action' => 'index'
		));
	}

}
