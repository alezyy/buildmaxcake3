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

App::uses('Controller', 'Controller');
App::uses('ComponentCollection', 'Controller');
App::uses('AclComponent', 'Controller/Component');
App::uses('DbAcl', 'Model');

/**
 * AclInitShell class.
 *
 * @extends AppShell
 */
class AclInitShell extends AppShell {
/**
 * uses
 *
 * (default value: array('User'))
 *
 * @var string
 * @access public
 */
	public $uses = array('User');
/**
 * Acl
 *
 * @var mixed
 * @access public
 */
	public $Acl;
/**
 * Aco
 *
 * @var mixed
 * @access public
 */
	public $Aco;

/**
 * Construct
 * @return void
 */
	public function startup() {
		parent::startup();
		$collection = new ComponentCollection();
		$this->Acl = new AclComponent($collection);
		$controller = new Controller();
		$this->Acl->startup($controller);
		$this->Aco = $this->Acl->Aco;
	}
	/**
	 * main function.
	 *
	 * @access public
	 * @return void
	 */
	public function main () {
		$this->__initDB();
	}

	/**
	 * __initDB function.
	 *
	 * @access private
	 * @return void
	 */
	private function __initDB() {

		$group = $this->User->Group;

	/**
	 * Global Rules (for all user groups)
	 */
		for ($i = 1; $i <= 6; $i++) {
			$group->id = $i;
			$this->Acl->deny($group, 'controllers'); // Deny access by default
			$this->Acl->allow($group, 'controllers/Users/change_password');
			$this->Acl->allow($group, 'controllers/Profiles');
			$this->Acl->allow($group, 'controllers/Users/my_account');
			$this->Acl->allow($group, 'controllers/DeliveryAddresses');
		}

	/**
	 * Site Administrator
	 */
		$group->id = 1;
		$this->Acl->allow($group, 'controllers');


	/**
	 * Restaurant Administrator
	 */
		$group->id = 2;

		// Add rules here

		

	/**
	 * Location Administrator
	 */
		$group->id = 3;
		// Add rules here



	/**
	 * Chef
	 */
		$group->id = 4;
		// Add rules here



	/**
	 * User
	 */
		$group->id = 5;                                  
		// Add rules here
		

	/**
	 * Data Entry
	 */
		$group->id = 6;
		// Add rules here
		$this->Acl->allow($group, 'controllers/Admins');
		$this->Acl->allow($group, 'controllers/Articles');
		$this->Acl->allow($group, 'controllers/BlogCategories');
		$this->Acl->allow($group, 'controllers/Cuisines');
		$this->Acl->allow($group, 'controllers/DeliveryAreas');

		$this->Acl->allow($group, 'controllers/Devices/admin_index');
		$this->Acl->allow($group, 'controllers/Devices/admin_location_index');
		$this->Acl->allow($group, 'controllers/Devices/admin_view');


		$this->Acl->allow($group, 'controllers/Features');
		$this->Acl->allow($group, 'controllers/LocationGalleries');
		$this->Acl->allow($group, 'controllers/Locations');
		$this->Acl->allow($group, 'controllers/MenuCategories');
		$this->Acl->allow($group, 'controllers/MenuItemOptions');
		$this->Acl->allow($group, 'controllers/MenuItemOptionValues');
		$this->Acl->allow($group, 'controllers/MenuItems');
		$this->Acl->allow($group, 'controllers/Menus');
		$this->Acl->allow($group, 'controllers/Newsletters');
		$this->Acl->allow($group, 'controllers/Pages');
		$this->Acl->allow($group, 'controllers/Posts');
		$this->Acl->allow($group, 'controllers/Ratings');
		// $this->Acl->allow($group, 'controllers/Restaurants');
		// $this->Acl->allow($group, 'controllers/Reviews');
		$this->Acl->allow($group, 'controllers/Schedules');
		$this->Acl->allow($group, 'controllers/Sectors');
		$this->Acl->allow($group, 'controllers/SlideshowImages');
		$this->Acl->allow($group, 'controllers/Specialties');
		$this->Acl->allow($group, 'controllers/StreetAddresses');
		$this->Acl->allow($group, 'controllers/Themes');
		$this->Acl->allow($group, 'controllers/TipOptions');



		echo "All Done!\n";
	}
}