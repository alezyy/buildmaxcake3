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

App::uses('AppModel', 'Model');
App::uses('CakeSession', 'Model/Datasource');
/**
 * DeviceOrder Model
 *
 * @property Order $Order
 * @property Location $Location
 */
class DeviceOrder extends AppModel {


/**
 * Behaviors
 * @var array
 */
	public $actsAs = array('GoodcomPrinter');
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
//		'order_id' => array(
//			'uuid' => array(
//				'rule' => array('uuid'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
		'location_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'order_string' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'order_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'location_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	/**
	 * Has Many Association
	 * @var array
	 */
	public $hasMany = array(
		'TransactionLog' => array(
			'className' => 'TransactionLog',
			'foreignKey' => 'order_id',
			'order' => 'TransactionLog.created DESC'
		)
	);


/**
 * Order Data
 * @var [type]
 */
protected $order_data = array(
		'location_id'          => '',
		'order_type'           => '',
		'order_id'             => '',
		'customer_type'        => '',
		'customer_name'        => '',
		'customer_address'     => '',
		'requested_for'        => '',
		'payment_status'       => 'Paid',
		'customer_phone'       => '',
		'comments'             => '',
		'delivery_charge'      => 0,
		'total'                => 0,
		'previous_order_count' => 0,
		'items'                => array(),
		'breakdown'            => array()
	);


