
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
 * @version       2
 *                                                                   
 */
App::uses('AppController', 'Controller');
App::uses('CakeNumber', 'Utility');

/**
 * Locations Controller
 *
 * @property Location $Location
 * @property PaginatorComponent $Paginator
 */
class LocationsController extends AppController {

	public $uses = array('Location', 'Sector', 'Cuisine', 'Schedule');

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components	 = array('Paginator', 'Image', 'PDFMenu', 'UploadValidation', 'RequestHandler', 'OrderSession', 'Cookie');
	public $helpers		 = array('Image', 'PDF', 'Schedule');

	public function beforeFilter() {
		switch ($this->request->action) {
			case 'admin_add':
			case 'admin_edit':
			case 'search':
				$this->Security->validatePost	 = false;
				$this->Security->csrfCheck		 = false;
				break;
		}

		parent::beforeFilter();
		$this->Auth->allow(
			'by_cuisine', 'view', 'search', 'info', 'set_order_type', 'delete_order_confirmation', 'invalid', 'add_postal_code'
		);
	}

	public function afterFilter() {
		switch ($this->request->action) {
			case 'search':
				$this->Session->delete('newRegistration'); // delete this variable that should only be in the session after the user as registered
		}
	}

	/**
	 *  Search restaurants
	*/
	public function search() {
		// if postal code has been inserted in form. Get all restaurants that deliver in the postal code
		if ($this->request->data) {
			$this->redirect(
				Router::url(
                    [
                        'controller' => 'locations',
                        'action' => 'search',
                        'language' => $this->langSuffix,
                        'pc' => $this->request->data['Location']['postal_code1']
                    ]
                )
			);
		}
		// if no parameter is passed, thow a 404 error
		elseif(!($this->params['pc'] || $this->params['nh'])){
			throw new NotFoundException("Invalid Postal Code");
		}
		// if postal code is passed. Get all restaurants that deliver in the postal code
		elseif($this->params['pc']){
			$postal_code = strtoupper($this->params['pc']);
			$this->set('query', $postal_code);
			$this->_getAndOutputSearchResult($postal_code);
			$this->set('title_for_layout', $postal_code);
			$this->insertPostalCodeInSession($this->params['pc']);
		}
		// if Neighborhood is passed. Get all restaurants that deliver in the Neighborhood
		elseif($this->params['nh']){
			$area = $this->params['nh'];
			$sector					 = $this->Sector->findByUrl($area);								   // get the sector record from the by using the sector name provided by a URL parameter			
			$sectorPostalCodeList	 = str_replace(",", "','", $sector['Sector']['code']);
			$this->_getAndOutputSearchResult($sectorPostalCodeList);									// Get locations and cuisine types
			$this->set('query', $sector['Sector']['name']);	   // Output div header text                
			$this->insertPostalCodeInSession(substr($sector['Sector']['code'], 0, 3));	
		}
		$this->loadModel('Order');
		$this->set('ccAllowedTag', $this->Order->isClientSupportWorkingNow());
	}
	/**
	 * admin_index method
	 *
	 * @return void
	 */
	public function admin_index() {

		$query = null;
		if ($this->request->is('post')) {
			if (isset($this->request->data['Query']['search'])) {
				$this->Session->write('location.query', $this->request->data['Query']['search']);
			}
		}
		if ($this->Session->read('location.query')) {
			$query									 = $this->Session->read('location.query');
			$this->request->data['Query']['search']	 = $query;
		}
		$query		 = str_ireplace(' ', '%', $query);
		$conditions	 = array(
			'OR' => array(
				'Location.name LIKE' => '%' . $query . '%'
			)
		);

		$this->Paginator->settings = array(
			'conditions' => $conditions,
			'recursive'	 => 0
		);

		$this->set('locations', $this->Paginator->paginate());
	}

