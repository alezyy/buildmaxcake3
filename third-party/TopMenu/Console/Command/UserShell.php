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
class UserShell extends AppShell {
	public  $uses = array(
		'User'
	);

	public function initialize() {
		Configure::write('debug', 2);
		parent::initialize();
	}

	public function main() {
		$this->out('Welcome to the user shell!');
		$this->out('Possible Commands:');

		$this->out('A) Add User - Add a user to the database');
		$this->out('Q) Quit - Quits the shell');

		$command = $this->in(
			'Command',
			array(
				'A',
				'Q'
			),
			'Q'
		);

		switch ($command) {
			case 'A':
			case 'a':
			default:
				$this->addUser();
			break;

			case 'q':
			case 'Q':
				$this->out('Thanks for using the user shell!');
				exit;
			break;
		}
	}

	public function addUser() {
		$data = array();
		$data['User']['email']         = $this->in('Email/Username');
		$data['User']['password']         = $this->in('Password');
		$data['User']['password_confirm'] = $this->in('Confirm');
		$data['User']['is_active']        = true;

		$this->out('A) Administrator');
		$this->out('R) Restaurant Administrator');
		$this->out('L) Location Administrator');
		$this->out('C) Chef');
		$this->out('U) User');

		$group = $this->in('Group', array('A', 'R', 'L', 'C', 'U'), 'A');
		switch (strtoupper($group)) {
			case 'A':
				$data['User']['group_id'] = 1;
			break;
			case 'R':
				$data['User']['group_id'] = 2;
			break;
			case 'L':
				$data['User']['group_id'] = 3;
			break;
			case 'C':
				$data['User']['group_id'] = 4;
			break;
			case 'U':
				$data['User']['group_id'] = 5;
			break;
		}
		$this->clear();
		$this->out('Adding User: ' . $data['User']['email']);
		$this->User->create();
		if ($this->User->save($data, false)) {
			$this->out('User Added!');
		} else {
			foreach ($this->User->validationErrors as $field => $error) {
				$this->out('Error: ' . $error[0]);
			}
			$this->error('Errors found', 'Please try again');
		}
		$this->main();
	}

}
