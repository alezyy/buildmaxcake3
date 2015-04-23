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
 * Orders Controller
 *
 * @property Order $Order
 * @property PaginatorComponent $Paginator
 */
class OrdersController extends AppController {

	public $flashMessage = NULL;

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components	 = array('Paginator', 'OrderSession', 'BreadCrumbs', 'Cookie', 'CsvView.CsvView', 'UserAccount');
	public $uses		 = array('Payment', 'Order', 'User', 'Coupon', 'Location');
	public $helpers		 = array('ES', 'Image');
	

	public function beforeFilter() {
		parent::beforeFilter();

		switch ($this->request->action) {
			case 'admin_refunds':
				$this->Security->csrfUseOnce	 = FALSE;
				$this->Security->csrfCheck		 = FALSE;
				$this->Security->validatePost	 = FALSE;
				break;
			case 'checkout':
				$this->Security->csrfUseOnce	 = FALSE;
				$this->_receiveFromPlatform();
				break;
			case 'update_checkout':
			case 'future_time_form':
			case 'session_to_db':
			case 'credit_or_cash':
			case 'proceed_to_payment':
			case 'admin_accounting_report':
			case 'admin_index':
				$this->Security->csrfCheck		 = FALSE;
				$this->Security->validatePost	 = FALSE;
				break;
		}
			
		if ($this->Auth->user('group_id') > 1) { // This is weird I don't know where checkout is allowe only to admins
			$this->Auth->allow('checkout', 'proceed_to_payment');
		}
		
		$this->Auth->allow(
			'future_time_form', 
			'summary', 
			'increment_item_quantity', 
			'decrement_item_quantity', 
			'increment_tip', 
			'decrement_tip', 
			'apply_coupon', 
			'proceed_to_payment', 
			'credit_or_cash',
			'.sidebar-parent'
		);
	}

	public function afterFilter() {
		switch ($this->request->action) {
			case 'checkout':
				$this->Session->delete('newRegistration'); // delete this variable that should only be in the session after the user as registered
		}
	}

	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {
		$query			 = array();
		$conditions[0]	 = array('NOT' => array('Order.overall_status' => 'reimbursement')); // don't show reimbursement by default

		if ($this->request->is('post') || $this->Session->check('orderSearchQuery')) {


			// Export all result to CSV
			if (isset($this->request->data['exportAllToCSV'])) {
				Configure::write('debug', 0); // debuggin messages prevents the the downloading of the file. I don't have time to debug that plugin                
				$this->response->download('allOrders_' . time() . '.csv');
				$this->CsvView->quickExport($this->Order->find('all'));
			} elseif (isset($this->request->data['Query']['search'])) {
				$query = $this->request->data['Query'];
				$this->Session->delete('orderSearchQuery');
				$this->Session->write('orderSearchQuery', $query);
			} else {
				$query['search'] = (!$this->Session->check('orderSearchQuery.search')) ? '' : $this->Session->read('orderSearchQuery.search');
				$query['fields'] = (!$this->Session->check('orderSearchQuery.fields')) ? '' : $this->Session->read('orderSearchQuery.fields');
				$query['from']	 = (!$this->Session->check('orderSearchQuery.from')) ? '' : $this->Session->read('orderSearchQuery.from');
				$query['to']	 = (!$this->Session->check('orderSearchQuery.to')) ? '' : $this->Session->read('orderSearchQuery.to');
				$query['status'] = '';
				$this->Session->write('orderSearchQuery', $query);
			}

			$this->set('querySearch', $query); // send data to create the pagination 


			if (!empty($query['fields'])) {
				switch ($query['fields']) {
					case 'order_number':
						$field	 = 'Order.id';
						break;
					case 'location':
						$field	 = 'Location.name';
						break;
					case 'user':
						$field	 = 'User.email';
						break;
					case 'subtotal':
						$field	 = 'Order.subtotal';
						break;
					case 'type':
						$field	 = 'Order.total';
						break;
					case 'total':
						$field	 = 'Order.type';
						break;
					case 'method_of_payment':
						$field	 = 'Order.method_of_payment';
						break;
				}
			} else {
				$field = '_all';
			}

			if (!empty($query['search'])) {
				$conditions[] = array(
					'query_string' => array(
						'query'				 => $query['search'],
						'default_operator'	 => 'AND',
						'default_field'		 => $field
					)
				);
			}

			if (!empty($query['from']) && !empty($query['to'])) {
				$conditions[] = array(
					'AND' => array(
						'Order.created >='	 => $query['from'],
						'Order.created <='	 => $query['to']
					)
				);
			} else {
				$this->request->data['Query']['from']	 = '';
				$this->request->data['Query']['to']		 = '';
			}

			if (!empty($query['status'])) {
				unset($conditions[0]);
				$conditions[]	 = array('Order.overall_status' => $query['status']);
				$conditions[]	 = array('Order.overall_status' => $query['status']);
			}
		}

		$this->Order->useDbConfig	 = 'index';
		$this->Order->useTable		 = 'order';
		$this->Order->Behaviors->attach('Elastic.Indexable');

		$this->Order->recursive		 = 1;
		$this->Paginator->settings	 = array('conditions' => $conditions, 'limit' => 50);
		$orders						 = $this->Paginator->paginate('Order');

		$this->Order->useDbConfig	 = 'default';
		$this->Order->recursive		 = 0;

		foreach ($orders as $k => $o) {

			// Get the number of orders made by user
			$orders[$k]['Order']['nb_orders'] = $this->Order->find('count', array(
				'fields'	 => 'Order.id',
				'conditions' => array(
					'Order.user_id'			 => $o['User']['id'],
					'Order.overall_status'	 => 'complete')));
		}

		// Table data        
		$this->set('orders', $orders);

		// Export to CSV button		
		if (isset($this->request->data['exportToCSV'])) {
			Configure::write('debug', 0); // debuggin messages prevents the the downloading of the file. I don't have time to debug that plugin
			$this->response->download('filteredOrders_' . time() . '.csv');
			$this->CsvView->quickExport($orders);
		}
	}

