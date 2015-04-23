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
App::uses('ValidationException', 'Lib/Error/Exception');
App::uses('WarningException', 'Lib/Error/Exception');
App::import('Component', 'SessionComponent');

/**
 * Log Model
 *
 */
class TransactionLog extends AppModel {

	public $actsAs = array(
		'Containable',
		'Elasticsearch.Searchable' => array(
			'index_find_params' => array(
				'fields'	 => array(
					'id',
					'user_id',
					'order_id',
					'location_id',
					'message',
					'code',
					'status',
					'created'),
				'contain'	 => array(
					'Order'		 => array(
						'fields' => array(
							'id',
							'total',
							'overall_status')),
					'Location'	 => array(
						'fields' => array(
							'id',
							'name')),
					'User'		 => array(
						'fields' => array(
							'id',
							'email'))))));


	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Order'		 => array(
			'className'	 => 'Order',
			'foreignKey' => 'order_id'),
		'Location'	 => array(
			'className'	 => 'Location',
			'foreignKey' => 'location_id'),
		'User'		 => array(
			'className'	 => 'User',
			'foreignKey' => 'user_id'));

	/**
	 * Save the transaction
	 * 
	 * @param Object $response		Gateway's response
	 * @param String $userId		User ID
	 * @param String $orderId		Order ID
	 * @param String $locationId	Location ID
	 * @param Array  $avsData		Billing address form the session
	 * @return Boolean				Save is sucessful or not
	 */
	public function logTransaction($response, $userId, $orderId, $locationId) {

		$data									 = array();
		$data['TransactionLog']['number']		 = (empty($response['id'])) ? 'error' : $response['id'];
		$data['TransactionLog']['user_id']		 = $userId;
		$data['TransactionLog']['order_id']		 = $orderId;
		$data['TransactionLog']['location_id']	 = $locationId;
		$data['TransactionLog']['status']		 = $response['status'];
		$data['TransactionLog']['amount']		 = $response['amount'];

		// Hide passwords
		$xmlRequest								 = preg_replace("/<OrbitalConnectionPassword>.*<\/OrbitalConnectionPassword>/i", "<OrbitalConnectionPassword>***</OrbitalConnectionPassword>", $response['xml_request']);	// our passowrd for chase
		$xmlRequest								 = preg_replace("/<AccountNum>.*<\/AccountNum>/i", "<AccountNum>***</AccountNum>", $xmlRequest);	// Credit card number
		$xmlRequest								 = preg_replace("/<MerchantID>.*<\/MerchantID>/i", "<MerchantID>***</MerchantID>", $xmlRequest);	// Our user for Chase
		$xmlRequest								 = preg_replace("/<CardSecVal>.*<\/CardSecVal>/i", "<CardSecVal>***</CardSecVal>", $xmlRequest);		// CVV Number
		$xmlResponse							 = preg_replace("/<OrbitalConnectionPassword>.*<\/OrbitalConnectionPassword>/i", "<OrbitalConnectionPassword>***</OrbitalConnectionPassword>", $response['xml_response']);
		$xmlResponse							 = preg_replace("/<AccountNum>.*<\/AccountNum>/i", "<AccountNum>***</AccountNum>", $xmlResponse);
		$xmlResponse							 = preg_replace("/<MerchantID>.*<\/MerchantID>/i", "<MerchantID>***</MerchantID>", $xmlResponse);
		
		
		$data['TransactionLog']['xml_request']	 = $xmlRequest;
		$data['TransactionLog']['xml_response']	 = $xmlResponse;

		if ($response['status'] == 'approved') {
			$data['TransactionLog']['code']		 = is_array($response['code']) ? (empty($response['code'][0]) ? '' : $response['error'][0]) : ($response['error']); // LOL I'm bad (actually lazy)
			$data['TransactionLog']['message']	 = 'approved';
		} else {
			
			$data['TransactionLog']['message']	 = is_array($response['error']) ? (empty($response['error'][0]) ? '' : $response['error'][0]) : ($response['error']); // LOL I'm bad (actually lazy)
			$data['TransactionLog']['code']		 = (empty($response['status']) ? 'ERROR' : $response['status'] );
		}

		$this->create();
				$result = $this->save($data);

		if (!$this->validates()) {
			throw new ValidationException(serialize($this->validationErrors));
		}


		return (!empty($result)) ? true : false;
	}

}
