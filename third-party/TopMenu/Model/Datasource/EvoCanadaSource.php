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

define("APPROVED", 1);
define("DECLINED", 2);
define("ERROR", 3);

/**
 * EvoCanadaSource class.
 *
 * @extends DataSource
 */
class EvoCanadaSource extends DataSource
{
/**
 * description
 *
 * (default value: "EvoCanada direct payment API")
 *
 * @var string
 * @access public
 */
	public $description = "EvoCanada direct payment API";


/**
 * userName
 *
 * (default value: "")
 * SET IN database.php
 *
 * @var string
 * @access private
 */
	private $_userName = "";
/**
 * password
 *
 * (default value: "")
 * SET IN database.php
 *
 * @var string
 * @access private
 */
	private $_password = "";

/**
 * Http
 *
 * (default value: null)
 * SET IN database.php
 *
 * @var mixed
 * @access protected
 */
	protected $Http = null;


/**
 * nvpStr
 *
 * (default value: null)
 *
 * @var mixed
 * @access private
 */
	private $_nvpStr = null;

/**
 * Response object
 * @var array
 */
	private $_response = false;

/**
 * Request array
 * @var array
 */
	private $_request = array();

/**
 * __construct function.
 *
 * @access public
 * @param  mixed $config
 * @return void
 */
	public function __construct($config) {
		parent::__construct($config);

		$this->_userName = $this->config['username'];
		$this->_password = $this->config['password'];
	}


/**
 * info function.
 *
 *	Returns info about this datasource
 * @access public
 * @return void
 */
	public function info() {
		 return $this->description;
	}

/**
 * Make a credit card payment
 * @param  array     $request    data for the transaction
 * @param  stdClass  $response   Response object
 * @param  string    $type       Type of transaction: (sale|authorize)
 */
	public function creditCardPayment(array $request, stdClass $response, $type = null) {
	 	$this->_response = $response;
	 	$this->_request = false;

	 	$this->_request['type'] =  $this->_callType($type);
		$year = $request['credit_card']['expire_year']['year'];
	 	// Set the expirey date in MMYY format, pad the month with 0 if needed
	 	$expire = str_pad($request['credit_card']['expire_month'], 2, '0', STR_PAD_LEFT);
	 	if (strlen($year) > 2) {
	 		$expire .= substr($year, 2);
	 	} else {
	 		$expire .= $year;
	 	}

		$request['credit_card']['expire_year']['year'];
	 	// CREDIT CARD DATA
		$this->_request['firstname'] = $request['credit_card']['first_name'];
		$this->_request['lastname']  = $request['credit_card']['last_name'];
		$this->_request['ccnumber']  = $request['credit_card']['number'];
		$this->_request['ccexp']     = $expire;
		$this->_request['cvv']       = $request['credit_card']['cvv2'];


		// Billing Data
		$this->_request['address1'] = $request['billing_address']['line1'];
		$this->_request['address2'] = $request['billing_address']['line2'];
		$this->_request['city']     = $request['billing_address']['city'];
		$this->_request['country']  = $request['billing_address']['country_code'];
		$this->_request['state']    = $request['billing_address']['state'];
		$this->_request['zip']      = $request['billing_address']['postal_code'];

		// Transaction Data
		$this->_request['tax']      = $request['transaction']['amount']['details']['tax'];
		$this->_request['shipping'] = $request['transaction']['amount']['details']['shipping'];
		$this->_request['amount']   = $request['transaction']['amount']['total'];
		$this->_request['currency'] = $request['transaction']['amount']['currency'];

		$this->_call();

		return $this->_response;

	}




/**
 * Capture an authorization
 */
	public function captureAuthorization(array $request, stdClass $response) {
	 	$this->_response = $response;
	 	$this->_request = false;

	 	$this->_request['type'] =  'capture';
	 	$this->_request['transactionid'] = $request['transaction']['id'];

	 	$this->_call();

	 	return $this->_response;
	}





/**
 * Voids an authorization
 */
	public function voidAuthorization(array $request, stdClass $response) {
	 	$this->_response = $response;
	 	$this->_request = false;

	 	$this->_request['type'] =  'void';
	 	$this->_request['transactionid'] = $request['transaction']['id'];

	 	$this->_call();

	 	return $this->_response;
	}







