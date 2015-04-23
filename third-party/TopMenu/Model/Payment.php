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
App::uses('Order', 'Model');
App::uses('ValidationException', 'Lib/Error/Exception');

class Payment extends AppModel {

	/**
	 * We don't use a DB table
	 * @var boolean
	 */
	public $useTable = false;

	/**
	 * Default datasource for this model
	 * @var string
	 */
//	public $useDbConfig = 'EvoCanada';
	public $useDbConfig = 'OrbitalGateway';

	/**
	 * Validation rules
	 *
	 * @var array 
	 */
	public $validate = array(
		// credit card
		'firstname'	 => array(
			'notempty' => array(
				'rule'		 => array('notempty'),
				'message'	 => 'The card holder first name is Required',
				'allowEmpty' => false,
				'required'	 => false)),
		'lastname'	 => array(
			'notempty' => array(
				'rule'		 => array('notempty'),
				'message'	 => 'The card holder last name is Required',
				'allowEmpty' => false,
				'required'	 => false)),
		'ccnumber'	 => array(
			'notempty'	 => array(
				'rule'		 => array('notempty'),
				'message'	 => 'The credit card number is required',
				'allowEmpty' => false,
				'required'	 => false
			),
			'creditcard' => array(
				'rule'		 => array(
					'cc',
					array('visa', 'mc'),
					true),
				'message'	 => 'The credit card number is incorrect',
				'allowEmpty' => false,
				'required'	 => false)),
		'ccexp'		 => array(
			'rule'		 => array('custom', '/^\d{2}\/1[0-2]|0[1-9]$/'),
			'message'	 => 'Expiry date is incorrect'),
		'cvv'		 => array(
			'notempty'	 => array(
				'rule'		 => array('notempty'),
				'message'	 => 'CVV number is required',
				'allowEmpty' => false,
				'required'	 => false,),
			'cvv'		 => array(
				'rule'		 => '/^\d{3,4}$/',
				'message'	 => 'Your CVV number is incorrect (3 or 4 numbers on the back of your card)')),
		// address
		'address1'	 => array(
			'notempty' => array(
				'rule'		 => array('notempty'),
				'message'	 => 'The credit card address is required',
				'allowEmpty' => false,
				'required'	 => false)),
		'city'		 => array(
			'notempty' => array(
				'rule'		 => array('notempty'),
				'message'	 => 'The city is required',
				'allowEmpty' => false,
				'required'	 => false)),
		'state'		 => array(
			'notempty'		 => array(
				'rule'		 => array('notempty'),
				'message'	 => 'The province state is required',
				'allowEmpty' => false,
				'required'	 => false),
			'twoChar'		 => array(
				'rule'		 => array('alphaNumeric'),
				'message'	 => 'Letters only for the province',
				'allowEmpty' => false,
				'required'	 => false),
			'alphaNumeric'	 => array(
				'rule'		 => array('between', 2, 2),
				'message'	 => 'Must be the province\'s two character code',
				'allowEmpty' => false,
				'required'	 => false)),
		'country'	 => array(
			'notempty'		 => array(
				'rule'		 => array('notempty'),
				'message'	 => 'Country required',
				'allowEmpty' => false,
				'required'	 => false),
			'alphaNumeric'	 => array(
				'rule'		 => array('alphaNumeric'),
				'message'	 => 'Letters only for country',
				'allowEmpty' => false,
				'required'	 => false),
			'twoChar'		 => array(
				'rule'		 => array('between', 2, 2),
				'message'	 => 'Must be the country\'s two character code',
				'allowEmpty' => false,
				'required'	 => false)),
		'zip'		 => array(
			'notempty'		 => array(
				'rule'		 => array('notempty'),
				'message'	 => 'Postal code is required',
				'allowEmpty' => false,
				'required'	 => false),
			'postal_code'	 => array(
				'rule'		 => '',
				'message'	 => 'Postal code format must be: H0H 0H0',
				'allowEmpty' => false,
				'required'	 => false)),
		// Transaction
		'tax'		 => array(
			'notempty'	 => array(
				'rule'		 => array('notempty'),
				'message'	 => 'Tax Required',
				'allowEmpty' => false,
				'required'	 => false),
			'numeric'	 => array(
				'rule'		 => array('numeric'),
				'message'	 => 'Not a numeric value',
				'allowEmpty' => false,
				'required'	 => false),
			'positive'	 => array(
				'rule'		 => array('range', 0, NULL),
				'message'	 => 'Positive number only',
				'allowEmpty' => false,
				'required'	 => false)),
		'amount'	 => array(
			'notempty'	 => array(
				'rule'		 => array('notempty'),
				'message'	 => 'Amount Required',
				'allowEmpty' => false,
				'required'	 => false),
			'numeric'	 => array(
				'rule'		 => array('numeric'),
				'message'	 => 'Not a numeric value',
				'allowEmpty' => false,
				'required'	 => false),
			'positive'	 => array(
				'rule'		 => array('range', 0, NULL),
				'message'	 => 'Positive number only',
				'allowEmpty' => false,
				'required'	 => false)),
		'currency'	 => array(
			'notempty'		 => array(
				'rule'		 => array('notempty'),
				'message'	 => 'Required',
				'allowEmpty' => false,
				'required'	 => false),
			'alphaNumeric'	 => array(
				'rule'		 => array('alphaNumeric'),
				'message'	 => 'Letters only',
				'allowEmpty' => false,
				'required'	 => false),
			'twoChar'		 => array(
				'rule'		 => array('between', 2, 2),
				'message'	 => '2 character code only',
				'allowEmpty' => false,
				'required'	 => false)));

