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
App::uses('CouponException', 'Lib/Error/Exception');

/**
 * Coupon Model
 *
 * @property User $User
 * @property Location $Location
 */
class Coupon extends AppModel {

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'code' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
			),
			'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'required' => true,
				'message' => 'Alphabets and numbers only')),
		'one_per_user' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
			),
			'bool' => array(
				'rule' => array('boolean'),
				'message' => 'Incorrect value for myCheckbox'
			),
		),
		'amount_type' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
			),
		),
		'one_per_location' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
			),
			'bool' => array(
				'rule' => array('boolean'),
				'message' => 'Incorrect value for myCheckbox'
			),
		),
		'is_enabled' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
			),
			'bool' => array(
				'rule' => array('boolean'),
				'message' => 'Incorrect value for myCheckbox'
			),
		),
		'is_enabled' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
			),
		),
//		'location_id' => array(
//			'uuid' => array(
//				'rule' => array('uuid'),
//			),),
//		'user_id' => array(
//			'uuid' => array(
//				'rule' => array('uuid'),
//			),),
		'admin_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => 'Must not be empty!',)
			),
		),
		'end_date' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
			),
			'date' => array(
				'rule' => 'datetime',
				'message' => 'Enter a valid date',
				'allowEmpty' => true
			)
		),
		'start_date' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
			),
			'date' => array(
				'rule' => 'datetime',
				'message' => 'Enter a valid date',
				'allowEmpty' => true
			)
		),
	);

