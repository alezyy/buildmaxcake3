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
App::uses('HttpSocket', 'Network/Http');
App::uses('ValidationException', 'Lib/Error/Exception');

/**
 * EvoCanadaSource class.
 *
 * @extends DataSource
 */
class OrbitalGatewaySource extends DataSource {

	/**
	 * description
	 *
	 * (default value: "EvoCanada direct payment API")
	 *
	 * @var string
	 * @access public
	 */
	public $description = "Chase's Orbital Gateway API";

	/**
	 * Proc Status is the the response code given by chase 0 means transaction accepted, other codes are error messages
	 * @var string Proc Status Code
	 */
	const PROC_STATUS_ACCEPTED = '0';

	/**
	 * <b>Approval Status</b>
	 * Conditional on Process Status returning a 0 (or successful) response. 
	 * If so, the Approval Status identifies the result of the authorization request to the host system:
	 * <ul>
	 * <li>0 Declined</li>
	 * <li>1 Approved</li>
	 * <li>2 Message/System Error</li>
	 * </ul>
	 * @var string Approval Status
	 */
	const APPROVAL_STATUS_ACCEPTED = '1';
		
	/**
	* CVV Approve status
	*/
	const CVV_STATUS_ACCEPTED = 'M';
	
	/**
	 * AVS Respond Code considered as valid	 
	 * @var array 
	 */
	private $avsStatusAcceptedArray = array(
		'9',	// Zip Match/Zip4 Match/Locale match
		'A',	// Zip Match/Zip 4 Match/Locale no match
		'B',	// Zip Match/Zip 4 no Match/Locale match
		'C',	// Zip Match/Zip 4 no Match/Locale no match
		'F',	// Zip No Match/Zip 4 No Match/Locale match
		'H',	// Zip Match/Locale match
		'M2',	// Cardholder name, billing address, and postal code matches
		'M3',	// Cardholder name and billing code matches
		'M4',	// Cardholder name and billing address match
		'M5',	// Cardholder name incorrect, billing address and postal code match
		'M6',	// Cardholder name incorrect, billing postal code matches
		'M7',	// Cardholder name incorrect, billing address matches
		'N5',	// Address and ZIP code match (International only)
		'N8',	// Address and ZIP code match (International only)'
		'X',	// Zip Match/Zip 4 Match/Address Match
		'Z',	// Zip Match/Locale no match
	);
	
	/**
	 *  Field [Address verification service address] cannot exceed max length of [30] 
	 * @var int MAX_CHAR_ADDRESS
	 */
	const MAX_CHAR_ADDRESS = 29;

	/**
	 * Electronic Commerce Indicator  _checkAVSRespCode($responseXml, &$response) (ECI)<br/>
	 * The Electronic Commerce Indicator (ECI) indicates the level of security used when the cardholder provided payment information to the merchant. It must be set to a value corresponding to the authentication results and the characteristics of the merchant checkout process. The merchant commerce server transmits the authorization request message, including the ECI, to the acquirer or its processor.<br/>
	 * Possible ECI data values are: <ul>
	 * <li>ECI = 5: This value means that the cardholder was authenticated by the issuer by verifying the cardholder’s password or identity information. The value is returned by the ACS in the Payer Authentication Response message when the cardholder successfully passed 3-D Secure payment authentication.</li>
	 * <li>ECI = 6: This value means that the merchant attempted to authenticate the cardholder, but either the cardholder or issuer was not participating. The value should be returned by the ACS in the Authentication Response message for an Attempt Response. Additionally, merchants may use an ECI 6 in the authorization request when a Verify Enrollment of N is received from the Visa Directory Server.</li>
	 * <li>ECI = 7: This value is set by the merchant when the payment transaction was conducted over a secure channel (for example, SSL/TLS), but payment authentication was not performed, or when the issuer responded that authentication could not be performed. An ECI 7 applies when either the Verify Enrollment or the Payer Authentication Response contains a U for Unable to Authenticate.</li></ul>
	 * <i> - Verified by Visa and MasterCard SecureCode Guide</i>
	 * 
	 * @var string ECI
	 */
	const ECI = '5';

