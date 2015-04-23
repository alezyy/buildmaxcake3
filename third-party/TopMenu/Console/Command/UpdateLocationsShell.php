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

class UpdateLocationsShell extends AppShell {

	public $uses = array('Location');

	public function main() {
		$results = $this->Location->find(
			'all',
			array(
				'fields' => array(
					'postal_code',
					'id'
				)
			)
		);

		foreach ($results as $result) {
			$data = $result;
			$data['Location']['modified'] = date('Y-m-d H:i:s');
			$this->Location->save($data);
		}
	}
}