	/**
	 * admin_view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id) {
		if (!$this->Location->exists($id)) {
			throw new NotFoundException(__('Invalid location'));
		}
		$options = array(
			'conditions' => array('Location.' . $this->Location->primaryKey => $id),
			'recursive'	 => 1
		);
		$this->set('location', $this->Location->find('first', $options));
	}

	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$save = false;
			$this->Location->create();

			// Process uploaded images
			$this->PDFMenu->process('pdf_menu');
			$this->Image->process('logo');


			// Run validation on current model, and merge image validation back in
			// this function will return false if there are errors, allowing us to
			// stop the save.
			$save = $this->UploadValidation->validate();


			if ($save && $this->Location->saveAll($this->request->data)) {

				// Everything went well, the data has been saved.
				$this->Session->setFlash(
					__('The location has been saved'),
					'flash_success'
				);

				// Our save was a success, we have an insert ID, lets
				// tell the file registry about it.
				if (isset($this->request->data['Location']['logo'])) {
					$this->Image->finishCreate(
						$this->request->data['Location']['logo'], $this->Location->getLastInsertID()
					);
				}
				if (isset($this->request->data['Location']['pdf_menu'])) {
					$this->PDFMenu->finishCreate(
						$this->request->data['Location']['pdf_menu'], $this->Location->getLastInsertID()
					);
				}
				return $this->redirect(array(
						'action' => 'view',
						$this->Location->getLastInsertID()
				));
			} else {
				// Something went wrong!
				$this->Session->setFlash(__('The location could not be saved. Please, try again.'), 'flash_danger');

				// Because this is an add function, and there wasn't an ID set in $thid->Location->id
				// we need to delete the files we created, otherwise we'll lose track of their UUIDs.
				// We don't have a choice, browsers don't keep uploaded file values in the form element
				// so we are forced to ask them to input the file again.
				$this->PDFMenu->delete('pdf_menu');
				$this->Image->delete('logo');
			}
		}

		$sectors	 = $this->Location->Sector->find('list', array('fields' => array('Sector.url', 'Sector.name_with_codes')));
		$cuisines	 = $this->Location->Cuisine->find('list');
		$features	 = $this->Location->Feature->find('list');
		$specialties = $this->Location->Specialty->find('list');
		$this->set(compact('sectors', 'cuisines', 'features', 'users', 'specialties'));
	}

	/**
	 * admin_edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id) {
		// Very important to set or file processing wont' work.
		$this->Location->id = $id;
		if (!$this->Location->exists()) {
			throw new NotFoundException(__('Invalid location'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$save = false;

			// Process uploaded images
			$this->Image->process('logo');
			$this->PDFMenu->process('pdf_menu');

			// Run validation on current model, and merge image validation back in
			// this function will return false if there are errors, allowing us to
			// stop the save.
			$save = $this->UploadValidation->validate();

			if ($save && $this->Location->save($this->request->data)) {
				$this->Session->setFlash(__('The location has been saved'), 'flash_success');
				return $this->redirect(array(
						'action' => 'view',
						$id
				));
			} else {
				// Something went wrong!
				$this->Session->setFlash(__('The location could not be saved. Please, try again.'), 'flash_danger');

				// Because we are just editing a record, we'll save any files we can (ones that pass validation)
				// for the convenience of the user. That way when they come back to the form with errors
				// displayed, the file has already been uploaded and processed, and the record updated.
			}
		} else {
			$options			 = array(
				'conditions' => array('Location.' . $this->Location->primaryKey => $id),
				'contain'	 => array(
					'Cuisine',
					'Sector',
					'Feature',
					'Specialty'
				),
				'recursive'	 => 1,
			);
			$this->request->data = $this->Location->find('first', $options);
		}
		$sectors	 = $this->Location->Sector->find('list', array('fields' => array('Sector.url', 'Sector.name_with_codes')));
		$cuisines	 = $this->Location->Cuisine->find('list');
		$features	 = $this->Location->Feature->find('list');
		$specialties = $this->Location->Specialty->find('list');
		$this->set(compact('sectors', 'cuisines', 'features', 'users', 'specialties'));
	}

	/**
	 * admin_delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id) {
		$this->Location->id = $id;
		if (!$this->Location->exists()) {
			throw new NotFoundException(__('Invalid location'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Location->delete()) {
			$this->Session->setFlash(__('Location deleted'), 'flash_success');
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Location was not deleted'), 'flash_danger');
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * Display detailed informatino of a location
	 * 
	 * @param string $url location's url
	 */
	public function view($sector_slug = null, $url, $distance = null) {

		
		// Models        
		$this->loadModel('Order');
		$this->loadModel('Device');
		$this->loadModel('DeliveryArea');
		$this->loadModel('DeliveryAddress');
		$this->loadModel('MenuItem');
		$this->loadModel('Menu');
		$this->loadModel('MenuCategory');
		$this->loadModel('TipOption');

		// set the checkout boutton to enabled
		if ($this->Session->check('Order')) {
			$this->Session->write('enableCheckout', TRUE);
		}

		// Location
		$location = $this->Location->findForDisplayingDetailedView($url);   // location's info (adresse, schedule...)
		if (!$location) {
			$locationId = $this->Location->findByUrl($url);
			$this->redirect(array('controller' => 'locations', 'action' => 'invalid', $locationId['Location']['id'], urlencode($this->referer())));
		}

		// Set this location data in session 
		$this->Session->write('Location.url', Router::url(array(// URL
				'language'	 => $this->langSuffix,
				'controller' => 'locations',
				'action'	 => 'view',
				'location'	 => $location['Location']['url'],
				'sector'	 => $location['Location']['sector_slug'])));
		$this->Session->write('Location.id', $location['Location']['id']);  // ID
		$this->Session->write('Location.distance', $distance);				  // Distance
		// Get menu Id
		$menuId = $this->Menu->getActiveMenuForLocation($location['Location']['id'], $this->Auth->user('group_id'));

		// Set title
		$this->set('title_for_layout', $location['Location']['name']);

		// Order in session is compatible with this restaurant 
		if (!$this->OrderSession->locationIsCompatibleWithOrder($location['Location']['id'])) {
			$this->redirect(array('controller' => 'locations', 'action' => 'delete_order_confirmation', $url));
		}

		// Is this a online restaurant? //todo this should be a function	
		$online = $this->Device->getDeviceStatus($location['Location']['id']);
		if ($online) {		 // ONLINE
			$this->set('locationIsOnline', TRUE);
			$items = $this->MenuItem->getToDisplayAsMenu($menuId, $this->Auth->user('group_id'));
		} else {		  // OFFLINE DEVICE
			if (!empty($menuId)) {
				$items = $this->MenuItem->getToDisplayAsMenu($menuId, $this->Auth->user('group_id'));
				$this->Session->setFlash(__('The restaurant at this location is presently not accepting orders. Please try another locations or a different restaurant'), 'flash_danger');
			} else {		  // PDF MENU
				$items = array();
			}

			$this->Session->write('enableCheckout', FALSE);
			$this->set('locationIsOnline', FALSE); // write: restaurant is offline
			$this->set('deliveryCharge', __('No delivery presently'));
		}

		// Breadcrumbs		
		$this->Breadcrumbs = $this->Components->load('BreadCrumbs');
		$this->Breadcrumbs->add('Location', 'locations', 'view', $location['Location']['name'], array('location' => $location['Location']['url'], 'sector' => $location['Location']['sector_slug']));
		$this->set('activeBreadCrumb', $location['Location']['name']);

		// Set a delivery postal code //todo this should be a function	
		if (!$this->Session->check('DeliveryDestination.postal_code') && $this->Auth->loggedIn()) {
			$da = $this->DeliveryAddress->getLastAddedAddress($this->Auth->user('id'));
			$this->Session->write('DeliveryDestination', $da);
			$this->Cookie->write('postal_code', $da['postal_code'], FALSE, '1 Year', '/', FALSE, FALSE); // add object to session
		}


		// DELIVERY/PICKUP STUFF

		$typeIsDelivery = TRUE;
		//todo this should be a function	
		if ($this->Session->check('Order')) {
			if ($this->Session->read('Order.Order.type') === 'pickup') {
				$typeIsDelivery = FALSE;
			}
		} elseif ($this->Session->check('Search')) {
			if ($this->Session->read('Search.type') === 'pickup') {
				$typeIsDelivery = FALSE;
			}
		}

		// META TAGS
		// postal code for meta tag
		//TODO refractor into it's own function
		$metaDeliveryAreasArray	 = $this->DeliveryArea->findAllByLocationId($location['Location']['id'], array('postal_code'));
		$metaDeliveryAreas		 = '';
		foreach ($metaDeliveryAreasArray as $mdaa) {
			$metaDeliveryAreas .= strtoupper($mdaa['DeliveryArea']['postal_code']) . ', ';
		}
		$metaDeliveryAreas = substr($metaDeliveryAreas, 0, strlen($metaDeliveryAreas) - 2);

		$this->set('metaDeliveryAreas', $metaDeliveryAreas);

		// Get the price charged by the restaurant to deliver to the destination postal code	//todo this should be a function		
		$destinationPostalCode	 = strtoupper($this->Session->read('DeliveryDestination.postal_code'));
		$deliveryCharge			 = $this->DeliveryArea->deliversThereAndCharges($location['Location']['id'], $destinationPostalCode);

		if ($typeIsDelivery) {
			if (!empty($destinationPostalCode)) {

				if ($deliveryCharge === FALSE) {
					$this->Session->setFlash(__('This Restaurant does not deliver in %s. You can change your address at the checkout.', $destinationPostalCode), 'flash_danger');
					$this->set('minOrder', __('This Restaurant does not deliver in %s', $destinationPostalCode));
					$this->set('deliveryCharge', __('This Restaurant does not deliver in %s', $destinationPostalCode));
				} else {
					$this->set('deliveryCharge', $deliveryCharge['delivery_charge']);
					$this->set('minOrder', $deliveryCharge['delivery_min']);
				}
			} else {
				$this->set('deliveryCharge', __('Your postal code is required.'));
				$this->set('minOrder', __('Your postal code is required.'));
			}

			// check if min order is achieve
			if ($this->Session->check('Order')) {
				$minReq = $this->Order->checkOrdersMinimalValue($this->Session->read('Order.Order'), FALSE, $destinationPostalCode); // get the delivery charges and min required
				if ($minReq['delivers'] !== TRUE) {
					$this->Session->setFlash($minReq['delivers'], 'sidebarFlash', array(), 'sidebar');
					$this->set('enablePayment', 'disabled');
					$this->set('minOrder', $deliveryCharge['delivery_min']);
				} else {
					$this->set('minOrder', $deliveryCharge['delivery_min']);
				}
			}
			$this->set('delType', 'delivery');
		} else {
			$this->set('deliveryCharge', $location['Location']['delivery_message']);
			$this->set('delType', 'pickup');
		}



		// Check if items in order are empty //todo this should be a function	
		if ($this->Session->check('Order.OrderDetail')) {
			$od = $this->Session->read('Order.OrderDetail');
			if (empty($od)) {
				$this->Session->write('enableCheckout', FALSE);
			}
		} else {
			$this->Session->write('enableCheckout', FALSE);
		}

		// SEO stuff
//		$this->_populateSeoData();

		$categories			 = $this->MenuCategory->findActiveByMenuId($menuId);
		$locationSchedule	 = $this->Schedule->scheduleOfDay($location['Location']['id'], date('w'));
		$delivery			 = $this->Schedule->isOpenForDelivery($location['Location']['id']);

		if ($this->request->is('ajax')) {

			$fullSchedule = $this->_getFullSchedule($location['Location']['id']);

			$returnAjax = array(
				'categories' => $categories,
				'location'	 => $location['Location'],
				'schedule'	 => $fullSchedule,
				'items'		 => $items,
				'delivery'	 => $delivery
			);

			$jsonMenu		 = json_encode($returnAjax, JSON_PRETTY_PRINT);
			$this->layout	 = "ajax";
			$this->set(
				array(
					'jsonMenu'	 => $jsonMenu,
					'_serialize' => array('jsonMenu')
				)
			);

			$this->render('view_ajax');
		} else {

			// location's data
			$this->set('isPdfLocation', empty($menuId));
			$this->set('isDelivering', $delivery);
			$this->set('schedule', $locationSchedule);
			$this->set('location', $location);	 // location's info (adresse, schedule...)
			$this->set('items', $items);	  // all the menu items for this menu
			$this->set('categories', $categories);	  // all the categories for this menu
			$this->set('tipOptions', $this->TipOption->getTipOptions($location['Location']['id'])); // all the tip options for thismenu
		}

		// META TAGS //TODO put in controller
		$cuisineType = '';
			$cuisineTypeH2 = '';
	  		foreach ($location['Cuisine'] as $value) {
			$cuisineType = $cuisineType . ", " . $value['name'];
	 			$cuisineTypeH2 = $value['name'] . ', ' . $cuisineTypeH2;
	  		}
	 		$cuisineTypeH2 = substr($cuisineTypeH2, 0, strlen($cuisineTypeH2) - 2);

		$commonKeywords = __('Delivery, Topmenu, Restaurants, ') . $location['Location']['sector_slug'];

	 	$this->set('cuisineTypeH2', $cuisineTypeH2);
	}