	/**
	 * XML Document Info element
	 * @var string XML_DOC_TYPE
	 */
	const XML_DOC_TYPE = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><Request></Request>";

	/**
	 * Create our HttpSocket and handle any config tweaks.
	 */
	public function __construct($config) {
		parent::__construct($config);

		$this->_userName = $this->config['username'];
		$this->_password = $this->config['password'];
               // $this->_PxPayUserId= $this->config['PxPayUserId']);
              //  $this->_newOrderNode->addChild('PxPayKey', $this->config['PxPayKey']);

		// Cake's example from doc
		$this->Http = new HttpSocket();
	}

	/**
	 * info function.
	 *
	 * Returns info about this datasource
	 * @access public
	 * @return void
	 */
	public function info() {
		return $this->description;
	}

	/**
	 * calculate() is for determining how we will count the records and is
	 * required to get ``update()`` and ``delete()`` to work.
	 *
	 * We don't count the records here but return a string to be passed to
	 * ``read()`` which will do the actual counting. The easiest way is to just
	 * return the string 'COUNT' and check for it in ``read()`` where
	 * ``$data['fields'] === 'COUNT'``.
	 */
	public function calculate(Model $model, $func, $params = array()) {
		return 'COUNT'; //TODO
	}

	/**
	 * Response object
	 * @var HttpSocketResponse
	 */
	private $_response;

	/**
	 * Request data
	 * @var SimpleXMLElement
	 */
	private $_requestData	 = null;
	private $_newOrderNode	 = null;

	/**
	 * Response data
	 * @var SimpleXMLElement
	 */
	private $_responseData = null;

	/**
	 * Language to use with end user
	 * @var string
	 */
	private $_language = "fr";