	/**
	 * Template of Request array (what we send to the datasource)
	 * @var array
	 */
	public $requestTemplate = array(
		'credit_card'		 => array(
			'number'		 => '', // Credit Card Number
			'type'			 => '', // Card Type
			'expire_month'	 => '', // Expiration Month
			'expire_year'	 => '', // Expiration Year
			'cvv2'			 => '', // CVV2 Code
			'first_name'	 => '', // Card Holder's first name
			'last_name'		 => ''  // Card Holder's last name
		),
		'billing_address'	 => array(
			'line1'			 => '', // Address line 1
			'line2'			 => '', // Address line 2 -- Optional
			'city'			 => '', // City
			'country_code'	 => '', // 2 Char Country Code
			'postal_code'	 => '', // Postal Code / Zip Code
			'state'			 => ''  // State/Province
		),
		'transaction'		 => array(
			'id'	 => null, // Transaction ID (if applicable)
			'amount' => array(
				'total'		 => '', // Total amount to be charged
				'currency'	 => '', // Currency  (3 Char ISO code)
				'details'	 => array(
					'subtotal'	 => '', // Total with out tax or shipping
					'tax'		 => '', // Total tax
					'shipping'	 => ''  // Total shipping
				)
			)
		),
		'return_urls'		 => array(// These are set for Paypal, and for Beanstream
			'cancel_url' => '', // URL to send users back to when they cancel payment
			'return_url' => ''  // URL to send users back to when the payment was successful
		)
	);

	/**
	 * Template of the Response Object returned by the datasource
	 * use this as a template only!!! Make a copy in the function and fill it with
	 * @var array
	 */
	public $responseTemplate = array(
		'id'			 => '', // Transaction ID
		'status'		 => '', // Status of the transaction  Possible Values: (approved|declined|error)
		'authorization'	 => array(// Set when we're authorizing
			'id' => '' // Authorization ID
		),
		'error'			 => false
	);

