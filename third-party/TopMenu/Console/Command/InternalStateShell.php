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

/**
 * This shell is responsible for checking the internal state of the site
 * It will create alerts as needed, and close alerts when the problem is resolved.
 */
class InternalStateShell extends AppShell {

	public $uses = array(
		'InternalAlert',
		'Location'
	);

/**
 * The main function
 */
	public function main() {
		Configure::write('Config.language', 'fr');
		// Check active *online ordering* locations for printer status
		$this->checkLocationPrinters();

		// Flush the notification queue
		$this->InternalAlert->flushNotificationQueue();
	}

/**
 * Checks Locations for printers that are offline but shouldn't be.
 */
	public function checkLocationPrinters() {

		$locations = $this->Location->find('all', array(
			'conditions' => array(
				'Location.status'          => 'active',
				'Location.online_ordering' => true
			),
			'fields' => array('Location.id')
		));

		if ($locations) {
			foreach ($locations as $location) {
				$shouldDeviceBeOnlineAndIsNot = $this->Location
					->Device
					->shouldDeviceBeOnlineAndIsNot($location['Location']['id']);

				$openAlert = $this->InternalAlert->getAlert($location['Location']['id'], 'printer_offline', true);

				if (!$openAlert && $shouldDeviceBeOnlineAndIsNot) {
					// Theres no open alert for this location, and it's printer is offline
					// when it should be online. Open an alert
					$this->InternalAlert->createAlert(
						$location['Location']['id'],
						'printer_offline'
					);
				} elseif ($openAlert && !$shouldDeviceBeOnlineAndIsNot) {
					// The location has an open alert, and it's printer is
					// back online. Resolve the alert.
					$this->InternalAlert->resolveAlert(
						$location['Location']['id'],
						'printer_offline'
					);
				}
			}
		}
	}


}