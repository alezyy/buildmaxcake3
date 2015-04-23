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
App::import('Component', 'PDFMenu');

class MigrationShell extends AppShell {

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
		'Restaurant',
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
		'application/item_images/original',
		'application/slideshow_images',
		'media'
	);

/**
 * If set to true, don't process any images/pdfs
 */
	private $files_dry_run = false;

/**
 * Path to old TopMenu Site
 * 
 * @var [type]
 */
	private $old_path = null;

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
 * Array of blog category IDs
 */
	private $blog_cats = array();


/**
 * Array of feature IDs
 */

	private $features = array();

/**
 * Array of devices
 */

	private $devices = array();

/**
 * Array of Restaurant.id
 */
	private $restaurants = array();

/**
 * Array of old restaurants table ids
 */
	private $new_restaurants = array();

/**
 * Array of restaurant names
 * restaurant_name => restaurant_id
 * @var array
 */
	private $restaurant_names = array();
    
/**
 * Map of locations id to their restaurant id key is location's id and value is restaurant's id
 */
    private $locationsRestaurants = array();

/**
 * Array of Location names
 * @var array
 */
	private $location_names = array();

/**
 * Array of Location URls
 * @var array
 */
	private $location_urls = array();

/**
 * Array of locations 
 */

	private $locations = array();

/**
 * Theme IDs
 */

	private $themes = array();

/**
 * Cuisines
 */
	private $cuisines = array();

/**
 * Array of sectors IDs
 */
	private $sectors = array();


/**
 * Array of image IDs
 */
	private $images = array();

/**
 * Array of menus IDs
 */
	private $menus = array();

/**
 * Array of menus category
 */
	private $menu_categories = array();

/**
 * Array of items IDs
 */
	private $items = array();

/**
 * Array of orders IDs
 */
	private $orders = array();

/**
 * Array of transaction IDs
 */
	private $transactions = array();

/**
 * Array of Post IDs
 */
	private $posts = array();

/**
 * Array of Reviews IDs
 */
	private $reviews = array();

/**
 * Specialties
 */

	private $specialties = array();

/**
 * Menu Items
 */

	private $menu_items = array();

/**
 * Menu Option
 */
	private $menu_item_options = array();

/**
 * Holds an instance of ImageComponent
 */
	private $Image = false;

/**
 * Holds an instance of PDFMenuComponent
 */
	private $PDFMenu;

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
		$this->old_path = Configure::read('Topmenu.old_site_path');
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
		die('Deprecated Shell Command!');
		$dont_unload = array(
		);
		foreach ($this->uses as $Model) {
			if (array_search($Model, $dont_unload) === false) {
				$this->{$Model}->Behaviors->unload('Elasticsearch.Searchable');
			}

		}

		$this->Location->unbindModel(
			array(
				'hasAndBelongsToMany' => array(
					'Sector',
					'Cuisine',
					'Specialty',
					'Feature'
				)
			), false
		);

		$this->Restaurant->unbindModel(
			array(
				'hasAndBelongsToMany' => array(
					'Cuisine',
					'Specialty'
				)
			), false
		);


		$this->User->unbindModel(
			array(
				'hasAndBelongsToMany' => array(
					'Restaurant',
					'Location'
				)
			), false
		);








		$this->User->bindModel(
			array(
				'hasAndBelongsToMany' => array(
					'Restaurant' => array(
						'unique' => false
					),

					'Location' => array(
						'unique' => false
					)
				)
			), false
		);

		$this->Location->bindModel(
			array(
				'hasAndBelongsToMany' => array(
					'Sector' => array(
						'unique' => false
					),

					'Cuisine' => array(
						'unique' => false
					),
					'Specialty' => array(
						'unique' => false
					),
					'Feature' => array(
						'unique' => false
					)
				)
			), false
		);


		$this->Restaurant->bindModel(
			array(
				'hasAndBelongsToMany' => array(

					'Specialty' => array(
						'unique' => false
					),

					'Cuisine' => array(
						'unique' => false
					)

				)
			), false
		);

		$this->MenuItem->bindModel(
			array(
				'hasAndBelongsToMany' => array(

					'MenuCategory' => array(
						'unique' => false
					),
					'MenuItemOption' => array(
						'unique' => false
					)
				)
			), false
		);

		if (isset($this->args[0]) && $this->args[0] === 'dry')
			$this->files_dry_run = true;

		$this->out('Migrating will destroy ALL data in the database!');
		$continue = $this->in('Are you sure you want to proceed with the migration?', array('Y', 'N'), 'N');

		if (strtoupper($continue) == 'N' ) {
			exit;
		}

		if ($this->files_dry_run !== true) {
			$this->out('Sanitizing filenames in old website...');
			$this->clean_directories();
		}

		$this->dataSource = ConnectionManager::getDataSource('old');
		$this->_connect();
		mysql_select_db($this->dataSource->config['database'], $this->sql);
		mysql_query("set names '" . $this->dataSource->config['encoding'] . "'");


		$this->out('Clearing the database...');
		$this->clear_db();

		$this->out('Cleaning the old database');
		$this->clean_old_db();

		// Gets a list of methods in this class
		$methods = get_class_methods('MigrationShell');

		// an array of methods we're going to call
		$run_methods = array();


		foreach ($methods as $method) {
			$method = explode('_', $method);
			// Try to find 'transfer' methods
			if (is_array($method) && $method[0] === 'transfer') {
				// For sorting reasons, we get rid of the first
				// element of the array which will always be 'transfer'
				array_shift($method);
				$run_methods[] = implode('_', $method);
			}
			
		}

		// Sort that array!
		array_multisort($run_methods, SORT_ASC);



		foreach ($run_methods as $method) {

			// Check to see if we should skip this method			
			if (array_search($method, $this->skip) === false) {
				$friendly_name = $method;
				if (is_numeric(substr($friendly_name, 0, 3))) {
					// for display purposes, if we have a function like
					// 100_users in the array, we should return a substring
					// removing the first two characters.
					$friendly_name = substr($friendly_name, 4);
				}
				$friendly_name = ucwords($friendly_name);

				$this->out('Transferring: ' . $friendly_name);
				$method = 'transfer_' . $method;

				// Call the method
				$this->{$method}();

				// Profit!

			} else {
				$this->out('Skipping: ' . $friendly_name);
			}
		}
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
 * Builds a controller and instanciates objects for
 * ImageComponent and PDFMenu Component to use. This
 * basically emulates a request coming from a browser. 
 * We do this so we don't break the automagic that the Components implement.
 * @param  string $controller_name Name of the controller you want to build
 * @return void
 */
	private function _buildController($controller_name) {
		
		$model_name      = Inflector::singularize($controller_name);
		$controller_name =  Inflector::pluralize($controller_name);

		$this->controller          = new Controller();
		$collection                = new ComponentCollection();
		$this->controller->request = new CakeRequest();
		$this->Image               =& new ImageComponent($collection);
		$this->PDFMenu             =& new PDFMenuComponent($collection);

		$this->controller->name          = $controller_name;
		$this->controller->{$model_name} = $this->{$model_name};

		$this->Image->initialize($this->controller, $this->files_dry_run);
		$this->PDFMenu->initialize($this->controller, $this->files_dry_run);

	}


/**
 * Cleans a filename from illegal chars
 * @param  string $input filename to be cleaned
 * @return string        clean filename
 */
	private function clean_file_name($input) {
		return preg_replace('/\(*\)* *\-*_*/', '', $input);
	}

/**
 * Sanitizes the directories listed in $this->directories_to_clean
 * from bad filenames.
 * @return [type] [description]
 */
	private function clean_directories() {
		foreach ($this->directories_to_clean as $directory) {
			$path = $this->old_path . $directory . DS;
			echo "\n$path\n";
			$files = scandir($path);
			array_shift($files);
			array_shift($files);
			foreach ($files as $file) {
				$new_name = $this->clean_file_name($file);

				printf('Moving %s to %s' . "\n", $file, $new_name);
				
				rename($path . $file, $path . $new_name);
			}
		}
	}