	/**
	 * This takes all the values in the calling model schema and transforms it into a correct Orbital Gateway xml request
	 * @param array $data Order data given by model
	 * @param string $industryType "A" for authorisation, "AC" for capture ....
	 * @return string the xml string
	 * 
	 */
	private function _arrayToXmlOrder($data, $industryType = null) {

		// Default data
		// If the datasource config array as a value that not overwritten in $data add this value to $data
		if (!empty($this->config['optinal_values'])) {
			foreach ($this->config['optional_values'] as $ovk => $ovv) {
				if (!array_key_exists($ovk)) {
					$data[$ovk] = $ovv;
				}
			}
		}

		$this->_requestData	 = new SimpleXMLElement(self::XML_DOC_TYPE);
		$this->_newOrderNode = $this->_requestData->addChild('NewOrder');
		$this->_newOrderNode->addChild('OrbitalConnectionUsername', $this->config['username']);
		$this->_newOrderNode->addChild('OrbitalConnectionPassword', $this->config['password']);
                $this->_newOrderNode->addChild('PxPayUserId', $this->config['PxPayUserId']);
                $this->_newOrderNode->addChild('PxPayKey', $this->config['PxPayKey']);

		// Transaction data        
		$this->_newOrderNode->addChild('IndustryType', ($industryType === null) ? $this->config['IndustryType'] : $industryType);
		$this->_newOrderNode->addChild('MessageType', $data['MessageType']);
		$this->_newOrderNode->addChild('BIN', $this->config['BIN']);
		$this->_newOrderNode->addChild('MerchantID', $this->config['optional_values']['MerchantId']);
		$this->_newOrderNode->addChild('TerminalID', $this->config['optional_values']['TerminalId']);

		// Card data
		$this->_newOrderNode->addChild('AccountNum', $this->_parseCreditCardNumber($data['credit_card']['number']));  // Credit Card Number
		$this->_newOrderNode->addChild('Exp', $this->_parseExpirationDate($data));  // Credit Card expiration date
		//
        // Currency
		$this->_newOrderNode->addChild('CurrencyCode', $this->config['optional_values']['CurrencyCode']);
		$this->_newOrderNode->addChild('CurrencyExponent', $this->config['optional_values']['CurrencyExp']);

		// Card security data 
		$this->_newOrderNode->addChild('CardSecValInd', $this->_setCardSecValInd($data['credit_card']['number']));   // check CVV ?
		$this->_newOrderNode->addChild('CardSecVal', $data['credit_card']['cvv2']);   // CVV value
		$this->_newOrderNode->addChild('AVSzip', $this->_parsePostalCode($data['billing_address']['postal_code']));  // Credit Card Number
		$this->_newOrderNode->addChild('AVSaddress1', substr($data['billing_address']['line1'], 0, self::MAX_CHAR_ADDRESS));   // Credit Card Number
		if (!empty($data['AVSaddress2'])) {
			$this->_newOrderNode->addChild('AVSaddress2', substr($data['billing_address']['line2'], 0, self::MAX_CHAR_ADDRESS));
		}
		$this->_newOrderNode->addChild('AVScity', $data['billing_address']['city']);  // Credit Card Number
		$this->_newOrderNode->addChild('AVSstate', $this->_tmpReturnQuebecString($data['billing_address']['state']));   // Credit Card Number
		$this->_newOrderNode->addChild('AVSphoneNum', $this->_parsePhoneNumber($data['billing_address']['phone'])); // Credit Card Number        
//		// Secured By Visa and MasterCard SecureCode
//		$this->_newOrderNode->addChild('AuthenticationECIInd', self::ECI);
//		
		// Order data
		$this->_hasOrderId($data['OrderID']);
		$this->_newOrderNode->addChild('OrderID', $data['OrderID']);
		$this->_newOrderNode->addChild('Amount', $this->_parseAmount($data['transaction']['amount']['total']));

		return $this->_requestData->asXML();
	}

	/**
	 * This takes all the values in the calling model schema and transforms it into a correct Orbital Gateway xml request
	 * @param array $data Order data given by model
	 * @param string $industryType "A" for authorisation, "AC" for capture ....
	 * @return string the xml string
	 * 
	 */
	private function _arrayToXmlCapture($orderId, $transactionId, $amount) {

		// Default data
		// If the datasource config array as a value that not overwritten in $data add this value to $data
		if (!empty($this->config['optional_values'])) {
			foreach ($this->config['optional_values'] as $ovk => $ovv) {
				if (!array_key_exists($ovk, $this->config['optional_values'])) {
					$data[$ovk] = $ovv;
				}
			}
		}

		// Build xml object
		$this->_requestData	 = new SimpleXMLElement(self::XML_DOC_TYPE);
		$markForCapture		 = $this->_requestData->addChild('MarkForCapture');
		$markForCapture->addChild('OrbitalConnectionUsername', $this->config['username']);
		$markForCapture->addChild('OrbitalConnectionPassword', $this->config['password']);

		$this->_hasOrderId($orderId);
		$markForCapture->addChild('OrderID', $orderId);
		$markForCapture->addChild('Amount', $this->_parseAmount($amount));

		$markForCapture->addChild('BIN', $this->config['BIN']);
		$markForCapture->addChild('MerchantID', $this->config['optional_values']['MerchantId']);
		$markForCapture->addChild('TerminalID', $this->config['optional_values']['TerminalId']);
		$markForCapture->addChild('TxRefNum', $transactionId);
		return $this->_requestData->asXML();
	}