	/**
	 * Function to get the full schedule for a week for a specific
	 *
	 * @author Pierre-Eric Chartrand
	 * @author Bogdan Dionisie Bajanica (re-implemented)
	 *
	 * @param $locationUrl the location URL (ex: le-roi-de-l-inde)
	 *
	 * @return array an array with 2 keys Location and Schedule
	 */
	protected function _getFullSchedule($locationUrl) {
		// Fields form the Location table
		$fields = array(
			'Location.building_number',
			'Location.street',
			'Location.postal_code',
			'Location.province',
			'Location.city',
			'Location.country',
			'Location.name',
			'Location.description'
		);

		// Get necessary data
		return $this->Location->find('first', array(
				'conditions' => array('Location.url' => $locationUrl),
				'contain'	 => array(
					'Location' => array()),
				'contain'	 => array(
					'Schedule' => array(
						'fields' => '*')),
				'fields'	 => $fields)
		);
	}

	/**
	 * Add's filters with there id, name and url to the session variables and returns a array of ids only
	 * 
	 * @param String $filter filter's name to add to the filter list
	 * @param String $tableName name of session variable to edit default is for legacy
	 * 
	 * @return array of ids (ids only)  - This array is identical to the sessino variable create
	 * @todo Refractor code to remove the default 'CuisineFilter'
	 * @deprecated replace by Elastic Search 
	 */
	protected function addFilter($filter, $tableName = 'Cuisine') {

		$tableName	 = strtolower($tableName);	// to lowercase
		$tableName	 = ucfirst($tableName);	   // first letter uppercase
		$sessionVar	 = $tableName . 'Filter';


		// get filter's id from name
		if ($tableName === 'Cuisine') {
			$this->loadModel('Cuisine');
			$table = $this->Cuisine->find('first', array(
				'conditions' => array($tableName . '.url =' => $filter),
				'fields'	 => array($tableName . '.id', $tableName . '.name', $tableName . '.url')));
		} elseif ($tableName === 'Sector') {
			$this->loadModel('Sector');
			$table = $this->Sector->find('first', array(
				'conditions' => array($tableName . '.url =' => $filter),
				'fields'	 => array($tableName . '.id', $tableName . '.title', $tableName . '.url')));
		}

		// add the id to the session
		$sessionArray = $this->Session->read($sessionVar);
		if (empty($sessionArray)) {
			$this->Session->write($sessionVar);		 // create the session variable
		}
		$data	 = $this->Session->read($sessionVar);	  // append the new filter
		$data[]	 = $table;
		$this->Session->write($sessionVar, $data);


		// make an array of ids
		$ids = array(); // array of ids only
		foreach ($table as $row) {
			$ids[] = $row['id'];
		}
		return $ids;
	}

