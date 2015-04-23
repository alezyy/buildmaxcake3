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
App::uses('CakeTime', 'Utility');

/**
 * DeviceOrders Controller
 *
 * @property DeviceOrder $DeviceOrder
 * @property PaginatorComponent $Paginator
 */
class DeviceOrdersController extends AppController {

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'RequestHandler');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Security->unlockedActions = array(
			'get',
			'process'
		);
		switch ($this->request->action) {
			case 'get':
			case 'process':
				$this->_setErrorHandler();
				break;
		}
		$this->Auth->allow(
			'get', 'process'
		);

		switch ($this->request->action) {
			case 'get':
			case 'process':
				Configure::write('debug', 0);
				break;
		}
	}

	/**
	 * This is the get endpoint, devices will connect to it every x seconds
	 * and get any orders in the system, it will also update the devices
	 * last_connection
	 *
	 */
	public function get() {

		// Make sure the view doesn't render.
		$this->autoRender = false;
		
		// dont send debug output because it drives the printer crazy
		Configure::write('debug', 0); 
		error_reporting(0);
		
		try {

			// Set the type
			$this->response->type('text');

			// Make software updates
//        $this->_updateDeviceSoftware();
			// Authenticate the device
			$device = $this->_authenticate();

			// Update it's last connected
			$this->DeviceOrder->Location->Device->updateDeviceLastConnected($device['Device']['id']);

			// Fetch the last order from the queue
			$order = $this->DeviceOrder->getOrder($device['Device']['location_id']);

			if ($order) {
				$this->DeviceOrder->id	 = $order['DeviceOrder']['id'];
				$range_header			 = $this->request->header('Range');
				$order_string			 = $order['DeviceOrder']['order_string'];
				$total					 = strlen($order_string);


				// Check to see if the string is <= 1kb
				if ($total <= 1024) {
					// It's not, send the whole thing and remove the job from the queue
					$this->DeviceOrder->delete();
				} else {
					// We have a large order...
					// Break it up into chunks

					if (!$range_header) {
						// No Range header set, lets use default values
						$unit	 = 'bytes';
						$start	 = 0;
						$end	 = $total;
					} else {
						// Range header was set, lets parse it
						list($unit, $range) = explode('=', $range_header);
						list($start, $end) = explode('-', $range);

						// If the range has no end, feed the whole string
						if (empty($end)) {
							$end = $total;
						}
					}



					// Grab the string segment requested, and pad the request to 1kb
					// The printers don't like receiving < 1kb segments... They do *weird* stuff...
					$order_string	 = substr($order_string, $start, $end);
					$order_string	 = str_pad($order_string, 1024, ' ');


					// Set the status to 206 (Partial Content)
					// and set some other relevant headers
					$this->response->statusCode(206);
					$this->response->header(array(
						'Accept-Ranges'	 => 'bytes',
						'Content-Range'	 => "$unit $start-$end/$total"
					));

					// If this was the last segment, delete the record from the queue
					if ($end >= $total) {
						$this->DeviceOrder->delete();
					}
				}

				$size = strlen($order_string);

				$this->response->header('Content-Length', $size);

				// Set the body
				$this->response->body($order_string);
			}
		} catch (Exception $e) {
			
			// dont send Exceptio errors because it drives the printer crazy		
			$this->_sendError(500);
		}
	}

	/**
	 * Processing of orders happens here, this is the endpoint where the device
	 * will send information regarding order acceptance/rejection
	 *
	 */
	public function process() {


		
		// Make sure the view doesn't render.
		$this->autoRender = false;
		Configure::write('debug', 0); // dont output debug because it drives the printer crazy
		// Set the type
		$this->response->type('text');

		$device		 = $this->_authenticate();
		$order_id	 = $this->request->data('o');
		$response	 = $this->request->data('m');
		$status		 = strtolower($this->request->data('ak'));

		// Extract the delivery time
		if (strpos($response, '_') > 0) {
			$delivery_time	 = explode("_", $response);
			$delivery_time	 = $delivery_time[0];
		} elseif (strpos($response, ' ') > 0) {
			$delivery_time	 = explode(" ", $response);
			$delivery_time	 = $delivery_time[0];
		} else {
			$delivery_time = $this->request->data('dt');
		}
		$delivery_time = date('Y-m-d H:i:s', strtotime('+' . $delivery_time . ' Minute'));

		// Process the request
		$this->DeviceOrder->processDeviceResponse($order_id, $status, $delivery_time, $response);
	}

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$this->DeviceOrder->recursive = 0;
		$this->set('deviceOrders', $this->Paginator->paginate());
	}

	/**
	 * admin_view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->DeviceOrder->exists($id)) {
			throw new NotFoundException(__('Invalid device order'));
		}
		$options = array('conditions' => array('DeviceOrder.' . $this->DeviceOrder->primaryKey => $id));
		$this->set('deviceOrder', $this->DeviceOrder->find('first', $options));
	}

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->DeviceOrder->create();
			if ($this->DeviceOrder->save($this->request->data)) {
				$this->Session->setFlash(__('The device order has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The device order could not be saved. Please, try again.'));
			}
		}
		$orders		 = $this->DeviceOrder->Order->find('list');
		$locations	 = $this->DeviceOrder->Location->find('list');
		$this->set(compact('orders', 'locations'));
	}

	/**
	 * admin_edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		if (!$this->DeviceOrder->exists($id)) {
			throw new NotFoundException(__('Invalid device order'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->DeviceOrder->save($this->request->data)) {
				$this->Session->setFlash(__('The device order has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The device order could not be saved. Please, try again.'));
			}
		} else {
			$options			 = array('conditions' => array('DeviceOrder.' . $this->DeviceOrder->primaryKey => $id));
			$this->request->data = $this->DeviceOrder->find('first', $options);
		}
		$orders		 = $this->DeviceOrder->Order->find('list');
		$locations	 = $this->DeviceOrder->Location->find('list');
		$this->set(compact('orders', 'locations'));
	}

	/**
	 * admin_delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		$this->DeviceOrder->id = $id;
		if (!$this->DeviceOrder->exists()) {
			throw new NotFoundException(__('Invalid device order'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DeviceOrder->delete()) {
			$this->Session->setFlash(__('Device order deleted'), 'default', array('class' => 'flash_success'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Device order was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * Sends a 403 with an empty body to the client
	 */
	private function _sendError($code = 403) {
		$this->response->statusCode($code);
		$this->response->send();
		exit;
	}

	/**
	 * Take over error handling so that we don't get
	 * a bunch of gibberish printing if we break something...
	 */
	private function _setErrorHandler() {
		ini_set('display_errors', 0);
		Configure::write(
			'Error.handler', function($code, $response, $file = null, $line = null, $context = null) {
			
		}
		);
	}

	/**
	 * Authenticates a device, and returns it's data. (or sends an error)
	 */
	private function _authenticate() {
		$username	 = $this->request->data('u');
		$password	 = $this->request->data('p');

		$device = $this->DeviceOrder->Location->Device->authenticate($username, $password);

		if (!$device) {
			$this->_sendError();
		}
		return $device;
	}

	/**
	 * update software on devices
	 */
	private function _updateDeviceSoftware() {

		//TODO check if devices needs update

		$userAgent = "";

		if (isset($_SERVER['HTTP_USER_AGENT'])) {

			$userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
		}

		if ($userAgent != "") {

			//get the type,ex.Gc(2s)

			$printerType = explode("/", $userAgent);

			//get the version

			$cmpOldVer = explode(" ", $printerType[1]);
			// Get the latest version from server's file or database; 
//            $cmpNewVer = strtolower(fread($verfp, $verLength));
			//to see does the printer's version is the old version 

			if ($cmpOldVer != $cmpNewVer || 1 === 1) {

				// Send the data needed for device to update themselves
				//$sUpgrade   = "Upgrade:goodcom.cn:80";
				//$sUpgrade   = "Upgrade:192.168.2.50:443";
				$sUpgrade = "Upgrade:192.168.2.50:80";

				//$newUrl     = "http://goodcom.cn:80/order/ca(1w)v1.1.0.12.bin";
				//$newUrl     = "https://192.168.2.50:443/ca(1w)v1.1.0.12.bin";
				//$newUrl     = "http://192.168.2.50:80/ca(1w)v1.1.0.12.bin";
				$newUrl = "http://192.168.2.50/ca(1w)v1.1.0.12.bin";

				$Length			 = strlen($newUrl);
				header("HTTP/1.1 206 Partial Content");
				$contentRange	 = "bytes 0-" . ($Length - 1) . "/" . ($Length);
				header("Content-Range" . ": " . $contentRange);
				header("Content-Length:" . $Length);
				header($sUpgrade);
				echo $newUrl;
			}
		}
	}

}
