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

App::uses('AppController', 'Controller');

class CitiesController extends AppController {
/**
 * Components
 */
	public $components = array('RequestHandler');

/**
 * beforeFilter, construct
 * @return void
 */	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow();
	}

/**
 * Gets a list of cities for a given province
 * @param  string $province
 * @return json
 */
	public function getCities($province) {
		$cities = $this->City->getCities($province);
		$city_names = array();
		foreach ($cities as $city) {
			$city_names[] = $city['City']['city'];
		}
		$this->set('city_names', $city_names);
		$this->set('_serialize', array('city_names'));
	}

}