	public function beforeSave($options = array()) {
		parent::beforeSave($options);
		if (
			isset($this->data['Order'])
			&& isset($this->data['OrderDetail'])
			&& isset($this->data['Location'])
		) {

			$location_language = 'fr'; // $this->Location->getLanguage($this->data['Location']['id']);
			$original_language = Configure::read('Config.language');

			Configure::write('Config.language', $location_language);
			CakeSession::write('Config.language', $location_language);

			$data = array();
			$data['DeviceOrder']['order_string'] = $this->generateOrderString();
			$data['DeviceOrder']['location_id']  = $this->data['Location']['id'];
			$data['DeviceOrder']['order_id']     = $this->data['Order']['id'];
			$data['DeviceOrder']['status']       = 'ready';
			$data['DeviceOrder']['created']		 = date('Y-m-d H:i:s');

			unset($this->data);
			$this->data = $data;

			Configure::write('Config.language', $original_language);
			CakeSession::write('Config.language', $original_language);
		}
		
	}

/**
 * Send a new order to it's device
 * @param   int   $id order id
 */
	public function sendOrder($order) {
		if ($order) {
			$this->create();
			$this->data = $order;						
			$this->save($this->data, false);
		}
	}

/**
 * Grabs the next order from the queue
 * @param  string $location_id
 * @return array              false on failure
 */
	public function getOrder($location_id) {
		$order = $this->find('first', array(
			'conditions' => array(
				'DeviceOrder.location_id' => $location_id,
				'DeviceOrder.status'      => 'phone'
			),
			'order' => array('DeviceOrder.created' => 'ASC')
		));

		if (empty($order) || !$order) {
			$order = $this->find('first', array(
				'conditions' => array(
					'DeviceOrder.location_id' => $location_id,
					'DeviceOrder.status'      => 'ready'
				),
				'order' => array('DeviceOrder.created' => 'ASC')
			));
		}
		return $order;
	}

/**
 * Processes a devices response, and updates an order accordingly
 *
 * @param   int   $id
 * @param  [type] $status
 * @param  [type] $delivery_time
 * @param  [type] $description   Rejection reason (if given)
 */
	public function processDeviceResponse($order_id, $status, $delivery_time, $description) {

		$paymentModel        = ClassRegistry::init('Payment');

        $this->Order->id = $order_id;
		if (!$this->Order->exists()) {
			return false;
		}		
		
		//@todo remove if unuse?
		$order				 = $this->Order->findById($order_id);
		$location_language	 = 'fr';
		Configure::write('Config.language', $location_language);
		CakeSession::write('Config.language', $location_language);

		// Update order statuses
        $data = array(
            'Order' => array(
                'expected_delivery_time' => $delivery_time,
                'device_status'          => $status,
                'response'               => $description,
                'id'                     => $order_id,
                'gateway_status'         => ''));
		
		$isNotTiemoutByTime = $this->_isNotTimeoutByTime($order);

		//TODO check if checking for ($this->Order->field('overall_status') === 'waiting_resto') works correctly
        if (($status === 'accepted' || $status === 'approved') && //  Everything GOOD
            ($this->Order->field('overall_status') !== 'rejected') &&
            ($this->Order->field('overall_status') !== 'timeout') &&
			$isNotTiemoutByTime){
			
			// Set device status
			$data['Order']['device_status'] = 'accepted';
				
            //  RRRR! Capture money from the credit card [read in a pirate accent].           
            $payment_response = $paymentModel->captureAuthorization($order_id);            
            
        } elseif ($status  === 'timeout' || !$isNotTiemoutByTime) {
        
            // void credit card authorization
            $payment_response         = $paymentModel->voidAuthorization($order_id);
			$payment_response['status'] = "voided";
            $data['Order']['device_status'] = 'timeout';
            
        } elseif ($status  === 'rejected') {             //  REJECTED BY RESTAURANT
		
            // void credit card authorization
            $payment_response         = $paymentModel->voidAuthorization($order_id);
			$payment_response['status'] = "voided";
            $data['Order']['device_status'] = $status;
        }

        $data['Order']['gateway_status'] = $payment_response['status'];
        $data['Order']['user_id']        = $this->Order->field('user_id');
        $data['Order']['location_id']    = $this->Order->field('location_id');
        $data['Order']['coupon_code']    = $this->Order->field('coupon_code');

        $data = $this->_checkStatuses($data, $order, $order_id);
        $this->Order->save($data);
        return $data;
    }

/**
 * Deletes a record by order ID
 * @param  int    $order_id 
 */
	public function deleteByOrderId($order_id) {
		$result = $this->find('first', array(
			'fields' => 'DeviceOrder.id',
			'conditions' => array(
				'DeviceOrder.order_id' => $order_id
			)
		));
		if ($result) {
			$this->delete($result['DeviceOrder']['id']);
		}
	}

/**
 * Sends a system message to all devices
 * @param  string $message
 */
	public function sendSystemMessage($message) {
		$devices = $this->Location->Device->find('all', array(
			'group' => 'Device.location_id'
		));

		foreach ($devices as $device) {
			$this->create();
			$order_id = String::uuid();
			$this->data = array(
				'DeviceOrder' => array(
					'location_id' => $device['Device']['location_id'],
					'order_id' => $order_id,
					'order_string' => $this->generateSystemMessage(
						$this->sanitize($message)
					)
				)
			);
			$this->save();
		}
	}

/**
 * Send customer phone number to device
 * @param string $location_id
 * @param string $order_id
 * @param string $phone_number client's phone number
 * @param bool $orderConfirm is the order confirm or cancelled?
 */
	public function sendPhoneNumber($location_id, $order_id, $phone_number, $orderConfirm) {

		// Get order data
		$this->Order->recursive = 1;
		$this->data = $this->Order->findById($order_id);
		$this->_parseData();
		
		$this->create();
		$this->data = array(
			'DeviceOrder' => array(
				'location_id'  => $location_id,
				'order_id'     => $order_id,
				'status'       => 'phone',
				'order_string' => $this->generatePhoneNumberString($order_id, $phone_number, $orderConfirm)));
		$this->save($this->data, false);

	}

/**
 * Generates a string to be given to the printer
 * @param  Model  $Model [description]
 * @return [type]        [description]
 */
	public function generateOrderString() {
		//$this->clear();
		$this->_parseData();
		$this->_buildString();	
		return $this->getString();
	}
	
/**
 * Generates a string to be given to the printer inside the with the phone number
 * @param  Model  $Model [description]
 * @return [type]        [description]
 */
	private function _generateOrderStringBody() {
		//$this->clear();
		$this->_parseData();
		$this->_buildStringBody();
		return $this->getString();
	}
/**
 * Generates a system message to be sent to all printers
 */
	public function generateSystemMessage($message) {
		//$this->clear();
		$this->_buildSystemMessage(wordwrap($this->sanitize($message), 30, '``'));
		return $this->getString();
	}

/**
 * Generates the phone numeber string
 * @param  Model  $Model [description]
 * @return [type]        [description]
 */
	public function generatePhoneNumberString($order_id, $phone_number, $orderConfirm) {

		$this->_buildPhoneNumber($order_id, $phone_number, $orderConfirm);
		return $this->getString();
	}


/**
 * Parses $this->data for the information we need for the
 * string.
 *
 */
	private function _parseData() {
		$this->data = $this->sanitize($this->data);


		// Paid/NotPaid message
		if ($this->data['Order']['method_of_payment'] === 'creditcard') {
			$payment_status = __('PAID');
		} elseif ($this->data['Order']['method_of_payment'] === 'cash') {
			$payment_status = __('Not Paid');
		} else {
			$payment_status = __('Paid_'); //TODO switch to a real error message
		}

		// Delivery/Takeout
		if ($this->data['Order']['type'] == 'delivery') {
			$order_type = __('Delivery');
		} else {
			$order_type = __('Take-out');
		}

		$this->setTimezone('America/Montreal');

		$this->data['Order']['coupon_discount'] = empty($this->data['Order']['coupon_discount']) ? '':  $this->data['Order']['coupon_discount'];
		$this->data['Order']['coupon_offered_by'] = empty($this->data['Order']['coupon_offered_by']) ? "": $this->data['Order']['coupon_offered_by'];

		$this->order_data['location_id']     = $this->data['Location']['id'];
		$this->order_data['order_id']        = $this->data['Order']['id'];
		$this->order_data['delivery_charge'] = $this->data['Order']['delivery_charge'];						
		$this->order_data['total']           = $this->data['Order']['total'];
		$this->order_data['restaurant_total']= $this->Order->getRestaurantTotal($this->data);		
		//$this->order_data['customer_phone']  = $this->data['Order']['phone'];
		$this->order_data['comments']        = wordwrap($this->data['Order']['special_instruction'], 30, '``');
		$this->order_data['items']           = $this->data['OrderDetail'];
		//$this->order_data['customer_type']   = __('Verified');
		$this->order_data['customer_name']   = $this->data['Order']['first_name'];
		$this->order_data['customer_name']   .= ' ';
		$this->order_data['customer_name']   .=$this->data['Order']['last_name'];
		$this->order_data['overall_status']  = $this->data['Order']['overall_status'];
		$this->order_data['payment_status']  = $payment_status;
		$this->order_data['order_type']      = $order_type;
		$this->order_data['requested_for']   = $this->formatDate($this->data['Order']['requested_for']);
		$this->order_data['coupon_discount'] = $this->data['Order']['coupon_discount'] ? $this->data['Order']['coupon_discount'] : '';
		$this->order_data['coupon_offered_by'] = $this->data['Order']['coupon_offered_by'] ? $this->data['Order']['coupon_offered_by'] : '';

		if (strtotime('+5 Minute') < strtotime($this->data['Order']['requested_for'])) {
			$this->order_data['future_order'] = true;
		} else {
			$this->order_data['future_order'] = false;
		}
		
		 /**
		 *  Is customer's first order?
		 */
		$UserModel = ClassRegistry::init('User');
		$this->order_data['first_order'] = !$UserModel->isCustomer($this->data['Order']['user_id']);

		/**
		 * Builds the customer's address
		 */
		$this->order_data['customer_address'] = $this->newLine(1, true);
		$this->order_data['customer_address'] .= $this->data['Order']['address'];

		if (
			isset($this->data['Order']['address2'])
			&& !empty($this->data['Order']['address2'])
		) {
			$this->order_data['customer_address'] .= $this->newLine(1, true);
			$this->order_data['customer_address'] .= $this->data['Order']['address2'];
		}

		$this->order_data['customer_address'] .= $this->newLine(1, true);
		$this->order_data['customer_address'] .= $this->data['Order']['city'];
		$this->order_data['customer_address'] .= $this->newLine(1, true);
		$this->order_data['customer_address'] .= $this->data['Order']['state'];
		$this->order_data['customer_address'] .= $this->data['Order']['postal_code'];

		if (
			isset($this->data['Order']['cross_street'])
			&& !empty($this->data['Order']['cross_street'])
		) {
			$this->order_data['customer_address'] .= $this->newLine(2, true);
			$this->order_data['customer_address'] .= __('Cross-street:');
			$this->order_data['customer_address'] .= $this->newLine(1, true);
			$this->order_data['customer_address'] .= $this->data['Order']['cross_street'];
		}

		/**
		 * Build the price breakdown
		 */

		if (
			isset($this->data['Order']['delivery_charge'])
			&& ($this->data['Order']['delivery_charge'] > 0)
		) {
			$this->order_data['breakdown'][] = __('Delivery Charge: $%.2f', $this->order_data['delivery_charge']);
		}

		// restaurant coupon		
		if($this->order_data['coupon_discount'] > 0 && $this->order_data['coupon_offered_by'] === 'restaurant'){		
			$this->order_data['breakdown'][] = __('discount: $%.2f', $this->order_data['coupon_discount']);
		}


		if (
			isset($this->data['Order']['subtotal'])
			&& ($this->data['Order']['subtotal'] > 0)
		) {
			$this->order_data['breakdown'][] = __('SubTotal: $%.2f', $this->data['Order']['subtotal']);
		}


		if (
			isset($this->data['Order']['pst'])
			&& ($this->data['Order']['pst'] > 0)
		) {
			$this->order_data['breakdown'][] = __('PST: $%.2f', $this->data['Order']['pst']);
		}

		if (
			isset($this->data['Order']['gst'])
			&& ($this->data['Order']['gst'] > 0)
		) {
			$this->order_data['breakdown'][] = __('GST: $%.2f', $this->data['Order']['gst']);
		}

		if (
			isset($this->data['Order']['hst'])
			&& ($this->data['Order']['hst'] > 0)
		) {
			$this->order_data['breakdown'][] = __('HST: $%.2f', $this->data['Order']['hst']);
		}

		if (
			isset($this->data['Order']['tip'])
			&& ($this->data['Order']['tip'] > 0)
		) {
			$this->order_data['breakdown'][] = __('Tip: $%.2f', $this->data['Order']['tip']);
		}

	}



/**
 * Builds the order string with the information provided
 */