	/**
	 * Construct
	 *
	 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->_getDatasource();
	}

	/**
	 * __get() - Overload the model
	 * @param  string $name property we're tying to get
	 * @return mixed
	 */
	public function __get($name) {
		parent::__get($name);
		if ($name == 'response') {
			return $this->_arrayToObject($this->responseTemplate);
		}
		if ($name == 'request') {
			$request = $this->requestTemplate;
			return $request;
		}
	}

	/**
	 * Create a credit card payment
	 *
	 * @param  array  $data Array of data to send	 
	 * @param string $orderid Order's id
	 * @param  string $languageSuffix two letter code or the end user language
	 * @return array Data given as a response from gateway
	 */
	public function requestAuthorization($data, $orderid, $languageSuffix) {
		
		
		// debug
						
		
		$request = array_merge($this->request, $data);
		$result	 = $this->Gateway->requestAuthorization($request, $languageSuffix, $orderid); // converting SimpleXMLElement to array because SimpleXMLElement object cannot be serialized
						$result['response'] = $result['error'][0];
		return $result;
	}

	/**
	 * Captures an authorized payment (take money from client)
	 * @param  string $orderId
	 * @return array Data given as a response from gateway
	 */
	public function captureAuthorization($orderId) {

				// log result in TransactionLog table
		$tlModel = ClassRegistry::init('TransactionLog');
		$tlData	 = $tlModel->find('first', array(
			'condition'	 => array(
				'TransactionLog.order_id'	 => $orderId,
				'TransactionLog.status'		 => "approved",
			),
			'order'		 => array('TransactionLog.created DESC')
			)
		);

		$result = (array) $this->Gateway->captureAuthorization($orderId, $tlData['TransactionLog']['number'], $tlData['TransactionLog']['amount'], 'fr');
		$tlModel->logTransaction($result, $tlData['TransactionLog']['user_id'], $orderId, $tlData['TransactionLog']['location_id']);

		return $result;
	}

	/**
	 * Voids an authorization
	 * @param  array  $transactonData
	 * @return object
	 */
	public function voidAuthorization($orderId) {

		$transactionLogModel = ClassRegistry::init('TransactionLog');

		// Get transaction id by order
		$tl = $transactionLogModel->findByOrderId($orderId);

		if (empty($tl)) {
			$this->log("Failed to void Order $orderId");
			return array('status' => 'not voided');
		}

		$result = $this->Gateway->voidAuthorization($tl['TransactionLog']['order_id'], $tl['TransactionLog']['number'], null, 'fr');

		// log result in TransactionLog table			
		$tl['TransactionLog']['status'] = ($result['status'] === 'approved') ? 'voided' : $result['status'];
		$transactionLogModel->logTransaction($result, $tl['TransactionLog']['user_id'], $tl['TransactionLog']['order_id'], $tl['TransactionLog']['location_id']); //TODO on users rejection page we have to make sure this is done	

		$resultArray = (array) $result;
		return $resultArray;
	}

	/**
	 * Stores a CC in the gateway's vault
	 * @param  array  $data
	 * @return object
	 */
	public function storeCreditCard($data) {
		$request = array_merge($this->request, $data);
		return $this->Gateway->storeCreditCard($request, $this->response);
	}

	/**
	 * Gets the status of a stored credit card
	 * @param  array  $data
	 * @return object
	 */
	public function getStoredCreditCardStatus($data) {
		$request = array_merge($this->request, $data);
		return $this->Gateway->getStoredCreditCardStatus($request, $this->response);
	}

	/**
	 * Deletes a stored CC from the vault
	 * @param  array  $data
	 * @return object
	 */
	public function deleteStoredCreditCard($data) {
		$request = array_merge($this->request, $data);
		return $this->Gateway->deleteStoredCreditCard($request, $this->response);
	}

	/**
	 * Grabs a datasource and sets it to $this->Gateway
	 * @param  string $datasource name of the datasource config
	 * @return void
	 */
	private function _getDatasource($datasource = null) {
		$this->Gateway = $this->getDataSource($datasource);
	}

