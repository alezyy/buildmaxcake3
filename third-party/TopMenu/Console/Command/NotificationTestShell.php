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
 * Resizes images
 *
 * @extends AppShell
 */
class NotificationTestShell extends AppShell {

	public $uses = array('Pushover');

	/**
	 * main function.
	 *
	 * @access public
	 * @return void
	 */
	public function main() {


		$to      = 'gPt9UeR6zL6qPnYNoUan1GF98R4A2d';
		$title   = 'Test Message';
		$message = 'This is a test message.';

		$response = $this->Pushover->sendMessage($to, $title, $message);

		var_dump($response);

		return true;
	}
}