	private function _buildString() {
		
		// Open
		$this->pound();

		/**
		 * Section 1
		 * Order ID
		 */
		$this->text($this->order_data['order_id']);



		/**
		 * Section 2
		 * Message Header
		 */

		$this->star();
		$this->text($this->order_data['order_type']);


		/**
		 * Section 3
		 * Message Body
		 */
		$this->star();
		
//		$this->text($this->formatDate(date('Y-m-d H:i:s')));
		$this->newLine();
//		$this->hr();
		// Order Number
		$this->text(__('Order #%s/r', $this->order_data['order_id']));
		$this->hr();

		// Requested Date/Time
		$this->text(__('Requested For/r'));
		$this->newLine();

		if ($this->order_data['future_order']) {
			$this->text(__('Future Order'));

		} else {
			$this->text(__('ASAP'));
		}
		$this->newLine();
		$this->text('%s', $this->order_data['requested_for']);

		$this->hr();
		$this->_buildStringBody();
		

		/**
		 * Jump to section 8
		 */
		$this->star(4);


		/**
		 * End
		 */
		$this->pound();

	}

	/**
	 * Send customer phone numeber to the printer
	 * @param  string $order_id          Order ID
	 * @return [type]              [description]
	 */
	private function _buildPhoneNumber($order_id, $phone_number, $orderConfirm) {
		// Open
		$this->pound();

		/**
		 * Section 1
		 * Message ID
		 */
		$this->text(str_pad(time(), 10, 0, STR_PAD_RIGHT));				

		/**
		 * Section 2
		 * Message Header
		 */
		$this->star();	
		if (!$orderConfirm){
            $this->text(__('CALL:/r'));$this->newLine();
            $this->text(__('514 989 1233/r'));$this->newLine();
			$this->text(__('CANCELLED  CANCELLED/r'));$this->newLine();											
			$this->text(__('CANCELLED  CANCELLED/r'));$this->newLine();											
		} else {
			$this->text($this->order_data['order_type']);
		}




		/**
		 * Section 3
		 * Message Body
		 */
		$this->star();
		if (!$orderConfirm){
			$this->hr();
			$this->text(__('Order #%s', $order_id));
			$this->hr();
			$this->text(__('Do NOT cook order #%s. Check if the previous order was this one.', $order_id));
			$this->hr();
		} else {

			$this->text(__('Order #%s', $order_id));
			$this->hr();
			$this->hr();
			$this->text(wordwrap(__("Customer Phone: %s/r", $phone_number)), 30, '``');
			$this->hr();

			// Requested Date/Time
			$this->text(__('Requested For/r'));
			$this->newLine();

			if ($this->order_data['future_order']) {
				$this->text(__('Future Order'));
			} else {
				$this->text(__('ASAP'));
			}
			$this->newLine();
			$this->text('%s', $this->order_data['requested_for']);

			$this->hr();
		}

		$this->_buildStringBody(TRUE);

		if (!$orderConfirm){
			$this->hr();
            $this->text(__('CALL 514 989 1233'));$this->newLine();
			$this->text(__('CANCELLED  CANCELLED'));$this->newLine();			
			$this->text(__('CANCELLED  CANCELLED'));$this->newLine();			
			$this->text(__('CANCELLED  CANCELLED'));$this->newLine();			
			$this->text(__('CANCELLED  CANCELLED'));$this->newLine();
            $this->text(__('CALL 514 989 1233'));$this->newLine();
			$this->hr();
			$this->text(__('Do NOT cook this order. It was cancelled by the user'));
			$this->hr();
		}

		/**
		 * Jump to section 8
		 */
		$this->star(4);
//
//
//		$this->newLine();
//		$this->text(__('Thank you!/r'));
//		$this->newLine();

		/**
		 * End
		 */
		$this->pound();

	}
/**
 * Builds a system message to broadcast
 * @param  string $id          message id, use a UUID
 * @param  string $message     message to be sent
 * @return [type]              [description]
 */
	private function _buildSystemMessage($message) {
		$message = str_ireplace("\n", $this->newLine(1, true), $message);
		// Open
		$this->pound();

		/**
		 * Section 1
		 * Message ID
		 */
		$this->text(str_pad(time(), 22, 0, STR_PAD_RIGHT));



		/**
		 * Section 2
		 * Message Header
		 */
		$this->star();
		$this->text(__('Important!'));


		/**
		 * Section 3
		 * Message Body
		 */
		$this->star();
		$this->text($this->formatDate(date('Y-m-d H:i:s')));
		$this->newLine();
		$this->hr();
		$this->text(__('Message from'));
		$this->newLine();
		$this->text(_('TopMenu/r'));
		$this->hr();
		$this->newLine();
		$this->text($message);
		//$this->newLine();



		/**
		 * Footer
		 */
		$this->star(4);
		$this->hr();
		$this->text(__('Thank you!/r'));

		/**
		 * End
		 */
		$this->pound();

	}
	
