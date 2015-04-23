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

App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
App::import('Component', 'Auth');
App::uses('Core', 'ConnectionManager');
App::uses('AppModel', 'Model');

/**
 * Installs TopMenu
 */
class InstallShell extends AppShell {

	public $uses = array(
		'Group'
	);

	private $groups;


	public function __construct() {

		$this->groups = array(
			array('id' => '1', 'name' => 'Site Administrator'),
			array('id' => '2', 'name' => 'Restaurant Administrator'),
			array('id' => '3', 'name' => 'Location Administrator'),
			array('id' => '4', 'name' => 'Chef'),
			array('id' => '5', 'name' => 'User'),
			array('id' => '6', 'name' => 'Data Entry')
		);
		parent::__construct();
	}
	public function main() {

		$debugLevel = Configure::read('debug');
		if ($debugLevel < 1) {
			die('Can\'t run in production mode...');
		}

		$continue = $this->in('Are you sure you want to proceed?', array('Y', 'N'), 'N');

		if (strtoupper($continue) == 'N' ) {
			exit;
		}

		$this->dispatchShell('schema', 'create');
		$this->dispatchShell('schema', 'create', 'sessions');
		$this->dispatchShell('i18n', 'initdb');


		$this->out(__('Creating Groups'));
		$this->createGroups();

		$this->out(__('Creating Indexes and Mappings'));
		$this->_createIndexes();

		$this->out('Importing SQL from SQL Directory');
		$this->importSQL();


	}


	private function _createIndexes() {
		$models_to_map = array(
		);
		$index = ConnectionManager::getDataSource('index')->config['index'];

		$this->dispatchShell('Elastic.elastic', 'create_index', '--drop', $index);
		$this->dispatchShell('Elastic.elastic', 'create_index', $index);


		foreach ($models_to_map as $model) {
			$this->dispatchShell('Elastic.elastic', 'mapping', $this->{$model}->name);
		}

	}

	public function createGroups() {
		foreach ($this->groups as $group) {
			$data = array();
			$data['Group'] = $group;
			$this->Group->create();
			$this->Group->save($data);
		}
	}




	public function importSQL() {
		$files = scandir(ROOT . DS . 'sql');
		array_shift($files);
		array_shift($files);
		foreach ($files as $file) {
			$file = explode('.', $file);
			if ($file[1] == 'sql' && (sizeof($file) <= 2)) {
				$file = implode('.', $file);
				$db = ConnectionManager::getDataSource('default');


				$user = $db->config['login'];
				$pass = $db->config['password'];
				$database = $db->config['database'];
				$host = $db->config['host'];

				$sql_file = 'sql' . DS . $file;

				$command = "mysql -u{$user} -p{$pass} -h{$host} "
						 . "-D {$database} < {$sql_file}";

				$this->out('Importing ' . $file);
				shell_exec($command);

			}
		}
	}
}