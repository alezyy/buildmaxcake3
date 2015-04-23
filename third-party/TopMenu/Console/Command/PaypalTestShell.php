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

App::uses('Core', 'Model/ConnectionManager');
App::uses('Controller', 'Controller');
App::uses('CakeRequest', 'Network');
class PaypalTestShell extends AppShell {
	public $uses = array('Payment');

	/**
	* main function.
	*
	* @access public
	* @return void
	*/
	public function main() {

		$data =<<<EOF
{
	"credit_card":{
		"number":"4417119669820331",
		"type":"visa",
		"expire_month":1,
		"expire_year":2018,
		"cvv2":"874",
		"first_name":"Joe",
		"last_name":"Shopper"
	},
	"billing_address":{
		"line1":"52 N Main ST",
		"line2":"Apt. 211",
		"city":"Johnstown",
		"country_code":"CA",
		"postal_code":"H0H 0H0",
		"state":"Quebec"
	},
	"transaction":{
		"amount":{
			"total":"7.47",
			"currency":"USD",
			"details":{
				"subtotal":"7.41",
				"tax":"0.03",
				"shipping":"0.03"
			}
		},
		"description":"This is the payment transaction description."
	},
	"return_urls":{
		"cancel_url": "http://www.example.com",
		"return_url": "http://www.example.com"
	},
	"payer_id": "sometest"

}
EOF;




		$response = $this->Payment->creditCardPayment(json_decode($data, true), 'authorization');
		$this->out(json_encode($response) . "\n\n\n");




		$this->out(json_encode(
			$this->Payment->refundPayment(array(
				'transaction' => array(
					'id' => $response->id,
					'amount' => array(
						'total' => 0.00
					)
				)
			))
		) . "\n\n\n");



		// $capture_data = array(
		// 	'total' => 7.47,
		// 	'currency' => 'USD',
		// 	'is_final_capture' => true,
		// 	'authorization_id' => $response->transaction->authorization->id
		// );

		// $captureResponse = $this->Payment->captureAuthorization($capture_data);
		// $this->out(json_encode($captureResponse) . "\n\n\n");

		// $this->out(json_encode($this->Payment->refundPayment(array(
		// 	'payment_id' => $captureResponse->id,
		// 	'total' => '5.00',
		// 	'currency' => 'USD'
		// ), 'capture')) . "\n\n\n");

		// return true;
	}

}