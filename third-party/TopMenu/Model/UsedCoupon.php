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

/**
 * Coupon Model
 *
 * @property User $User
 * @property Location $Location
 */
class UsedCoupon extends AppModel {

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'location_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!'),
			'uuid' => array(
				'rule' => array('uuid'))),
		'user_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!'),
			'uuid' => array(
				'rule' => array('uuid'))));

	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Coupon' => array(
			'className' => 'Coupon',
			'foreignKey' => 'coupon_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),		
	);
	
	/**
	 * Insert a cuopon usage in the database
	 */
	public function addCouponUsage($couponCode, $userId, $locationId, $orderId){
		$cData = $this->Coupon->findByCode($couponCode);
			
			$usedCouponData = array(
				'UsedCoupon' => array(
					'user_id' => $userId,
					'location_id' => $locationId,					
					'order_id' => $orderId,
					'coupon_id' => $cData['Coupon']['id']));
			
			// Add coupon to order
			$this->create();
			$this->save($usedCouponData);
	}
}