	private function _buildStringBody($isConfirmation = FALSE){
					
	
		// ITEMS AND ITEMS OPTIONS		
		foreach ($this->order_data['items'] as $item) {
		
			// Item
			$this->itemBlock(array($item['quantity'] . 'x ' . $item['name'] => sprintf('$%.2f', $item['subtotal'])));

			// Items options
			if (!empty($item['options'])) {
				$itemOptionStr = trim($item['options']);
				$itemOptionArray = (explode('||', $itemOptionStr));  // explode options		
				array_pop($itemOptionArray);

				// remove last element which is always emtpy explose delimeter is at end of string


				foreach ($itemOptionArray as $io) {
					if (empty($io)) {
						continue;
					}

					/**
					 * option[0] = name
					 * option[1] = price
					 * option[2] = quantity // which is always set to one so it will be ignored
					 */
					$ioArray = explode('~', $io);

					$this->newLine();

					// Options name and price on same line?
					if (strlen(trim($ioArray[0])) < 25) {
						$this->text('++%s $%s', trim($ioArray[0]), trim($ioArray[1]));
					} else {
						$this->text('++%s', trim($ioArray[0]));
						$this->newLine();
						$this->text('%20s$', trim($ioArray[1]));
					}
				}
			}
			
			if (isset($item['special_instruction']) && !empty($item['special_instruction'])) {
				$tmpSpecialInstruction = substr($item['special_instruction'], 0, 200);				// truncate special instructions
				$lineBreaks = array("\r\n", "\n", "\r");
				$tmpSpecialInstruction = str_replace($lineBreaks, "  ", $tmpSpecialInstruction);	// strip out linebreaks	
				$this->newLine();
				$this->text('   [%s]', $tmpSpecialInstruction);

			}
			$this->hr();
		}		

		
		// BREAKDOWN
		foreach ($this->order_data['breakdown'] as $fee) {
			$this->textRight($fee);
			$this->newLine();
		}

		// TOTAL
		$this->newLine();
		if ($this->order_data['overall_status'] === 'rejected' || $this->order_data['overall_status'] === 'waiting_user') {
            $this->text(__('CALL 514 989 1233'));$this->newLine();
			$this->text(__('CANCELLED  CANCELLED'));$this->newLine();			
			$this->text(__('CANCELLED  CANCELLED'));$this->newLine();			
			$this->text(__('CANCELLED  CANCELLED'));$this->newLine();			
			$this->text(__('CANCELLED  CANCELLED'));$this->newLine();            
			
		} else {
			
			// Total
			$this->text(__('Total: $%.2f/r', $this->order_data['restaurant_total']	));
			$this->text('%s/r', $this->order_data['payment_status']);
			$this->newLine();		
		}


		// CUSTOMER INFO
		$this->hr();
		
		// First order?
		if($this->order_data['first_order']){
			$this->text('%s', "FIRST ORDER");		
			$this->newLine();		
			$this->text('%s', "Client first Order. Confirm order by phone");
			$this->hr();
		}

		// Name
		if ($this->order_data['overall_status'] === 'rejected' || $this->order_data['overall_status'] === 'waiting_user') {
            $this->text(__('CALL 514 989 1233'));$this->newLine();
			$this->text(__('CANCELLED  CANCELLED'));$this->newLine();			
			$this->text(__('CANCELLED  CANCELLED'));$this->newLine();			
			$this->text(__('CANCELLED  CANCELLED'));$this->newLine();			
			$this->text(__('CANCELLED  CANCELLED'));$this->newLine();		            
		} else {
			$this->text('%s/r', $this->order_data['customer_name']);
		}
		
		// Address
		if (
			strtolower($this->order_data['order_type']) == 'delivery'
			|| strtolower($this->order_data['order_type']) == 'livraison'
		) {
			$this->text('%s', $this->order_data['customer_address']);
			$this->newLine();
		}				
		
		// Topmenu coupons explanation text
		if($this->order_data['coupon_discount'] > 0 && $this->order_data['coupon_offered_by'] === 'topmenu'){

			$this->newLine();
			$this->text(__('Topmenu.com as offered you a $%.2f discount on your order.', $this->order_data['coupon_discount']));
			$this->text(__('Your total order is $%.2f.', $this->order_data['total']));
			$this->newLine();
		}

		// Comments
		if (!empty($this->order_data['comments'])) {
			$this->hr();
			$this->text('%s/r', __('Comments'));
			$this->newLine();
			$tmpComment = substr($this->order_data['comments'], 0, 200);
			$this->text($tmpComment);
			$this->newLine();
		}
		
		
        // FOOTER        
		$this->signature();
	}
	