//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
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
	public $hasMany = array(
		'UsedCoupon' => array(
			'className' => 'UsedCoupon',
			'foreignKey' => 'coupon_id'),
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'coupon_code'
		));
	
	public $displayField = 'code';
	
	/**
	* Construct -- Build our virtual fields, and set the display name based
	* on language
	*
	*/
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->virtualFields['description'] = 'Coupon.description_' . $this->langSuffix;
		$this->virtualFields['description'] = 'Coupon.name_' . $this->langSuffix;
	}

	/**
	 * Applies a given coupon to a given order.
	 * <ul>
	 * <li>Check if coupon is applicable</li>
	 * <li>Calculate the total after rebate</li>
	 * <li>Insert the event usage in the used coupon database</li>
	 * <li>Update the coupon status</li>
	 * <li>Calls the createRebateInvoice which is the negetive order for accounting purposes</li>
	 * </ul>
	 * 
	 * @param	array 	$order 		Order's data on which the coupon is applied
	 * @param	string 	$couponCode The coupon's code 
	 * @param	string 	$userId		The user's Id although it might not be useful we still add it to the db
	 * @param	string  $id			Id of the coupon to instantiate. If set to null assume the coupon is already instantiated
	 * @return	boolean True if coupons is accepted and correctly applied to the order.<br/>
	 * 					False otherwise
	 */
	public function applyCouponToOrder($order, $couponCode = NULL, $id = NULL) {

		// Instatiate the coupon
		$this->_loadCoupon($id, $couponCode);
		
		// Validate order data
		if (empty($order)) {
			throw new CouponException(__('Please create an order before using the coupon'));
		}
		if (empty($order['Order']['Order']['user_id'])) {
			throw new CouponException(__('Please login to use your coupon'));
		}

		// CHECK IF COUPON IS APPLICABLE		
		if($this->_isValid()){
			
		}
			
	}

	/**
	 * Checks if the given coupon is in effect for at least one usage. Can it currently be use by a user.<br/>
	 * If the coupon is in effect for only one user or only one restaurant this will return true 
	 * 
	 * @param string id of the coupon to instantiate. If set to null assume the coupon is already instantiated
	 * @return boolean 
	 * @todo unit test
	 */
	public function isInEffect($id = NULL) {

		// Instantiate the coupon if needed
		$this->_loadCoupon($id);

		// Coupon is set has disabled
		if (!$this->data['Coupon']['is_enabled']) {
			throw new CouponException(__('Coupon is not in effect'));
		}

		// Time range of coupon
		$now = time();
		$start = strtotime($this->data['Coupon']['start_date']);
		$end = strtotime($this->data['Coupon']['end_date']);

		if ($start === $end) {
			throw new Exception(__('Invalid date range given for coupon'));
		}

		if ($start > $end) {
			throw new Exception(__('Invalid date range given for coupon'));
		}
		if ($start > $now) {
			throw new CouponException(__('Coupon is not in effect'));
		}
		if ($end < $now) {
			throw new CouponException(__('Coupon is expired'));
		}

		// Any coupon left
		if (is_numeric($this->data['Coupon']['max_usage'])) {
			
			// get total usage for this coupon
			$maxUsageCount = $this->UsedCoupon->find('count', array(
				'conditions' => array(
					'UsedCoupon.coupon_id' => $this->data['Coupon']['id'])));			
			if ($this->data['Coupon']['max_usage'] <= $maxUsageCount ) {
				throw new CouponException(__('Coupon is no longer in effect.'));
			}
		}

		return TRUE;
	}

	/**
	 * Is this coupon valid for this user <br>
	 * <b>This does take in consideration the specific user conditions</b>
	 * @param type $data
	 * @param type $userId
	 * @return boolean
	 * @throws CouponException
	 */
	private function _maxUsageByUser($userId) {

		if ($this->data['Coupon']['max_usage_by_user'] !== NULL) {
			$userUsage = $this->UsedCoupon->find('count', array(
				'conditions' => array(
					'UsedCoupon.user_id' => $userId,
					'UsedCoupon.coupon_id' => $this->data['Coupon']['id']
					)
			));

			if ($this->data['Coupon']['max_usage_by_user'] === 0) {
				throw new CouponException(__('Coupon is not in effect'));
			}

			if ($userUsage >= $this->data['Coupon']['max_usage_by_user']) {
				throw new CouponException(__('You have already used this coupon'));
			}
		}

		return TRUE;
	}

	/**
	 * Is this coupon valid for this restaurant
	 * @param type $data
	 * @param type $locationId
	 * @return boolean
	 */
	private function _validForRestaurant($locationId) {
		
		if(!empty($this->data['Coupon']['location_id']) && $locationId != $this->data['Coupon']['location_id']){
			throw new CouponException(__('This coupon is not available for this restaurant'));			
		}
		
		if ($this->data['Coupon']['max_usage_by_restaurant'] !== NULL) {
			$locationUsage = $this->UsedCoupon->find('count', array(
				'condition' => array('UsedCoupon.location_id' => $locationId)
			));

			if ($locationUsage >= $this->data['Coupon']['max_usage_by_restaurant']) {
				throw new CouponException(__('This coupon is no longer valid'));
			}
		}

		return TRUE;
	}		

	/**
	 * Check if the current user can use the current coupon
	 * 
	 * @param string $userId
	 * @param string $locationId
	 * @param string $code coupon's code
	 * @param string id of the coupon to instantiate. If set to null assume the coupon is already instantiated
	 * @return boolean True if valid
	 * @throws CouponException Throws a validation with an tranlatable message descriving the rejection reason
	 */
	public function isValid($userId, $locationId, $couponCode = NULL, $id = NULL) {

		// Instatiate the coupon
		$this->_loadCoupon($id, $couponCode);

		// Check if coupon is valid
		if(empty($this->data)){
			throw new CouponException(__('This coupon does not exist'), 1395947523); // this error code is use to by checkout page
		}
		$this->isInEffect();
		$this->_validForRestaurant($locationId);
		$this->isValidForUser($userId);

		return TRUE;
	}

	/**
	 * Is this coupon limited to one per user?
	 * @param string $locationId
	 * @param string id of the coupon to instantiate. If set to null assume the coupon is already instantiated
	 * @return boolean True on sucess or through a ValidationError if validation fails
	 * @throws CouponException Throws a validation with an tranlatable message descriving the rejection reason
	 */
	public function isValidForUser($userId, $id = NULL) {
		$this->_loadCoupon($id);
		
		// Specific user conditions
		if (!empty($this->data['Coupon']['user_id'])) {
			if ($this->data['Coupon']['user_id'] !== $userId) {
				throw new CouponException(__('You may not use this coupon'));
			}
		}

		// Max usage by user conditions
		$this->_maxUsageByUser($userId);

		return true;
	}

	/**
	 * Loads the model with an coupon from the database if an ID is provided
	 * @param string $id
	 * @return boolean Return true if the coupon was instatiated by this method<br/>
	 * Returns false if the coupon was not instantiate by this method. The coupon may or may not be instantiated
	 * 
	 */
	private function _loadCouponById($id) {
		if ($id != NULL) {
			$this->read(null, $id);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * Loads the model with an coupon from the database if an ID is provided
	 * @param string $couponCode string given to coupon to be use as nice looking id
	 * @param string $id
	 * @return boolean Return true if the coupon was instatiated by this method<br/>
	 * Returns false if the coupon was not instantiate by this method. The coupon may or may not be instantiated
	 * 
	 */
	private function _loadCoupon($id = NULL, $couponCode = NULL) {
		if ($couponCode !== NULL) {
			
			$couponCode = strtoupper(trim($couponCode));
			$coupon = $this->findByCode($couponCode);
			
			if(!empty($coupon)){
				$this->read(null, $coupon['Coupon']['id']);
			}else{
				throw new CouponException(__('This coupon does not exist'), 1395947523); // this error code is use to by checkout page
			}
			
		} elseif ($id !== NULL) {
			if(!$this->_loadCouponById($id)){
				throw new Exception('No record identification was given to populate the Coupon model');				
			}				
		}
	}
}
	