	/**
	 * Remove's a filter type of the current list of filters and updates the corresponding session variable
	 *
	 * @param String $url url, from the tables url field, to be removed from the filter
	 * @param boolean $all True removes all the filters from the session and returns false
	 * @param String $tableName user for the session varaible name and to query the database default to Cuisine for legacy issues
	 * 
	 * @return array of cuisine ids of false if no or all filters where deleted
	 *
	 * @todo Refractor code to remove the default 'CuisineFilter'
	 * * @deprecated replace by Elastic Search 
	 */
	protected function removeFilter($url, $all = false, $tableName = 'Cuisine') {

		$tableName	 = strtolower($tableName);	// to lowercase
		$tableName	 = ucfirst($tableName);	   // first letter uppercase
		$sessionVar	 = $tableName . 'Filter';

		// Delete all filters from the session
		if ($all) {

			$this->Session->delete($sessionVar);
			return false;
		}


		// Check for matches for of the cuisineUrl in the session 
		$cfs = $this->Session->read($sessionVar);
		if (!empty($cfs)) {

			foreach ($cfs as $k => $cf) {

				if ($cf[$tableName]['url'] == $url) {
					unset($cfs[$k]);		   // delete this element
				}
			}

			// if theres no more filters then return false
			if (empty($cfs)) {
				$this->Session->delete($sessionVar);
				return false;
			}

			// return rest of the array and update the session
			else {
				$this->Session->write($sessionVar, $cfs);

				// return array of ids only

				$ids = array(); // array of ids only
				foreach ($cfs as $row) {
					$ids[] = $row['id'];
				}
				return $this->Session->read($sessionVar);
			}
		}
		return false;
	}

