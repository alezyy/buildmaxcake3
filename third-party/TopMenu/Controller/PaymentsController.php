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
App::uses('Order', 'Controller');

/**
 * Payments Controller
 *
 * @author pechartrand
 */
class PaymentsController extends AppController{
			
	public $uses = array('Payment', 'Order');
	public $components = array('OrderSession');
	public function beforeFilter() {
		parent::beforeFilter();

		switch ($this->request->action) {
			case 'billing_info':				
				$this->Security->csrfCheck = FALSE;
				$this->Security->validatePost = FALSE;
				break;				
		
			/**
			 * Delete the order in the sessin since it's completed
			 */
			case 'printable_order':
				$this->OrderSession->clearOrder();
				break;
			
			case 'processing':
				$this->header("refresh:300;" . Router::url(array('controller' => 'payments', 'action' => 'rejected')));
				break;
			
			case 'check_db':
				Configure::write('debug', 0);
				break;
        }

		$this->Auth->allow(
			'billing_info',
			'approved',
			'processing',
			'rejected',
			'check_db'
		);
		
	}
	
	public function afterFilter() {
		parent::afterFilter();
		
		switch($this->request->action){
			case 'approved':
			case 'printable_order':
				$this->OrderSession->clearOrder();
				break;
				
		}
	}

	/**
	 * Form where the user enters the is billing address and credit card info
	 * Only use by the mobile version of the site
	 */
	public function billing_info() {
				
		// Validate order
		try {
		$this->Order->updateCurrent($this->Session->read('Order'));	
		} catch (ValidationException $e) {
			$this->Session->setFlash($e->getMessage());				// Validation error
			$this->redirect(array('controller' => 'orders', 'action' => 'checkout'));
		} catch (CouponException $e) {
			$this->Session->setFlash($e->getMessage());				// Validation error
			$this->Session->write('Order.Order.coupon_code', '');	// Coupon error
			$this->redirect(array('controller' => 'orders', 'action' => 'checkout'));
		}

		if(!$this->Auth->user()){
			throw new ForbiddenException;
		}

		$this->loadModel('DeliveryAddress');
		$this->loadModel('Location');
		$this->loadModel('Province');
		$this->loadModel('AcceptedCreditCard');
		        
		$location = $this->Location->find('first', array(
			'contain' => array('Cuisine'),
			'conditions' => array(
				'Location.id' => $this->Session->read('Order.Order.location_id')),
			'fields' => array('Location.name', 'Location.delivery_average_time')));
		
		$this->set(
			'creditCardList', 
			$this->AcceptedCreditCard->find(
				'list', 
				array('fields' => array('name_en', 'name_' . $this->langSuffix))));
		
		$this->set(
			'provinces',
			$this->Province->get_provinces(
				Configure::read('I18N.COUNTRY_CODE_2'),
				$this->langSuffix,
				TRUE));

		$thisYear = date('y', time()); // get current year for expiry year min
		$this->set('thisYear', $thisYear);
		$this->set('thisYearPlus20', $thisYear + 20); // expiry year max

		$this->set('location', $location);
		
		// format "requested_for" date
		$requestedFor = strtotime($this->Session->read('Order.Order.requested_for'));
		setlocale(LC_TIME, $this->langSuffix . '_' . Configure::read('TopMenu.country'));
		$this->set('requestedFor', ($requestedFor < time())? __('ASAP'): strftime("%a %d %b %Y - %k:%M", $requestedFor));

		if($this->Session->check('DeliveryDestination.id')){
			$this->set('deliveryAddress', array('DeliveryAddress' => $this->Session->read('DeliveryDestination')));
		}else{
			$this->set('deliveryAddress', 
					$this->DeliveryAddress->findByUserId($this->Auth->user('id'), array(
						'address',
						'address2',
						'city',
						'province',
						'postal_code')));		
		}

        $this->set('orderId', $this->Session->read('Order.Order.id'));
	}
		