/**
 * Performs operations on the old database to clean out bad records as best as we can
 * 
 * @return void
 */
	private function clean_old_db() {
		$sql = array(
			'DELETE FROM `restaurant_secteur` WHERE ID_secteur NOT IN (SELECT ID_secteur FROM `secteur`)'
		);
		foreach ($sql as $query) {
			$rows = $this->runQuery($query);
		}

	}

/**
 * Runs a mysql query
 * @param  string $query the query to run
 */
	private function runQuery($query) {
		return mysql_query($query, $this->sql);
	}

/**
 * Clear out the DB of current data
 * We'll have to add new queries here to remove the data as we go
 * for most tables we can very easily use $this->ModelName->query('DELETE FROM `table_name` WHERE 1');
 * @return void
 */
	private function clear_db() {
		$database = $this->User->getDataSource()->config['database'];
		$tables = $this->User->query('SHOW TABLES');

		
		foreach ($tables as $table) {
			$table_name = $table['TABLE_NAMES']['Tables_in_' . $database];
			if (array_search($table_name, $this->ommitted_tables) === FALSE) {
				$this->User->query('DELETE FROM `' . $table_name . '` WHERE 1');
			}
		}


		
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
 *  **** Transfer Methods ****
 *  	(put them bellow this docblock)
 */

/**
 * Transfer Cities
 */
	private function transfer_cities() {
		$res = mysql_query('SELECT * FROM `cities` WHERE 1', $this->sql);
		while ($row = mysql_fetch_array($res)) {
			$row = $this->toText($row);

			$data = array(
				'City' => array(
					'city'     => $row['city'],
					'province' => $row['province'],
					'url'      => strtolower(Inflector::slug($row['city']))
				)
			);
			$this->City->create();
			$this->City->save($data, false);
						
		}
	}


/**
 * Transfers user accounts to the new db
 * @return void
 */
	private function transfer_400_users() {


		// Grab all administrator accounts and insert them into the new db
		// $res = mysql_query('SELECT * FROM `administrators` WHERE 1', $this->sql);
		// while ($row = mysql_fetch_array($res)) {
		// 	$row = $this->toText($row);
		// 	if (!array_search($row['username'], $this->users)) {
		// 		$data = array(
		// 			'User' => array(
		// 				'email'       => $row['username'],
		// 				'old_salt'    => BcryptFormAuthenticate::generateSalt(),
		// 				'group_id'    => $row['admin_type'],
		// 				'is_active'   => $row['status'] == 'active' ? true : false,
		// 				'force_reset' => false
		// 			)
		// 		);

		// 		$data['User']['old_hash'] = $this->generateNewHash($row['password'], $data['User']['old_salt']);


		// 		$this->User->create();
		// 		$this->User->save($data, false);
		// 		$this->users[] = $row['username'];
		// 		$this->user_ids[$row['user_id']] = $this->User->getLastInsertID();
		// 	}
			
		// }

		// foreach ($this->user_ids as $old_id => $new_id) {
		// 	$res = mysql_query('SELECT * FROM `administrator_location_xref` WHERE `user_id`='. $old_id . ' ', $this->sql);
		// 	while ($row = mysql_fetch_array($res)) {
		// 		if (array_key_exists($row['location_id'], $this->locations)) {
		// 			$data = array(
		// 				'User' => array(
		// 					'id' => $new_id
		// 				),
		// 				'Location' => array(
		// 					'id' => $this->locations[$row['location_id']]
		// 				)
		// 			);
		// 			$this->User->saveAll($data);
		// 		}

		// 	}

		// 	$res = mysql_query('SELECT * FROM `administrator_restaurant_xref` WHERE `user_id`='. $old_id . ' ', $this->sql);
		// 	while ($row = mysql_fetch_array($res)) {
		// 		if (array_key_exists($row['restaurant_id'], $this->restaurants)) {
		// 			$data = array(
		// 				'User' => array(
		// 					'id' => $new_id
		// 				),
		// 				'Restaurant' => array(
		// 					'id' => $this->restaurants[$row['restaurant_id']]
		// 				)
		// 			);
		// 			$this->User->saveAll($data);
		// 		}
		// 	}
		// }

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
				$this->User->save($data, false);

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
	 * Transfers concours2 table from old database to contests table in new database
	 */
	// private function transfer_contests() {
	// 	$res = mysql_query("SELECT * FROM  `concours2` WHERE 1", $this->sql);
	// 	while ($row = mysql_fetch_array($res)) {
	// 		$row = $this->toText($row);
	// 		$data = array(
	// 			'Contest' => array(
	// 				'first_name'        => $row['prenom'],
	// 				'last_name'         => $row['nom'],
	// 				'address'           => $row['adresse'],
	// 				'city'              => $row['ville'],
	// 				'telephone'         => $row['tel'],
	// 				'date_of_birth'     => $row['daten'],
	// 				'gender'            => $row['sexe'],
	// 				'sector'            => $row['secteur'],
	// 				'postal_code'       => $row['code'],
	// 				'email'             => $row['email'],
	// 				'restaurant'        => $row['restaurant'],
	// 				'registration_date' => $row['date_ins']
	// 			)
	// 		);
	// 		$this->Contest->create();
	// 		$this->Contest->save($data, false);
	// 	}
	// }
		
/**
* Transfers blog_categories table from old database to contests table in new database
 */
	private function transfer_blog_categories() {
		$res = mysql_query("SELECT * FROM  `blog_categories` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			$row = $this->toText($row);
			$data = array(
				'BlogCategory' => array(
					'meta_description_en' => $row['meta_description_en'],
					'meta_description_fr' => $row['meta_description_fr'],
					'meta_keywords_en'    => $row['meta_keywords_en'],
					'meta_keywords_fr'    => $row['meta_keywords_fr'],
					'meta_name_en'       => $row['meta_title_en'],
					'meta_name_fr'       => $row['meta_title_fr'],
					'name_en'             => $row['name_en'],
					'name_fr'             => $row['name_fr'],
					'status'              => ($row['status'] == 'active') ? 'active' : 'inactive',                     
				)
			);
			$this->BlogCategory->create();
			$this->BlogCategory->save($data, false);
			$this->blog_cats[$row['category_id']] = $this->BlogCategory->getLastInsertID();
		}
	}

/**
 * Transfers features table from old database to new database
 */
	private function transfer_features() {
		$res = mysql_query("SELECT * FROM  `features` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			$row = $this->toText($row);
			$data = array(
				'Feature' => array(
					'name_en' => $row['title_en'],
					'name_fr' => $row['title_fr'],
				)
			);
			$this->Feature->create();
			$this->Feature->save($data, false);
			$this->features[$row['feature_id']] = $this->Feature->getLastInsertID();
		}
		foreach ($this->features as $old_id => $new_id) {
			$res = mysql_query('SELECT * FROM `restaurant_specialite` WHERE `ID_restaurant`='. $old_id . ' ', $this->sql);
			while ($row = mysql_fetch_array($res)) {
				if (array_key_exists($row['ID_specialite'], $this->specialties)) {
					$data = array(
						'Restaurant' => array(
							'id' => $new_id
						),
						'Location' => array(
							'id' => $this->specialties[$row['ID_specialite']]
						)
					);
					$this->Restaurant->saveAll($data);
				}
			}
		}
	}
	
/**
 * Transfers web domains table from old database to new database
 */
	private function transfer_domains() {
		$res = mysql_query("SELECT * FROM  `domains` WHERE `restaurant_id`!=0", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			if (array_key_exists($row['restaurant_id'], $this->restaurants)) {
				$row = $this->toText($row);
				$data = array(
					'Domain' => array(
						'domain_name'  => $row['domain_name'],
						'domain_type'  => $row['domain_type'],
						'main_website' => $row['main_website'],                        
						'location_id'  => $this->new_restaurants[$row['restaurant_id']],
						'status'       => ($row['status'] == 'active') ? 'active' : 'inactive',                        
						'theme_id'     => $this->themes[$row['theme_id']],          
						'theme_values' => $row['theme_values']                        
					)
				);
				$this->Domain->create();
				$this->Domain->save($data, false);
		   }
		}
	}

/**
 * Transfers devices table from old database to new database
 */
	// private function transfer_devices() {
	// 	$res = mysql_query("SELECT * FROM  `devices` GROUP BY `url` WHERE 1 ORDER BY `date` DESC", $this->sql);
	// 	while ($row = mysql_fetch_array($res)) {
	// 		$row = $this->toText($row);
	// 		$data = array(
	// 			'Device' => array(
	// 				'last_connection' => $row['date'],
	// 				'created' => $row['date']
	// 			)
	// 		);
	// 		$this->Device->create();
	// 		$this->Device->save($data, false);
	// 		$this->devices[$row['id']] = $this->Device->getLastInsertID();
	// 	}
		
	// }

/**
 * Transfers articles table from old database to new database
 */
	private function transfer_articles() {
		$res = mysql_query("SELECT * FROM  `articles` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			$row = $this->toText($row);
			$data = array(
				'Article' => array(
					'content_en'          => $row['content_en'],
					'content_fr'          => $row['content_fr'],
					'meta_description_en' => $row['meta_description_en'],
					'meta_description_fr' => $row['meta_description_fr'],
					'meta_keywords_en'    => $row['meta_keywords_en'],
					'meta_keywords_fr'    => $row['meta_keywords_fr'],
					'meta_name_en'       => $row['meta_title_en'],
					'meta_name_fr'       => $row['meta_title_en'],
					'published'           => $row['published'],
					'name_en'            => $row['title_en'],
					'name_fr'            => $row['title_fr']
				)
			);
			$this->Article->create();
			$this->Article->save($data, false);
		}
	}

/**
 * Transfer Restaurants
 */

	private function transfer_300_restaurants() {
		// restaurant table

		$query = "SELECT * FROM `restaurant` AS `r` ";

		$res = mysql_query($query, $this->sql);
		while ($row = mysql_fetch_array($res)) {
			$row = $this->toText($row);


			if (array_search($this->Location->generateUrlFromName($row['Nom_restaurant']), $this->location_urls) === false) {
				$data = array(
					'Restaurant' => array(
						'name' => $row['Nom_restaurant'],
						'logo' => array(
							'tmp_name' => $this->old_path  . 'application' . DS . 'logos' . DS . $this->clean_file_name($row['Logo_restaurant']),
							'error' => (int) 0
						)
					)
					
				);


				$this->_buildController('Restaurants');
				$this->controller->request->data = $data;


				$this->Restaurant->create();



				$this->Image->process('logo');
				


				$this->Restaurant->save($this->controller->request->data, false);
				if (isset($this->controller->request->data['Restaurant']['logo'])) {
					$this->Image->finishCreate(
						$this->controller->request->data['Restaurant']['logo'],
						$this->Restaurant->getLastInsertID()
					);
				}
				$this->restaurants[$row['ID_restaurant']] = $this->Restaurant->getLastInsertID();
				$this->restaurant_names[$row['Nom_restaurant']] = $this->Restaurant->getLastInsertID();
				$this->location_urls[] = $this->Location->generateUrlFromName($row['Nom_restaurant']);



				unset($data);

				$this->Sector->order = array('Sector.name_en' => 'ASC');
				$sector = $this->Sector->find('first', array(
					'conditions' => array(
						'code LIKE' => '%' . $row['Code_restaurant1'] . '%'
					),
					'fields' => array(
						'Sector.name_en'
					)
				));

				if (array_search($row['Nom_restaurant'], $this->location_names) !== false) {
					$name = $row['Nom_restaurant'] . ' (' . $sector['Sector']['name_en'] . ') ';
				} else {
					$name = $row['Nom_restaurant'];
				}





				$data = array(
					'Location' => array(
						'restaurant_id'     => $this->restaurant_names[$row['Nom_restaurant']],
						'address'           => $row['Adresse_restaurant'],
						'city'              => $row['Ville_restaurant'],
						'postal_code'       => $row['Code_restaurant1'] . ' ' . $row['Code_restaurant2'],
						'province'          => 'Quebec',
						'country'           => 'CA',
						'name'              => $name,
						'phone'             => $row['Tel_restaurant'],
						'website'           => $row['Site_restaurant'],
						'email'             => $row['Email_restaurant'],
						'delivery_hours'    => $row['Heures_livraison'],
						'delivery_hours_en' => $row['Heures_livraison_en'],
						'conditions_fr'     => $row['Conditions'],
						'conditions_en'     => $row['Conditions_en'],
						'rebate_text_fr'    => $row['Rabais'],
						'rebate_text_en'    => $row['Rabais_en'],
						'status'            => ($row['Active'] ? 'active' : 'inactive'),
						'visa'              => $row['Visa'],
						'mastercard'        => $row['MasterCard'],
						'american'          => $row['American'],
						'interac'           => $row['Interac'],
						'enroute'           => $row['EnRoute'],
						'online_ordering'   => $row['Order_resto'],
						'paypal'            => $row['Paypal'],
						'delivery'          => $row['delivery'],
						'pickup'            => $row['pickup'],
						'old_pdf_only'		=> true,
						'logo' 				=> array(
							'tmp_name' => $this->old_path  . 'application' . DS . 'logos' . DS . $this->clean_file_name($row['Logo_restaurant']),
							'error'    => (int) 0
						),
						'pdf_menu' 		=> array(
							'tmp_name' => $this->old_path  .  'media' . DS . $this->clean_file_name($row['PDF_restaurant']),
							'error'    => (int) 0
						)
					)
				);





				$this->_buildController('Locations');

				$this->controller->request->data = $data;

				$this->Location->create();


				$this->Image->process('logo');
				$this->PDFMenu->process('pdf_menu');



				$this->Location->save($this->controller->request->data, false);                
                $this->locationsRestaurants[$this->Location->getLastInsertID()] = $this->restaurant_names[$row['Nom_restaurant']];

				if (isset($this->controller->request->data['Location']['pdf_menu'])) {
					$this->PDFMenu->finishCreate(
						$this->controller->request->data['Location']['pdf_menu'],
						$this->Location->getLastInsertID()
					);
				}
				if (isset($this->controller->request->data['Location']['logo'])) {
					$this->Image->finishCreate(
						$this->controller->request->data['Location']['logo'],
						$this->Location->getLastInsertID()
					);
				}




				$this->location_names[] = $name;

			}
			unset($data);

			$location_id = $this->Location->getLastInsertID();



			$resource = mysql_query('SELECT * FROM `restaurant_specialite` WHERE `ID_restaurant`="' . $row['ID_restaurant'] . '"', $this->sql2);
			while ($row_inner = mysql_fetch_array($resource)) {
				if (array_key_exists($row_inner['ID_specialite'], $this->specialties)) {
					$data = array(
						'Specialty' => array(
							'id' => $this->specialties[$row_inner['ID_specialite']]
						),
						'Location' => array(
							'id' =>	$location_id
						)
					);
					$this->Location->saveAll($data);
				}
			}

			$resource = mysql_query('SELECT * FROM `restaurant_cuisine` WHERE `ID_restaurant`="' . $row['ID_restaurant'] . '"', $this->sql2);
			while ($row_inner = mysql_fetch_array($resource)) {
				$data = array(
					'Location' => array(
						'id' => $location_id
					),
					'Cuisine' => array(
						'id' => $this->cuisines[$row_inner['ID_cuisine']]
					)
				);
				$this->Location->saveAll($data);
			}
			
		}

		foreach ($this->restaurants as $old_id => $new_id) {
			$res = mysql_query('SELECT * FROM `restaurant_cuisine` WHERE `ID_restaurant`="' . $old_id . '"', $this->sql);
			while ($row = mysql_fetch_array($res)) {
				$data = array(
					'Restaurant' => array(
						'id' => $new_id
					),
					'Cuisine' => array(
						'id' => $this->cuisines[$row['ID_cuisine']]
					)
				);
				$this->Restaurant->saveAll($data);
				
			}
		}
		foreach ($this->new_restaurants as $old_id => $new_id) {
			$res = mysql_query('SELECT * FROM `restaurant_cuisine` WHERE `ID_restaurant`="' . $old_id . '"', $this->sql);
			while ($row = mysql_fetch_array($res)) {
				$data = array(
					'Restaurant' => array(
						'id' => $new_id
					),
					'Cuisine' => array(
						'id' => $this->cuisines[$row['ID_cuisine']]
					)
				);
				$this->Restaurant->saveAll($data);
				
			}
		}
		foreach ($this->restaurants as $old_id => $new_id) {
			$res = mysql_query('SELECT * FROM `restaurant_specialite` WHERE `ID_restaurant`='. $old_id . ' ', $this->sql);
			while ($row = mysql_fetch_array($res)) {
				if (array_key_exists($row['ID_specialite'], $this->specialties)) {
					$data = array(
						'Restaurant' => array(
							'id' => $new_id
						),
						'Specialty' => array(
							'id' => $this->specialties[$row['ID_specialite']]
						)
					);
					$this->Restaurant->saveAll($data);
				}
			}
		}

		foreach ($this->new_restaurants as $old_id => $new_id) {
			$res = mysql_query('SELECT * FROM `restaurant_specialite` WHERE `ID_restaurant`='. $old_id . ' ', $this->sql);
			while ($row = mysql_fetch_array($res)) {
				if (array_key_exists($row['ID_specialite'], $this->specialties)) {
					$data = array(
						'Restaurant' => array(
							'id' => $new_id
						),
						'Specialty' => array(
							'id' => $this->specialties[$row['ID_specialite']]
						)
					);
					$this->Restaurant->saveAll($data);
				}
			}
		}
		foreach ($this->new_restaurants as $old_id => $new_id) {
			$query = 'SELECT * FROM `restaurant_location_xref` AS `rl`';
			$query .= ' INNER JOIN  `locations` AS  `l` ON ( `l`.`location_id` =  `rl`.`location_id` AND `l`.`ID_secteur` != 0 )';
			$query .= ' INNER JOIN  `secteur` AS `s` ON ( `l`.`ID_secteur` = `s`.`ID_secteur`)';
			$query .= ' WHERE `rl`.`restaurant_id`=\''. $old_id . '\'';

			$res = mysql_query($query, $this->sql);
			while ($row = mysql_fetch_array($res)) {
				if (array_search($row['name'], $this->location_names) !== false) {
					$name = $row['name'] . ' (' . $row['Titre_secteur'] . ') ';
				} else {
					$name = $row['name'];
				}
				if (array_key_exists($row['location_id'], $this->locations)) {
					$data = array(
						'Location' => array(
							'restaurant_id' => $new_id,
							'id'            => $this->locations[$row['location_id']],
							'name'			=> $name
						)
					);
					$this->Location->save($data, false);
					$this->location_names[$name] = $this->Location->getLastInsertID();
				}
			}
			// $resource = mysql_query('SELECT * FROM `restaurant_secteur` WHERE `ID_restaurant`="' . $old_id . '"', $this->sql2);
			// while ($row_inner = mysql_fetch_array($resource)) {
			// 	$data = array(
			// 		'Sector' => array(
			// 			'id' => $this->sectors[$row_inner['ID_secteur']]
			// 		),
			// 		'Location' => array(
			// 			'id' =>	$new_id
			// 		)
			// 	);
			// 	$this->Location->saveAll($data);
			// }
		}
	}

/**
 * Transfer Themes
 */
	private function transfer_themes() {
		$res = mysql_query("SELECT * FROM  `themes` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			$row = $this->toText($row);
			$data = array(
				'Theme' => array(
					'name'             => $row['name'],
					'folder_name'      => $row['folder_name'],
					'default_settings' => $row['default_settings']
				)
			);
			$this->Theme->create();
			$this->Theme->save($data, false);
			$this->themes[$row['theme_id']] = $this->Theme->getLastInsertID();
		}
	}

/**
 * Transfer Cuisines
 */
	private function transfer_100_cuisines() {
		$res = mysql_query("SELECT * FROM  `cuisines` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			$row = $this->toText($row);
			$data = array(
				'Cuisine' => array(
					'name_en'          => $row['name_en'],
					'name_fr'          => $row['name_fr']
				)
			);
			$this->Cuisine->create();
			$this->Cuisine->save($data, false);
			$this->cuisines[$row['cuisine_id']] = $this->Cuisine->getLastInsertID();
		}
		foreach ($this->cuisines as $old_id => $new_id) {
			if (empty($this->locations)) {
				break;
			}
			$res = mysql_query('SELECT * FROM `cuisine_location_xref` WHERE `cuisine_id`='. $old_id . ' ', $this->sql);
			while ($row = mysql_fetch_array($res)) {
				$data = array(
					'Cuisine' => array(
						'id' => $new_id
					),
					'Location' => array(
						'id' => $this->locations[$row['location_id']]
					)
				);
				$this->Cuisine->saveAll($data);
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

/**
 * Transfer delivery areas
 */
	private function transfer_delivery_areas() {
		$res = mysql_query("SELECT * FROM  `location_postal_code_xref` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			if (array_key_exists($row['location_id'], $this->locations)) {
				$row = $this->toText($row);
				$data = array(
					'DeliveryArea' => array(
						'location_id'     => $this->locations[$row['location_id']],
						'postal_code'     => $row['postal_code'],
						'delivery_charge' => $row['delivery_charge']

					)
				);
				$this->DeliveryArea->create();
				$this->DeliveryArea->save($data, false);
			}
		}
	}

/**
 * Transfer Coupons
 */
	private function transfer_coupons() {
		$res = mysql_query("SELECT * FROM  `coupons` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			if (
				array_key_exists($row['user_id'], $this->user_ids)
				&& array_key_exists($row['location_id'], $this->locations)
			) {
				$row = $this->toText($row);
				$data = array(
					'Coupon' => array(
						'user_id'         => $this->user_ids[$row['user_id']],
						'location_id'     => $this->locations[$row['location_id']],
						'coupon_code'     => $row['coupon_code'],
						'discount_type'   => $row['discount_type'],
						'discount'        => $row['discount'],
						'date_created'    => $row['date_created'],
						'experation_date' => $row['valid_till_date'],
						'coupon_type'     => $row['coupon_type'],
						'frequency'       => $row['frequency'],
						'frequency_used'  => $row['frequency_used'],
						'status'          => ($row['status'] == 'active') ? 'active' : 'inactive'

					)
				);
				$this->DeliveryAddress->create();
				$this->DeliveryAddress->save($data, false);
			}
		}
	}


/**
 * Transfers Locations table from old database to new database
 */
	private function transfer_200_locations() {

		// restaurants table
		$res = mysql_query("SELECT * FROM  `restaurants` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {

			if (!array_key_exists($row['name'], $this->restaurant_names)) {
				$row = $this->toText($row);

				$data = array(
					'Restaurant' => array(
						'name' => $row['name']
					)

				);

				$this->Restaurant->create();
				$this->Restaurant->save($data, false);
				$this->new_restaurants[$row['restaurant_id']] = $this->Restaurant->getLastInsertID();
				$this->restaurant_names[$row['name']] = $this->Restaurant->getLastInsertID();
			}
		}


		$res = mysql_query("SELECT `x`.*, `l`.* FROM `restaurant_location_xref` AS `x` INNER JOIN `locations` AS `l` ON (`l`.`location_id` = `x`.`location_id`)", $this->sql);
		
		while ($row = mysql_fetch_array($res)) {
			$this->Sector->order = array('Sector.name_en' => 'ASC');
			$sector = $this->Sector->find('first', array(
				'conditions' => array(
					'code LIKE' => '%' . substr($row['postal_code'], 0, 3) . '%'
				),
				'fields' => array(
					'Sector.name_en'
				)
			));

			if (array_search($row['name'], $this->location_names) !== false) {
				$name = $row['name'] . ' (' . $sector['Sector']['name_en'] . ') ';
			} else {
				$name = $row['name'];
			}

			$data = array(
				'Location' => array(
					'restaurant_id'         => $this->new_restaurants[$row['restaurant_id']],
					'building_number'       => $row['building_no'],
					'city'                  => $row['city'],
					'country'               => 'CA',
					'delivery_end'          => $row['delivery_end'],
					'delivery_start'        => $row['delivery_start'],
					'delivery'              => $row['delivey'],
					'description_en'        => $row['description_en'],
					'description_fr'        => $row['description_fr'],
					'email'                 => $row['email'],
					'fax'                   => $row['fax'],
					'name'                  => $name,
					'phone'                 => $row['phone'],
					'pickup'                => $row['pickup'],
					'postal_code'           => $row['postal_code'],
					'province'              => $row['province'],
					'real_time_status'      => $row['real_time_status'],
					'street'                => $row['street'],
					'use_email'             => $row['use_email'],
					'use_fax'               => $row['use_fax'],
					'accepted_credit_cards' => $row['accepted_credit_cards'],
					'delivery_message_en'   => $row['delivery_message_en'],
					'delivery_message_fr'   => $row['delivery_message_fr'],
					'featured'              => $row['featured'],
					'delivery_min_order'    => $row['min_order'],
					'status'                => ($row['status'] == 'active') ? 'active' : 'inactive',
					'weight'                => $row['weight'],
					'logo'                  => array(
						'tmp_name' => $this->old_path  . 'application' . DS . 'logos' . DS . $this->clean_file_name($row['logo']),
						'error' => (int) 0
					),
				)
			);

			$this->_buildController('Locations');

			
			$this->controller->request->data = $data;

			$this->Location->create();
			$this->Image->process('logo');


			$this->Location->create();
			$this->Location->save($this->controller->request->data, false);
			if (isset($this->controller->request->data['Location']['logo'])) {
				$this->Image->finishCreate(
					$this->controller->request->data['Location']['logo'],
					$this->Location->getLastInsertID()
				);
			}

			$this->locations[$row['location_id']] = $this->Location->getLastInsertID();			
			$this->location_names[$name] = $this->Location->getLastInsertID();
			$this->location_urls[] = $this->Location->generateUrlFromName($name);
            }
		}
/**
 * Transfers Location_gallery table from old database to new database
 */
	private function transfer_location_galleries() {
		$res = mysql_query("SELECT * FROM  `location_gallery` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			if (array_key_exists($row['location_id'], $this->locations)) {
				$row = $this->toText($row);
				$data = array(
					'LocationGallery' => array(
						'caption_en'  => $row['caption_en'],
						'caption_fr'  => $row['caption_fr'],
						'image'       => array(
							'tmp_name' => $this->old_path  
								. 'application'
								. DS
								. 'location_gallery'
								. DS
								. 'original'
								. DS
								. $this->clean_file_name($row['image']),
							'error' => (int) 0
						),
						'location_id' => $this->locations[$row['location_id']]
					)
				);
				$this->LocationGallery->create();

				$this->_buildController('LocationGallery');
				$this->controller->request->data = $data;

				$this->Image->process('image');

				$this->LocationGallery->save($this->controller->request->data, false);

				if (isset($this->controller->request->data['LocationGallery']['logo'])) {
					$this->Image->finishCreate(
						$this->controller->request->data['LocationGallery']['logo'],
						$this->LocationGallery->getLastInsertID()
					);
				}
			}
		}
	}


/**
 * Transfers logs table from old database to new database
 */
	private function transfer_logs() {
		$res = mysql_query("SELECT * FROM  `logs` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			$row = $this->toText($row);
			$data = array(
				'Log' => array(
					'api_key'    => $row['api_key'],
					'authorized' => $row['authorized'],
					'ip_address' => $row['ip_address'],
					'method'     => $row['method'],
					'params'     => $row['params'],
					'time'       => $row['time'],
					'uri'        => $row['uri'],
				)
			);
			$this->Log->create();
			$this->Log->save($data, false);
		}
	}
/**
 * Transfers menus table from old database to new database
 */
private function transfer_400_menus() {
    
    // oldDatabase.restaurants
    $query = <<<EOF
SELECT r.restaurant_id AS 'r.id', m.menu_id AS 'm.id', rl.location_id AS 'rl.location_id', m.name AS 'm.name', m.status AS 'm.status'
FROM restaurants AS r
RIGHT JOIN menus AS m ON m.restaurant_id = r.restaurant_id
JOIN restaurant_location_xref AS rl ON rl.restaurant_id = r.restaurant_id
EOF;

        $res = mysql_query($query, $this->sql);
        while ($row = mysql_fetch_array($res)) {

            if (array_key_exists($row['r.id'], $this->new_restaurants) &&
                array_key_exists($row['rl.location_id'], $this->locations)) {
                $row = $this->toText($row);
                $data = array(
                    'Menu' => array(
                        'name' => $row['m.name'],
                        'location_id' => $this->locations[$row['rl.location_id']],
                        'restaurant_id' => $this->new_restaurants[$row['r.id']],
                        'status' => ($row['m.status'] == 'active') ? 'active' : 'inactive'
                    )
                );
                $this->Menu->create();
                $this->Menu->save($data, false);
                $this->menus[$row['m.id']] = $this->Menu->getLastInsertID();
            }
        }
        
    // oldDatabase.restaurants
    $query = <<<EOF
SELECT r.ID_restaurant AS 'r.id', m.menu_id AS 'm.id', rl.location_id AS 'rl.location_id', m.name AS 'm.name', m.status AS 'm.status'
FROM restaurant AS r
RIGHT JOIN menus AS m ON m.restaurant_id = r.ID_restaurant
JOIN restaurant_location_xref AS rl ON rl.restaurant_id = r.ID_restaurant
EOF;

        $res = mysql_query($query, $this->sql);
        while ($row = mysql_fetch_array($res)) {

            if (array_key_exists($row['r.id'], $this->restaurants) &&
                array_key_exists($row['rl.location_id'], $this->locations)) {
                $row = $this->toText($row);
                $data = array(
                    'Menu' => array(
                        'name' => $row['m.name'],
                        'location_id' => $this->locations[$row['rl.location_id']],
                        'restaurant_id' => $this->restaurants[$row['r.id']],
                        'status' => ($row['m.status'] == 'active') ? 'active' : 'inactive'
                    )
                );
                $this->Menu->create();
                $this->Menu->save($data, false);
                $this->menus[$row['m.id']] = $this->Menu->getLastInsertID();
            }
        }
    }
        
                
/**
 * Transfers item_group_menu_xref table from old database to new database
 */
	private function transfer_500_menu_categories() {

		$res = mysql_query("SELECT * FROM `item_group_menu_xref` AS `x` INNER JOIN `item_groups` AS `g` ON (`g`.`group_id` = `x`.`group_id`) ORDER BY `g`.`serial_no` ASC", $this->sql);
		while ($row = mysql_fetch_array($res)) {
				$row = $this->toText($row);
				if (array_key_exists($row['menu_id'], $this->menus)) {
					$data = array(
						'MenuCategory' => array(
							'description_en' => $row['description_en'],
							'description_fr' => $row['description_fr'],
							'name_en' => $row['name_en'],
							'name_fr' => $row['name_fr'],
							'start_time' => $row['time_start'],
							'end_time' => $row['time_end'],
							'menu_id' => $this->menus[$row['menu_id']],
							'status' => ($row['status'] == 'active') ? 'active' : 'inactive',
						)
					);
					$this->MenuCategory->attachTree($data['MenuCategory']['menu_id']);
					$this->MenuCategory->create();
					$this->MenuCategory->save($data, false);
					$this->menu_categories[$row['group_id']] = $this->MenuCategory->getLastInsertID();
				}
		}	
	}

	/**
	 * Transfers menu_option table form the old database to the new menu_item_options table
	 */

	private function transfer_501_menu_item_options() {
	
        $query =<<<EOF
SELECT ioov.*, io.*, miio.*, miig.*, igm.*
FROM option_values AS ov
LEFT JOIN item_option_option_value_xref AS ioov
  ON ov.value_id = ioov.value_id
LEFT JOIN item_options AS io
  ON ioov.option_id = io.option_id
LEFT JOIN menu_item_item_option_xref AS miio
  ON (miio.option_id = ioov.option_id)
LEFT JOIN menu_items AS mi
  ON ( mi.item_id = miio.item_id)
LEFT JOIN menu_item_item_group_xref AS miig
  ON (miig.item_id = miio.item_id)
LEFT JOIN item_group_menu_xref AS igm
  ON (igm.group_id = miig.group_id)
GROUP BY mi.item_id
EOF;
        $res = mysql_query($query, $this->sql);
		while ($row = mysql_fetch_array($res)) {
			if (array_key_exists($row['group_id'], $this->menu_categories)) {
				$row = $this->toText($row);
				$data = array(
					'MenuItemOption' => array(
						'name_en'               => $row['name_en'],
						'name_fr'               => $row['name_fr'],
						'price'                 => !empty($row['price']) ? $row['price'] : 0,
						'multiselect'           => $row['multiselect'],
						'required'              => $row['required'],
						'number_of_free_values' => $row['no_of_free_values'],
						'number_of_portions'    => $row['half_n_half'],
						'status'                => ($row['status'] == 'active') ? 'active' : 'inactive',
						'menu_category_id'      => $this->menu_categories[$row['group_id']],
						'menu_id'               => $this->menus[$row['menu_id']]
					)
				);
				$this->MenuItemOption->create();
				$this->MenuItemOption->save($data, false);
				$this->menu_item_options[$row['option_id']] = $this->MenuItemOption->getLastInsertID();
                
                foreach ($this->menu_items as $old_id => $new_id) {
	                if (empty($this->menu_items)) {
	                    break;
	                }

	                $res = mysql_query('SELECT * FROM `menu_item_item_option_xref` WHERE `option_id`=' . $old_id . ' ', $this->sql);
	                while ($row = mysql_fetch_array($res)) {

	                    $data = array(
	                        'MenuItem' => array(
	                            'id' => $new_id
	                        ),
	                        'MenuItemOption' => array(
	                            'id' => $this->MenuItemOption->getLastInsertID()
	                        )
	                    );
	                    $this->MenuItemOption->saveAll($data);
	                }
				}
			}
		}
		$query2 =<<<EOF
SELECT `ioov`.*, `ov`.* FROM `item_option_option_value_xref` AS `ioov`
INNER JOIN `item_options` AS `io` ON (`ioov`.`option_id` = `io`.`option_id`)
INNER JOIN `option_values` AS `ov` ON (`ov`.`value_id` = `ioov`.`value_id`)
ORDER BY `ov`.`serial_no`
EOF;
		$res = mysql_query($query2, $this->sql);
		while ($row = mysql_fetch_array($res)) {
			if (array_key_exists($row['option_id'], $this->menu_item_options)) {
				$row = $this->toText($row);
				$data = array(
					'MenuItemOptionValue' => array(
						'name_en'             => $row['name_en'],
						'name_fr'             => $row['name_fr'],
						'price'               => !empty($row['price']) ? $row['price'] : 0,
						'status'              => ($row['status'] == 'active') ? 'active' : 'inactive',
						'menu_item_option_id' => $this->menu_item_options[$row['option_id']],
					)
				);
				$this->MenuItemOption->MenuItemOptionValue->create();
				$this->MenuItemOption->MenuItemOptionValue->save($data, false);
			}
		}
    }

/**
 * Transfers menus_items table from old database to new database
 */
    private function transfer_600_menu_items() {

        $query = <<<EOF
SELECT `mi`.*, `miig`.`group_id`, `igm`.`menu_id` FROM `menu_items` AS `mi`
LEFT JOIN `menu_item_item_group_xref` AS `miig` ON (`mi`.`item_id` = `miig`.`item_id`)
LEFT JOIN `item_group_menu_xref` AS `igm` ON (`miig`.`group_id` = `igm`.`group_id`)
GROUP BY `mi`.`item_id`
EOF;
        $res = mysql_query($query, $this->sql);
        while ($row = mysql_fetch_array($res)) {
        	if (array_key_exists($row['group_id'], $this->menu_categories)) {
	            $row = $this->toText($row);
	            $data = array(
	                'MenuItem' => array(
						'description_en' => $row['description_en'],
						'description_fr' => $row['description_fr'],
						'icons'          => $row['icons'],
						'image'                  => array(
							'tmp_name' => $this->old_path  . 'application' . DS . 'item_images' . DS . 'original' . DS . $this->clean_file_name($row['image']),
							'error' => (int) 0
						),
						'name_en'        => $row['name_en'],
						'name_fr'        => $row['name_fr'],
						'status'         => ($row['status'] == 'active') ? 'active' : 'inactive',
						'price'          => (float) $row['price']
					)
	            );

	            if (array_key_exists($row['menu_id'], $this->menus)) {
	                $data['MenuItem']['menu_id'] = $this->menus[$row['menu_id']];
	            }

	            $this->MenuItem->create();
	            $this->_buildController('MenuItems');
				$this->controller->request->data = $data;

				$this->Image->process('image');

				$data = $this->controller->request->data;


	            $data['MenuItem']['menu_category_id'] = $this->menu_categories[$row['group_id']];





	            $this->MenuItem->attachTree($data['MenuItem']['menu_category_id']);
	            $this->MenuItem->save($data, false);
	            $this->menu_items[$row['item_id']] = $this->MenuItem->getLastInsertID();
            }
        }

        // Populate many to many tables associated with this one
        foreach ($this->menu_items as $old_id => $new_id) {

            // // menu_category_menu_items
            // $res = mysql_query('SELECT * FROM  `menu_item_item_group_xref` WHERE `item_id` =' . $old_id . ' ', $this->sql);

            // while ($row = mysql_fetch_array($res)) {
            //     $data = array(
            //         'MenuItem' => array('id' => $new_id),
            //         'MenuCategory' => array('id' => $this->menu_categories[$row['group_id']]));
            //     $this->MenuItem->saveAll($data);
            // }


            // menu_item_option_menu_items
            $res = mysql_query('SELECT * FROM  `menu_item_item_option_xref` WHERE `item_id` =' . $old_id . ' ', $this->sql);
            while ($row = mysql_fetch_array($res)) {
            	if (array_key_exists($row['option_id'], $this->menu_item_options)) {
	                $data = array(
	                    'MenuItem' => array('id' => $new_id),
	                    'MenuItemOption' => array('id' => $this->menu_item_options[$row['option_id']]));
	                $this->MenuItem->saveAll($data);
				}
            }
        }
    }

	

/**
 * Transfers orders table from old database to new database
 */
	private function disable_transfer_700_orders() {
		$res = mysql_query("SELECT * FROM  `orders` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			$row     = $this->toText($row);
			
			$data = array(
				'Order' => array(
					'date'                   => $row['dated'],
					'delivery_charge'        => $row['delivery_charge'],
					'gst'                    => $row['gst'],
					'gst_percent'            => $row['gst_percent'],
					'hst'                    => $row['hst'],
					'hst_percent'            => $row['hst_percent'],
					'location_id'            => $this->locations[$row['location_id']],
					'subtotal'               => $row['order_subtotal'],
					'total'                  => $row['order_total'],
					'paid_by'                => $row['paid_by'],
					'paid_to_client'         => $row['paid_to_client'],
					'points_earned'          => $row['points_earned'],
					'pst'                    => $row['pst'],
					'pst_name'               => $row['pst_name_fr'],
					'compound_tax'           => $row['pst_on_gst'],
					'pst_percent'            => $row['pst_percent'],
					'redeemed_points'        => $row['redeemed_points'],
					'redeemed_points_value'  => $row['redeemed_points_value'],
					'restaurant_id'          => $this->new_restaurants[$row['restaurant_id']],
					'tip'                    => $row['tip'],
					'transaction_number'     => $row['transaction_id'],
					'first_name'             => $row['first_name'],
					'last_name'              => $row['last_name'],
					'address'                => $row['address'],
					'address2'               => $row['address2'],
					'city'                   => $row['city'],
					'state'                  => $row['state'],
					'postal_code'            => $row['postal_code'],
					'door_code'              => $row['door_code'],
					'cross_street'           => $row['cross_street'],
					'phone'                  => $row['phone'],
					'email'                  => $row['email'],
					'special_instruction'    => $row['special_instruction'],
					'coupon_code'            => $row['coupon_code'],
					'coupon_discount'        => $row['coupon_discount'],
					'language'               => $row['language'],
					'status'                 => $row['status'],
					'type' 			         => $row['order_goes_to'],
					// 'future_order_time'      => $row['future_order_time'],
					// 'expected_delivery_time' => $row['expected_delivery_time'],
					'response'  		     => $row['rejection_reason'],
					'referrer'               => $row['referrer'],
					//'id' 					 => String::uuid()
				)
			);
			if (array_key_exists($row['user_id'], $this->user_ids)) {
				$data['Order']['user_id'] = $this->user_ids[$row['user_id']];
			}
			// $res2 = mysql_query("SELECT * FROM  `order_detail` WHERE `order_id`=" . $row['order_id'], $this->sql2);
			// while ($row2 = mysql_fetch_array($res2)) {
			// 	$row2 = $this->toText($row2);
			// 	$data['Order']['OrderDetail'][] = array(
			// 		'name_en'             => $row2['name_en'],
			// 		'name_fr'             => $row2['name_fr'],
			// 		'options'             => $row2['options'],
			// 		'price'               => $row2['price'],
			// 		'quantity'            => $row2['quantity'],
			// 		'special_instruction' => $row2['special_instruction'],
			// 	);
			// }

			$this->Order->create();
			$this->Order->save($data, false);
			$this->orders[$row['order_id']] = $this->Order->getLastInsertID();
		
		}
	}

/**
 * Transfers order_detail table from old database to new database
 */
	private function disable_transfer_800_order_details() {
		$res = mysql_query("SELECT * FROM  `order_detail` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			if (
				//array_key_exists($row['item_id'], $this->menu_items)
				array_key_exists($row['order_id'], $this->orders)
			) {
				$row = $this->toText($row);
				$data = array(
					'OrderDetail' => array(
						//'menu_item_id'        => $this->menu_items[$row['item_id']],
						'name_en'             => $row['name_en'],
						'name_fr'             => $row['name_fr'],
						'options'             => json_encode(unserialize($row['options'])),
						'order_id'            => $this->orders[$row['order_id']],
						'price'               => $row['price'],
						'quantity'            => $row['quantity'],
						'special_instruction' => $row['special_instruction'],
					)
				);
				$this->OrderDetail->create();
				$this->OrderDetail->save($data, false);
			}
		}
	}


/**
 * Transfers pages table from old database to new database
 */
	private function transfer_pages() {
		$res = mysql_query("SELECT * FROM  `page` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			$row = $this->toText($row);
			$data = array(
				'Page' => array(
					'content' => $row['Contenu'],
					'title'   => $row['Lib'],
				)
			);
			$this->Page->create();
			$this->Page->save($data, false);
		}
	}


/**
 * Transfers phone clicks table from old database to new database
 */
	private function transfer_phone_clicks() {
		$res = mysql_query("SELECT * FROM  `phone_clicks` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			if (array_key_exists($row['location_id'], $this->locations)) {
				$row = $this->toText($row);
				$data = array(
					'PhoneClick' => array(
						'dated'       => $row['dated'],
						'location_id' => $this->locations[$row['location_id']],
					)
				);
				$this->PhoneClick->create();
				$this->PhoneClick->save($data, false);
			}
		}
	}

