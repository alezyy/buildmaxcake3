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

class PushoverSource extends DataSource
{
/**
 * description
 *
 * @var string
 * @access public
 */
	public $description = "Pushover API client";



/**
 * Http
 *
 * (default value: null)
 * SET IN database.php
 *
 * @var mixed
 * @access private
 */
	private $Http = null;



/**
 * Payload we're sending
 *
 * (default value: null)
 *
 * @var mixed
 * @access private
 */
	private $_payload = null;





/**
 * Token we use to authenticate to paypal
 * @var [type]
 */
	private $_token = null;




/**
 * Endpoint
 * @var [type]
 */
	private $api_endpoint = null;


/**
 * Response
 */
	private $_response = null;




/**
 * __construct function.
 *
 * @access public
 * @param  mixed $config
 * @return void
 */
	public function __construct($config) {
		parent::__construct($config);

		$this->Http         = new HttpSocket();
		$this->_token       = $this->config['token'];
		$this->api_endpoint = "https://api.pushover.net/1";
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
 * Send a message
 *
 * @param  string $to      ID where the message is headed (user, or group token)
 * @param  string $subject Subject of the message
 * @param  string $message The body of the message
 */
	public function sendMessage($to, $subject, $message) {
		$this->_payload['user']    = $to;
		$this->_payload['title']   = $subject;
		$this->_payload['message'] = $message;

		$this->_call('/messages.json');

		return $this->_response;
	}



/**
 * Calls the Pushover API
 */
	private function _call($endpoint) {

		if (empty($this->_token)) {
			var_dump('test');
			return false;
		}

		$end_point     = $this->api_endpoint . $endpoint;
		$body          = $this->_payload;
		$body['token'] = $this->_token;


		$this->_response = $this->Http->post($end_point, $body);

		if (!$this->_response->isOk()) {
			$this->_response = false;
		}
	}
}