	public function approved($orderId){

		// User logged in
		if(!$this->Auth->user()){
			throw new ForbiddenException;
		}				
		
		$this->loadModel('Location');
		$this->loadModel('Rating');
		$this->loadModel('User');			
		
		// Location data
		$location = $this->Location->find('first', array(
			'contain' => array('Cuisine'),
			'conditions' => array(
				'Location.id' => $this->Session->read('Order.Order.location_id')),
			'fields' => array(
				'Location.id', 
				'Location.name', 
				'Location.delivery_average_time',
				'phone',
				'building_number',
				'street',
				'city',
				'province',
				'postal_code')));

		$this->Order->read(NULL, $orderId);
		$user = $this->User->getUserForEmail($this->Auth->user('id'));
				
		// Order is really approved?
		if($this->Order->field('overall_status') != 'waiting_user'){
			$this->redirect(array(
				'controller' => 'payments',
				'action' => 'rejected',
				'waiting_user'));
		}
		
		// Save order statuses in db
		$this->Order->set('overall_status', 'complete');					
		$this->Order->save();
		
		$this->set('orderIsDelayed', $this->Order->field('requested_for') > time());		// if order is set in a future time		
		$this->set('siteName', Configure::read('SITENAME'));							// Get this website name
		$this->set('locationName', $location['Location']['name']);						// Get this website name
		$this->set('location', $location);
		
		// Device response
		$this->loadModel('DeviceResponseMessage');	
		if(!$this->Order->id){
			$this->set('response_string', __('Your order is being process by the restaurant.'));
		}
		else{
			$this->set('response_string', $this->DeviceResponseMessage->translateString($this->Order->field('response'), $this->langSuffix));
		}
				
		// Open review entry (allow user to write a review for this order)
		//TODO put this in Rating model
		$this->Rating->create();
		$this->Rating->set('location_id', $this->Order->field('location_id'));
		$this->Rating->set('order_id', $orderId);
		$this->Rating->set('user_id', $this->Auth->user('id'));
		$this->Rating->set('status', 'open');
		$this->Rating->set('rating', '0');
		$this->Rating->set('review', 'Default Message');
		$this->Rating->save();
		$reviewId = $this->Rating->getLastInsertID();			

		// Breadcrumbs
		$this->Session->delete('Breadcrumbs.Checkout');
				
		// send email
		try{			
			$this->Order->sendInvoiceEmail($this->Order->data, $location['Location'], $user, $reviewId);
		}  catch (Exception $e){
			$this->Session->setFlash(__('Email fail to be sent. Please save this page as your order<br/>'.$e->getMessage()));
			$this->set('location', $location);
			$this->set('user', $user);
			$this->render('printable_order', 'print');//
		}
		
		$this->Session->write('Order.status', 'complete');		// close order
        
        // Platform layout
        if($this->Session->check('platform')){
            $this->set('platformCheckoutCssPath', $this->Session->read('platformCheckoutCssPath'));
            $this->layout = 'platforms';
        }
	}
		
	/**
	 * waiting room where the user is left while the device/restaurant respond
	 * @throws ForbiddenException
	 * @throws BadRequestException
	 */
	public function processing(){
		
		$this->response->disableCache();
		$this->loadModel('Device');
		$this->loadModel('Location');

		// Forbid access
		if(!$this->Auth->user()){
			$this->OrderSession->clearOrder();
			throw new ForbiddenException;
		}

		// Prevent user from reordering if theres no order in session or if the refer is not one of the list.
		if(!$this->Session->check('Order') || !$this->_correctRefererForProcessing()){
			$this->Session->setFlash(__('Your order is already sent'));			
			
			// set order has rejected in db and delete form session
			$orderFromDb = $this->Order->findById($this->Session->read('Order.Order.id'));
			$this->Order->set($orderFromDb['Order']['id']);
			$this->Order->set('overall_status', 'rejected');
			$this->Order->set('response', 'reorder');
			$this->Order->save();
			
			$this->OrderSession->clearOrder();
			
			// Show user's the order he just made
			$this->redirect(array('controller' => 'users', 'action' => 'my_account'));			
		}

        $this->_fromPlatform(); // checkout what layout to give
        
		$order = $this->Order->findById($this->Session->read('Order.Order.id'));
		$device = $this->Device->findByLocationId($order['Order']['location_id']);
			
		$this->set('location_response', $order['Order']['response']);	// Display the message selected by restaurant on device
		$this->set('timeout', $device['Device']['timeout']);			// Get the timeout of device to ajust processing max time accordingly to device speed (wifi = 120, sim = 300)
		$this->set('orderId', $order['Order']['id']);	
		
	}
	