	/**
	 * admin_view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		if (!$this->Order->exists($id)) {
			throw new NotFoundException(__('Invalid order 1382473296'));
		}
		$options = array(
			'conditions' => array('Order.' . $this->Order->primaryKey => $id),
			'recursive'	 => 0,
			'contain'	 => array('OrderDetail', 'Location', 'User', 'Location')
		);

		$this->set('order', $this->Order->find('first', $options));
	}

	/**
	 * admin_edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {

		    //TODO the admin user levels must be implemented correctly instead of doing this crazy stuff
       			 if ($this->Auth->user('email') !== 'sc@topmenu.com' && $this->Auth->user('email') !== 'pec@mail.com') {
           		// throw new ForbiddenException('Access denied / Accès refusé');
           		$this->Session->setFlash(__('Access denied / Accès refusé'), 'flash_danger');
           
          		 $this->redirect(array("controller" => "orders", 
                                 "action" => "view/$id",)
                            );			
        }

       if($this->Auth->user('group_id') > 1){
            throw new ForbiddenException(__('Level 1 admins only'));
        }

		if ($this->request->is('post') || $this->request->is('put')) {

			if (!$this->Order->exists($this->request->data['Order']['id'])) {
				throw new NotFoundException(__('Invalid order number'));
			}
			$this->data = $this->request->data;
			if ($this->Order->save($this->request->data)) {
				$this->Session->setFlash(__('The order has been saved'), 'flash_success');
			} else {
				$this->Session->setFlash(__('The order could not be saved. Please, try again.'), 'flash_success');
			}
		} else {
			if ($id !== NULL) {
				$this->data = $this->Order->findById($id);
				if (!$this->data) {
					$this->Session->setFlash(__('Order id #%s does not exist', $id), 'flash_success');
					$this->redirect(array(
						'controller' => 'admins',
						'action'	 => 'index',
						'admin'		 => true));
				}
			}
		}
	}

	/**
	 * Declares a "Order" variable in the session to prepare the save order action and to display the order totals to
	 * the user.
	 * @param string $locationId
	 * @param string $userId
	 * @todo Reconsider this function location's (Model or Controller).
	 * @return bool true on success, false on failure
	 */
	public function declareOrderInSession($locationId, $userId, $destinationPostalCode) {

		$this->loadModel('Tax');
		$this->loadModel('DeliveryArea');

		$this->Session->write('Order');
		$this->Session->write('Order.locationId', $locationId);   // set location's id
		$this->Session->write('Order.userId', $userId); // set user's id
		$this->Session->write('Order.deliveryCharge', 0);
		$this->Session->write('OrderDetail', array());  // empty item list
		// set Taxes accordingly to location's province
		$taxes = $this->Tax->getTaxesForProvince($this->Location->getProvince($locationId));

		return true;
	}

	/**
	 * Executes the order checkout:
	 * <ul>
	 * <li>Validates the order object in the session</li>
	 * <li>Displays the order for confirmation or edition</li>
	 * </ul>
	 *
	 */
	public function checkout() {
				
		$this->loadModel('DeliveryAddress');
		$this->loadModel('DeliveryArea');
		$this->loadModel('Fraud');
		$this->helpers[] = 'Order';		

		// No credit card payment message when client support is not available        
		$this->set('ccAllowedTag', $this->Order->isClientSupportWorkingNow());

		$allowPayment = TRUE; // allow user to access payment info.ctp?
		//
        // Check for fraud
		$this->Fraud->suspiciousUser($this->Auth->user('id'), $this->Session->read('Order.Order.location_id'));
		$this->Fraud->blackLists($this->Auth->user('email'), $this->_getAddressForFraud(), $this->_getPhoneForFraud());

		// Check if the pickup button (on mobile) was use to access this page
		if ($this->request->query('pickupButton') == '1') {
			$this->Session->write('Order.Order.type', 'pickup');
		}

		if ($this->request->params['type'] === 'pickup') {
			$this->Session->write('Order.Order.type', 'pickup');
		} elseif ($this->request->params['type'] === 'delivery') {
			$this->Session->write('Order.Order.type', 'delivery');
		}

		// Insert user data in order
		$this->Session->write('Order.Order.user_id', $this->Auth->user('id'));
		$this->loadModel('Profile');
		$user = $this->Profile->findById($this->Auth->user('id'));
		if (!empty($user)) {
			$this->Session->write('Order.Order.first_name', $user['Profile']['first_name']);
			$this->Session->write('Order.Order.last_name', $user['Profile']['last_name']);
		}

		// send location data to checkout form
		$this->Location->contain('Cuisine');
		$location = $this->Location->find('first', array(
			'conditions' => array(
				'Location.id' => $this->Session->read('Order.Order.location_id')),
			'fields'	 => array(
				'Location.id',
				'Location.sector_slug',
				'Location.name',
				'Location.short_address',
				'Location.url',
				'Location.logo')));

		$this->set('location', $location);


		// BREADCRUMBS //TODO still useful?
		$this->BreadCrumbs->add('Checkout', 'orders', 'checkout', __('Checkout'));
		$this->set('activeBreadCrumb', 'Checkout');


		// CALCULATE AND VALIDATE ORDER BEFORE RENDERING
		// Validate coupon
		$this->_isCouponValid();
		$this->update_checkout($this->Session->read['Order']);  // Validation method

		$this->set('valid', TRUE);   // display data
		// Add user email to order
		$this->Session->write('Order.Order.email', $this->Auth->user('email'));

		// ADDRESSES STUFF
		// CHECK DELIVERY AVAILABILITY AND SET ADDRESS OF CLIENT (INCLUDING PHONE NUMBER FOR TAKEOUT)
		$postalCode = $this->Session->check('DeliveryDestination.postal_code') ? strtoupper($this->Session->read('Order.Order.postal_code')) : NULL;

		// Check if a delivery address has been selected
		if ($this->Session->check('DeliveryDestination')) {

			// Add the customer address to the select address form
			$this->request->data['delivery_address'] = $this->Session->read('DeliveryDestination.inline_address');
			$this->set('currentAddress', $this->Session->read('DeliveryDestination.name'));
		}

		// Check if a billing address has been selected
		if ($this->Session->check('BillingAddress')) {

			// Add the customer address to the select address form
			$this->request->data['billing_address'] = $this->Session->read('BillingAddress.inline_address');
			$this->set('currentAddress', $this->Session->read('BillingAddress.name'));
		}

		// Get list of delivery or billing addresses for the delivery address matrix
		$addressList = $this->DeliveryAddress->find(
			'all', array(
			'conditions' => array('DeliveryAddress.user_id' => $this->Session->read('Auth.User.id')),
			'order'		 => array('DeliveryAddress.last_used DESC')));

		// mark the addreses that can receive delivery from the current restaurant (valid addresses)
		foreach ($addressList as &$address) {
			$dtac = $this->DeliveryArea->deliversThereAndCharges($location['Location']['id'], $address['DeliveryAddress']['postal_code']);
			if (is_array($dtac)) {
				$address['DeliveryAddress']['available']		 = TRUE;
				$address['DeliveryAddress']['delivery_charge']	 = $dtac['delivery_charge'];
			} else {
				$address['DeliveryAddress']['available'] = FALSE;
			}
		}
		
		// List of available addressses
		$deliveryAddresses = Set::combine($addressList, '{n}.DeliveryAddress.name', '{n}.DeliveryAddress.inline_address');
		   
		$this->set('deliveryAddresses', $deliveryAddresses);

		// IF DELIVERY And pickup stuff
		if ($this->Session->read('Order.Order.type') === 'delivery') {

			// is Current user's address a valid delivery destination
			$minReq = $this->Order->checkOrdersMinimalValue($this->Session->read('Order.Order'), FALSE, $postalCode);
			if ($minReq['delivers'] !== TRUE) {
				$this->flashMessage	 = ($this->flashMessage === NULL) ? $minReq['delivers'] : $this->flashMessage;
				$allowPayment		 = FALSE;
			}

			// Validate the order postal code because some time the search optino overwrites it to an invalid (3 char instead of 6)
			if (!$this->_validePostalCodeIsFull($postalCode)) {
				$this->flashMessage	 = ($this->flashMessage === NULL) ? __('Please choose a delivery address') : $this->flashMessage;
				$allowPayment		 = FALSE;
			}
		} else {

			// Cash is not allowed for pickup orders
			if ($this->Session->check('Order.Order.method_of_payment')) {
				if ($this->Session->read('Order.Order.method_of_payment') === 'cash') {
					$this->flashMessage	 = ($this->flashMessage === NULL) ? __('Please note that take out orders are credit card only') : $this->flashMessage;
					$allowPayment		 = FALSE;
				}
			}
		}

		$this->set('allowPayment', $allowPayment);
		$resquestedFor = $this->Session->read('Order.Order.requested_for');

		// Requested for time
		if ($resquestedFor > time()) {
			$this->set('requested_for', $resquestedFor);
		} else {
			$this->set('requested_for', FALSE);
		}

		// From ajax?
		if ($this->request->is('ajax')) {
			$this->set('flashMessage', ($this->flashMessage !== NULL) ? $this->flashMessage : 'success');   // Output the error message or success message since the flashMessage wont work with ajax
			// Also use the traditionnal flash message for cases where ajax actually requires a reload after (I know, that doesnt make a lot of sense)
			if ($this->flashMessage !== NULL) {
				$this->Session->setFlash($this->flashMessage, 'flash_danger');
			}
			return $this->render('checkout_right_side');
		}

		// Display flash message
		if ($this->flashMessage !== NULL) {
			$this->Session->setFlash($this->flashMessage, 'flash_danger');
		}
	}

