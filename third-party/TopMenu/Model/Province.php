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
class Province extends AppModel {


/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Country' => array(
			'className'  => 'Country',
			'foreignKey' => 'country',
			'conditions' => '',
			'fields'     => array(
				'country',
				'name'
			),
			'order' => ''
		)
	);
/**
 * get_provinces function.
 *
 * @access public
 * @param mixed		$country
 * @param string	Two letter code of language for the province name
 * @param boolean	True means the first field is the province code<br/>
 *					False means the first field is the english name of the province
 * @return void
 */
	public function get_provinces($country = NULL, $language = 'en' , $code = FALSE) {
		
		$country = (($country === NULL)? Configure::read('I18N.COUNTRY_CODE_2'): $country);
		$code = ($code)?'code': 'name_en';
		$result = $this->find('list', array(
			'fields' => array(
				'Province.'. $code,
				'Province.name_'. $language,
			),
			'conditions' => array(
				'Province.country' => $country
			)
		));
		if ($result) {
			return $result;
		} else {
			return false;
		}

	}	
}