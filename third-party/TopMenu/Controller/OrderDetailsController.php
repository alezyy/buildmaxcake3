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

App::uses('AppController', 'Controller', 'Order', 'MenuItem');
/**
 * OrderDetails Controller
 *
 * @property OrderDetail $OrderDetail
 * @property PaginatorComponent $Paginator
 */
class OrderDetailsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->OrderDetail->recursive = 0;
		$this->set('orderDetails', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->OrderDetail->exists($id)) {
			throw new NotFoundException(__('Invalid order detail'));
		}
		$options = array('conditions' => array('OrderDetail.' . $this->OrderDetail->primaryKey => $id));
		$this->set('orderDetail', $this->OrderDetail->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->OrderDetail->create();
			if ($this->OrderDetail->save($this->request->data)) {
				$this->Session->setFlash(__('The order detail has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order detail could not be saved. Please, try again.'));
			}
		}
		$orders = $this->OrderDetail->Order->find('list');
		$menuItems = $this->OrderDetail->MenuItem->find('list');
		$this->set(compact('orders', 'menuItems'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->OrderDetail->exists($id)) {
			throw new NotFoundException(__('Invalid order detail'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->OrderDetail->save($this->request->data)) {
				$this->Session->setFlash(__('The order detail has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The order detail could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('OrderDetail.' . $this->OrderDetail->primaryKey => $id));
			$this->request->data = $this->OrderDetail->find('first', $options);
		}
		$orders = $this->OrderDetail->Order->find('list');
		$menuItems = $this->OrderDetail->MenuItem->find('list');
		$this->set(compact('orders', 'menuItems'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->OrderDetail->id = $id;
		if (!$this->OrderDetail->exists()) {
			throw new NotFoundException(__('Invalid order detail'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->OrderDetail->delete()) {
			$this->Session->setFlash(__('Order detail deleted'), 'default', array('class' => 'flash_success'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Order detail was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * Adds an item to the "OrderDetails" *(creates it if necessary) variable in the session and prepares information for the order in the
	 * "Order" variable (creates it if necessary)
	 *
	 * @param uuid $itemId Item's id
	 * @param int $quantity Quantity of items
	 * @param int $openedTime Time of
	 */
	public function add_item($itemId, $quantity, $locationId){



		$userId = $this->Auth->user('id');
		$isDelivery = $this->Session->check('isDelivery');


		// SOME VALIDATION

		// Right user
		if ($userId != $this->Session->read('Order.userId')){
			$this->render( DS .'Elements'. DS . 'shoppingcart_wrong_userid');   // output an error message instead
                                                                                // of a the order //TODO make this element
		}

		// If Delivery
		if($isDelivery){

			if ($this->Session->check('postalCode')) {
                $postalCode = $this->Session->read('postalCode');
                $this->loadModel('DeliveryArea');
//                $deliveryCharge = $this->DeliveryArea->deliversThereAndCharges($locationId, $postalCode);
			}
            // destination Postal code is required
            else {
				$this->render( DS .'Elements'. DS . 'shoppingcart_pc_required');	// output an error message instead
                                                                                    // of a the order //TODO make this an element
			}
		}


		// BUILD ORDER

		// Check if we need to create an order variable
		if ($this->Session->check('Order')){

			// Build Order
        $this->Order->declareOrderInSession($locationId, $userId, $postalCode, $isDelivery);
		}
		// check if the added item comes from the same location
		elseif(($locationId != $this->Session->read('Order.locationId'))){
                $this->render( DS .'Elements'. DS . 'shoppingcart_same_location');  // output an error message instead
                                                                                    // of a the order //TODO make this element
		}


		// UPDATE/CREATE ORDER

        $this->Order->updateCurrent($menuItems, $deliveryCharges, $locationId, $userId, $tip, $taxes);


        // update the order element (shoppingcart)
        $this->render(DS.'Elements' .DS. 'shoppingcart_summary');

	}

}