	public function future_time_form() {

		// get location's data
		$urlExploded = explode('/', $this->referer());
		$url		 = end($urlExploded);
		$location	 = $this->Location->findByUrl($url);

		// HANDLE SUB
		if ($this->request->is('post')) {

			try {

				// convert posted data to time
				$data = $this->request->data['Order'];

				// Update session
				$this->OrderSession->validateEdit($location['Location']['id'], $this->Auth->user('id')); // initiate order
				$requested_for = date('Y-m-d H:i:s', strtotime($data['mirrorField']));   // convert string to time
				if (!$requested_for) {
					throw new ValidationException(__('No date was entered'));
				}   // validate input
				// Is location open at taht time?
				$this->loadModel('Schedule');

				if ($this->Schedule->isOpenForDelivery($location['Location']['id'], NULL, $requested_for)) {
					$this->Session->write('Order.Order.requested_for', $requested_for);  // write to session
					// Confirmatino message
					$this->set('setFlashMessage', __('Order\'s date is set')); // error message
					$this->set('setFlashLevel', 'success'); // errror type

					$this->render('requested_for_result', 'ajax');  // insert this view in the callling form
				} else {
					$this->Session->write('Order.Order.requested_for', 'ERROR');  // write to session
					throw new ValidationException(__('This restaurant is close. Please try another one'));
				}
			} catch (ValidationException $e) {

				// Error message
				$this->set('setFlashMessage', $e->getMessage()); // error message
				$this->set('setFlashLevel', 'error'); // errror type

				$this->render('requested_for_result', 'ajax');
			}

			// got to error page
		}

		// OUTUPUT FORM
		else {

			// BUILD DATEPICKE			//TODO THIS GOT TO GO

			$startDate	 = date('Y-m-d H:i');   // start date is now
			$endDate	 = date('Y-m-d H:i', time() + (WEEK)); // end date is in one week
			$minuteStep	 = 10;   // round minutes
			// config script for datepicker
			$script		 = <<<EOF
		$(".form_datetime").datetimepicker({
			language: '$this->langSuffix',
			autoclose: true,
			todayBtn: true,
			startDate: '$startDate',
			endDate: '$endDate',
			minuteStep: 10,
			linkField: "mirrorField",
			pickerPosition: "bottom-left"
		});
EOF;

			// PASS DATA
			$this->set('url', $this->request['location']); // location's timezone
			$this->set('script', $script);
		}
	}

