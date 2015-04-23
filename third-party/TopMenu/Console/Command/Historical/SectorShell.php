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

App::import('Core', 'ConnectionManager');
class SectorShell extends AppShell {
	public  $uses = array(
		'DeliveryArea',
		'Location',
		'Sector'
	);

	public function initialize() {
		Configure::write('debug', 2);
		parent::initialize();
	}

	public function main() {
		$debugLevel = Configure::read('debug');
		if ($debugLevel < 1) {
			die('Can\'t run in production mode...');
		}

		$locations = $this->Location->find('all', array(
			'conditions' => array(
				'Location.online_ordering' => false
			),
			'fields' => array(
				'Location.postal_code',
				'Location.id'
			),
			'recursive' => -1
		));


		foreach ($locations as $location) {
			$locationPostal = substr($location['Location']['postal_code'], 0, 3);
			$postal_codes = $this->Sector->find('first', array(
				'conditions' => array(
					'Sector.code LIKE' => '%' . $locationPostal . '%'
				),
				'fields' => array(
					'Sector.code'
				),
				'recursive' => -1
			));

			if (!isset($postal_codes['Sector']['code'])) {
				continue;
			}

			$postal_codes = explode(',', $postal_codes['Sector']['code']);

			foreach ($postal_codes as $sector_code) {
				$this->DeliveryArea->create();
				$this->DeliveryArea->recursive = -1;
				$data = array(
					'DeliveryArea' => array(
						'location_id'     => $location['Location']['id'],
						'postal_code'     => $sector_code,
						'delivery_charge' => '0',
						'delivery_min'    => '0',
						'featured'        => '0'

					)
				);

				$this->DeliveryArea->save($data, false);
			}
		}
	}

	

}