	/**
	 * Refunds a payment
	 * @param array $order full order data retrieved form database
	 * @return array answer data from gateway
	 */
	public function refundPayment($transactionId, $orderTotal) {
		
		$this->_request['type']			 = 'refund';
		$this->_request['transactionid'] = $transactionId;

		if (isset($orderTotal) && $orderTotal > 0) {
			$this->_request['amount'] = number_format($orderTotal, 2, '.', '');
		}
		$this->_call();

		return $this->_response;
	}
		
/**
 * Stores a credit card in the CC vault provided by
 * Paypal
 * @param  array  $request Data to be stored
 * @return object
 */
	public function storeCreditCard(array $request, stdClass $response) {
	 	// TODO
	}






/**
 * Gets a credit card from the vault (used to check the status of a saved card mostly.)
 * @param  array  $request array containing the ID of the card
 * @return object
 */
	public function getStoredCreditCardStatus(array $request, stdClass $response) {
	 	// TODO
	}






/**
 * Deletes a CC from the vault
 * @param  array  $request array containing the ID of the card
 * @return object
 */
	public function deleteStoredCreditCard(array $request, stdClass $response) {
	  	// TODO
	}
   

	/**
	 * Performs the communication with the EvoCanada api
	 *
	 * In case of error it returns false
	 * @return mixed array if success, false otherwise.
	 *
	 */
	private function _call() {


		$API_Endpoint = "https://secure.evoepay.com/api/transact.php";

		$this->_request['username'] = $this->_userName;
		$this->_request['password'] = $this->_password;


		//call the web service

		$this->_buildString();

		$ch = curl_init();

	    curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, "RC4-SHA");
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $this->nvpStr);
	    curl_setopt($ch, CURLOPT_POST, 1);

	    $data = curl_exec($ch);


	    if (!$data) {
	        return ERROR;
	    }

	    curl_close($ch);
	    unset($ch);

		// Extract the response details.
		$httpResponse = explode("&", $data);

		$httpParsedResponseArray = array();
		foreach ($httpResponse as $part) {
			if (strpos($part, '=') === 0) {
				continue;
			}
			list($key, $value) = explode("=", $part);

			$key   = urldecode($key);
			$value = urldecode($value);


			if (!empty($key) && !empty($value)) {
				$httpParsedResponseArray[$key] = $value;
			}
		}

		if (
			(sizeof($httpParsedResponseArray) == 0)
			|| !array_key_exists('response', $httpParsedResponseArray)
		) {
			return false;
		}

		if ($httpParsedResponseArray['response'] == APPROVED) {
			$this->_setResponse($httpParsedResponseArray);
		} else {
			$this->_handleError($httpParsedResponseArray);
		}
	}

/**
 * Sets the response object
 * @param [type] $response [description]
 */
	private function _setResponse(&$response) {
		$this->_response->id                = @$response['transactionid'];
		$this->_response->status            = @$this->_response((int) $response['response']);
		$this->_response->authorization->id = @$response['authcode'];
	}
/**
 * Handles errors
 *
 * @param  object $response Response object
 */
	private function _handleError(&$response) {
		$this->_response->status      = 'error';
		$this->_response->error       = $response['responsetext'];

		$this->_setResponse($response);
	}
/**
 * Generates a querystring
 * @param  array  $str [description]
 * @return [type]      [description]
 */
	private function _buildString() {
		foreach($this->_request as $key => $val)
		{
			$key = urlencode($key);
			$val = urlencode($val);
			if (empty($this->nvpStr)) {
				$this->nvpStr = "$key=$val";
			} else {
				$this->nvpStr .= "&$key=$val";
			}
		}
	}

/**
 * Types of sales we can do
 */
	private function _callType($type) {
		switch ($type) {
			case 'authorize':
			case 'authorization':
				$type = 'auth';
				break;
			case 'refund':
				$type = 'refund';
				break;
			default:
				$type = 'sale';
				break;
		}
		return $type;
	}

/**
 * Converts an int response code into a string representation
 */
	private function _response($response_code) {
		switch ($response_code) {
			case APPROVED:
				return 'approved';
				break;
			case ERROR:
				return 'error';
				break;
			default:
			case DECLINED:
				return 'declined';
				break;
		}
	}


}