	/**
	 * <ol>
	 * <li>Verify the device, gateway and overall statuses.</li>
	 * <li>Update the status fields in the db accordingly</li>
	 * <li>Print out the second copy of the order or print out the cancellation messasge</li>
	 * </ol> 
	 * 
	 * @param array $data Data struture that will be added to the order before saving
	 */
	private function _checkStatuses($data, $order, $order_id){				
	
		if (                                                                    //  CREDIT CARD GOOD
            $data['Order']['gateway_status'] === 'approved' &&
            $data['Order']['device_status'] === 'accepted' &&
            $order['Order']['overall_status'] != 'rejected' &&
            $order['Order']['overall_status'] != 'waiting_user' &&
            $order['Order']['overall_status'] != 'timeout'
        ) {
            
            // Credit card order accepted
            $data['Order']['overall_status'] = 'waiting_user';   // this wil be set to completed when/if the user reaches the "approve" page. The order is considered complete either way
            $this->_addCouponUsage($data, $order_id);
            $this->sendPhoneNumber($order['Order']['location_id'], $order_id, $order['Order']['phone'], TRUE);
            
        } elseif (                                                              //  CASH GOOD
						
			$order['Order']['method_of_payment'] === 'cash' &&
            $data['Order']['device_status'] === 'accepted' &&
            $order['Order']['overall_status'] != 'rejected' &&
            $order['Order']['overall_status'] != 'waiting_user' &&
            $order['Order']['overall_status'] != 'timeout') {

            // Cash order accepted
            $data['Order']['overall_status'] = 'waiting_user';   // this wil be set to completed when/if the user reaches the "approve" page. The order is considered complete either way
            $data['Order']['gateway_status'] = 'cash';

            $this->_addCouponUsage($data, $order_id);
            $this->sendPhoneNumber($order['Order']['location_id'], $order_id, $order['Order']['phone'], TRUE);
            
        } else {                                                                // ORDER CANCELLED
            
            $data['Order']['overall_status'] = ($data['Order']['device_status'] === 'timeout')? 'timeout' : 'rejected'; // differentiate between rejection by timesout and any other reason
            $this->sendPhoneNumber($order['Order']['location_id'], $order_id, $order['Order']['phone'], FALSE);
		}

        		return $data;
	}
	