	/**
	 * Post an order to the Orbital Gateway, handle any connection problems and set the response in the _response 
	 * property and the response body in the _responseData property
	 * @return boolean true only if respond code is 200
	 */
	private function _getResposne() {


		$HttpSocket	 = new HttpSocket(array('ssl_verify_peer' => false));
		$options	 = array(
			'header' => array(
				'MIME-Version'				 => '1.0',
				'Content-Type'				 => 'application/PTI62',
				'Content-transfer-encoding'	 => 'text',
				'Request-number'			 => '1',
				'Document-type'				 => 'Request',
			)
		);

		// First attempt			
		$this->_response = $HttpSocket->post($this->config["primaryCertificationAddress"], $this->_requestData->asXML(), $options); // post to the primary address        
		if ($this->_response->isOk()) {
			return true;
		}

		// Second attempt (on Chase's secondary URL)
		$this->_response = $HttpSocket->post($this->config["secondaryCertificationAddress"], $this->_requestData->asXML(), $options); // post to the primary address 			
		if ($this->_response->isOk()) {
			return true;
		}

		$this->log('Failed to connect for payment. Error code: 1414268202');
		$this->log($this->_response);
		throw new Exception(__("Failed to connect for payment. Error code: %s", array("1414268202")));
	}

	/**
	 * Get an authorization to captute money from the creditcard
	 * @param array $request
	 * @param array $language User's prefered language for communications
	 * @return array the useful information from the resposne  
	 */
	public function requestAuthorization($request, $orderid, $language = 'fr') {

		// Prepare data
		$request['MessageType']	 = 'A';  // Set transaction as Authorization only
		$request['OrderID']		 = $orderid;  // Set transaction as Authorization only
		$this->_setLanguageCode($language);
		$xmlResquest			 = $this->_arrayToXmlOrder($request); //TODO use $this->addRequestAuthentificationNodes($reversal) instead of arraToxmlAuthorization
		// Send data to gateway
		$this->_getResposne();
		$result					 = $this->_parseResponse($language);
		$result['amount']		 = $request['transaction']['amount']['total']; // this is float number
		$result['xml_request']	 = $xmlResquest;

		// prepare response to controller
				return $this->_simpleXml2Aray($result);
	}

	/**
	 * Capture an order already authorized
	 * 
	 * @param string $orderId
	 * @param string $transactionId
	 * @param int $amount
	 * @param string $language
	 * @return type
	 */
	public function captureAuthorization($orderId, $transactionId, $amount, $language = 'fr') {

		$xmlResquest = $this->_arrayToXmlCapture($orderId, $transactionId, $amount);

		$this->_getResposne();

		$result					 = $this->_parseResponse($language);
		$result['xml_request']	 = $xmlResquest;
		$result['amount']		 = $result['amount'] / 100; // convert back to decimal ($$.¢¢) format

						return $this->_simpleXml2Aray($result);
	}

	/**
	 * Void a transaction that was authorize but not capture.
	 * @param string $orderId
	 * @param string $transactionId
	 * @param int $amount
	 * @return type
	 */
	public function voidAuthorization($orderId, $transactionId, $amount = NULL, $language = 'fr') {

		// Build xml object
		$this->_requestData	 = new SimpleXMLElement(self::XML_DOC_TYPE); // First node
		$reversal			 = $this->_requestData->addChild('Reversal'); // Transaction Type specific parent node
		// Authentification
		$reversal->addChild('OrbitalConnectionUsername', $this->config['username']);
		$reversal->addChild('OrbitalConnectionPassword', $this->config['password']);

		// Void data		
		$reversal->addChild('TxRefNum', $transactionId);
		$reversal->addChild('TxRefIdx');
		$this->_hasOrderId($orderId);
		$reversal->addChild('OrderID', $orderId);
		if ($amount != NULL) {
			$reversal->addChild('AdjustedAmt', $amount);
		}
		$reversal->addChild('BIN', $this->config['BIN']);
		$reversal->addChild('MerchantID', $this->config['optional_values']['MerchantId']);
		$reversal->addChild('TerminalID', $this->config['optional_values']['TerminalId']);

		// Get response
		$this->_getResposne();
		$result					 = $this->_parseResponse($language);
		$result['xml_request']	 = $this->_requestData->asXML();

						return $this->_simpleXml2Aray($result);
	}

