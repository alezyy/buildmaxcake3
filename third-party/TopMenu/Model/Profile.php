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
 * Profile Model
 *
 * @property User $User
 */
class Profile extends AppModel {

/**
 * Virtual Fields
 */
	public $virtualFields = array(
		'name' => 'CONCAT(Profile.first_name, " ", Profile.last_name)'
	);
	
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'first_name' => array(
			'rule' => 'notEmpty',
			'message' => 'Please enter your first name.',
			'allowEmpty' => false
		),
		'last_name' => array(
			'rule' => 'notEmpty',
			'message' => 'Please enter your last name.',
			'allowEmpty' => false
		),
		
		'phone' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Phone number cannot be empty'
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


	
/**
 * Gets a user's preferred language
 * @param  string $user_id
 * @return string          language code on success, false on failure
 */
	public function getLanguage($id) {
		$result = $this->find('first', array(
			'conditions' => array(
				'Profile.id' => $id
			)
		));
		if (isset($result['Profile']['language'])) {
			return $result['Profile']['language'];
		} else {
			return false;
		}
	}
}