	/**
	 * If the order is rejected the user is redirected here
	 * @param type $rejectionSource		Who rejected the order (ex: gateway or restaurant)
	 * @throws ForbiddenException		if acess by someone not logged in
	 */
	public function rejected($rejectionSource = NULL){
						
		$orderId = $this->Session->read('Order.Order.id');
		
		if(!$this->Auth->user()){
			throw new ForbiddenException;
		}		
		
		// Remove order from devices queue to avoid it being print at the restaurant 
		$this->loadModel('DeviceOrder');
		$deviceOrder = $this->DeviceOrder->findByOrderId($orderId);
		if(!empty($deviceOrder)){
			$this->DeviceOrder->delete($deviceOrder['DeviceOrder']['id']);
		}
		
		try {
			
			// Make sure the order is Set to rejecteds
			if (!$orderId) {
				throw new Exception();
			}

			$order								 = $this->Order->findById($orderId);
			$order['Order']['overall_status']	 = 'rejected';

			// Breadcrumbs
			$this->Session->delete('Breadcrumbs.Checkout');

			// Get rejection message
			if ($rejectionSource === 'restaurant') {
				$this->loadModel('DeviceResponseMessage');
				$order['Order']['location_response'] = $this->DeviceResponseMessage->translateString($this->Order->field('response'), $this->langSuffix);
			} elseif ($rejectionSource === 'gateway') {
				$this->loadModel('GatewayResponseMessage');
				$order['Order']['location_response'] = $this->GatewayResponseMessage->translateString($this->Order->field('response'), $this->langSuffix);
			} else {
				$order['Order']['overall_status']	 = 'timeout';
				$order['Order']['location_response'] = __('The restaurant may not be able to answer your request presently');
			}

			// Platform layout
			if ($this->Session->check('platform')) {
				$order['Order']['platformCheckoutCssPath']	 = $this->Session->read('platformCheckoutCssPath');
				$this->layout								 = 'platforms';
			}

			$this->Order->save($order, false);
			$this->OrderSession->clearOrder();
		} catch (Exception $e) {
			if ($this->Session->check('Order.Order.id')) {
				$orderId = $this->Session->read('Order.Order.id');
			} else {
				$orderId = __('None');
			}
			$this->set(
				'location_response', __('Something went wrong. Please contact Topmenu. (Use the customer support link in the footer)<br>Order id: %s', array($orderId)));
			$this->Session->destroy();
		}
	}
	
	/**
	 * Send Order->checkDb result to ajax caller
	 */
	public function check_db($attempt){

		if(!$this->Auth->user()){
			throw new ForbiddenException;
		}
		
		try{
			$result = $this->Order->checkDb($this->Session->read('Order.Order.id'), $attempt);
			$this->layout = 'ajax';
			$this->set('result', $result['device_status']);   // send value to view which will be read by ajax call
			$this->Session->write('Order.Order.overall_status', $result['overall_status']);
			$this->Session->write('Order.Order.device_status', $result['device_status']);

		
		} catch (Exception $e){
			if($this->Session->check('Order.Order.id')){
				$orderId = $this->Session->read('Order.Order.id');
			}else{
				$orderId = __('None');
			}
            
			$this->set('location_response', __('Something went wrong. Please contact Topmenu. (Use the customer support link in the footer)<br>Order id: %s<br/>Error message: %s', array($orderId, $e->getMessage())));

            // Destroy session to avoid weird stuff
            if ($this->Session->check('platform')) {

                // Keep platform data in session
                $location = $this->Location->find('first', array(
                    'conditions' => array(
                        'Location.id' => $this->Session->read('Order.Order.location_id')),
                    'fields'     => array('Location.name',)));

                $platformCheckoutCssPath = $this->Session->read('platformCheckoutCssPath');
                $this->set('platformCheckoutCssPath', $platformCheckoutCssPath);
                $this->Session->write('Location.Location.name', $location['Location']['name']);

                $this->Session->destroy();

                $this->Session->write('platformCheckoutCssPath', $platformCheckoutCssPath);
                $this->Session->write('platformCheckoutCssPath', $platformCheckoutCssPath);
                $this->layout = 'platforms';
            } else {
                $this->Session->destroy();
            }
        }
	}
	
	private function _redirectToApproveView() {

						if ($this->Order->validates()) {			
			$this->redirect(array(
				'controller' => 'payments',
				'action' => 'processing'));
		} else {
			$time = time();
			$this->Session->destroy();
			throw new Exception(__('Sorry something whent wrong. You may try ordering again<br/> Error Number:' . $time), 500);
		}
	}
	