	/**
	 * Takes the expiration date in the posted data from the the payment form and parse it in the right format for the gateway
	 * 
	 * @param array $request request data comming from the form
	 * @return string Return the year date in the MMYY format or 0000 to signify the absence of expiration date
	 * @throws UnexpectedValueException if the values given can not produce a valid date
	 */
	private function _parseExpirationDate($request) {

		$year	 = $request['credit_card']['expire_year']['year']; //TODO before 2100, pad the year        
		$month	 = str_pad($request['credit_card']['expire_month'], 2, '0', STR_PAD_LEFT);

		// make sure that the month and year are express as numeric strings
		if (!preg_match("/(^[0-9]{2}$)|(^[0-9]{4}$)/", $year) || !preg_match("/(^[0-9]$)|(^[0-9]{2}$)/", $month)) {
			throw new UnexpectedValueException("Month and year must be numeric values");
		}

		// Handle the absence of null expiration dates
		if (empty($request['credit_card']['expire_year']) && empty($request['credit_card']['expire_month'])) {
			return '0000';
		} elseif (empty($request['credit_card']['expire_year']) || empty($request['credit_card']['expire_month'])) { // at this point we know that at least one of the fields is not empty
			throw new UnexpectedValueException("Year and month values must both be empty or both be not empty");
		}

		// Convert for digit year to 2 digit
		if (strlen($year) > 2) {
			$year = substr($year, 2);
		}

		// Zero field mont
		$month = str_pad($month, 2, '0', STR_PAD_LEFT);

		// Concatenate and return 
		return $month . $year;
	}

	/**
	 * Check if the language code given in the request is valid and sets it.
	 * @param String $language Language ISO code (2 characters)
	 * @throws InvalidArgumentException
	 */
	private function _setLanguageCode($language) {
		if (strlen($language) !== 2) {
			throw new InvalidArgumentException("Language argument must be a 2 character iso language code.");
		}

		$this->_language = strtolower($language);
	}

	/**
	 * Get the Chase Response and transform it into what the controllers are expecting
	 * @return array Response data formated for the order and payment controllers
	 */
	private function _parseResponse($language) {

		$responseXml	 = new SimpleXMLElement($this->_response->body());
		$response		 = array();
		$errorMessage	 = array(); // Store different error message
		$stillValid		 = true;	// response status flag

		// Chase response have different root name's depending of the type of message they are sending		
		$rootChidrens	 = $responseXml->children();
		$rootNode		 = $rootChidrens[0];

		if ($rootNode->getName() === 'NewOrderResp') {
			// Check the CVV Field is correct
			if ($this->_checkCVVRespCode($rootNode, $response)) {
				$errorMessage[]	 = $response['error'];
				$stillValid		 = false;
			}

			// Check the AVS Field is valid
			if (!$this->_checkAVSRespCode($rootNode, $response)) {
				$errorMessage[]	 = $response['error'];
				$stillValid		 = false;
			}
		}
		
		// Convert Chase's response into something expected by the Payment Model
		if ((string) $rootNode->ProcStatus == self::PROC_STATUS_ACCEPTED &&
			(string) $rootNode->ApprovalStatus == self::APPROVAL_STATUS_ACCEPTED &&
			$stillValid) {
			$response['status']	 = 'approved';
			$response['error']	 = 'approved';
			$response['id']		 = (string) $rootNode->TxRefNum;
		} else {
			$errorMessage[]		 = empty($rootNode->RespMsg) ? (string) $rootNode->StatusMsg : (string) $rootNode->RespMsg;
			$response['status']	 = 'rejected: ' . (string) $rootNode->ProcStatus; // give error code with status
			$response['error']	 = implode(';', $errorMessage);
			$response['id']		 = empty($rootNode->TxRefNum) ? __("No message provided") : (string) $rootNode->TxRefNum;
		}

		$response['order_id']		 = $rootNode->OrderID;
		$response['code']			 = empty($rootNode->RespCode) ? " - " : $rootNode->RespCode;
		$response['amount']			 = empty($rootNode->Amount) ? null : $rootNode->Amount;
		$response['xml_response']	 = $responseXml->asXML();

		return $response;
	}