	/**
	 * Displays some information for the info tab in View/Location/view.ctp
	 * 
	 * @param string $locationUrl url use as pretty id to retrieve the location info
	 */
	public function info($locationUrl) {

		$schedule = $this->_getFullSchedule($locationUrl);

		// Get necessary data
		$this->set('locationInfo', $schedule);
	}

	/**
	 * Catches change of the Delivery/Take out radio button on the page and set the session's 'Order.Order.type' 
	 * variable accordingly
	 * @param string	$type			delivery or pickup
	 * @param string	$locationId		current location's ID
	 * @param mixe		$redirect		Cakephp url <br>
	 * 									<b>defaults to the referer</b>
	 * @todo move to OrdersController
	 * 
	 */
	public function set_order_type($type, $locationURL, $locationId, $redirect = NULL) {

		$this->loadModel('Order');

		if ($this->Session->check('Order.Order.location_id')) {
			$orderExist = TRUE;
		} else {
			$orderExist = FALSE;
		}

		$this->OrderSession->validateEdit($locationId);
		$this->Session->write('Order.Order.type', $type);

		try {
			if ($orderExist) {

				// Update and validate full order
				$update = $this->Order->updateCurrent($this->Session->read('Order')); // calculate totals and validate 
				$this->Session->write('Order', $update);  // update session
			}
		} catch (ValidationException $e) {
			$this->Session->setFlash($e->getMessage(), 'flash_danger');
		}

		if ($redirect === NULL) {
			$this->redirect($this->referer($locationId));
		}
		$this->redirect($redirect);
	}