/**
 * Transfers posts table from old database to new database
 */
	private function transfer_posts() {
		$res = mysql_query("SELECT * FROM  `posts` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			$row = $this->toText($row);
			$data = array(
				'Post' => array(
					'content_en'          => $row['content_en'],
					'content_fr'          => $row['content_fr'],
					'meta_description_en' => $row['meta_description_en'],
					'meta_description_fr' => $row['meta_description_fr'],
					'meta_keywords_en'    => $row['meta_keywords_en'],
					'meta_keywords_fr'    => $row['meta_keywords_fr'],
					'meta_name_en'       => $row['meta_title_en'],
					'meta_name_fr'       => $row['meta_title_fr'],
					'post_date'           => $row['post_date'],
					'published'           => $row['published'],
					'name_en'            => $row['title_en'],
					'name_fr'            => $row['title_fr'],
				)
			);
			$this->Post->create();
			$this->Post->save($data, false);
			$this->posts[$row['post_id']] = $this->Post->getLastInsertID();
		}

		foreach ($this->posts as $old_id => $new_id) {
			if (empty($this->blog_cats)) {
				break;
			}
			$res = mysql_query('SELECT * FROM `post_category_xref` WHERE `post_id`='. $old_id . ' ', $this->sql);
			while ($row = mysql_fetch_array($res)) {
				$data = array(
					'Post' => array(
						'id' => $new_id,
						'blog_category_id' => $this->blog_cats[$row['category_id']]
					)
				);
				$this->Post->saveAll($data);
			}
		}
	}