	/**
	* Checks, in the response, if the CVV Response Code is a positive one (CVV Matches)
	* @param SimpleXMLElement $responseXml Response's xml response
	* @param String[] &$response The result array returned by _parseREsponse
	* @return boolean If the the CVV response code is positive
	*/
	private function _checkCVVRespCode($responseXml, &$response){
	
		$cvvRespCode = (string)$responseXml->CVV2RespCode;
		$cvvRespCode = trim($cvvRespCode);
		
		if ( !empty($cvvRespCode) && $cvvRespCode != self::CVV_STATUS_ACCEPTED) { // CVV Matches?
			
			// Edit the response array
			$response['status']	 = 'validation_error';
			$response['error']	 = 'CVV2RespCode';
			$response['id']		 = empty($responseXml->TxRefNum) ? __("No message provided") : (string) $responseXml->TxRefNum;
			
			return true;
		}
		
		return false;
		
	}
	
	/**
	 * Checks if the AVS code (address and name on card) given in the responseis an approbation or a rejection.
	 * @param SimpleXMLElement $responseXml Response's xml response
	 * @param String[] &$response The result array returned by _parseREsponse
	 * @return boolean AVS is valid?
	 */
	private function _checkAVSRespCode($responseXml, &$response) {

		$avsRespCode = (string)($responseXml->AVSRespCode);
		$avsRespCode = trim($avsRespCode);

		if (in_array($avsRespCode, $this->avsStatusAcceptedArray)) {
			return true;
		} else {

			// Edit the response array
			$response['status']	 = 'validation_error';
			$response['error']	 = 'AVSRespCode';
			$response['id']		 = empty($responseXml->TxRefNum) ? __("No message provided") : (string) $responseXml->TxRefNum;

			// Execute some action weither this was a approbation or a capture
			$this->_isThisFailureOnCaptureTransaction($responseXml);

			// Invalid
			return false;
		}
	}

	/**
	 * Check if we have an order id
	 * 
	 * @param string $id order id 
	 * @throws Exception
	 */
	private function _hasOrderId($id) {
		if (empty($id)) {
			throw new Exception(__('Order ID is required in the payment gateway New Order Request'));
		}
	}

	/**
	 * Parse the Postal code to fit Chase's expected format
	 * @param string $postalCode
	 * @return string
	 */
	private function _parsePostalCode($postalCode) {
		$postalCode	 = preg_replace("/[^A-Za-z0-9]/", '', $postalCode);
		$pc1		 = substr($postalCode, 0, 3);
		$pc2		 = substr($postalCode, 3, 3);
		return $pc1 . " " . $pc2;
	}

	/**
	 * Chase does not want decima amount they only accepte integer. Change decimal amount value into an integer
	 * @param double $amount
	 * @return int amount
	 */
	private function _parseAmount($amount) {
		return $amount * 100;
	}

	/**
	 * Parse phone number to fit Chase's expected format. 
	 * Cardholder Billing Phone Number:
	 * <ul>
	 * 	<li>AAAEEENNNNXXXX, where</li>
	 * 	<li>AAA = Area Code</li>
	 * 	<li>EEE = Exchange</li>
	 * 	<li>NNNN = Number</li>
	 * 	<li>XXXX = Extension</li>
	 * </ul>
	 * 
	 * @string $phonephone number
	 * @return string parse phone number
	 */
	private function _parsePhoneNumber($phone) {
		$phone = preg_replace("/[^0-9]/", '', $phone);
		return $phone;
	}