	/**
	 * Changes the items quantity in the order session variable
	 *
	 * @param array $data request data
	 */
	private function update_checkout($data = NULL) {

		$valid = TRUE;

		// Data from the checkout form
		if ($data !== NULL) {
			if ($data['tip'] >= 0 && is_numeric($data['tip'])) {
				$this->Session->write('Order.Order.tip', $data['tip']);
			} else {
				$this->Session->setFlash(__('Tip value is incorrect'), 'flash_danger');
			}

			// delete coupon info from session
			$this->Session->write('Order.Order.coupon_code', '');
			$this->Session->write('Order.Order.coupon_discount', '');

			// Update coupon in session
			if (!empty($data['coupon_code'])) {
				$this->Session->write('Order.Order.coupon_code', $data['coupon_code']);
			}


			// change the items quantity field
			//TODO check if still necessary
			foreach ($data['OrderDetail'] as $k => $v) {
				if ($v > 0 && $v < 100 && is_numeric($v)) {
					$this->Session->write('Order.OrderDetail.' . $k . '.quantity', $v);  // change item quantity
				} elseif ($v == '0') {
					$this->Session->delete('Order.OrderDetail.' . $k);  // remove item from order
					$orderDetail = $this->Session->read('Order.OrderDetail');   // remove item from order
					// If no more items in Order
					if (empty($orderDetail)) {
						$location = $this->Location->findById($this->Session->read('Order.Order.location_id'));
						$this->Session->setFlash(__('Order is empty'));
						$this->OrderSession->clearOrder();
						$this->redirect(
							array(
								'controller' => 'locations',
								'action'	 => 'view',
								'location'	 => $location['Location']['url'],
								'sector'	 => $location['Location']['sector_slug']));
					}
				} else {
					$valid = FALSE;
					$this->Session->setFlash(__('Invalid quantity given'), 'flash_danger');
				}
			}
		}

		// update the session
		if ($valid) {

			$order = $this->Order->updateCurrent($this->Session->read('Order'));
			$this->Session->write('Order', $order);

			if ($order) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	public function admin_send($id) {
		$this->Order->id = $id;
		if (!$this->Order->exists()) {
			throw new NotFoundException(__('Can\'t find that order...'));
		}
		$device_orders = $this->Order->DeviceOrder->find('count', array(
			'conditions' => array(
				'DeviceOrder.order_id' => $id
			)
		));
		if ($device_orders > 0) {
			$this->Session->setFlash(__('Order was already sent to the device!'), 'flash_danger');
			$this->redirect(array(
				'controller' => 'orders',
				'action'	 => 'index'
			));
		}
		$order = $this->Order->find('first', array(
			'conditions' => array(
				'Order.id' => $id
			),
			'contain'	 => array(
				'OrderDetail',
				'Location',
				'User'
			),
			'recursive'	 => 0
		));
		$this->Order->DeviceOrder->sendOrder($order);
		$this->Session->setFlash(__('Order sent to device!'), 'flash_success');
		$this->redirect(array(
			'controller' => 'orders',
			'action'	 => 'index'
		));
	}

	public function printable_order() {
		// get location data
		// get locati
	}

	/**
	 * Check to see that the postal code is not just the prefix
	 * @param type $postalCode
	 */
	private function _validePostalCodeIsFull($postalCode) {
		return preg_match(Configure::read('regex.postal_code'), $postalCode);
	}

	public function summary($locationId) {

		$this->helpers[] = 'Currency';
		$this->helpers[] = 'Order';
		$location		 = $this->Location->findById($locationId);
		$this->set('locationId', $locationId);
		$this->set('locationUrl', $location['Location']['url']);
		$this->set('locationSlug', $location['Location']['sector_slug']);



		if ($this->is_mobile) {
			$this->layout = 'mobile_modal';
		}
	}

	/**
	 * Checks and sets the order type (delvery or pickup) variable in the session
	 */
//	private function _deliveryOrPickup(){
//
//		if(!empty($this->request->data['Order']['type'])){
//			$this->Session->write('Order.Order.type', $this->request->data['Order']['type']);
//		}else{
//			$this->Session->write('Order.Order.type', 'delivery');
//		}
//	}


	private function _validateCheckout() {

		$model = ClassRegistry::init(array('class' => 'Checkout', 'table' => false, 'type' => 'Model'));
		if (!empty($this->request->data)) {
			$model->validate = array(
				'method_of_payment' => array(
					'notempty' => array(
						'rule'		 => array('notempty'),
						'message'	 => 'Must not be empty!')));
		}

		$model->save($this->request->data['Checkout']);
		return $model->validates();
	}

	/**
	 * Check if the delivery address in session is valid for the current order type (delivery or pickup)
	 */
	private function _validateDeliveryAddress() {

		if ($this->Session->check('Order.Order.address')  // DELIVERY
			&& $this->Session->check('Order.Order.phone') && $this->Session->check('Order.Order.postal_code') && $this->Session->read('Order.Order.type') === 'delivery') {

			$ooa	 = $this->Session->read('Order.Order.address');
			$oop	 = $this->Session->read('Order.Order.phone');
			$oopc	 = $this->Session->read('Order.Order.postal_code');

			if (empty($ooa) || empty($oop) || !$this->_validePostalCodeIsFull($oopc)) {
				return FALSE;
			}
		} elseif ($this->Session->check('Order.Order.phone') // PICKUP
			&& $this->Session->read('Order.Order.type') === 'pickup') {

			$oop = $this->Session->read('Order.Order.phone');

			if (empty($oop)) {
				return FALSE;
			}
		}

		return TRUE;
	}

	/**
	 * Action - This decrements the selected item by 1 and renders the checkout_right_side view
	 * @param type $itemKeyInOrder Items key in Order.OrderDetail in session.
	 */
	public function decrement_item_quantity($itemKeyInOrder) {

		if (!$this->Session->check("Order.OrderDetail.$itemKeyInOrder")) {
			throw new Exception(__('Order Item does not exists for decrementation'));
		}

		// Decrement items current quantity
		$qty = $this->Session->read("Order.OrderDetail.$itemKeyInOrder.quantity");
		$qty--;
		if ($qty < 1) {
			$this->Session->delete("Order.OrderDetail.$itemKeyInOrder"); // Remove item if quantity is 0
		} else {
			$this->Session->write("Order.OrderDetail.$itemKeyInOrder.quantity", $qty); // set item quantity to Decremented value
		}

		// Update order
		$this->checkout();
	}

	/**
	 * Action - This increment the selected item by 1 and renders the checkout_right_side view
	 * @param type $itemKeyInOrder Items key in Order.OrderDetail in session.
	 */
	public function increment_item_quantity($itemKeyInOrder) {


		if (!$this->Session->check("Order.OrderDetail.$itemKeyInOrder")) {
			throw new Exception(__('Order Item does not exists for incrementation'));
		}

		// Increment items current quantity
		$qty = $this->Session->read("Order.OrderDetail.$itemKeyInOrder.quantity");
		$this->Session->write("Order.OrderDetail.$itemKeyInOrder.quantity", ++$qty);

		// Update order
		$this->checkout();
	}

	/**
	 * Action - This substract a dollar from the current tip amount
	 */
	public function decrement_tip() {

		if (!$this->Session->check("Order.Order.tip")) {
			throw new Exception(__('Order Tip does not exists for decrementation'));
		}

		// Decrement items current quantity
		$tip = $this->Session->read("Order.Order.tip");
		$tip -= 1;
		if ($tip < 1) {
			$this->Session->write("Order.Order.tip", '0'); // Remove item if quantity is 0
		} else {
			$this->Session->write("Order.Order.tip", $tip); // set item quantity to Decremented value
		}

		// Update order
		$this->checkout();
	}

	/**
	 * Action - This adds a dollar to the current tip amount
	 */
	public function increment_tip() {


		if (!$this->Session->check("Order.Order.tip")) {
			throw new Exception(__('Order Tip does not exists for incrementation'));
		}

		// Increment items current quantity
		$tip = $this->Session->read("Order.Order.tip");
		$this->Session->write("Order.Order.tip", $tip + 1);

		// Update order
		$this->checkout();
	}

	/**
	 * Action - Apply coupon
	 */
	public function apply_coupon($couponCode = '') {
		$this->autoRender = false;
		// remove coupon from order for cash orders
		if ($this->Session->read('Order.Order.method_of_payment') != 'creditcard') {
			$this->Session->write("Order.Order.coupon_code", '');
			$this->flashMessage = ($this->flashMessage === NULL) ? __('Coupons are available on credit card orders only') : $this->flashMessage;  // Output the error message or success message since the flashMessage wont work with ajax
		} else {
			$couponCode = urldecode($couponCode);
			$this->Session->write("Order.Order.coupon_code", $couponCode);
		}

		// Update order
		$this->checkout();
	}

	/**
	 * this check if the user should be sent to payment and redirects him.
	 * This returns an error message if not redirect or null if the user did not ask to pay
	 * @return string
	 */
	public function proceed_to_payment() {



		// Set method of payment in session
		if ($this->request->data('method_of_payment_is_cash')) {

			// mobile cash submit button
			$this->Session->write('Order.Order.method_of_payment', 'cash');			 // set the method_of_payment in the session
			$this->_resetCoupon();													  // Remove any coupons
		} elseif ($this->request->data('method_of_payment_is_credit')) {

			// mobile credit card submit button
			$this->Session->write('Order.Order.method_of_payment', 'creditcard');
		} else {																		// Desktop version get method from request
			$this->Session->write('Order.Order.method_of_payment', $this->request->data['Payment']['method_of_payment']);
		}

		// Put special instruction in session
		$this->Session->write('Order.Order.special_instruction', $this->request->data['Order']['special_instruction']);

		// Merge payment data with the order data
		$data = $this->_addPaymentInfoToOrder();

		// Validate order again
		if ($this->update_checkout()) {

			// PAYMENT BY CASH					/////////////////////////////////////////////////////////////////////////////////////////////

			if ($this->Session->read('Order.Order.method_of_payment') === 'cash') {

				// Merge more payment data in the order in session
				$this->Session->write('Order.Order.gateway_status', 'cash');
				$this->Session->write('Order.Order.device_status', 'unprocessed');
				$this->Session->write('Order.Order.overall_status', 'processing');
				$this->Session->write('Order.Order.response', '');
				$this->Session->write('Order.Order.transaction_number', 'cash'); // update table in session

				$this->_saveOrderBeforeProcessing(true);	// Update order and send to restaurant
				// Redirect
				$this->set('orderId', $this->Order->id);
				$this->_redirectToApproveView();
			}

			// PAYMENT BY CREDIT CARD			/////////////////////////////////////////////////////////////////////////////////////////////

			$this->loadModel('DeliveryAddress');
			$this->loadModel('Province');
			$this->loadModel('AcceptedCreditCard');

			// No credit card payment message when client support is not available
			$this->Order->isClientSupportWorkingNow();

			// Check for fraudulent user
			//TODO remove or reconfigure with when we switch to the new payment gateway
			$isFraudulentSession = $this->Session->read('Auth.User.isFraudulent');
			if ($this->UserAccount->isFraudulentBrowser() || $isFraudulentSession) {
				throw new Exception('GTFO');
			}

			// Validate payment info
			if ($this->Payment->validates()) {
				$this->Order->id		 = (empty($this->Order->id) ? $this->Session->read('Order.Order.id') : $this->Order->id);
				// Validate credit card
				$authorizationResponse	 = $this->Payment->requestAuthorization($data, $this->langSuffix, $this->Order->id);

				// check the authorization and redirect back to checkout to allow user to make changes
				if ($authorizationResponse === null) {
					
					$this->_allowUserToTryCreditCardAgain(__('Invalid data entered. Please review your billing information'));

					// reload billing_info
					$this->redirect(array(
						'controller' => 'payments',
						'action'	 => 'billing_info',
						'gateway'));
				}

				// Store the gateway response into the transaction log
				$this->_logTransaction($authorizationResponse, $this->Session->read('Order.Order.id'));
				$this->loadModel('GatewayResponseMessage');

				if ($authorizationResponse['status'] === 'approved') {

					// update order table in db
					$this->Session->write('Order.Order.gateway_status', 'authorized');
					$this->Session->write('Order.Order.transaction_number', $authorizationResponse['id']);
					$this->Session->write('Order.Order.device_status', 'unprocessed');
					$this->Session->write('Order.Order.overall_status', 'processing');
					$this->Session->write('Order.Order.response', $authorizationResponse['status']);

					$this->_saveOrderBeforeProcessing(true);		// Update order and sent to restaurant
					$this->set('orderId', $this->Session->read('Order.Order.id'));
					$this->_redirectToApproveView();
				} else {
					// Save failed order
					$this->Session->write('Order.Order.gateway_status', 'validation_error');
					$this->Session->write('Order.Order.transaction_number', 'rejected');
					$this->Session->write('Order.Order.device_status', 'unprocessed');
					$this->Session->write('Order.Order.overall_status', 'rejected');
					$this->Session->write('Order.Order.response', $authorizationResponse['error']);
					
					$this->_saveOrderBeforeProcessing(false);						   // Update order
					$this->_allowUserToTryCreditCardAgain($this->GatewayResponseMessage->translateString($authorizationResponse['error'], $this->langSuffix));
					$this->_redirectBackToPayementForm();
				}
			} else {
				// Validation errors
				$this->Session->setFlash($this->OrderSession->validationErrorsToHtml($this->Payment->validationErrors), 'flash_danger');
			}
			$this->set('orderId', $this->Session->read('Order.Order.id'));
		}
	}

	/**
	 * Takes data from the payment form and merges it to the Order in session. Also checkout validation the data
	 * @return array All of the data needed for the order
	 */
	private function _addPaymentInfoToOrder() {

		$taxesTotal		 = $this->Session->read('Order.Order.total') - $this->Session->read('Order.Order.subtotal');
		$data			 = $this->request->data('Payment');
		$data['method']	 = $this->Session->read('Order.Order.method_of_payment');

		// set object for validation
		//debug($data);
		$this->Payment->set($this->Payment->flattenRequest($data));
		$this->Payment->set(array(
			'tax'	 => $taxesTotal,
			'amount' => $this->Session->read('Order.Order.total')));

		// set transaction data in request array
		$data['transaction']['amount']['total']					 = $this->Session->read('Order.Order.total');
		$data['transaction']['amount']['currency']				 = Configure::read('I18N.CURRENCY');
		$data['transaction']['amount']['details']['subtotal']	 = $this->Session->read('Order.Order.subtotal');
		$data['transaction']['amount']['details']['tax']		 = $taxesTotal;
		$data['transaction']['amount']['details']['shipping']	 = 0;

		// Billing Info //todo I think that in the checkout view there is a hidden form that was suppose to contain the biling info but it doesn't work
		$data['billing_address']['country_code'] = Configure::read('I18N.COUNTRY_CODE_2');
		$data['billing_address']['postal_code']	 = $this->Session->read('BillingAddress.postal_code');
		$data['billing_address']['line1']		 = $this->Session->read('BillingAddress.address');
		$data['billing_address']['line2']		 = $this->Session->read('BillingAddress.address2');
		$data['billing_address']['city']		 = $this->Session->read('BillingAddress.city');
		$data['billing_address']['state']		 = $this->Session->read('BillingAddress.province');
		$data['billing_address']['phone']		 = $this->Session->read('BillingAddress.phone');

		$this->Payment->requestTemplate = $data;

		// save order in data base
		$gateWayStatus = ($this->Session->check('Order.Order.gateway_status')) ? $this->Session->read('Order.Order.gateway_status') : 'unproccessed';   // catch that this is a resubmit because gateway sent a error message
		$this->Session->write('Order.Order.gateway_status', $gateWayStatus);
		$this->Session->write('Order.Order.device_status', 'unprocessed');
		$this->Session->write('Order.Order.overall_status', 'processing');

		try {
			$orderId = $this->Order->session_to_db($this->Session->read('Order')); // save or from the session to the database
			$this->Session->write('Order.Order.id', $orderId);
		} catch (ValidationException $e) {


			// get the validation error (from a serialize array) trhown by session_to_db and output them
			$this->Session->setFlash($this->OrderSession->validationErrorsToHtml(unserialize($e->getMessage())));
		}

		$this->Session->write('Order.Order.id', $orderId);

		return $data;
	}

	/**
	 * Revalidate the order before going to payment processing
	 * @throws Exception
	 */
	private function _redirectToApproveView() {

		if ($this->Order->validates()) {
			$this->redirect(array(
				'controller' => 'payments',
				'action'	 => 'processing'));
		} else {
			$time = time();
			$this->Session->destroy();
			throw new Exception(__('Sorry something whent wrong. You may try ordering again<br/> Error Number:' . $time), 500);
		}
	}

	/**
	 * Records the transaction in the database
	 *
	 * @param type $authorizationResponse
	 * @param type $orderId
	 */
	private function _logTransaction($authorizationResponse = null, $orderId = null) {
		$this->loadModel('TransactionLog');
		$orderId = (empty($orderId)) ? 0000 : $orderId; // if order was ner initiated

		try {
			$this->TransactionLog->logTransaction(
				$authorizationResponse, $this->Auth->user('id'), $orderId, $this->Session->read('Order.Order.location_id'), $this->Session->read('BillingAddress')); // Save Transaction response
		} catch (ValidationException $e) {

			// get the validation error (from a serialize array) trhown by session_to_db and output them
			$this->Session->setFlash($this->OrderSession->validationErrorsToHtml(unserialize($e->getMessage())));

			// reload billing_info
			$this->_redirectBackToPayementForm();
		} catch (PDOException $e) {
			// get the validation error (from a serialize array) trhown by session_to_db and output them
			$this->Session->setFlash(__('Sorry, your order was deleted. You may try to reorder.'));
			$this->OrderSession->clearOrder();

			// reload billing_info
			$this->_redirectBackToPayementForm();
		}
	}

	/**
	 * This is a bad workaround to allow the user to connect on a platform and get to the checkout page
	 * @todo pretty sure this can be remove must be tested from a platform. 
	 */
	public function platform_checkout() {
		
	}

	/**
	 * Apply new customer discount to credit card orders
	 */
	private function _newCustomerDiscount() {

		$this->loadModel('User');

		// the user is a customer if he as made at least one order
		if ($this->User->giveFirstOrderDiscount($this->Auth->user('id')) && $this->Session->read('Order.Order.method_of_payment') === 'creditcard') {
			$this->set('firstOrder', TRUE);
			$this->Session->write('Order.Order.coupon_code', '1399499398');
		} else {
			$this->set('firstOrder', FALSE);
		}
	}

	/**
	 * Check if the entered coupon is valid. If it's not it put the validation error message in the falshMessage
	 * @return string an error message or null
	 */
	private function _isCouponValid() {

		$couponCode = $this->Session->read('Order.Order.coupon_code');

		// Empty coupon means no coupon which is valid
		if (!empty($couponCode)) {

			// if method of payment is cash
			if ($this->Session->read('Order.Order.method_of_payment') === 'cash') {
				$this->_resetCoupon();
			} else {

				// Handle coupons
				try {
					$this->Coupon->isValid($this->Auth->user('id'), $this->Session->read('Order.Order.location_id'), $couponCode);
				} catch (ValidationException $e) {
					$this->flashMessage = ($this->flashMessage === NULL) ? $e->getMessage() : $this->flashMessage; // Validation error
				} catch (CouponException $e) {
					$this->flashMessage = ($this->flashMessage === NULL) ? $e->getMessage() : $this->flashMessage;
					$this->_resetCoupon();
				}
			}
		} else {

			$this->_resetCoupon();
		}
	}

	/**
	 * Set's everything about the coupon to "empty"
	 */
	private function _resetCoupon() {
		$this->Session->write('Order.Order.coupon_offered_by', NULL);
		$this->Session->write('Order.Order.coupon_code', NULL);
		$this->Session->write('Order.Order.coupon_discount', 0);
	}

	/**
	 * update method of payment for order
	 */
	public function credit_or_cash($value) {
		if ($value !== 'creditcard' && $value !== 'cash') {
			throw New Exception(__('No order exist'));
		}

		if ($this->Session->check('Order.Order.method_of_payment')) {
			$this->Session->write('Order.Order.method_of_payment', $value);
		} else {
			throw New Exception(__('No order exist'));
		}

		$this->checkout();
	}

	/**
	 * Redirects to the form that sent the payment ifnormation
	 */
	private function _redirectBackToPayementForm() {


		// reload this forms page
		if ($this->is_mobile) {
			$this->redirect(array(
				'controller' => 'payments',
				'action'	 => 'billing_info',
				'gateway'));
		} else {
			return $this->redirect(array(
					'controller' => 'orders',
					'action'	 => 'checkout',
//                'gateway'
			));
		}
	}

	/**
	 * This update the order in the database and sends, if $finish is true, the order to the restaurant's printer
	 * @param boolean $finish Finnish the order and send to restaurant?
	 */
	private function _saveOrderBeforeProcessing($finish) {


		$orderData['Order']				 = $this->Session->read('Order.Order');   // update order table in db
		$orderData['Order']['response']	 = $orderData['Order']['response'][0];
		$this->Order->save($orderData['Order']);						// update order table in db        

		if ($finish) {
			$this->Order->finishNewOrder($this->Order->id);   // send order to device/restaurant
			$this->Session->write('Order.Order.id', $this->Order->id);
		}
	}

	public function admin_accounting_report() {

		// Line Chart data
		$nbYear = date('Y', time()) + 1 - 2014; // number of years since 2014 (year of the first orders on the site)
		$this->set('lineData', json_encode($this->Order->revenuByMonthData($nbYear)));  // Line Chart for revenu by month
		$this->set('locations', $this->Location->find('list', array('conditions' => array('online_ordering' => true, 'status' => 'active'), 'fields' => array('Location.id', 'Location.name'))));
		// POST
		if ($this->request->is('POST')) {

			if (!empty($this->request->data['report'])) {

				/**
				 * Generate csv report
				 */
				// date array to string
				$startStrSmall	 = $this->request->data['Report']['start_date']['year'] . "-"
					. $this->request->data['Report']['start_date']['month'] . "-"
					. $this->request->data['Report']['start_date']['day'];
				$startStr		 = $startStrSmall . " 00:00:00";
				$endStrSmall	 = $this->request->data['Report']['end_date']['year'] . "-"
					. $this->request->data['Report']['end_date']['month'] . "-"
					. $this->request->data['Report']['end_date']['day'];
				$endStr			 = $endStrSmall . " 23:59:59";
				$restaurant		 = (empty($this->request->data['Report']['location']) ? NULL : $this->request->data['Report']['location']);

				$this->Order->bimonthlyRestaurantReport($startStr, $endStr, $this->request->data['Report']['show_details'], $this->langSuffix, $restaurant);
			} elseif (!empty($this->request->data['delete'])) {

				/**
				 * DELETE SELECTED ORDERS
				 */
				// Update status to deleted for all the order number in the input
				$exp			 = $this->_csvListToArray($this->request->data['Order']['identity']);
				$flashMessage	 = "";
				$valid			 = true;

				foreach ($exp as $value) {
					if (preg_match("/[0-9]/", $value)) {

						$order = $this->Order->findById($value);
						if (empty($order)) {

							// dont create non-existent order
							$flashMessageInvalid .= "[#$value] ";
							$valid = false;
						} else {
							$this->Order->id = $value;
							$this->Order->set('overall_status', 'DELETED');
							$this->Order->save();

							// Validation                        
							if ($this->Order->validates()) {
								$flashMessage .= "#$value ";
							} else {
								$flashMessageInvalid .= "[#$value] ";
								$valid = false;
							}
						}
					} elseif ($value !== "") {

						// dont do nothing with empty fields
						$flashMessageInvalid .= "[#$value] ";
						$valid = false;
					}
				}

				if ($valid) {
					$this->Session->setFlash(__("Orders removed %s", $flashMessage), 'flash_success');
				} else {
					$this->Session->setFlash(__("Orders %s where not removed because there not valid order number. Those %s where removed", array($flashMessageInvalid, $flashMessage)), 'flash_warning');
				}
			} elseif (!empty($this->request->data['add_user'])) {

				/**
				 * Add Testers to the testing_user table
				 */
				$this->loadModel('TestingUser');

				$exp				 = $this->_csvListToArray($this->request->data['User']['email']);
				$validationErrros	 = "";
				foreach ($exp as $value) {
					$user = $this->User->findByEmail($value);
					$this->TestingUser->create();
					$this->TestingUser->set('id', $user['User']['id']);
					$this->TestingUser->set('email', $user['User']['email']);
					$this->TestingUser->save();
					if (!empty($this->TestingUser->validationErrors)) {
						$this->Session->setFlash(implode(';', $validationErrros), 'flash_danger');
						exit;
					}
				}
			} elseif (!empty($this->request->data['ReportByOrder'])) {

				// create the special conditions
				$conditions = $this->_buildReportCondtions($this->request->data['ReportByOrder']['order_ids']);

				// Get result array				
				try {
					$results = $this->Order->generateReports($this->request->data['ReportByOrder']['start_date'], $this->request->data['ReportByOrder']['end_date'], $conditions);
				} catch (ValidationException $e) {
					$this->Session->setFlash($e->getMessage(), 'flash_danger');
				}

				// Output, for download, the csv file				
				$this->_outputReportToCsv($results, $this->request->data['ReportByOrder']['start_date'], $this->request->data['ReportByOrder']['end_date']);
			}
		}
	}

	/**
	 * If the submission yields any results this method will prepare and render the view to force the csv file to downloaded
	 * @param string $results query result array
	 * @param string $startStrSmall part filename
	 * @param string $endStrSmall part filename
	 */
	private function _outputReportToCsv($results, $startStrSmall, $endStrSmall) {
		$this->set('_delimiter', $this->request->data['ReportByOrder']['delimeter']); // "," => by default ";" => for french excel

		if (empty($results)) {
			$this->Session->setFlash(__("No orders found for your query"), 'flash_danger');
		} else {
			Configure::write('debug', 0); // debuggin messages prevents the the downloading of the file. I don't have time to debug that plugin                
			$this->response->download("rapport_$startStrSmall" . "_" . "$endStrSmall.csv");
			$this->CsvView->quickExport($results);
		}
	}

	/**
	 * Builds the string to be added to the where clause of the report query from the fields in the request
	 * @return string the string to append (empty string if nothing needs to be added)
	 * @todo This function should divide into three functions:
	 * <ol>
	 * <li>for coupons only</li>
	 * <li>for reports by id</li>
	 * <li>for delete by id</li>
	 * </ol>
	 */
	private function _buildReportCondtions() {

		$result = "";

		// Coupons only
		if ($this->request->data['ReportByOrder']['coupons_only']) {
			$result .= " AND `Order`.`coupon_discount` > 0 ";
		}

		// Specific orders (by id)
		if (!empty($this->request->data['Report']['order_ids'])) {
			$exp = $this->_csvListToArray($this->request->data['Report']['order_ids']);
			$result .= " AND (";
			foreach ($exp as $k => $value) {
				if (is_numeric($value)) {
					$result .= ($k > 0) ? "OR " : "";
					$result .= " `Order`.`id` = $value ";
				}
			}
			$result .= " ) ";
		}
		return $result;
	}

	/**
	 * Take a comma seperated list inputed by the user and transform it into an array
	 * @param string $explosive string to be explose into an array
	 * @return array exploded string
	 */
	private function _csvListToArray($explosive) {

		// explode csv list from input
		$str = str_replace(' ', '', $explosive);
		return explode(',', $str);
	}

	/**
	 * Checks if user may continue to try to pay for is order by credit card
	 * <ul>
	 * <li>Check the gateway decline reason and evaluates if the user should be logout (for example logout user when receiving the <i>"Pick up Card"</i> message</li>
	 * <li>Counts credit card payment attempts and deletes the order and redirect the user to the login page if this limit is reach.</li>
	 * </ul>
	 * 
	 * @param string $gatewayMessage the string explaining the refusal reason
	 * @param integer $limit number of attemps the user is allowed to do <br/> Default limit is <b>4 attempts</b> (after the forth, the order in session is deleted)
	 * 
	 */
	private function _allowUserToTryCreditCardAgain($gatewayMessage, $limit = 4) {

		if ($this->Session->check('transactionAttempts')) {
			$ta = $this->Session->read('transactionAttempts');

			if ($ta < ($limit - 1)) {
				$this->Session->setFlash($gatewayMessage, 'flash_danger');
			} elseif ($ta == ($limit - 1)) {	

				// Warning last attempt			
				$this->Session->setFlash($gatewayMessage . "<br/><br/>" . 'This is you last chance to enter the correct billing information.', 'flash_danger');
			} elseif ($ta >= $limit) {

				// Limit reach
				session_destroy();
				$this->Session->setFlash('Sorry, you have reach the limit of credit card payment attemtps. Your order has been deleted', 'flash_danger');
				$this->redirect(array('controller' => 'users', 'action' => 'login'));
			}

			$this->Session->write('transactionAttempts', $ta + 1);
		} else {
			$this->Session->write('transactionAttempts', 1);
			$this->Session->setFlash($gatewayMessage, 'flash_danger');
		}
	}

	/**
	 * Authentify user coming in from the platform and loads there order into the session
	 */
	private function _receiveFromPlatform() {


		/*		 * *************
		 * TOPMENU.COM *
		 * ************* */

		$plordid = $this->request->query('plordid');

		// From paltform        
		if (($plordid !== null) || $this->Session->check('Order.plordid')) {

			$plordid = ($plordid !== null) ? $plordid : $this->Session->read('Order.plordid');

			$this->loadModel('PlatformOrder');
			$this->loadModel('User');
			$plorder = $this->PlatformOrder->findById($plordid);	// data to be transfered from platform
			// Clear anything in the ssesion  and start a new one
			session_destroy();
			$this->Session->write('platform', $plorder['PlatformOrder']['platform_url']);

			// Allow user to login?                        
			if ($plorder['PlatformOrder']['client_ip'] != $this->request->clientIp()) {
				throw new Exception(__("Could not connect to Payment site. Code A"));   // different ip
			}

			if (strtotime($plorder['PlatformOrder']['modified']) < time() - (90 * MINUTE)) {
				throw new Exception(__("Could not connect to Payment site. Code B"));   // order too old
			}

			//TODO Manually/programitcally login user
			$user = $this->User->findById($plorder['PlatformOrder']['user_id']);
			if (!$this->Auth->login($user['User'])) {
				throw new Exception(__("Could not connect to Payment site. Code C"));   // order too old
			}

			// Load data into session
			$data = json_decode($plorder['PlatformOrder']['data'], true);
			$this->Session->write('Order', $data['Order']);
			$this->Session->write('Order.plordid', $plordid); // insert the json string from the db into the session
			$this->Session->write('DeliveryDestination', $data['DeliveryDestination']);
			$this->Session->write('DeliveryDestination', $data['DeliveryDestination']);

			// Use platform specific css 
			$platformCheckoutCssPath = 'platforms/' . parse_url($plorder['PlatformOrder']['platform_url'], PHP_URL_HOST) . '/';
			$this->set('platformCheckoutCssPath', $platformCheckoutCssPath);
			$this->Session->write('platformCheckoutCssPath', $platformCheckoutCssPath);
			$location				 = $this->Location->find('first', array(
				'conditions' => array(
					'Location.id' => $this->Session->read('Order.Order.location_id')),
				'fields'	 => array('Location.name',)));
			$this->Session->write('Location.Location.name', $location['Location']['name']);
			$this->layout			 = 'platforms';
		}
	}

	/**
	 * Form to allow admin to insert refund orders in the db. This does NOT send the refund to the gateway. 
	 * The refund as to made on the gateway's refund interface and then added here for our records.
	 */
	public function admin_refunds() {

		//TODO the admin user levels must be implemented correctly instead of doing this crazy stuff
		if ($this->Auth->user('email') !== 'sc@topmenu.com' && $this->Auth->user('email') !== 'pec@mail.com') {
			throw new ForbiddenException('Access denied / Accès refusé');
		}

		if ($this->request->is('post')) {
			$data = $this->request->data;
			$this->Order->set($data);

			if (!$data['Order']['total'] || !$data['Order']['special_instructions'] || !$data['Order']['transaction_id']) {
				$this->Session->setFlash(__('All fields are required'), 'flash_warning');
				$this->redirect(array('controller' => 'orders', 'action' => 'refunds'));
			}

			// Execute refund
			try {
				$this->Order->addRefundOrder($data['Order']['id'], $this->Auth->user('email'), $data['Order']['total'], $data['Order']['special_instructions'], $data['Order']['transaction_id']);
				$this->Session->setFlash(__("Success. Refund id is : %s", $this->Order->getLastInsertID()), 'flash_success');
				$this->redirect(array('controller' => 'orders', 'action' => 'refunds'));
			} catch (ValidationException $e) {
				$this->Session->setFlash($e->getMessage(), 'flash_danger');
				$this->redirect(array('controller' => 'orders', 'action' => 'refunds'));
			}
		}
	}

	/**
	 * Get the total of a given order for ajax request
	 * @param string $id Order id
	 */
	public function getOrderTotal($id) {
		$this->Order->contain('OrderDetail');
		$order = $this->Order->findById($id);
		if (!empty($order['Order'])) {
			echo (json_encode($order));
		}

		$this->autoRender = false;
	}

	/**
	 * get the delivery address (street number wit street name) from the order in sesison
	 * @return string or null
	 */
	private function _getAddressForFraud() {
		if ($this->Session->check('Order.Order.address_id')) {
			$daId	 = $this->Session->read('Order.Order.address_id');
			$da		 = $this->DeliveryAddress->findById($daId);
			return $da['DeliveryAddress']['address'];
		} else {
			return null;
		}
	}

	/**
	 * get and parse the phone number from the order in session
	 * @return string or null
	 */
	private function _getPhoneForFraud() {
		if ($this->Session->check('Order.Order.phone')) {
			$phone = $this->Session->read('Order.Order.phone');
			return $phone;
		} else {
			return null;
		}
	}

}