/**
 * Transfers ratings table from old database to new database
 */
	private function transfer_ratings() {
		$res = mysql_query("SELECT * FROM  `rating` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			if (
				array_key_exists($row['user_id'], $this->user_ids)
				&& array_key_exists($row['location_id'], $this->locations
			)) {
				$row = $this->toText($row);
				$data = array(
					'Rating' => array(
						'location_id' => $this->locations[$row['location_id']],
						'rating'      => $row['rating'],
						'user_id'     => $this->user_ids[$row['user_id']]
					)
				);
				$this->Rating->create();
				$this->Rating->save($data, false);
			}
		}
	}

/**
 * Transfers reviews table from old database to new database
 */
	private function transfer_reviews() {
		$res = mysql_query("SELECT * FROM  `reviews` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			if (
				array_key_exists($row['restaurant_id'], $this->restaurants)
				&& array_key_exists($row['location_id'], $this->locations)
			) {
				$row = $this->toText($row);
				$data = array(
					'Review' => array(
						'coupon_code'   => $row['coupon_code'],
						'email'         => $row['email'],
						'first_name'    => $row['first_name'],
						'language'      => $row['language'],
						'last_name'     => $row['last_name'],
						'location_id'   => $this->locations[$row['location_id']],
						'rating'        => $row['rating'],
						'restaurant_id' => $this->restaurants[$row['restaurant_id']],
						'review'        => $row['review'],
						'review_date'   => $row['review_date'],
						'status'        => ($row['status'] == 'active') ? 'active' : 'inactive',
					)
				);
				$this->Review->create();
				$this->Review->save($data, false);
				$this->reviews[$row['review_id']] = $this->Review->getLastInsertID();
			}
		}
	}


