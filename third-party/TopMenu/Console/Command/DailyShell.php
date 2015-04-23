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
 * DailyShell class.
 *
 * @extends AppShell
 */
class DailyShell extends AppShell {
	/**
	 * uses
	 *
	 * @var mixed
	 * @access public
	 */
	public $uses = array(
		'User'
	);
	/**
	 * main function.
	 *
	 * @access public
	 * @return void
	 */
	public function main() {

		// Clean non-activated users from the DB
		$this->User->cleanInactive('-72 Hour');


		// Clean out old forgoten password hashes
		$this->User->ForgottenPassword->cleanOld('-24 Hour');

		return true;
	}
}