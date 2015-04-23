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
App::uses('BcryptFormAuthenticate', 'Controller/Component/Auth');
/**
 * Device Model
 *
 * @property Location $Location
 */
class Device extends AppModel {

/**
 * Behaviors
 * @var array
 */
	public $actsAs = array('Containable');

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'description';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
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
		'description' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Description cannot be empty!'
			)
		),
		'timeout' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Cannot be empty!'
			),
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Must be numeric!'
			)
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'location_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function beforeFind($query = array()) {
		parent::beforeFind($query);
		if (is_array($query['fields'])) {

			if (!array_search('Device.timeout', $query['fields'])) {
				$query['fields'][] = 'Device.timeout';
				$query['fields'][] = 'Device.last_connection';
			}
		} elseif (is_string($query['fields'])) {
			$query['fields'] = array(
				$query['fields'],
				'Device.timeout',
				'Device.last_connection'
			);
		}
		return $query;
	}
/**
 * After Find
 * @param  array   $results
 * @param  boolean $primary
 * @return array
 */
	public function afterFind($results = array(), $primary = false) {
		
		foreach ($results as $key => $result) {
			if (isset($result['Device']['last_connection']) && isset($result['Device']['timeout'])) {
				$difference = strtotime(date('Y-m-d H:i:s')) - strtotime($result['Device']['last_connection']);
				$results[$key]['Device']['online'] = $this->_getStatus(
					$difference,
					$result['Device']['timeout']
				);
			} else {
				$results[$key]['Device']['online'] = FALSE;
			}
		}
		return parent::afterFind($results, $primary);
	}

/**
 * Authenticates a device and returns the location ID on success
 * @param  string $username
 * @param  string $password
 * @return string           Device record on success, false on failure
 */
	public function authenticate($username, $password) {
		$device = $this->find('first', array(
			'conditions' => array(
				'Device.username' => $username
			),
			'contain' => array(
				'Location'
			),
			'fields' => array(
				'Device.id',
				'Device.location_id',
				'Device.username',
				'Device.password',
				'Device.salt',
			),
			'recursive' => 0
		));
		if (!$device) {
			return false;
		}

		$hashed = $this->generateHash($password, $device['Device']['salt']);

		if ($device['Device']['password'] !== $hashed) {
			return false;
		}
		Configure::write('Config.language', 'fr');
		return $device;
	}

/**
 * Updates a devices last_connection field
 * @param  string $id UUID of the device
 * @return bool     true on success, false on failure
 */
	public function updateDeviceLastConnected($id) {
		$this->id = $id;

		if (!$this->exists()) {
			return false;
		}

		if ($this->saveField('last_connection', date('Y-m-d H:i:s'))) {
			return true;
		}

		return false;
	}

/**
 * Generates a password to be used as an api secret key, nothing fancy
 * just a sha1 hash of a random string
 *
 * @return string
 */
	public function generatePassword() {
		return sha1(BcryptFormAuthenticate::generateSalt());
	}

/**
 * Generates a salt
 * @return string
 */
	public function generateSalt() {
		return BcryptFormAuthenticate::generateSalt();
	}

/**
 * Generates a username
 * @return string
 */
	public function generateUsername() {
		while (true) {
			$username = String::uuid();

			$count = $this->find('count' , array(
				'conditions' => array(
					'username' => $username
				)
			));

			if ($count < 1) {
				break;
			}
		}
		return $username;
	}
/**
 * Gets the password hash
 * @param  string $password
 * @param  string $salt
 * @return string           bcrypt hash
 */
	public function generateHash($password, $salt) {
		return BcryptFormAuthenticate::hash($password, $salt);
	}

/**
 * Returns a device's status.
 * @param  string  $location_id UUID
 */
	public function getDeviceStatus($location_id) {
		if(Configure::read('printerOnline')){
			return TRUE;
		}
		$results = $this->find('all', array(
            'conditions' => array(
				'Device.location_id' => $location_id
			),
			'fields' => array(
				'Device.id')));
		
		if ($results) {
			foreach ($results as $result) {
				if ($result['Device']['online']) {
					return TRUE;
				}
			}
		}
		return FALSE;
	}

/**
 * If restaurant is open then the device should be online too.
 *
 * @param	string	$locaiton_id Location ID
 * @return	bool		         true if the restaurant is open but the device is offline
 */
	public function shouldDeviceBeOnlineAndIsNot($location_id) {
		$restaurantIsOpen     = $this->Location->Schedule->isOpenForDelivery($location_id);
        $deviceStatus         = $this->Location->Device->getDeviceStatus($location_id);
        $isLocationMenuActive = $this->Location->findById($location_id, array('Location.status'));

        if ($restaurantIsOpen && !$deviceStatus && $isLocationMenuActive['Location']['status']) {
			return true;
		}

		return false;
	}

/**
 * Decides whether a device is active, or inactive based
 * on the difference in time provided to the function
 * @param  time $difference Difference (in seconds)
 * @return bool             True if active, False if inactive
 */
	private function _getStatus($difference, $timeout = null) {
		if ($timeout === null) {
			$timeout = Configure::read('Topmenu.device_timeout');
		}
		if ($difference < $timeout) {
			return true;
		}
		return false;
	}




}