	/**
	 * 
	 * @param string	$type	Search type (delivery, pickup or by name)
	 * @param string	$term	Search term (postal code or restaurant name)
	 * @return string			The full string to be use for the title the result section
	 */
	private function _niceSearchTitle($type, $term) {

		switch ($type) {
			case 'delivery':
			case 'pickup':
				$string	 = __('Restaurants delivering in: %s', $this->Sector->getSectorByPostal(strtoupper($term)));
				break;
			case 'byname':
				$string	 = __('Restaurants for: %s', $string['string']);
				break;
			default:
				$string	 = __('Search');
				break;
		}
		return $string;
	}

	public function delete_order_confirmation($url) {

		// set redirect page
		$original = $this->Location->find('first', array(
			'conditions' => array(
				'Location.id' => $this->Session->read('Order.Order.location_id')),
			'fields'	 => array('Location.url')));

		$this->set('originalRestaurant', $original['Location']['url']);
		$this->set('destinationPage', $url);

		// Post
		if ($this->request->is('post')) {

			// Continue to view and delete order?
			if (isset($this->request->data['yes'])) {
				$this->OrderSession->clearOrder();
				$this->redirect(array(
					'controller' => 'locations',
					'action'	 => 'view',
					'sector'	 => $this->Location->getLocationSectorSlugByUrl($url),
					'location'	 => $this->request->data['Location']['destinationPage']));
			} else {
				$this->redirect(array(
					'controller' => 'locations',
					'action'	 => 'view',
					'sector'	 => $this->Location->getLocationSectorSlugByUrl($url),
					'location'	 => $this->request->data['Location']['originalRestaurant']));
			}
		}
	}

