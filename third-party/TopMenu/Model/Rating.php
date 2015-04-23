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
 * Rating Model
 *
 * @property Location $Location
 * @property User $User
 */
class Rating extends AppModel {

	/**
	 * Model properties
	 */
	public $order = "created DESC";

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
		'user_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
			//'message' => 'Your custom message here',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'rating' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'Please set the number of stars for this review',
				'allowEmpty' => false,
				'required' => true,
			),
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Must be numeric!',
			//'allowEmpty' => false,
			//'required' => false,
			//'last' => false, // Stop validation after this rule
			//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'review' => array(
			'required' => array(
				'rule' => 'notEmpty',
				'message' => 'A review message is required',
				'allowEmpty' => false,
				'required' => true,
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
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'location_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'order_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),        
	);

	public function beforeSave($options = array()) {
		if (!$this->data['Rating']['review']) {
			$this->data['Rating']['review'] = strip_tags($this->data['Rating']['review']);
		}
		return TRUE;
	}

	/**
	 * Returns the calculated rating for a specific location
	 * 
	 * @param string $locationID location's id
	 * @return mixe return float on success or false if no records where found
	 */
	public function calculate($locationID) {

			$results = $this->find(
				'all', array(
				'conditions' => array(
					'Rating.location_id' => $locationID,
					'Rating.status' => 'active'),
				'fields' => array(
					'rating'
				)
				)
			);

		$count = sizeof($results);

		if ($count > 0) {
			$total = 0;
			foreach ($results as $result) {
				$total += $result['Rating']['rating'];
			}
			return round(($total / $count) / 5, 1) * 5;
		} else {
			return 0;
		}
	}

	public function openRating($locationId, $userId) {
		$this->create();
		$this->set('location_id', $locationId);
		$this->set('user_id', $userId);
		$this->set('status', 'open');
		$this->save();
		return $this->getLastInsertID();
	}

	/**
	 * Check if a review can is ready to be edit by the given user and return the appropriate review "template
	 * 
	 * @param 	string 	$id
	 * @param 	string 	$userId
	 * @return 	array 	returns the found Rating object
	 */
	public function isOpen($id, $userId) {
		if (!$this->exists($id)) {
			return FALSE;
		}

		$rating = $this->findById($id);

		if ($rating['Rating']['status'] !== 'open') {
			return FALSE;
		}

		if ($rating['Rating']['user_id'] != $userId) {
			return FALSE;
		}
		return $rating;
	}
    
    /**
     * 
     * @param int $age Delete all ratings older than this (in seconds). 
     * <br/><b>Example:</b> 86400 would delete all ratings created before yesterday
     * <br/><b>Default:</b> 90 days or 7776000
     */
    public function cleanUpOldRatings($age = NULL){
        
        $age = ($age === NULL) ? MONTH * 3 : $age;
        $result = $this->Location->deleteAll(array(
            'Location.status' => 'open',
            'Location.created <' => date('Y-m-d', time() - $age)  ));
        
        return $result;
    }

}
