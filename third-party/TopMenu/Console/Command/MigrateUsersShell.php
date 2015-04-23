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

/**************************************************************************************\

Sample Old DB Config to go in app/Config/database.php
public $old = array(
	'datasource' => 'Database/Mysql',
	'host' => 'localhost',
	'login' => 'username',
	'password' => 'some_awesome_password',
	'database' => 'the_db_name',
	'encoding' => 'utf8',
);


All functions named in the format: transfer_some_name() will be executed
by main(). 

If your function must execute before another function, format the
function name as follows:

public function transfer_[1-9]_function_name() {...};

Example:

public function transfer_200_some_function() {...};  // this will be fired with any other
												   // function that has a priority of 2.


To skip a function add it's name to the MigrationShell::skip propery. 
	See it's docblock for more information

***************************************************************************************/
App::uses('Core', 'ConnectionManager');
App::uses('BcryptFormAuthenticate', 'Controller/Components/Auth');
App::uses('ComponentCollection', 'Controller');
App::uses('Controller', 'Controller');
App::uses('CakeRequest', 'Network');
App::import('Component', 'Auth');
App::import('Component', 'Image');

class MigrateUsersShell extends AppShell {

/**
 * Array of models to use
 * @var array
 */
	public $uses = array(
		'User',
		'Contest',
		'BlogCategory',
		'Feature',
		'Domain',
		'Device',
		'Article',
		'Theme',
		'Cuisine',
		'DeliveryAddress',
		'Coupon',
		'Location',
		'LocationGallery',
		'Log',
		'Menu',
		'MenuItem',
		'MenuItemOption',
		'MenuCategory',
		'Newsletter',
		'Order',
		'OrderDetail',
		'Page',
		'Post',
		'PhoneClick',
		'Rating',
		'Review',
		'ReviewCode',
		'Schedule',
		'Sector',
		'SlideshowImage',
		'Specialty',
		'StreetAddress',
		'Tax',
		'UserPoint',
		'Invoice',
		'TipOption',
		'DeliveryArea',
		'City'

	);

/**
 * Functions to skip
 * Must be actual function name! If you used a priority you must include it.
 * e.g. 100_users  or  500_cuisines
 * @var array
 */
	private $skip = array(
		'phone_clicks',
		'700_orders',
		'800_order_details',
		'logs',				
//		'devices'
	);

/**
 * Tables we don't want to clear from the DB
 */
	private	$ommitted_tables = array(
			'acos',
			'aros',
			'aros_acos',
			'groups',
			'countries',
			'provinces',
			'street_addresses'
		);

/**
 * Directories to sanitize (filenames)
 */
	private $directories_to_clean = array(
		'application/logos',
		'application/location_gallery/original',
		'application/slideshow_images',
		'media'
	);


/**
 * Array of email addresses we've processed (avoiding duplicate entries, there seem to be some in the old db)
 * @var array
 */
	private $users = array();


/**
 * Array of user ids
 * @var array
 */
	private $user_ids = array();



/**
 * Array of image IDs
 */
	private $images = array();


/**
 * Holds an instance of ImageComponent
 */
	private $Image = false;


/**
 * Holds an instance of Controller
 */
	private $controller;






/**
 * Construct
 * Don't put MySQL connection stuff here
 */
	public function __construct() {
		parent::__construct();
	}

/**
 * Destruct
 * Close MySQL connection
 */
	public function __destruct() {
		if (isset($this->sql)) {
			mysql_close($this->sql);
		}
		if (isset($this->sql)) {
			mysql_close($this->sql2);
		}
	}


/**
 * Main function, this is what gets called by AppShell
 * @return void
 */
	public function main () {
		$debugLevel = Configure::read('debug');
		if ($debugLevel < 1) {
			die('Can\'t run in production mode...');
		}
		$dont_unload = array(
		);
		foreach ($this->uses as $Model) {
			if (array_search($Model, $dont_unload) === false) {
				$this->{$Model}->Behaviors->unload('Elasticsearch.Searchable');
			}

		}



		$this->dataSource = ConnectionManager::getDataSource('old');
		$this->_connect();
		mysql_select_db($this->dataSource->config['database'], $this->sql);
		mysql_query("set names '" . $this->dataSource->config['encoding'] . "'");

		$this->out('Transferring Users');
		$this->transfer_400_users();
		$this->out('Delivery Addresses');
		$this->transfer_delivery_addresses();
	}

/**
 * Connects to MySQL DB
 * @return void
 */
	private function _connect() {
		$this->sql = mysql_connect(
			$this->dataSource->config['host'],
			$this->dataSource->config['login'],
			$this->dataSource->config['password']
		);
		$this->sql2 = mysql_connect(
			$this->dataSource->config['host'],
			$this->dataSource->config['login'],
			$this->dataSource->config['password']
		);
	}




/**
 * Runs a mysql query
 * @param  string $query the query to run
 */
	private function runQuery($query) {
		return mysql_query($query, $this->sql);
	}

/**
 * Converts html codes into text chars
 * @param  string $text text to convert
 * @return string
 */
	private function toText($text) {
		$search = array("&amp;#039;", "&amp;#036;", "&#039;", "&#036;", "&#092;", "&amp;#092;", "&quot;", "&amp;");
		$replace = array("'", '$', "'", '$', "\\", "\\", "\"", "&");
		if (!is_array($text)) {
			$text = stripslashes(str_replace($search, $replace, $text));
		} else {
			foreach ($text as $key => $val) {
				$text[$key] = $this->toText($val);
			}
		}
		return $text;
	}



/**
 * Generates a new password hash using bcrypt
 * @param  string $old_hash
 * @param  string $salt
 * @return string           new hash
 */
	private function generateNewHash($old_hash, $salt) {
		return BcryptFormAuthenticate::hash($old_hash, $salt);
	}



/**
 * Transfers user accounts to the new db
 * @return void
 */
	private function transfer_400_users() {


		// Grab all user accounts and insert them into new db
		$res = mysql_query('SELECT * FROM `users` WHERE 1', $this->sql);
		while ($row = mysql_fetch_array($res)) {
			$row = $this->toText($row);
			if (!array_search($row['email'], $this->users)) {
				$data = array(
					'User' => array(
						'email'       => $row['email'],
						'old_salt'    => BcryptFormAuthenticate::generateSalt(),
						'group_id'    => 5,  // 5 - User
						'created'     => $row['register_date'],
						'is_active'   => $row['status'] == 'active' ? true : false,
						'last_login'  => $row['last_login'],
						'force_reset' => false
					)
				);

				$data['User']['old_hash'] = $this->generateNewHash($row['password'], $data['User']['old_salt']);

				$this->User->create();
				$this->User->save($data);

				$data = array(
					'Profile' => array(
						'id'         => $this->User->getInsertID(),
						'first_name' => $row['first_name'],
						'last_name'  => $row['last_name'],
						'phone'      => $row['phone'],
						'language'   => 'eng',
						'timezone'   => 'America/Montreal'


					)
				);

				$this->User->Profile->create();
				$this->User->Profile->save($data, false);
				$this->users[] = $row['email'];
			}
		}
	}


/**
 * Transfer Delivery Addresses
 */
	private function transfer_delivery_addresses() {
		$res = mysql_query("SELECT * FROM  `user_delivery_addresses` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			if (array_key_exists($row['user_id'], $this->user_ids)) {
				$row = $this->toText($row);
				$data = array(
					'DeliveryAddress' => array(
						'user_id'         => $this->user_ids[$row['user_id']],
						'phone'           => $row['phone'],
						'secondary_phone' => $row['secondary_phone'],
						'street_number'   => $row['street_no'],
						'door_code'       => $row['door_code'],
						'cross_street'    => $row['cross_street'],
						'address'         => $row['address'],
						'address2'        => $row['address2'],
						'city'            => $row['city'],
						'state'           => $row['state'],
						'postal_code'     => $row['postal_code']

					)
				);
				$this->DeliveryAddress->create();
				$this->DeliveryAddress->save($data, false);
			}
		}
	}

}