	/**
	 * Inserts the query postal code in the session will avoiding deleting an address with matching postal code.<br/>
	 * If the address' postal code does not match the one fo the search query then the address is deleted and search postal code is inserted
	 * @param type $postalCode
	 */
	private function insertPostalCodeInSession($postalCode) {
		if ($this->Session->check('DeliveryDestination.postal_code')) {

			// Delivery Destination not empty
			$postalCode	 = strtoupper($postalCode);
			$sessionPc	 = strtoupper($this->Session->read('DeliveryDestination.postal_code'));

			if (substr($sessionPc, 0, 3) != $postalCode) {

				// Overwrite DeliveryDestination since it's different               
				$this->Session->delete('DeliveryDestination');
				if ($this->Auth->user()) {

					// User is log in, get is full delivery address
					$this->loadModel('DeliveryAddress');
					$da = $this->DeliveryAddress->getLastAddedAddress($this->Auth->user('id'), $postalCode);
				} else {
					$da = array('postal_code' => $postalCode);	  // for cookie
				}
			} else {
				$da = array('postal_code' => $postalCode);	  // for cookie
			}
		} else {
			$da = array('postal_code' => $postalCode);	  // for cookie
		}

		$this->Session->write('DeliveryDestination', $da);
		$this->Cookie->write('postal_code', $da['postal_code'], FALSE, '1 Year', '/', FALSE, FALSE); // add object to session
	}

	/**
	 * Catches invalid restaurant url and offer a search form instead
	 * @param type $invalid
	 */
	public function invalid($locationId = NULL) {

		$location = ($locationId === NULL) ? array() : $this->Location->findById($locationId);
		if (empty($location)) {
			$message = __('Sorry we could not find your page');
		} else {
			$message = $location['Location']['name'];
		}
		$this->response->statusCode(404);
		$this->set('title_for_layout', 'Restaurant not found - 404');
		$this->set('message', $message);
		$this->render('/Elements/404');
	}

	/**
	 * Set's some variable in the view for the google analytics tags
	 */
	public function _populateSeoData() {
		if (isset($_GET['tipAmount'])) {
			$tipAmount = number_format((float) $_GET['tipAmount'], 2, '.', '');
			$this->set('tipAmount', $tipAmount);
		}
		if (isset($_GET['itemId'])) {
			$this->MenuItem->recursive = 1;

			$seoItemData			 = $this->MenuItem->findById($_GET['itemId'], array('MenuItem.name_en', 'MenuCategory.name_en', 'MenuItem.image'));
			$seoItem['name_en']		 = $seoItemData['MenuItem']['name_en'];
			$seoItem['cat_name_en']	 = $seoItemData['MenuCategory']['name_en'];
			$seoOrderDetail			 = $this->Session->read('Order.OrderDetail');
			$seoItem['image']		 = empty($seoItemData['MenuItem']['name_en']) ? 'product without picture' : 'product with pictures';

			foreach ($seoOrderDetail as $k => $sod) {
				if ($sod['menu_item_id'] == $_GET['itemId']) {
					$seoItem['subtotal'] = $sod['subtotal'];
				}
			}
			$this->set('seoItem', $seoItem);
		}
	}

	/**
	 * Check if postal code search is in a online sector
	 * @return int boolean value reprenseted by 1 or 0 to match tinyint type in database
	 * @deprecated since version > 2.0.65
	 */
	private function _isInOlineSector($postalCode = NULL) {

		$postalCode = ($postalCode === NULL) ? $this->request->data['Location']['postal_code1'] : $postalCode;

		$isOnlineSector	 = array_search($postalCode, Configure::read('Topmenu.block_pdf_menus'));
		$isOnlineSector	 = is_integer($isOnlineSector);	  // array_search return int starting from 0 if something is found. So 0 is true
		$isOnlineSector	 = $isOnlineSector ? '1' : '0';	  // this will be use in sql query where boolean must be tiny ints

		return $isOnlineSector;
	}

