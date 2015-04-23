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
class ForgottenPassword extends AppModel {


/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User'
		)
	);

	/**
	 * create_hash function.
	 *
	 * @access public
	 * @param mixed $id
	 * @return void
	 */
	public function create_hash($id) {
		$user =  ClassRegistry::init('User');
		$user->id = $id;
		$return = false;
		if ($user->exists()) {
			if ($hash = $this->currentHash($id)) {
				$return = $hash;
			} else {
				$return = substr(Security::hash(Configure::read('Security.salt') . $user->field('created') . date('Y-m-d H:i:s e')), 0, 16);
			}
		}
		return $return;

	}
	/**
	 * validate_hash function.
	 *
	 * @access public
	 * @param mixed $id
	 * @param mixed $hash
	 * @return bool
	 */
	public function validate_hash($id, $hash) {
		$result = $this->find('first', array(
			'conditions' => array(
				'ForgottenPassword.user_id'   => $id,
				'ForgottenPassword.created >' => date('Y-m-d H:i:s', strtotime('- 24 hour'))
			),
			'fields' => array(
				'ForgottenPassword.id',
				'ForgottenPassword.hash'
			)
		));
		if (
			isset($result['ForgottenPassword']['hash'])
			&& $result['ForgottenPassword']['hash'] == $hash
		) {
			return $result;
		} else {
			return false;
		}
	}
	/**
	 * currentHash function.
	 *
	 * @access public
	 * @param mixed $id
	 * @return void
	 */
	public function currentHash($id) {
		$result = $this->find('first', array(
			'conditions' => array(
				'ForgottenPassword.user_id'   => $id,
				'ForgottenPassword.created >' => date('Y-m-d H:i:s', strtotime('- 24 hour'))
			),
			'fields' => array(
				'ForgottenPassword.hash'
			)
		));
		if (isset($result['ForgottenPassword']['hash'])) {
			return $result['ForgottenPassword']['hash'];
		} else {
			return false;
		}
	}
	/**
	 * cleanOld function.
	 *
	 * @access public
	 * @param mixed $time
	 * @return void
	 */
	public function cleanOld($time) {
		$results = $this->find('all', array(
			'conditions' => array(
				'ForgottenPassword.created <' => date('Y-m-d H:i:s', strtotime($time))
			),
			'fields' => array(
				'ForgottenPassword.id'
			)
		));
		if ($results) {
			foreach ($results as $result) {
				$this->delete($result['ForgottenPassword']['id']);
			}
		}
	}
}