	/**
	 * Converts an array into an object
	 *
	 * @param  array $array Array to be converted
	 * @return stdClass
	 */
	private function _arrayToObject($array) {
		return json_decode(json_encode($array));
	}

	/**
	 * Flattens request's array for validation (CC number and CC address)
	 * 
	 * @param array $data Request array
	 * @return array Flatten array ready to be validated
	 * 
	 */
	public function flattenRequest($data) {

		if ($data['method'] === 'cc') {
			// 0 filled month
			if ($data['credit_card']['expire_month'] < 10) {
				$data['credit_card']['expire_month'] = '0' . $data['credit_card']['expire_month'];
			}

			// 2 digit date
			if (strlen($data['credit_card']['expire_year']['year']) > 2) {
				$data['credit_card']['expire_year']['year'] = substr($data['credit_card']['expire_year']['year'], -2);
			}

			return array(
				'ccnumber'	 => $data['credit_card']['number'],
				'ccexp'		 => $data['credit_card']['expire_year']['year'] . '/' . $data['credit_card']['expire_month'],
				'cvv'		 => $data['credit_card']['cvv2'],
				'firstname'	 => $data['credit_card']['first_name'],
				'lastname'	 => $data['credit_card']['last_name'],
				'phone'		 => $data['billing_address']['phone'],
				'address1'	 => $data['billing_address']['address'],
				'address2'	 => $data['billing_address']['address2'],
				'city'		 => $data['billing_address']['city'],
				'state'		 => $data['billing_address']['province'],
				'zip'		 => strtoupper($data['billing_address']['postal_code']),
				'country'	 => Configure::read('I18N.COUNTRY_CODE_2'));
		}
	}

	/**
	 * Reads the error message from the database 
	 * @param type $declineMessage
	 */
	public function processGatewayDecline($declineMessage) {

		// log intodatabse
		// get nice decline message
	}

	/**
	 * Refunds a payment to the user and crate new record in the db representing this "refund order"
	 * @param  array order data from database
	 * @param  string Justification text for the refund
	 * @return array Data of the new "refund order" to be save
	 * @throws ValidationException
	 */
	public function refund(array $data, $description = "") {

		$orderModel	 = new Order();
		// try to refund		
		$result		 = $this->Gateway->refundPayment($data['Order']['transaction_number'], $data['Order']['total']);
		debug($data);
		debug($result);
		if ($result->status !== "SUCCES") {

			// INSERT NEW "REFUND ORDER" IN DB
			// make sure original order info is present in the refund justification
			$description .= "\nOriginal transaction:     " . $data['Order']['transaction_number'];
			$description .= "\nOriginal Order id:        " . $data['Order']['id'];
			$description .= "\n------------------";
			$description .= "\nOriginal special instructions:";
			$description .= "\n------------------";
			$description .= "\n" . $data['Order']['id'];

			// copy original order
			$this->create();
			unset($data['Order']['id']); // dont copy the order id 
			$this->data = $data;

			// alter refund order
			$orderModel->set('total', $data['Order']['total'] * -1); // the order total is the negative amount of the origianl order
			$orderModel->set('special_instruction', $description); // put some justification of the refund in the special instruction field
			$orderModel->set('method_of_payment', 'reimbursement');
			$orderModel->set('gateway_status', $result->status);
			$orderModel->set('overall_status', 'reimbursement');
			$orderModel->set('transaction_number', $result->id);
			$orderModel->set('response', 'Transaction Successfully Refunded');
			$orderModel->set('date', date('Y-m-d H:i:s', time()));
			$orderModel->set('created', date('Y-m-d H:i:s', time()));

			// save
			$orderModel->save();
			if (!$orderModel->validates()) {
				throw new ValidationException(print_r($this->validationErrors));
			}
		} else {
			throw new ValidationException($result->error);
		}

		return $orderModel->getLastInsertID();
	}

}