	/**
	 * 
	 * @param array $results Array of result sets of location. 
	 * <br/>Typically it looks like this: 
	 * <pre>array($open_locations, $close_locations, $pdf_locations)</pre>
	 * 
	 * @return array list of all the unique cuisines types int the combine results sets
	 */
	private function _getCuisinesTypesInResults($results) {
		$cuisineTypes = array();

		// Merge arrays in $results
		foreach ($results as $result) {							 // iterate the arrays givent in $results
			foreach ($result as $location) {						// iterate all the locations in those arrays
				foreach ($location['Cuisine'] as $cuisine) {		// iterate all the cuisnes type of these locations
					$cuisineTypes[] = $cuisine['name_'.$this->langSuffix];			 // store the all those cuisines type into an array 
				}
			}
		}
		asort($cuisineTypes);
		return array_unique($cuisineTypes);

	}

	public function add_postal_code($input, $default, $locationId) {

		if (empty($input) || $input === '0') {

			$this->Session->write('DeliveryDestination.postal_code', $default); // Give a random but valid postal code to the user
			try {
				$this->OrderSession->validateEdit($locationId);
			} catch (ValidationException $e) {
				$this->Session->setFlash($e->getMessage(), 'flash_danger');
			}
			$this->Session->write('Order.Order.type', 'pickup');
		} else {
			$postal_code = urldecode($input);
			if (preg_match(Configure::read('regex.postal_code_3to7_char'), $postal_code)) {
				$this->Session->write('DeliveryDestination.postal_code', $postal_code);
			} else {
				$this->Session->setFlash(__("'$postal_code' is not a valid postal code"), 'flash_danger');
			}
		}

		$this->redirect($this->Session->read('Location.url'));
	}

	/**
	 * <ol>
	 * <li>Get all the location results and seperate them in tree groups: Open online restaurant, Closed online restaurants and PDF only restaurants.</li>
	 * <li>Get all the cuisine type offered by the set of locations</li>
	 * <li>Sends all those result set to the view</li>
	 * </ol>
	 * 
	 * @param mixe $postal_code String or array of the postal codes composing the area where the user is
	 * @param array $fields fields to include in the location results
	 * @param boolean $paginate Paginate or not the results
	 */
	private function _getAndOutputSearchResult($postal_code, $fields = null, $paginate = TRUE) {

		// Default fields 
		if ($fields === NULL) {
			$fields = array(
				'Location.name',
				'Location.id',
				'Location.url',
				'Location.sector_slug',
				'Location.logo',
				'Location.building_number',
				'Location.street',
				'Location.city',
				'Location.postal_code',
				'Location.latitude',
				'Location.rating',
				'Location.longitude',
				'Location.delivery_average_time',
				'Location.description_' . $this->langSuffix,
				'Location.online_ordering',
				'Location.old_pdf_only',
				'DeliveryArea.postal_code',
				'DeliveryArea.delivery_charge',
				'DeliveryArea.featured',
				'Menu.created'
			);
		}

		// Pagination
		if (!$paginate) {
			$page	 = $this->request->query('page');
			$page	 = (empty($page) ? 1 : $page);
			$this->set('page', $page);
		} else {
			$page = 0;
		}

		// get locations
		$open_locations	 = $this->Location->findRestaurantsByPostalCode($postal_code, $fields, true, true, $page);
		$close_locations = $this->Location->findRestaurantsByPostalCode($postal_code, $fields, true, false, $page);
		$pdf_locations	 = $this->Location->findRestaurantsByPostalCodePDF($postal_code, $fields, $page);

		// get all the cuisine type offered by the set of locations
		$cuisineTypes = $this->_getCuisinesTypesInResults(array($open_locations, $close_locations, $pdf_locations));

		// Send data to the view
		$this->set('open_locations', $open_locations);
		$this->set('close_locations', $close_locations);
		$this->set('pdf_locations', $pdf_locations);
		$this->set('cuisines', $cuisineTypes);
	}

}