	/**
	 * At the moment the gui provide to users does not allow them to enter there province or country so 
	 * everything is set to "Quebec". This method just returns "QC". A real parsing function should replace this
	 * but fuck that! I'm not paid enough to keep this job. You do it. 
	 * I'm gone have fun
	 * 
	 * 
	 * @param null $dummyArgument	just putting an argument to simulate the signature the future method should have
	 * @returns string 
	 * @todo this is bad !!!!!!!!!!!!!!!!!!!!!!!!!!
	 */
	private function _tmpReturnQuebecString($dummyArgument) {
		return "QC";
	}

	/**
	 * Parse the Credit card number from the request to match Chase's expected format (numbers only)
	 * @param string $creditCard Credit Card number
	 * @return string Credit Card number
	 */
	private function _parseCreditCardNumber($creditCard) {
		return preg_replace("/[^0-9]/", '', $creditCard);
	}
	
	/**
	* Detects the vendor (Visa, Mastercard....) of the credit card from it's number
	* @param string Credit Card Number
	* @return string Vendor's lower case 4 character code <i>ex: American Express => amex</i>
	*/
	private function _getCreditCardVendor($ccNumber){
		
		// the first number of the card represents a vendor
		$firstNumber = substr($ccNumber, 0, 1);
		switch ($firstNumber) {
			case '3': 
				return 'amex'; // American express
			
			case '4':
				return 'visa'; // Visa
			
			case '5':
				return 'mast'; // MasterCard
				
			case '6':
				return 'disc'; // Discovery
				
			default:
				throw New Exception ("Invalid card number. Could not identify card vendor");
			
		}
	}
	
	/**
	* This parse the value that goes into "CardSecValInd" according to the credit card vendor
	* @param string Credit Card Number
	* @return string Value to be inserted in the "CardSecValInd" field
	*/
	private function _setCardSecValInd($ccNumber){
		$vendor = $this->_getCreditCardVendor($ccNumber);
		switch ($vendor) {
			case 'visa':
				return '1';
			case 'mast':
				return 'Null';
			default:
				throw New Exception ("Card vendor unsupported");				
		}
	}

	/**
	 * Check if the rejection message was on a capture. If so an email is sent to admins
	 */
	private function _isThisFailureOnCaptureTransaction(SimpleXMLElement $response) {

		if (!empty($responseXml->NewOrderResp->markForCapture)) {

			// We have a capture response here send email
			$xmlResponse			 = $response->asXML();
			$xmlResponse			 = preg_replace("/<OrbitalConnectionPassword>.*</OrbitalConnectionPassword>/i", "<OrbitalConnectionPassword>***</OrbitalConnectionPassword>", $response['xml_response']);
			$xmlResponse			 = preg_replace("/<AccountNum>.*<\/AccountNum>/i", "<AccountNum>***</AccountNum>", $xmlResponse);
			$xmlResponse			 = preg_replace("/<MerchantID>.*<\/MerchantID>/i", "<MerchantID>***</MerchantID>", $xmlResponse);
			$dom					 = new DOMDocument("1.0");
			$dom->preserveWhiteSpace = false;
			$dom->formatOutput		 = true;

			$body = __("A capture transaction attempt was rejected by Chase\n\n");
			$body .= "Chase response:\n";
			$body .= "---------------\n";
			$body .= $dom->loadXML($xmlResponse->asXML());

			mail(Configure::read('Topmenu.support_email'), __("Failed Money Capture"), $body);
		}
	}
	
	/**
	 * Converts a simpleXmlElement object into an array containing no objects
	 * @param SimpleXMLElement $simpleXml
	 * @return array Pur array representaion or simpleXmlElement objec
	 */
	private function _simpleXml2Aray($simpleXml) {
		$json	 = json_encode($simpleXml);
		return json_decode($json, TRUE);
	}

}
