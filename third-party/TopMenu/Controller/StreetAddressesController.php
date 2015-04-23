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

class StreetAddressesController extends AppController {
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
		$this->Security->validatePost = false;
        $this->Security->csrfCheck = false;
	}

/**
 * Gets a json string of street names for a given postal code
 * @param  string $postal_code
 * @param  string $street_name optional
 * @return json
 */
	public function getStreets($postal_code, $street_name = '') {
		$streets = $this->StreetAddress->getStreets($postal_code, $street_name);
		$street_names = array();
		foreach ($streets as $street) {
			$street_names[] = $street['StreetAddress']['street_name'];
		}
		$this->set('street_names', $street_names);
		$this->set('_serialize', array('street_names'));
	}

/**
 * Gets a list of the 2nd half of the postal code provided
 * @param  [type] $postal_code [description]
 * @return [type]              [description]
 */
	public function getPostalCodesPart2($postal_code) {
		$codes = $this->StreetAddress->getPostalCodesPart2($postal_code);
		$return = array();
		foreach ($codes as $code) {
			$return[] = $code['StreetAddress']['postal_code2'];
		}
		$this->set('codes', $return);
		$this->set('_serialize', array('codes'));
	}

/**
 * Gets a postal code from a given lat/long
 */
	public function getPostalCodeFromCoords() {
		$this->autoRender = false;

		$this->layout = 'ajax';

		$this->response->type('json');

		$response = $this->StreetAddress->getPostalCodeFromCoords(
			$this->request->data('latitude'),
			$this->request->data('longitude')
		);

		if ($response) {
			$this->response->body(json_encode($response));
		} else {
			$this->response->body(false);
		}


	}
}