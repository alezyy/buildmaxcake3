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

App::uses('Component', 'Controller');
App::uses('ValidationException', 'Lib' .DS. 'Error' .DS. 'Exception');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP OrderSession
 * @author pechartrand
 */
class OrderSessionComponent extends Component {
	
	public $components = array('Auth', 'BreadCrumbs', 'Cookie');
	

	public function initialize(Controller $controller) {
		$this->controller = $controller;
		$this->Auth->loggedIn();
	}

	public function startup(Controller $controller) {	
		$this->controller = $controller;
	}

	/**
	 * Checks if the "Order" value inserted into the session Order object is possible
	 * 
	 * @param string	$locationId	location_id of the item being added
	 * 
	 * @return bool					TRUE if everything is valid. Otherwise throws error messages and returns FALSE
	 * @throws Exception			If something is invalid an exception is trhown with a descriptive error message
	 */
	public function validateEdit($locationId) {

		$locationModel= ClassRegistry::init('Location');		
		$deviceModel = ClassRegistry::init('Device');
		
		// check location id
		$location = $locationModel->find('first', array(
			'conditions' => array(
				'Location.id' => $locationId,
				'Location.status' => 'active',
				'Location.online_ordering' => true),
			'fields' => array('id')));
		if (empty($location)) {
			throw new ValidationException(__('This location is not accepting orders at the moment. Please try a different location or restaurant.'));
		}
		
		// Device is online
		if(!$deviceModel->getDeviceStatus($location['Location']['id'])){
			throw new ValidationException(__('The restaurant at this location is presently not accepting orders. Please try another locations or a different restaurant'));
		}	

		// Create a new order skeleton in session
		if (!$this->controller->Session->check('Order')) {						
			return $this->_createNewOrder($locationId);
		}
		
		// IF ORDER EXISTE, CHECK IT'S VALIDITY				
		
		// Order already sent?
		elseif ($this->controller->Session->check('Order.Order.id')) {
			$orderIdValue = $this->controller->Session->read('Order.Order.id');
			if (!empty($orderIdValue)) {
				$this->controller->Session->SetFlash(__('This order is or is being sent. Please wait for a confirmation message or email'));
			}
		}
		// same location in session has current location?		
		elseif ($this->controller->Session->read('Order.Order.location_id') !== $locationId && $this->controller->Session->read('Order.Order.location_id') !== NULL) {
				throw new ValidationException(__('Please order from only one location at the time.'));
			}
		// order initialize more than 60 minutes ago?
		elseif (((time() - $this->controller->Session->read('Order.initialize_time')) / 60) > 60) {
				throw new ValidationException(__('This order is too old. Please log out and login again.'));
			}
		
		// still the original user?
		if ($this->Auth->loggedIn() && $this->controller->Session->check('Order.Order.user_id')){
			if ($this->controller->Session->read('Order.Order.user_id') !== $this->Auth->user('id')) {
				throw new ValidationException(__('Please log out and login again.'));
			}	
		}

		// VALID	
		return TRUE;
	}

	/**
	 * Declares a "Order" variable in the session to prepare the save order action and to display the order totals to 
	 * the user.
	 * @param string $locationId
	 * @param string $userId
	 * @todo Reconsider this function location's (Model or Controller).
	 * @return bool true on success, false on failure
	 */
	public function declareOrderInSession($locationId, $userId) {

            $this->loadModel('Location');

            $this->controller->Session->write('Order');
            $this->controller->Session->write('Order.locationId', $locationId);   // set location's id		
            $this->controller->Session->write('Order.userId', $userId); // set user's id		
            $this->controller->Session->write('Order.deliveryCharge', 0);
            $this->controller->Session->write('OrderDetail', array());  // empty item list		
            
		return true;
	}
	
	/**
	 * Copies the relevent data from Session variable    DeliveryAddress.* to Order.Order.*
	 * @param bool $validateAddress whetter to check if address is valid (as oppose to simply a postal code)
	 * @return bool
	 */
	public function copyDeliveryAddressInOrder() {
		
		// Check if is delivery				
		if ($this->controller->Session->check('DeliveryDestination')) {
			$deliveryAddress = $this->controller->Session->read('DeliveryDestination');
			if (!empty($deliveryAddress)) {
				foreach ($deliveryAddress as $k => $da) {
					if ($k === 'id') {
						$this->controller->Session->write('Order.Order.address_id', $da);
					}else{					
						$this->controller->Session->write('Order.Order.' . $k, $da);
					}
				}
				
				// remove irrelevent fields
				$this->controller->Session->delete('Order.Order.confirmed');
				$this->controller->Session->delete('Order.Order.asked');
				
				return TRUE;
			} else {
				throw new ValidationException(__('Delivery address is empty. Please choose or add one from/to your profile.'));
			}
		}
		return FALSE;
	}
	
	/**
	 * Calculate and set update everything to do with an order
	 */
	public function updateOrder() {
		$orderModel = ClassRegistry::init('Order');
		try {
			$update = $orderModel->updateCurrent($this->controller->Session->read('Order'));  // calculate totals and validate 
			$this->controller->Session->write('Order', $update);   // update session
			if ($this->Auth->loggedIn()){
				$this->controller->Session->write('Order.Order.user_id', $this->Auth->user('id'));
			}
		} catch (ValidationException $e) {

			// Error message in order side bar
			$this->controller->Session->setFlash($e->getMessage());			
		}
	}
	
	/**
	 * completely delete the order and it's relative variables from the session
	 */
	public function clearOrder(){
		
		// Destroy order in session
		$this->controller->Session->delete('Order');
		$this->controller->Session->delete('enableCheckout');
		
		// remove checkout from bread crumbs
		if($this->controller->Session->check('Breadcrumbs.Checkout')){
			$this->controller->Session->delete('Breadcrumbs.Checkout');
		}
	}
	
