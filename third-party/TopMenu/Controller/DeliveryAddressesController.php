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
 * DeliveryAddresses Controller
 *
 * @property DeliveryAddress $DeliveryAddress
 * @property PaginatorComponent $Paginator
 */
class DeliveryAddressesController extends AppController {

	public $uses = array(
		'DeliveryAddress',
		'DeliveryArea',
		'User',
		'Country',
		'Province',
		'City');

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow(
			'choose', 
			'check_user_has_delivery_address',
			'change_delivery_address',
			'change_billing_address'
		);

		switch ($this->request->action) {
			case 'user_edit':
			case 'user_add':
			case 'user_delete':
				$this->Security->validatePost = FALSE;
				$this->Security->csrfUseOnce = FALSE;
				break;
		}

		$this->Security->unlockedActions = array(
			'change_delivery_address',
			'change_billing_address'
		);
	}

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Image', 'AjaxForm');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->DeliveryAddress->recursive = 0;
		$this->set('deliveryAddresses', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->DeliveryAddress->exists($id)) {
			throw new NotFoundException(__('Invalid delivery address'));
		}
		$options = array('conditions' => array('DeliveryAddress.' . $this->DeliveryAddress->primaryKey => $id));
		$this->set('deliveryAddress', $this->DeliveryAddress->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->DeliveryAddress->create();
			print_r($this->request->data);
			$data = $this->request->data;
			$data['DeliveryAddress']['user_id'] = $this->Auth->user('id');
			if ($this->DeliveryAddress->save($data)) {
				$this->Session->setFlash(__('The delivery address has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The delivery address could not be saved. Please, try again.'));
			}
		}
		$users = $this->DeliveryAddress->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->DeliveryAddress->exists($id)) {
			throw new NotFoundException(__('Invalid delivery address'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->DeliveryAddress->save($this->request->data)) {
				$this->Session->setFlash(__('The delivery address has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The delivery address could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('DeliveryAddress.' . $this->DeliveryAddress->primaryKey => $id));
			$this->request->data = $this->DeliveryAddress->find('first', $options);
		}
		$users = $this->DeliveryAddress->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->DeliveryAddress->id = $id;
		if (!$this->DeliveryAddress->exists()) {
			throw new NotFoundException(__('Invalid delivery address'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DeliveryAddress->delete()) {
			$this->Session->setFlash(__('Delivery address deleted'), 'default', array('class' => 'flash_success'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Delivery address was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}

/**
 * user_view method
 *
 * @param string $id
 * @return void
 */
	function index() {
		$this->view = 'user_view';
		$addreses = $this->Paginator->paginate('DeliveryAddress', array('DeliveryAddress.user_id' => $this->Auth->user('id')));
		$this->set('address', $addreses);
	}

/**
 * admin_add method
 * @param	string	$successPage The url of the Locations to where the user should be redirected (calling page)
 * @return	void
 */
	public function user_add($successPage = NULL) {
	
		// populate dropdown list
		$this->loadModel('Country');
		$this->loadModel('Province');
		$country = $this->Country->get_countries();
		$province = $this->Province->get_provinces(Configure::read('I18N.COUNTRY_CODE_2'));
		$this->set('provinces', $province);
		$this->set('countries', $country);

		// Get arrays of province, countries and cities
		$province = $this->Province->get_provinces(Configure::read('I18N.COUNTRY_CODE_2'));
		$this->set('province', $province);
		$country = $this->Country->get_countries();
		$this->set('country', $country);
		$city = $this->City->getCities('Quebec');
		$this->set('city', $city);
		$this->set('successPage', $successPage); // set success page
		$this->set('modal_id', sha1(microtime()));


		// POST

		if ($this->request->is('post')) {			// success
			$data = $this->request->data;
			$data['DeliveryAddress']['user_id'] = $this->Auth->user('id');
			$this->DeliveryAddress->create();

			// Ajax layout
			if ($this->request->is('ajax')) {
				Configure::write('debug', 0);
				$this->layout = 'ajax';
			}

			if ($this->DeliveryAddress->save($data) && $this->request->is('ajax')) {  // success AJAX
				// check if the delivery address is valid for the current order
				
				if ($this->Session->check('Order') &&
					$this->DeliveryArea->deliversThereAndCharges($this->Session->read('Order.Order.location_id'), $data['DeliveryAddress']['postal_code']) === FALSE) {
					$this->Session->setFlash(__('The restaurant does not delivery to this address. You may use this address as your billing address'));
				} else {
					$this->Session->setFlash(__('Your delivery and billing address have been set to your new address'), 'default', array('class' => 'flash_success'));
				}

				// Set new address as current addres in session
				$this->_updateSessionDeliveryAddress($data, $this->DeliveryAddress->getLastInsertID());
				$this->Session->setFlash(__('The delivery address has been added and selected'), 'default', array('class' => 'flash_success'));
				$this->set('response', '1');
				$this->render('json/add');
				
			} elseif ($this->DeliveryAddress->save($data)) {		 // success normal
				$this->Session->setFlash(__('The delivery address has been saved'), 'default', array('class' => 'flash_success'));
				$this->set('success', __('The delivery address has been saved'));

				// Set new address as current addres in session
				$this->_updateSessionDeliveryAddress($data, $this->DeliveryAddress->getLastInsertID());

				// Redirect to appropriate success page
				$this->_redirect($successPage);
			} elseif ($this->request->is('ajax')) {		   // validation and save failed AJAX
				// Output validation errors			
				$this->set('response', json_encode($this->AjaxForm->validationErrors('DeliveryAddress', $this->DeliveryAddress->validationErrors)));
				$this->render('json/add');
			} else {				  // validation and save failed AJAX
				$this->Session->setFlash(__('The delivery address could not be saved. Please, try again.'));
			}
		}
	}

/**
 * user_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function user_edit($id, $redirect = null) {

		// populate dropdown list
		$this->loadModel('Country');
		$this->loadModel('Province');
		$country = $this->Country->get_countries();
		$province = $this->Province->get_provinces(Configure::read('I18N.COUNTRY_CODE_2'));
		$this->set('provinces', $province);
		$this->set('countries', $country);

		if (!$this->DeliveryAddress->exists($id)) {
			throw new NotFoundException(__('Invalid delivery address'));
		}

		// POST
		if ($this->request->is('post') || $this->request->is('put')) {

			$data = $this->request->data;
			$result = $this->DeliveryAddress->save($data);
			if ($result && $this->request->is('ajax')) {  // success AJAX
				// check if the delivery address is valid for the current order
				if ($this->Session->check('Order') &&
					$this->DeliveryArea->deliversThereAndCharges($this->Session->read('Order.Order.location_id'), $data['DeliveryAddress']['postal_code']) === FALSE) {
					$this->Session->setFlash(__('The restaurant does not delivery to this address. You may use this address as your billing address'));
				} else {
					$this->Session->setFlash(__('Your delivery and billing address have been set to your new address'), 'default', array('class' => 'flash_success'));
				}

				// Set new address as current addres in session
				$this->_updateSessionDeliveryAddress($data, $data['DeliveryAddress']['id']);
				$this->set('response', TRUE);
				return $this->render('json/user_edit');
			} elseif ($result) {

				// Save
				$this->Session->setFlash(__('The delivery address has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} elseif ($this->request->is('ajax')) {		   // validation and save failed AJAX
				// Output validation errors								
				$this->set('response', json_encode($this->AjaxForm->validationErrors('DeliveryAddress', $this->DeliveryAddress->validationErrors)));
				return $this->render('json/user_edit');
			} else {

				// Save failed
				$this->Session->setFlash(__('The delivery address could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('DeliveryAddress.' . $this->DeliveryAddress->primaryKey => $id));
			$this->request->data = $this->DeliveryAddress->find('first', $options);
		}

		$this->set('addressId', $id);
		$users = $this->DeliveryAddress->User->find('list');
		$this->set(compact('users'));

		if ($this->request->is('ajax')) {
			return $this->render('modal/user_edit');
		}
	}

/**
 * user_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function user_delete($id = null, $redirect = null) {

		$this->DeliveryAddress->id = $id;
		if (!$this->DeliveryAddress->exists()) {
			throw new NotFoundException(__('Invalid delivery address'));
		}
		$this->request->onlyAllow('post', 'delete');

		if ($this->DeliveryAddress->delete()) {

			$this->Session->setFlash(__('Delivery address was deleted'), 'default', array('class' => 'flash_success'));

			switch ($redirect) {
				case 'checkout':
					$this->redirect(array('controller' => 'orders', 'action' => 'checkout'));
					break;

				default:
					$this->redirect(array('action' => 'index'));
					break;
			}
		}
		$this->Session->setFlash(__('Delivery address was not deleted'));

		return $this->redirect(array('action' => 'index'));
	}

	public function delete_confirm($id) {
		$address = $this->DeliveryAddress->findById($id);
		$this->set('id', $id);
		$this->set('address', $address);
		$this->render('modal/delete');
	}

	/**
	 * Set a delivery adress in the session and in the cookies
	 * 
	 * @param array $id DeliveryAddress model
	 */
	private function toSession($id) {

		// retrieve data
		$address = $this->DeliveryAddress->find('first', array(
			'conditions' => array('DeliveryAddress.id' => $id),
			'fields' => array('id', 'door_code', 'postal_code', 'country', 'province', 'city', 'address', 'address2', 'phone', 'cross_street', 'inline_address'),
			'order' => array('DeliveryAddress.last_used DESC')));

		// Write data in session
		$this->Session->write('DeliveryDestination', $address['DeliveryAddress']); // add object to session
		$this->Cookie->write('postal_code', $address['DeliveryAddress']['postal_code'], FALSE, '1 Year', '/', FALSE, FALSE); // add object to session
		
		// Update the billing address if none is choosen
		if(!$this->Session->check('BillingAddress')){
			$this->Session->write('BillingAddress', $address['DeliveryAddress']);
		}

		// if order exist update order delivery address
		if ($this->Session->check('Order')) {
			$this->OrderSession = $this->Components->load('OrderSession');
			$this->OrderSession->initialize($this);
			return $this->OrderSession->copyDeliveryAddressInOrder();
		}
	}

	private function _redirect($success) {
		
		// Redirect to the loginRedirect value in session if it exist
		if ($this->Session->check('loginRedirect')) {
			$tmpLoginRedirect = $this->Session->read('loginRedirect');
			$this->Session->delete('loginRedirect');
			$this->redirect($tmpLoginRedirect);			
		}
		
		// Use the $success parameter to redirect
		switch ($success) {
			case 'register': // go to search page
				$this->Session->write('newRegistration', TRUE);
			case '':
			case NULL:
				$this->Session->setFlash(__('New delivery address saved'), 'default', array('class' => 'flash_success'));
				//todo rebuild search query page wit $this->_setSearchQuery($postalCode);
				$this->redirect(
					array(
						'controller' => 'locations',
						'action' => 'search',
						'session'));

				break;

			case 'checkout': // go back to checkout page

				$this->redirect(array(
					'controller' => 'orders',
					'action' => 'checkout',
					'?' => 'seoAddressCreation'));
				break;

			default:   // variable is the retaurant url, go back to that restaurant
				$this->loadModel('Location');
				$location = $this->Location->findByUrl($success);
				$this->redirect(
					array(
						'controller' => 'locations',
						'action' => 'view',
						'location' => $success,
						'sector' => $location['Location']['sector_slug']));

				break;
		}
	}

/**
 * Set the delivery address to the newly added one for future use
 * @param array $data data from request
 * @param string $id id of the last inserte delivery address
 */
	private function _updateSessionDeliveryAddress($data, $id) {

//		// Check if the new address matches the postal code used for the previous search and warn if there's a difference
//		$pcPrefix = strtoupper(substr($data['DeliveryAddress']['postal_code'], 0, 3));
//		$sessionPostalCode = $this->Session->read('DeliveryDestination.postal_code');
//				
//		if ($this->Session->check('Search.query')) {
//			$sessionPostalCode = $this->Session->read('Search.query');
//			if (strtoupper(substr($sessionPostalCode, 0, 3)) != $pcPrefix) {
////				$this->Session->setFlash(__('The newly added delivery address does not match the postal code you searched for'));
//			}
//		}

		// Edit the request //TODO check if this is needed
		$this->request->data['Location']['type'] = 'delivery';
		$this->request->data['Location']['postal_code1'] = strtoupper($data['DeliveryAddress']['postal_code']);

		$this->toSession($id);
	}

/**
 * Outputs and address with minimal html formating
 * @param type $id id of address to be displayed
 */
	public function display_one_address($id, $displayLabel = TRUE) {
		$this->layout = 'ajax';
		$this->set('displayLabel', $displayLabel);
		$this->set('address', $this->DeliveryAddress->findById($id));
	}

/**
 * Change the delivery address of the order in session 
 * 
 * @param type $id delivery address id 
 */
	public function change_delivery_address_in_session($id) {
		
		$this->toSession($id);
		$this->Session->setFlash(__('Delivery address changed'), 'default', array('class' => 'flash_success'));
		$this->redirect(array('controller' => 'orders', 'action' => 'checkout'));
	}

	public function set_billing_address($id) {
		$result = $this->DeliveryAddress->findById($id);
		 $result['DeliveryAddress']['postal_code'] = strtoupper($result['DeliveryAddress']['postal_code']);
		$this->Session->write('BillingAddress', $result['DeliveryAddress']);
		$this->Session->setFlash(__('Billing address changed'), 'default', array('class' => 'flash_success'));
		$this->redirect(array('controller' => 'orders', 'action' => 'checkout'));
	}

	public function confirm($id) {

		// Make sure there's a delivery address in the session
		if (!$this->Session->check('DeliveryDestination.id')) {
			$da = $this->DeliveryAddress->findById($id);
			$this->Session->write('DeliveryDestination', $da['DeliveryAddress']);
            $this->Cookie->write('postal_code', $da['DeliveryAddress']['postal_code'], FALSE, '1 Year', '/', FALSE, FALSE); // add object to session
		}

		// Retrieve data for the Restaurant information row	
		//TODO when the user reach the location page set the location info in the session and retrieve the data from there to save some database queries
		$this->loadModel('Location');
		$location = $this->Location->findById($this->Session->read('Order.Order.location_id'), array('Location.logo', 'Location.short_address', 'Location.name', 'Location.sector_slug', 'Location.url'));
		$this->set('location', $location);

		if ($this->request->is('post')) {			// success
			$data = $this->request->data;
			$data['DeliveryAddress']['user_id'] = $this->Auth->user('id');
			$this->DeliveryAddress->create();

			if ($this->DeliveryAddress->save($data)) {		 // success normal
				$this->Session->setFlash(__('The delivery address has been saved'), 'default', array('class' => 'flash_success'));

				// Set new address as current addres in session
				$this->_updateSessionDeliveryAddress($data, $this->DeliveryAddress->getLastInsertID());

				// Redirect to appropriate success page
				$this->redirect(array('controller' => 'orders', 'action' => 'checkout'));
			} else {				  // validation and save failed
				$this->Session->setFlash(__('The delivery address could not be saved. Please, try again.'));
			}
		}
	}
	
	public function confirm_billing_address($id = null){
		
		// Make sure there's a billing address in the session
		if (!$this->Session->check('BillingAddress.address')) {
			$da = $this->DeliveryAddress->findById($id);
			$this->Session->write('BillingAddress', $da['DeliveryAddress']);
		}
		
		if ($this->request->is('post')) {			// success
			$data = $this->request->data;
			$data['DeliveryAddress']['user_id'] = $this->Auth->user('id');
			$this->DeliveryAddress->create();

			if ($this->DeliveryAddress->save($data)) {		 // success normal
				$this->Session->setFlash(__('The billing address has been change'), 'default', array('class' => 'flash_success'));

				// Set new address as current addres in session
				$this->Session->write('BillingAddress', $data['DeliveryAddress']);

				// Redirect to appropriate success page
				$this->redirect(array('controller' => 'payments', 'action' => 'billing_info'));
			} else {				  // validation and save failed
				$this->Session->setFlash(__('The billing  address could not be change. Please, try again.'));
			}
		}
	}
	public function same_as_delivery($id){
		
		// Make sure there's a billing address in the session		
        $this->Session->write('BillingAddress', $this->Session->read('DeliveryDestination'));		
        $this->redirect(array('controller' => 'payments', 'action' => 'billing_info'));
	}
    
    /**
     * Check if the user as already a delivery address in session.
     * <ul>
     * <li>if the user as one and it's the view outputs '1'</li>
     * <li>if the user does not have an address or it is not valid for this restaurant send the html to incorporate
     * into the modal box that will appear</li>
     * </ul>
     */
    public function check_user_has_delivery_address($locationId = NULL){
                
        $this->layout = 'ajax';
        if($this->Session->check('DeliveryDestination.postal_code')){
            $pc = $this->Session->read('DeliveryDestination.postal_code');
            $validArea =  $this->DeliveryArea->deliversThereAndCharges($locationId, $pc);
            if($validArea == FALSE && !is_numeric($validArea)){
                $this->set('show', TRUE);
                $this->set('reason', 'outside');    // Show's a message saying the restaurant does not deliver to this area                
            }else{
                $this->set('show', FALSE);
            }
            
        }else{
            $this->set('show', TRUE);
            $this->set('reason', 'empty');          // Show's a message asking the user to enter is postal code
        }
        
    }
    
    public function add_postal_code($input) {
        $this->layout = 'ajax';
        $postal_code  = strtoupper(urldecode($input));
        $this->set('output', '');

        // Validate input
        if (preg_match(Configure::read('regex.postal_code_3to7_char'), $postal_code)) {
            $validArea =  $this->DeliveryArea->deliversThereAndCharges($this->Session->read('Location.id'), $postal_code);
            
            // User out of range of restaurant
            if($validArea == FALSE && !is_numeric($validArea)){
                $this->set('output', __('This restaurant does not deliver to this postal code: %s', $postal_code));
            }else{
                $this->Session->write('DeliveryDestination.postal_code', $postal_code);
            }
            
            $this->Session->write('DeliveryDestination.postal_code', $postal_code);
        } elseif (empty($input) || $input === '0') {

            // Set order type to pickup
            $this->Session->write('DeliveryDestination.postal_code', 'pickup');            
            try {
                $this->OrderSession->validateEdit($this->Session->read('Location.id'));
            } catch (ValidationException $e) {
                $this->Session->setFlash($e->getMessage());
            }
            $this->Session->write('Order.Order.type', 'pickup');
        } else {
            
            // Invalid postal code
            $this->set('output', __('"%s" is not a valid postal code', strtoupper($postal_code)));
        }
    }

    public function change_delivery_address(){
		$this->layout = 'ajax';
		$this->loadModel('DeliveryAddress');
		$this->OrderSession = $this->Components->load('OrderSession');
		$this->OrderSession->initialize($this);

		$address = $this->DeliveryAddress->find('first', array(
	        'conditions' => array('DeliveryAddress.name' => $this->request->data['DeliveryAddress']['delivery_address'])
	    ));
	    unset($address['DeliveryAddress']['user_id']);
	    $address = $address['DeliveryAddress'];

	    // Choose one for the user
		$this->Session->write('DeliveryDestination', $address);
		$this->Cookie->write('postal_code', $address['postal_code'], FALSE, '1 Year', '/', FALSE, FALSE); // add object to session
		$this->OrderSession->copyDeliveryAddressInOrder();

		// Use this address as the billing address
		if (!$this->Session->check('BillingAddress.id')) {
			$this->Session->write('BillingAddress', $address);
		}

		$this->set('deliveryAddress', $address);
		
	}

	public function change_billing_address(){
		$this->layout = 'ajax';
		$this->loadModel('DeliveryAddress');
		$address = $this->DeliveryAddress->find('first', array(
	        'conditions' => array('DeliveryAddress.name' => $this->request->data['DeliveryAddress']['billing_address'])
	    ));
	    unset($address['DeliveryAddress']['user_id']);
	    $address = $address['DeliveryAddress'];

	    // Choose one for the user
		$this->Session->write('BillingAddress', $address);

		$this->set('billingAddress', $address);
	}

}