/**
 * Transfers sector table from old database to new database
 */
	private function transfer_100_sectors() {
		$res = mysql_query("SELECT * FROM  `secteur` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			$row = $this->toText($row);
			$code = strtoupper(preg_replace('/\;/', ',', $row['Code_secteur']));
			$code = preg_replace('/ /', '', $code);
			$data = array(
				'Sector' => array(
					'code'     => $code,
					'name_fr' => $row['Titre_secteur'],
					'name_en' => $row['Titre_secteur_en']
				)
			);
			//// MUST IMPORT IMAGES
			$this->Sector->create();
			$this->Sector->save($data, false);
			$this->sectors[$row['ID_secteur']] = $this->Sector->getLastInsertID();
		}
	}

/**
 * Transfers review_code table from old database to new database
 */
	private function transfer_review_codes() {
		$res = mysql_query("SELECT * FROM  `review_code` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			if (array_key_exists($row['order_id'], $this->orders) && array_key_exists($row['review_id'], $this->reviews)) {
				$row = $this->toText($row);
				$data = array(
					'ReviewCode' => array(
						'order_id'  => $this->orders[$row['order_id']],
						'review_id' => $this->reviews[$row['review_id']]
					)
				);
				$this->ReviewCode->create();
				$this->ReviewCode->save($data, false);
			}
		}
	}

