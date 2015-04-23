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
class Country extends AppModel {


/**
 * belongsTo associations
 *
 * @var array
 */
	public $hasMany = array(
		'Province' => array(
			'className'  => 'Province',
			'foreignKey' => 'country',
			'conditions' => '',
			'fields'     => 'name',
			'order'      => ''
		)
	);
/**
 * Gets a list of countries
 * @param  boolean $paypal_only return paypal enabled countries only?
 * @return array
 */
	public function get_countries($paypal_only = false) {
		$conditions = array();
		if ($paypal_only) {
			$conditions['Country.paypal'] = 1;
		}
		$result = $this->find('list', array(
			'fields' => array(
				'Country.country',
				'Country.name'
			),
			'conditions' => $conditions
		));
		if ($result) {
			return $result;
		} else {
			return false;
		}
	}

/**
 * Gets the full name for a country, lookup by code
 * @param  string $country Country Code
 * @return string          Full country name
 */
	public function get_name($country) {
		$result = $this->find('first', array(
			'conditions' => array(
				'Country.country' => $country
			),
			'fields' => array(
				'Country.name'
			)
		));
		if (isset($result['Country']['name']) && $result['Country']['name']) {
			return $result['Country']['name'];
		} else {
			return false;
		}
	}
}