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

/**
 * MenuItems Controller
 *
 * @property MenuItem $MenuItem
 * @property PaginatorComponent $Paginator
 */
class MenuItemsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'RequestHandler', 'Image', 'UploadValidation', 'OrderSession');

    public $helpers = array('Image');
	
    public function beforeFilter() {		
        parent::beforeFilter();

        // Disable validation
		switch ($this->request->action) {
            case 'add_to_order':				
            case 'remove_item':				
            case 'remove_item':
                $this->Security->validatePost = false;
                break;
        }		
				
        // Auth
        $this->Auth->allow(
            'menu_item_modal',
			'options_modal',
			'empty_cart',
			'remove_item',
			'add_to_order',
			'show_image'
        );

        $this->Security->unlockedActions = array(
            'add_to_order',
            'remove_item',
            'empty_cart'
        );
    }
	
	public function afterFilter() {		
        parent::afterFilter();
		switch ($this->request->action) {
            case 'add_to_order':
				Configure::write('debug', $this->debugLevel);			// warning and notice where preventing redirection
				break;
        }		
			
	}

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add($location_id, $menu_id, $menu_category_id) {
        if ($this->request->is('post')) {
            $this->MenuItem->create();
            $this->request->data['MenuItem']['menu_category_id'] = $menu_category_id;
            $this->request->data['MenuItem']['menu_id'] = $menu_id;

            $this->Image->process('image',  array('514x514'));

            $save = $this->UploadValidation->validate();


            $this->MenuItem->attachTree($menu_category_id);
            if ($save && $this->MenuItem->save($this->request->data)) {
                if (isset($this->request->data['MenuItem']['image'])) {
                    $this->Image->finishCreate(
                        $this->request->data['MenuItem']['image'], $this->MenuItem->getLastInsertID()
                    );
                }
                $this->Session->setFlash(__('The menu item has been saved'), 'default', array('class' => 'flash_success'));
                return $this->redirect(array(
                    'controller' => 'menus',
                    'action' => 'view',
                    $location_id,
                    $menu_id,
                    '#' => $menu_category_id
                ));
            } else {
                $this->Session->setFlash(__('The menu item could not be saved. Please, try again.'));
                $this->Image->delete('image');
            }
        }
        $this->set('menuItemOptions', $this->MenuItem->MenuItemOption->find('list', array(
            'conditions' => array(
                'MenuItemOption.menu_category_id' => $menu_category_id
            ),
            'fields' => array('MenuItemOption.id', 'MenuItemOption.description'))));
        $this->set(compact('location_id', 'menu_id'));
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($location_id, $menu_id, $menu_category_id, $id = null) {
        if (!$this->MenuItem->exists($id)) {
            throw new NotFoundException(__('Invalid menu item'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->MenuItem->attachTree($this->request->data['MenuItem']['menu_category_id']);

            $this->Image->process('image', array('514x514'));

            $save = $this->UploadValidation->validate();

            if ($this->request->data['MenuItem']['menu_category_id'] != $menu_category_id) {
                $menu_category_id = $this->request->data['MenuItem']['menu_category_id'];
                $last_entry = $this->MenuItem->find('first', array(
                    'conditions' => array(
                        'MenuItem.menu_category_id' => $menu_category_id
                    ),
                    'fields' => array(
                        'MenuItem.lft',
                        'MenuItem.rght'
                    ),
                    'order' => array('MenuItem.lft' => 'DESC')
                ));
                if (!$last_entry) {
                    $this->request->data['MenuItem']['lft']  = 0;
                    $this->request->data['MenuItem']['rght'] = 0;
                } else {
                    $this->request->data['MenuItem']['lft']  = $last_entry['MenuItem']['rght'] + 1;
                    $this->request->data['MenuItem']['rght'] = $this->request->data['MenuItem']['lft'] + 1;
                }
            }

            if ($save && $this->MenuItem->saveAll($this->request->data)) {
                $this->Session->setFlash(__('The menu item has been saved'), 'default', array('class' => 'flash_success'));
                return $this->redirect(array(
                    'controller' => 'menus',
                    'action' => 'view',
                    $location_id,
                    $menu_id,
                    '#' => $menu_category_id
                ));
            } else {
                $this->Session->setFlash(__('The menu item could not be saved. Please, try again.'));
            }
        } else {
            $options = array(
                'conditions' => array('MenuItem.' . $this->MenuItem->primaryKey => $id),
                'recursive' => 1,
                'contain' => array(
                    'MenuItemOption'
                )
            );
            $this->request->data = $this->MenuItem->find('first', $options);
        }
        $this->set('menuItemOptions', $this->MenuItem->MenuItemOption->find('list', array(
            'conditions' => array(
                'MenuItemOption.menu_category_id' => $menu_category_id
            ),
            'fields' => array('MenuItemOption.id', 'MenuItemOption.description')
        )));
        $this->set('menuCategories', $this->MenuItem->MenuCategory->find('list', array(
            'conditions' => array(
                'MenuCategory.menu_id' => $menu_id
            )
        )));
        $this->set(compact('location_id', 'menu_id', 'menu_category_id'));
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($location_id, $menu_id, $menu_category_id, $id = null) {
        $this->MenuItem->id = $id;
        if (!$this->MenuItem->exists()) {
            throw new NotFoundException(__('Invalid menu item'));
        }
        $this->request->onlyAllow('post', 'delete');
        $this->MenuItem->attachTree($menu_category_id);
        if ($this->MenuItem->delete()) {
            $this->Session->setFlash(__('Menu item deleted'), 'default', array('class' => 'flash_success'));
            return $this->redirect(array(
                'controller' => 'menus',
                'action' => 'view',
                $location_id,
                $menu_id,
				'#' => $menu_category_id
            ));
        }
        $this->Session->setFlash(__('Menu item was not deleted'));
        return $this->redirect(array(
            'controller' => 'menus',
            'action' => 'view',
            $location_id,
            $menu_id
        ));
    }

    public function admin_move_up($location_id, $menu_id, $menu_category_id, $id = null, $delta = 1) {
        $this->MenuItem->attachTree($menu_category_id);
        $this->MenuItem->id = $id;
        if ($this->MenuItem->moveUp($this->MenuItem->id, abs($delta))) {
            $this->Session->setFlash(__('The item has been moved up!'), 'default', array('class' => 'flash_success'));
            $this->redirect(array(
                'controller' => 'menus',
                'action' => 'view',
                $location_id,
                $menu_id,
                '#' => $menu_category_id
            ));
        }
        $this->Session->setFlash(__('I can\'t move the Item any higher than that!'));
        $this->redirect(array(
            'controller' => 'menus',
            'action' => 'view',
            $location_id,
            $menu_id,
            '#' => $menu_category_id
        ));
    }

    public function admin_move_down($location_id, $menu_id, $menu_category_id, $id = null, $delta = 1) {
        $this->MenuItem->attachTree($menu_category_id);
        $this->MenuItem->id = $id;
        if ($this->MenuItem->moveDown($this->MenuItem->id, abs($delta))) {
            $this->Session->setFlash(__('The item has been moved down!'), 'default', array('class' => 'flash_success'));
            $this->redirect(array(
                'controller' => 'menus',
                'action' => 'view',
                $location_id,
                $menu_id,
                '#' => $menu_category_id
            ));
        }
        $this->Session->setFlash(__('I can\'t move the Item any lower than that!'));
        $this->redirect(array(
            'controller' => 'menus',
            'action' => 'view',
            $location_id,
            $menu_id,
            '#' => $menu_category_id
        ));
    }

    public function menu_item_modal($id) {

        // fetch Menu item
        $item = $this->MenuItem->find('first', 
            array(
                'conditions' => array('MenuItem.id' => $id),
                'fields' => array('MenuItem.name', 'MenuItem.description', 'MenuItem.price', 'MenuItem.image' )));

        $this->set('item', $item['MenuItem']);  // set item in modal popup
        $this->set('id', $id);                  // send item id to view

        $this->render(DS . 'Elements' . DS . 'menu_item_modal');
    }

    /**
     * Adds an item and all it's options to the session's "Order" variable<br/>
	 * This function also validates that the request data is valid since "$this->Security->validatePost"
	 * is set to false for this action.
     *
     * @param string $locationId UUID of the current location
     */
    public function add_to_order() {
		
        $this->autoRender = false;

            
        $data = $this->request->data;

		$this->loadModel('Location');
		$this->loadModel('Order');
		$this->loadModel('Menu');
		$this->loadModel('MenuItemOption');
		$this->loadModel('MenuItemOptionValue');
		$this->loadModel('Schedule');
				
		$locationId = $this->MenuItem->getLocationId($data['MenuItem']['id']);		// get location id from item
		$categoryId = $this->MenuItem->findById($data['MenuItem']['id']);
        $userId = $this->Auth->user('id');  // get current logged in user
		
		// UPDATE AND VALIDATE ORDER
		try {
			// validate that we can edit the session order variable
			$proceed = $this->OrderSession->validateEdit($locationId, $userId);

			// Validate this menu_item
			$this->set('data1', $data);
			$menuItemArray = $this->Order->validateOrderDetail($data, $locationId, $categoryId['MenuItem']['name']);
			$OrderOrderDetail = $this->Session->read('Order.OrderDetail');			// copy session to array to insert it data
			$OrderOrderDetail[] = $menuItemArray;									// add the new orderDetails to the current array
			$this->Session->write('Order.OrderDetail', $OrderOrderDetail);			// write data to session
			
			// Update and validate full order
			$update = $this->Order->updateCurrent($this->Session->read('Order'));	// calculate totals and validate 
			$this->Session->write('Order', $update);								// update session
			
			// Confirmation message in order side bar
			$this->set('setFlashMessage', __('Item added'));
			$this->set('setFlashLevel', 'success');

			// Update the order destination address with the the "DestinationAddress" variable in the session
			$this->OrderSession->copyDeliveryAddressInOrder();
			
		} catch (ValidationException $e) {
			$this->Session->setFlash($e->getMessage());
		}					
				
        // GO BACK TO RESTAURANT PAGE
		
        // $this->redirect($this->optionModalRedirectPage($categoryId['MenuItem']['menu_category_id'], NULL, $data['MenuItem']['id']));

        // render cart element
        $this->layout = 'ajax';
        $this->render('/Elements/cart');
	}
		
	/**
	 * Call the modal window form to choose the options available for the given item
	 * 
	 * @param string $itemId Item's UUID
	 */
	public function options_modal($itemId){
		
		$this->loadModel('MenuItemOption');
		$this->loadModel('Schedule');				
		
		// get items info and it's options		
		$this->MenuItem->recursive = 2;
		$this->MenuItem->unbindModel(array('hasMany' => array('OrderDetail')));
		$items = $this->MenuItem->find('first', array(
			'conditions' => array('MenuItem.id' => $itemId),
			'fields' => array(
				'MenuItem.id', 
				'MenuItem.name', 
				'MenuItem.name_en',			// for google tags
				'MenuItem.description', 
				'MenuItem.price', 
				'MenuItem.number_of_instance',
				'MenuItem.image',
				'MenuCategory.name_en',		// for google tags
				'Menu.location_id')));		
			
        // redirect to location page on after submit or cancelation
		$categoryId = $this->MenuItem->findById($itemId);
        $this->set('redirectPage', $this->optionModalRedirectPage($categoryId['MenuItem']['menu_category_id'], NULL, $items['MenuItem']['id']));

		// get section that needs to be displayed
		$hasRequired = false;
		$hasFree = false;
		$hasMultiselect = false;
		foreach ($items['MenuItemOption'] as $mio) {
			if ($mio['multiselect'] === true){
				$hasMultiselect = true;
			}
			if ($mio['required'] === true){
				$hasRequired = true;
			}							
			if ($mio['number_of_free_values'] > 0){
				$hasFree = true;
			}							
		}		
		
		// Enable the addition
		$isAcceptingOrders = ($this->Schedule->isOpenForDelivery($items['Menu']['location_id'], NULL, NULL, TRUE))? '': 'disabled';
		
		$this->set('itemOptions', $items);
		$this->set('hasRequired', $hasRequired );
		$this->set('hasFree', $hasFree);
		$this->set('hasMultiselect', $hasMultiselect);
		$this->set('isAcceptingOrders', $isAcceptingOrders);

        if($this->is_mobile){
            $this->layout = 'mobile_modal';
        }
	}
	
	/**
	 * Display the image of the given item
	 * @param type $itemId
	 */
	public function show_image($itemId){
		
		$item = $this->MenuItem->findById($itemId);
		
		$this->set('imageId', $item['MenuItem']['image']);
		$this->set('itemName', $item['MenuItem']['name']);
	}
	
	/**
	 * Destroys the session the "Order" variables in the session and refreshes the "Order summary" sidebar
	 */
	public function empty_cart($locationId){
		
        $this->autoRender = false;
		// Delete order
		$this->OrderSession->clearOrder();
		
		// Breadcrumbs		
		$this->Breadcrumbs = $this->Components->load('BreadCrumbs');
		$this->Breadcrumbs->delete('Checkout');		
			
		// render cart element
        $this->layout = 'ajax';
        $this->render('/Elements/cart');
	}
	
	/*
	 * Remove the selected menu_item form the session and refresh the summary sidebar
	 * 
	 */
	public function remove_item($orderDetailIndex){
		
		
        $this->autoRender = false;
		
		try {
			$proceed = $this->OrderSession->validateEdit($this->Session->read('Order.Order.location_id'));
			$this->loadModel('Order');
			$this->Session->write('Order.OrderDetail.' . $orderDetailIndex . '.quantity', '0');	// set qty to 0 and Order->updateCurrent will delete it.
			$update = $this->Order->updateCurrent($this->Session->read('Order')); // recalculate order
			$this->Session->write('Order', $update);		// updatte session
		} catch (ValidationException $e) {

			// Error message in order side bar
			$this->Session->setFlash($e->getMessage(), 'flash_danger');			
		}
		
		// render cart element
        $this->layout = 'ajax';
        $this->render('/Elements/cart');
	}

    /**
     * Gives the locations page that called the option form
     *
     * @return array/string Cakephp style url
     */
    private function optionModalRedirectPage($menu_category_id, $modalId = NULL, $itemId){
				
		if ($modalId !== NULL){
			
			// Reopen previous modal because of validation errors in the form submission
			 $redirectPage = array(
                'controller' => 'locations',
                'action' => 'view',
                'location' => $this->Session->read('Breadcrumbs.Location.Parameter.location'),
				'sector' => $this->Session->read('Breadcrumbs.Location.Parameter.sector'),
				);				
		} else {	
			
			// Go back to the current restaurant's page
			$redirectPage = array(
                'controller' => 'locations',
                'action' => 'view',
                'location' => $this->Session->read('Breadcrumbs.Location.Parameter.location'),
				'sector' => $this->Session->read('Breadcrumbs.Location.Parameter.sector'),
				'#' => $menu_category_id);
		}
			
        return $redirectPage;
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