/**
 * Transfers schedules table from old database to new database
 */
	private function transfer_schedules() {
		$res = mysql_query("SELECT * FROM  `schedules` WHERE 1", $this->sql);
		
		while ($row = mysql_fetch_array($res)) {
			if (array_key_exists($row['location_id'], $this->locations)) {
				$row = $this->toText($row);
				foreach ($row as $key => $value) {
					switch ($key) {
						case 'day_id':
						case 'split_delivery_time':
						case 'location_id':
							continue;
						break;

						default:
							if (!empty($value))
								$row[$key] = date('H:i:s', strtotime($value));
						break;
					}
				}
				$data = array(
					'Schedule' => array(
						'day'                 => $row['day_id'],
						'delivery_end1'       => $row['delivery_end1'],
						'delivery_end2'       => $row['delivery_end2'],
						'delivery_start1'     => $row['delivery_start1'],
						'delivery_start2'     => $row['delivery_start2'],
						'location_id'         => $this->locations[$row['location_id']],
						'opening_hour'        => $row['opening_hour'],
						'closing_hour'        => $row['closing_hour'],
						'split_delivery_time' => $row['split_delivery_time'],
					)
				);
				$this->Schedule->create();
				$this->Schedule->save($data, false);
			}
		}
	}


/**
 * Transfers slideshow_images table from old database to new database
 */
	private function transfer_slideshow_images() {
		$res = mysql_query("SELECT * FROM  `slideshow_images` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			$row = $this->toText($row);
			$data = array(
				'SlideshowImage' => array(
					'description_en' => $row['description_en'],
					'description_fr' => $row['description_fr'],
					'image_en'       => array(
						'tmp_name' => $this->old_path  . 'application' . DS . 'slideshow_images' . DS . $this->clean_file_name($row['image_en']),
						'error'    => (int) 0
					),
					'image_fr'       => array(
						'tmp_name' => $this->old_path  . 'application' . DS . 'slideshow_images' . DS . $this->clean_file_name($row['image_fr']),
						'error'    => (int) 0
					),
					'name_en'       => $row['title_en'],
					'name_fr'       => $row['title_fr']
				)
			);
			$this->SlideshowImage->create();
			$this->_buildController('SlideshowImage');
			$this->controller->request->data = $data;


			$this->Image->process('image_en');
			$this->Image->process('image_fr');

			$this->SlideshowImage->save($this->controller->request->data, false);
			if (isset($this->controller->request->data['SlideshowImage']['image_en'])) {
				$this->Image->finishCreate(
					$this->controller->request->data['SlideshowImage']['image_en'],
					$this->SlideshowImage->getLastInsertID()
				);
			}
			if (isset($this->controller->request->data['SlideshowImage']['image_fr'])) {
				$this->Image->finishCreate(
					$this->controller->request->data['SlideshowImage']['image_fr'],
					$this->SlideshowImage->getLastInsertID()
				);
			}
		}
	}

