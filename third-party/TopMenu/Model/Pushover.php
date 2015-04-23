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

class Pushover extends AppModel
{
/**
 * We don't use a DB table
 * @var boolean
 */
	public $useTable = false;


/**
 * Default datasource for this model
 * @var string
 */
	public $useDbConfig = 'Pushover';
	
	
/**
 * Construct
 *
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->_getDatasource();
	}

/**
 * Sends a message
 */
	public function sendMessage($to, $subject, $message) {
		return $this->Pushover->sendMessage($to, $subject, $message);
	}


/**
 * Grabs a datasource and sets it to $this->Pushover
 * @param  string $datasource name of the datasource config
 * @return void
 */
	private function _getDatasource($datasource = null) {
		$this->Pushover = $this->getDataSource($datasource);
	}


}