	private function _logTransaction($authorizationResponse = null, $orderId = null) {
		$this->loadModel('TransactionLog');
		$orderId = (empty($orderId)) ? 0000 : $orderId; // if order was ner initiated

		if($authorizationResponse === null){
			// get the validation error (from a serialize array) trhown by session_to_db and output them
			$this->Session->setFlash(__('Invalid data entered. Please review your billing information'));

			// reload billing_info
			$this->redirect(array(
				'controller' => 'payments',
				'action' => 'billing_info',
				'gateway'));
		}
		try {
			$this->TransactionLog->logTransaction(
				$authorizationResponse, $this->Auth->user('id'), $orderId, $this->Session->read('Order.Order.location_id')); // Save Transaction response
		} catch (ValidationException $e) {

			// get the validation error (from a serialize array) trhown by session_to_db and output them
			$this->Session->setFlash($this->OrderSession->validationErrorsToHtml(unserialize($e->getMessage())));

			// reload billing_info
			$this->redirect(array(
				'controller' => 'payments',
				'action' => 'billing_info',
				'gateway'));
		} catch (PDOException $e){
			// get the validation error (from a serialize array) trhown by session_to_db and output them
			$this->Session->setFlash(__('Sorry, your order was deleted. You may try to reorder.'));
			$this->OrderSession->clearOrder();

			// reload billing_info
			$this->redirect(array(
				'controller' => 'payments',
				'action' => 'billing_info',
				'gateway'));
		}
	}
	
	private function _addPaymentInfoToOrder(){
			$taxesTotal = $this->Session->read('Order.Order.total') - $this->Session->read('Order.Order.subtotal');
			$data = $this->request->data('Payment');
			$data['method'] = $this->Session->read('Order.Order.method_of_payment');

			// set object for validation
			$this->Payment->set($this->Payment->flattenRequest($data));
			$this->Payment->set(array(
				'tax' => $taxesTotal,
				'amount' => $this->Session->read('Order.Order.total')));
			
			// set transaction data in request array
			$data['transaction']['amount']['total'] = $this->Session->read('Order.Order.total');
			$data['transaction']['amount']['currency'] = Configure::read('I18N.CURRENCY');
			$data['transaction']['amount']['details']['subtotal'] = $this->Session->read('Order.Order.subtotal');
			$data['transaction']['amount']['details']['tax'] = $taxesTotal;
			$data['transaction']['amount']['details']['shipping'] = 0;
			$data['billing_address']['country_code'] = Configure::read('I18N.COUNTRY_CODE_2');
			$this->Payment->requestTemplate = $data;
			
			// save order in data base
			$gateWayStatus = ($this->Session->check('Order.Order.gateway_status')) ? $this->Session->read('Order.Order.gateway_status') : 'unproccessed';			// catch that this is a resubmit because gateway sent a error message
			$this->Session->write('Order.Order.gateway_status', $gateWayStatus);
			$this->Session->write('Order.Order.device_status', 'unprocessed');
			$this->Session->write('Order.Order.overall_status', 'processing');
							
			try {
				$orderId = $this->Order->session_to_db($this->Session->read('Order')); // save or from the session to the database		
				$this->Session->write('Order.Order.id', $orderId);
			} catch (ValidationException $e) {

				
				// get the validation error (from a serialize array) trhown by session_to_db and output them
				$this->Session->setFlash($this->OrderSession->validationErrorsToHtml(unserialize($e->getMessage())));

				// reload billing_info
				$this->redirect(array(
					'controller' => 'payments',
					'action' => 'billing_info',
					'gateway'));
			}

			$this->Session->write('Order.Order.id', $orderId);		
			
			return $data;
	}
	
	/**
	 * Redirect user to his account page if has no order or the refering page is not an logical one
	 */
	private function _correctRefererForProcessing(){
		
		if($this->is_mobile){
			$expectedReferer = Router::url(array('controller' => 'payments', 'action' => 'billing_info', 'language' => $this->langSuffix), TRUE);
			return (strrpos($this->referer(), $expectedReferer) >= 0);
		}else{
			$expectedReferer = Router::url(array('controller' => 'orders', 'action' => 'checkout', 'language' => $this->langSuffix), TRUE);
			return (strrpos($this->referer(), $expectedReferer) >= 0);
		}
		
	}
    
    public function debug(){
        $this->autoRender = false;
        echo $this->Payment->testXml();
    }
    
    private function _fromPlatform(){
        if($this->Session->check('Order.plordid')){
            $this->set('platformCheckoutCssPath', $this->Session->read('platformCheckoutCssPath'));
            $this->layout = 'platforms';
            $this->set('location', $this->Session->read('Location'));
        }
    }
}