	/**
	 * Set the order (in the session) to delivery or pickup (Order.Order.type)
	 * @return	string	Resulting string "delivery" or "pickup"
	 */
	public function setOrderType(){

		if ($this->controller->Session->check('Order.Order.type')) {					// from order
			$delType = $this->controller->Session->check('Order.Order.type');
		} elseif ($this->controller->Session->check('Search.type')) {					// from search
			$searchType = $this->controller->Session->read('Search.type');
			$delType = $searchType === 'pickup' ? 'pickup': 'delivery';
		} else {															// default
			$delType = 'delivery';
		}
		
		return $delType;
	}
	
	public function locationIsCompatibleWithOrder($locationId){
		if (!$this->controller->Session->check('Order')){
			return TRUE;
		}elseif($this->controller->Session->check('Order.Order')){
			if(!$this->controller->Session->check('Order.Order.location_id') ){
				return TRUE;
			}
			elseif($this->controller->Session->read('Order.Order.location_id') != $locationId){
				return FALSE;
			}
		}
		
		return TRUE;
		
		
	}
	
	/**
	 * Transform validationError array into html for flash message
	 * 
	 * @param array $validationErrors the array of erros
	 * @param string $title Title of the message defaults to: <i> __('Please review theses fields: <br/>');</i>
	 * @return string
	 */
	public function validationErrorsToHtml($validationErrors, $title = null) {
		$htmlString = ($title === NULL) ? __('Please review theses fields: <br/>') : $title;
		$htmlString .= "<ul>";
		foreach ($validationErrors as $error) {
			$htmlString .= "<li>";
			$htmlString .= $error[0];
			$htmlString .= "</li>";
		}
		$htmlString .= "</ul>";
		return $htmlString;
	}
	
//  Function removed because was making more too buggy for the benefit it generated
//	private function _suspiciouslyRecenteOrder($userId) {
//
//		$orderModel = ClassRegistry::init('Order');
//		$lastOrderTimeArray = $orderModel->find('first', array(
//			'conditions' => array('Order.user_id' => $userId),
//			'order' => array('Order.created DESC')));
//		if (!empty($lastOrderTimeArray)) {
//			$lastOrderTime = strtotime($lastOrderTimeArray['Order']['created']);
//			$lessThan1Hour = (($lastOrderTime + 3600) > time()); // 3600 = 1 hour
//			if ($lessThan1Hour) {
//				$this->controller->Session->setFlash(__('You have already made an order less than an hour ago. Are you sure you want to create a new order?<br/>'));
//			}
//		}
//	}
	
	/**
	 * Insert user data in a new order
	 * @param type $userId
	 */
	private function _initiateUserData($userId){
		
		$userModel = ClassRegistry::init('User');
		$user = $userModel->find('first', array(
			'contain' => array('Profile'),
			'conditions' => array(
				'User.id' => $userId
			),
			'fields' => array(
				'User.email',
				'Profile.first_name',
				'Profile.last_name',
				'Profile.language',
				'Profile.phone')));

		$this->controller->Session->write('Order.Order.user_id', $this->Auth->user('id'));
		$this->controller->Session->write('Order.Order.first_name', $user['Profile']['first_name']);
		$this->controller->Session->write('Order.Order.last_name', $user['Profile']['last_name']);
		$this->controller->Session->write('Order.Order.phone', $user['Profile']['phone']);
		$this->controller->Session->write('Order.Order.language', $user['Profile']['language']);
		$this->controller->Session->write('Order.Order.email', $user['User']['email']);
	}
	
	/**
	 * Insert location data in a new order
	 * @param type $locationId
	 * @param type $timezone
	 */
	private function _initiateLocationData($locationId, $timezone = NULL) {
		$timezone = ($timezone === NULL) ? Configure::read('Config.timezone') : $timezone;
		$this->controller->Session->write('Order.Order.location_id', $locationId); // insert user data
		$this->controller->Session->write('Order.Location.timezone', $timezone);
	}
	
	/**
	 * Insert generic data in new order
	 * <ul>
	 *	<li>Set numeric fields to 0</li>
	 *	<li>Set the order type (delivery or takeout) to delivery by default</li>
	 *	<li>Set order requested for date to now</li>
	 * </ul>
	 * 
	 */
	private function _initiateGeneralOrderData() {

		$this->controller->Session->write('Order.Order.subtotal', 0);
		$this->controller->Session->write('Order.Order.type', $this->setOrderType());
		$this->controller->Session->write('Order.Order.delivery_charge', 0);
		$this->controller->Session->write('Order.Order.tip', 0);
		$this->controller->Session->write('Order.Order.total', 0);
		$this->controller->Session->write('Order.Order.requested_for', date('Y-m-d H:i:s'));
		$this->controller->Session->write('Order.Order.method_of_payment', 'creditcard');
		$this->controller->Session->write('Order.Order.coupon_code');
	}
	
	/**
	 * 
	 * @param type $locationId
	 * @return boolean
	 */
	private function _createNewOrder($locationId) {
		$this->controller->Session->write('Order');
		$this->controller->Session->write('Order.initialize_time', time());

		if ($this->Auth->loggedIn()) {
			$this->_initiateUserData($this->Auth->user('id'));	// insert user data in order				
		}

		$this->_initiateLocationData($locationId);		// Insert Location data
		$this->_initiateGeneralOrderData();				// Genereic data for order (totals to zero and date)		
		$this->copyDeliveryAddressInOrder();			// Insert Destination data

		return TRUE;
	}	
	
}