/**
 * Transfers specialite table from old database to new database
 */
	private function transfer_100_speciality() {
		$res = mysql_query("SELECT * FROM  `specialite` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			$row = $this->toText($row);
			$data = array(
				'Specialty' => array(
					'name_fr'   => $row['Titre_specialite'],
					'name_en'   => $row['Titre_specialite_en'],
				)
			);
			$this->Specialty->create();
			$this->Specialty->save($data, false);
			$this->specialties[$row['ID_specialite']] = $this->Specialty->getLastInsertID();	
		}        
	}


/**
 * Transfers taxes table from old database to new database
 */
private function transfer_taxes() {
    
        $data = array(
            array('id' => '5239bb59-1798-4b42-9f82-39a0fe51d21f', 'country' => 'CA', 'province' => 'MA', 'name_fr' => '', 'name_en' => 'PST', 'percent' => '5.000', 'compound' => '0'),
            array('id' => '5239bb59-1e1c-4e25-99bc-39a0fe51d21f', 'country' => 'CA', 'province' => 'PE', 'name_fr' => '', 'name_en' => 'GST', 'percent' => '10.000', 'compound' => '0'),
            array('id' => '5239bb59-2f04-45bf-bbff-39a0fe51d21f', 'country' => 'CA', 'province' => 'NB', 'name_fr' => '', 'name_en' => 'GST', 'percent' => '5.000', 'compound' => '0'),
            array('id' => '5239bb59-3150-4c0d-aaeb-39a0fe51d21f', 'country' => 'CA', 'province' => 'ON', 'name_fr' => '', 'name_en' => 'HST', 'percent' => '8.000', 'compound' => '0'),
            array('id' => '5239bb59-342c-4d98-9972-39a0fe51d21f', 'country' => 'CA', 'province' => 'YU', 'name_fr' => '', 'name_en' => 'GST', 'percent' => '5.000', 'compound' => '0'),
            array('id' => '5239bb59-4260-4075-aa7b-39a0fe51d21f', 'country' => 'CA', 'province' => 'NF', 'name_fr' => '', 'name_en' => 'GST', 'percent' => '8.000', 'compound' => '0'),
            array('id' => '5239bb59-535c-4c05-89d3-39a0fe51d21f', 'country' => 'CA', 'province' => 'QC', 'name_fr' => 'TPS', 'name_en' => 'GST', 'percent' => '5.000', 'compound' => '0'),
            array('id' => '5239bb59-606c-4caa-b1ec-39a0fe51d21f', 'country' => 'CA', 'province' => 'BC', 'name_fr' => 'TPS', 'name_en' => 'GST', 'percent' => '7.000', 'compound' => '0'),
            array('id' => '5239bb59-68b0-46f4-ac89-39a0fe51d21f', 'country' => 'CA', 'province' => 'SA', 'name_fr' => '', 'name_en' => 'GST', 'percent' => '5.000', 'compound' => '0'),
            array('id' => '5239bb59-9474-442f-b46c-39a0fe51d21f', 'country' => 'CA', 'province' => 'NT', 'name_fr' => '', 'name_en' => 'PST', 'percent' => '5.000', 'compound' => '0'),
            array('id' => '5239bb59-b9ac-47a2-bf40-39a0fe51d21f', 'country' => 'CA', 'province' => 'NS', 'name_fr' => '', 'name_en' => 'GST', 'percent' => '5.000', 'compound' => '0'),
            array('id' => '5239bb59-d598-4f1b-8ca5-39a0fe51d21f', 'country' => 'CA', 'province' => 'AL', 'name_fr' => 'TPS', 'name_en' => 'GST', 'percent' => '5.000', 'compound' => '0'),
            array('id' => '5239bb59-ffd8-4e58-8343-39a0fe51d21f', 'country' => 'CA', 'province' => 'NU', 'name_fr' => '', 'name_en' => 'GST', 'percent' => '5.000', 'compound' => '0')
        );
        
        foreach ($data as $d) {
            $data_tmp = array('Tax' => $d);
            $this->Tax->create();
            $this->Tax->save($data_tmp, false);
        }   
    }