	/**
	 * This insert a new coupon usage in the database if a coupon was use and the order is accepted
	 * @param array $data some of the order data
	 * @param $order_id
	 */
	private function _addCouponUsage($data, $order_id) {

		if (!empty($data['Order']['coupon_code'])) {
			$usedCouponModel = ClassRegistry::init('UsedCoupon');
			$usedCouponModel->addCouponUsage($data['Order']['coupon_code'], $data['Order']['user_id'], $data['Order']['location_id'], $order_id);
		}
	}
	
	/**
	 * Checks orders if an order is timeout by checking how old it is
	 * There's other way of detecting timeouts. This is the last line of defense but it's imperfect.
	 * Here I have put the magic number 15 minutes as the delais after which any order is consider timeout. Why 15 
	 * minutes: because sim devices can take up to 7.5 minutes to timeout as mention in the documentation, but we are 
	 * using the the orders creation date (not it's last updated date) to compare the tiem it's processing. We are doing
	 * so to avoid any situation where the order may be udpated by some other process a those resetting the timeout 
	 * time.
	 * @param type $order order's data
	 */
	private function _isNotTimeoutByTime($order){

		// Fetch timeout duration the same way it's calculated in the paymentController.php::processing() action
		$fifteenMinutesAgo = strtotime('-15 minutes');
		$this->log("Order $order was timeout by time delai. \nCreated on {$order['Order']['created']}. \nCheck on {$fifteenMinutesAgo}");
		return (strtotime($order['Order']['created']) > strtotime('-15 minutes'));
	}

}