/**
 * Insert default tip options into database
 * No previous data existed for this
 */
private function transfer_tip_options() {
    
        $data = array(
            array('amount' => 1, 'location_id' => 'default'),
            array('amount' => 2, 'location_id' => 'default'),
            array('amount' => 3, 'location_id' => 'default')
        );
        
        foreach ($data as $d) {
            $data_tmp = array('Tax' => $d);
            $this->TipOption->create();
            $this->TipOption->save($data_tmp, false);
        }   
    }
    
    
	
    

/**
 * Transfers user_points table from old database to new database
 */
	private function transfer_user_points() {
		$res = mysql_query("SELECT * FROM `user_points` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			if (array_key_exists($row['user_id'], $this->user_ids)) {
				$row = $this->toText($row);
				$data = array(
					'UserPoint' => array(
						'points'  => $row['points'],
						'user_id' => $this->user_ids[$row['user_id']],
					)
				);
				$this->UserPoint->create();
				$this->UserPoint->save($data, false);
		   }
		}
	}
/**
 * Transfers user_points table from old database to new database
 */
	private function transfer_invoices() {
		$res = mysql_query("SELECT * FROM `invoices` WHERE 1", $this->sql);
		while ($row = mysql_fetch_array($res)) {
			if (
				array_key_exists($row['restaurant_id'], $this->restaurants)
				&& array_key_exists($row['location_id'], $this->locations)
			) {
				$row = $this->toText($row);
				$data = array(
					'Invoice' => array(
						'from_date'      => $row['from_date'],
						'invoice_number' => $row['invoice_no'],
						'location_id'    => $this->locations[$row['location_id']],
						'paid_amount'    => $row['paid_amount'],
						'pdf_name'       => $row['pdf_name'],
						'restaurant_id'  => $this->restaurants[$row['restaurant_id']],
						'status'         => $row['status'],
						'total_amount'   => $row['total_amount'],
						'to_date'        => $row['to_date']
					)
				);
				$this->Invoice->create();
				$this->Invoice->save($data, false);
			}
		}
	}
}