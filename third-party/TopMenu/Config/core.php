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
 * This is core configuration file.
 *
 * Use it to configure core behavior of Cake.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses( 'CakeNumber', 'Utility' );

/**
 * CakePHP Debug Level:
 *
 * Production Mode:
 * 	0: No error messages, errors, or warnings shown. Flash messages redirect.
 *
 * Development Mode:
 * 	1: Errors and warnings shown, model caches refreshed, flash messages halted.
 * 	2: As in 1, but also with full debug messages and SQL output.
 *
 * In production mode, flash messages redirect after a time interval.
 * In development mode, you need to click the flash message to continue.
 */
	Configure::write('debug', 2);
	Configure::write('debug_toolbar', true);
	Configure::write('printerOnline', false);	// true makes all the printer appear as online

/**
 * Server Name
 */

    if (env('SERVER_NAME')) {
        Configure::write('Server.name', env('SERVER_NAME'));
    } else {
        /**
         * Set the following value to configure the
         * Server name for Console run scripts
         */
        Configure::write('Server.name', 'topmenu2.dev');
    }


/**
 * Secure Only
 * Only allows secure connections to be made to the site (through SSL)
 */

    Configure::write('secure_only', false);

/**
 * Security Level
 */
    Configure::write('Security.level', 'low');

/**
 * Run PHPIDS
 */
   	Configure::write('phpids.run', true);

/**
 * Email Config
 */

	Configure::write('Email.Config', 'amazon');

	/**
 * Site default country
 */
Configure::write('TopMenu.country', 'CA');

/**
 * Countries and Provinces that use fr by default
 * Use 2 letter CC for countries, and full province name for provinces
 * Comma separated
 * e.g.: Canada = CA
 *       -> Quebec = Quebec
 */
    Configure::write('TopMenu.fr_countries', 'FR');
    Configure::write('TopMenu.fr_provinces', 'Quebec');


/**
 * Languages
 * Enables i18n functionality
 */
    Configure::write('TopMenu.languages', true);


/**
 * Additional Languages we support (en is assumed)
 */
    Configure::write('Config.languages', array('fr'));

/**
 * Currencies needing an extension of CAKE's CakeNumber
 */    
CakeNumber::addFormat( 
    'fr_CA', 
    array(
        'wholeSymbol'      => ' $',
        'wholePosition'    => 'after',
		'fractionSymbol'   => FALSE,
        'zero'             => '0,00 $',
        'places'           => 2,
        'thousands'        => ' ',
        'decimals'         => ',',
        'negative'         => '()',
        'escape'           => true
    ) 
);
CakeNumber::addFormat(  
    'en_CA', 
    array(
        'wholeSymbol'      => '$ ',
        'wholePosition'    => 'before',
        'fractionSymbol'   => FALSE,
        'zero'             => '$ 0.00',
        'places'           => 2,
        'thousands'        => ',',
        'decimals'         => '.',
        'negative'         => '()',
        'escape'           => true
    )
); 

/**
 * Block PDF Menus in the following areas (only allow locations with online_ordering set to true)
 * MUST BE UPPERCASE!!!
 */
	Configure::write('Topmenu.block_pdf_menus', array(
		'H2L',
		'H2Z',
		'H2X',
		'H2E',
		'H2S',
		'H2R',
		'H2P',
		'H2H',
		'H2T',
		'H2J',
		'H2W',
		'H1Y',
		'H2G'
	));
	
/**
 * Aboslute minimum limit of an order made by a user. This is counted on the orders grand total.
 * <b>This must be higher then the minimum set by the payment gateways</b>
 */
	Configure::write('Topmenu.minimum_order', 3);

/**
 * Social media
 */
Configure::write('Topmenu.facebook_url', 'https://fr-ca.facebook.com/pages/Top-Menu/211987955507437');
Configure::write('Topmenu.twitter_url', 'https://twitter.com/topmenuweb');


/**
 * User Registration System
 * Set to "true" to enable, and "false" to disable
 */
    Configure::write('User.registration_enabled', true);


/**
 * Secure Admin
 * Require admin accounts to be accompanied by a client certificate
 * verified by Apache
 */

    Configure::write('TopMenu.secure_admin', false);


/**
 * Device timeout (in seconds)
 */
	Configure::write('Topmenu.device_timeout', 120);	// Default timeout and wifi's timeout 
	
/**
 * Maximum number of queries processing.ctp should do to the database before rejecting the order
 */
Configure::write('Topmenu.max_attempts', 15);	// 15 attempts of 12sec (wifi timeout divided by 10) = 3   min
													// 15 attempts of 30sec (sim  timeout divided by 10) = 7.5 min

/**
 * Constant for Contact info for topmenu
 */
	Configure::write('Topmenu.support_email', 'support@topmenu.com');
	Configure::write('Topmenu.support_phone', '5149891233');
    
/**
 * Other emails
 */
Configure::write('Topmenu.email.print_department', 'production@topmenu.com');

/**
 * Company info
 */
    Configure::write('Topmenu.company.name', 'TOP MENU WEB');
    Configure::write('Topmenu.company.address', '225 rue Chabanel Ouest Suite 1001');
    Configure::write('Topmenu.company.city', 'Montreal');
    Configure::write('Topmenu.company.province', 'Quebec');
    Configure::write('Topmenu.company.postal_code', 'H2N 2C9');
    Configure::write('Topmenu.company.phone', '514 989-1233');
    Configure::write('Topmenu.company.email', 'support@topmenu.com');
    
/**
 * Taxes
 */
Configure::write('Taxes.gst.rate', .05 );
Configure::write('Taxes.pst.rate', .09975);

/**
 * Alert Destinations
 */
	Configure::write('Alert.send', true);

	// Pushover IDs to send to
	Configure::write('Alert.Pushover', array(
		'' // List of IDs
	));

	// Email Addresses to send to
	Configure::write('Alert.Email', array(
		array(
			'name'    => 'Topmenu Support',
			'address' => 'support@topmenu.com'
		)
	));


/**
 * Rating display, set to true to display ratings
 */
	Configure::write('Topmenu.ratings', false);



/**
 * Site Constants
 */

	// Image Upload DIR
	// Must have trailing / (use CakePHP's defined DS constant)
	Configure::write('Topmenu.images', APP . 'Uploads' . DS . 'images' . DS);

	// PDF Upload DIR
	// Must have trailing / (use CakePHP's defined DS constant)
	Configure::write('Topmenu.pdfs', APP  . 'Uploads' . DS . 'pdfs' . DS);

	// Old Topmenu website (to migrate images)
	Configure::write('Topmenu.old_site_path', 'PATH' . DS . 'TO' . DS . 'topmenu_old' . DS);

    

/**
 * Configure the Error handler used to handle errors for your application. By default
 * ErrorHandler::handleError() is used. It will display errors using Debugger, when debug > 0
 * and log errors with CakeLog when debug = 0.
 *
 * Options:
 *
 * - `handler` - callback - The callback to handle errors. You can set this to any callable type,
 *   including anonymous functions.
 *   Make sure you add App::uses('MyHandler', 'Error'); when using a custom handler class
 * - `level` - int - The level of errors you are interested in capturing.
 * - `trace` - boolean - Include stack traces for errors in log files.
 *
 * @see ErrorHandler for more information on error handling and configuration.
 */
	Configure::write('Error', array(
		'handler' => 'ErrorHandler::handleError',
		'level' => E_ALL & ~E_DEPRECATED,
		'trace' => true
	));

/**
 * Configure the Exception handler used for uncaught exceptions. By default,
 * ErrorHandler::handleException() is used. It will display a HTML page for the exception, and
 * while debug > 0, framework errors like Missing Controller will be displayed. When debug = 0,
 * framework errors will be coerced into generic HTTP errors.
 *
 * Options:
 *
 * - `handler` - callback - The callback to handle exceptions. You can set this to any callback type,
 *   including anonymous functions.
 *   Make sure you add App::uses('MyHandler', 'Error'); when using a custom handler class
 * - `renderer` - string - The class responsible for rendering uncaught exceptions. If you choose a custom class you
 *   should place the file for that class in app/Lib/Error. This class needs to implement a render method.
 * - `log` - boolean - Should Exceptions be logged?
 *
 * @see ErrorHandler for more information on exception handling and configuration.
 */
	Configure::write('Exception', array(
		'handler' => 'ErrorHandler::handleException',
		'renderer' => 'ExceptionRenderer',
		'log' => true
	));

/**
 * Application wide charset encoding
 */
	Configure::write('App.encoding', 'UTF-8');

/**
 * To configure CakePHP *not* to use mod_rewrite and to
 * use CakePHP pretty URLs, remove these .htaccess
 * files:
 *
 * /.htaccess
 * /app/.htaccess
 * /app/webroot/.htaccess
 *
 * And uncomment the App.baseUrl below. But keep in mind
 * that plugin assets such as images, CSS and Javascript files
 * will not work without url rewriting!
 * To work around this issue you should either symlink or copy
 * the plugin assets into you app's webroot directory. This is
 * recommended even when you are using mod_rewrite. Handling static
 * assets through the Dispatcher is incredibly inefficient and
 * included primarily as a development convenience - and
 * thus not recommended for production applications.
 */
	//Configure::write('App.baseUrl', env('SCRIPT_NAME'));

/**
 * Uncomment the define below to use CakePHP prefix routes.
 *
 * The value of the define determines the names of the routes
 * and their associated controller actions:
 *
 * Set to an array of prefixes you want to use in your application. Use for
 * admin or other prefixed routes.
 *
 * 	Routing.prefixes = array('admin', 'manager');
 *
 * Enables:
 *	`admin_index()` and `/admin/controller/index`
 *	`manager_index()` and `/manager/controller/index`
 *
 */
	Configure::write('Routing.prefixes', array(
		'admin',
		'manager'
	));

/**
 * Turn off all caching application-wide.
 *
 */
	//Configure::write('Cache.disable', true);

/**
 * Enable cache checking.
 *
 * If set to true, for view caching you must still use the controller
 * public $cacheAction inside your controllers to define caching settings.
 * You can either set it controller-wide by setting public $cacheAction = true,
 * or in each action using $this->cacheAction = true.
 *
 */
	//Configure::write('Cache.check', true);

/**
 * Enable cache view prefixes.
 *
 * If set it will be prepended to the cache name for view file caching. This is
 * helpful if you deploy the same application via multiple subdomains and languages,
 * for instance. Each version can then have its own view cache namespace.
 * Note: The final cache file name will then be `prefix_cachefilename`.
 */
	Configure::write('Cache.viewPrefix', 'topmenu');

/**
 * Session configuration.
 *
 * Contains an array of settings to use for session configuration. The defaults key is
 * used to define a default preset to use for sessions, any settings declared here will override
 * the settings of the default config.
 *
 * ## Options
 *
 * - `Session.cookie` - The name of the cookie to use. Defaults to 'CAKEPHP'
 * - `Session.timeout` - The number of minutes you want sessions to live for. This timeout is handled by CakePHP
 * - `Session.cookieTimeout` - The number of minutes you want session cookies to live for.
 * - `Session.checkAgent` - Do you want the user agent to be checked when starting sessions? You might want to set the
 *    value to false, when dealing with older versions of IE, Chrome Frame or certain web-browsing devices and AJAX
 * - `Session.defaults` - The default configuration set to use as a basis for your session.
 *    There are four builtins: php, cake, cache, database.
 * - `Session.handler` - Can be used to enable a custom session handler. Expects an array of callables,
 *    that can be used with `session_save_handler`. Using this option will automatically add `session.save_handler`
 *    to the ini array.
 * - `Session.autoRegenerate` - Enabling this setting, turns on automatic renewal of sessions, and
 *    sessionids that change frequently. See CakeSession::$requestCountdown.
 * - `Session.ini` - An associative array of additional ini values to set.
 *
 * The built in defaults are:
 *
 * - 'php' - Uses settings defined in your php.ini.
 * - 'cake' - Saves session files in CakePHP's /tmp directory.
 * - 'database' - Uses CakePHP's database sessions.
 * - 'cache' - Use the Cache class to save sessions.
 *
 * To define a custom session handler, save it at /app/Model/Datasource/Session/<name>.php.
 * Make sure the class implements `CakeSessionHandlerInterface` and set Session.handler to <name>
 *
 * To use database sessions, run the app/Config/Schema/sessions.php schema using
 * the cake shell command: cake schema create Sessions
 *
 */
	Configure::write('Session', array(
		'defaults' => 'php',
		'cookie' => 'TOPMENU'
	));

/**
 * A random string used in security hashing methods.
 */
	Configure::write('Security.salt', 'nca0hXWlxdwCQzfgyoBWYU62yuzyZuWklRZYNeXYafFg5VmYX3b5Wb6pktomK3');

/**
 * A random numeric string (digits only) used to encrypt/decrypt strings.
 */
	Configure::write('Security.cipherSeed', '5897661568518622169283287554870');

/**
 * Apply timestamps with the last modified time to static assets (js, css, images).
 * Will append a query string parameter containing the time the file was modified. This is
 * useful for invalidating browser caches.
 *
 * Set to `true` to apply timestamps when debug > 0. Set to 'force' to always enable
 * timestamping regardless of debug value.
 */
	Configure::write('Asset.timestamp', true);

/**
 * Compress CSS output by removing comments, whitespace, repeating tags, etc.
 * This requires a/var/cache directory to be writable by the web server for caching.
 * and /vendors/csspp/csspp.php
 *
 * To use, prefix the CSS link URL with '/ccss/' instead of '/css/' or use HtmlHelper::css().
 */
	//Configure::write('Asset.filter.css', 'css.php');

/**
 * Plug in your own custom JavaScript compressor by dropping a script in your webroot to handle the
 * output, and setting the config below to the name of the script.
 *
 * To use, prefix your JavaScript link URLs with '/cjs/' instead of '/js/' or use JavaScriptHelper::link().
 */
	//Configure::write('Asset.filter.js', 'custom_javascript_output_filter.php');

/**
 * The class name and database used in CakePHP's
 * access control lists.
 */
	Configure::write('Acl.classname', 'DbAcl');
	Configure::write('Acl.database', 'default');

/**
 * Uncomment this line and correct your server timezone to fix
 * any date & time related errors.
 */
	date_default_timezone_set('America/Montreal');
	Configure::write('Config.timezone', 'America/Montreal');

/**
 *
 * Cache Engine Configuration
 * Default settings provided below
 *
 * File storage engine.
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'File', //[required]
 *		'duration' => 3600, //[optional]
 *		'probability' => 100, //[optional]
 * 		'path' => CACHE, //[optional] use system tmp directory - remember to use absolute path
 * 		'prefix' => 'cake_', //[optional]  prefix every cache file with this string
 * 		'lock' => false, //[optional]  use file locking
 * 		'serialize' => true, [optional]
 *	));
 *
 * APC (http://pecl.php.net/package/APC)
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'Apc', //[required]
 *		'duration' => 3600, //[optional]
 *		'probability' => 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 *	));
 *
 * Xcache (http://xcache.lighttpd.net/)
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'Xcache', //[required]
 *		'duration' => 3600, //[optional]
 *		'probability' => 100, //[optional]
 *		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional] prefix every cache file with this string
 *		'user' => 'user', //user from xcache.admin.user settings
 *		'password' => 'password', //plaintext password (xcache.admin.pass)
 *	));
 *
 * Memcache (http://www.danga.com/memcached/)
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'Memcache', //[required]
 *		'duration' => 3600, //[optional]
 *		'probability' => 100, //[optional]
 * 		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 * 		'servers' => array(
 * 			'127.0.0.1:11211' // localhost, default port 11211
 * 		), //[optional]
 * 		'persistent' => true, // [optional] set this to false for non-persistent connections
 * 		'compress' => false, // [optional] compress data in Memcache (slower, but uses less memory)
 *	));
 *
 *  Wincache (http://php.net/wincache)
 *
 * 	 Cache::config('default', array(
 *		'engine' => 'Wincache', //[required]
 *		'duration' => 3600, //[optional]
 *		'probability' => 100, //[optional]
 *		'prefix' => Inflector::slug(APP_DIR) . '_', //[optional]  prefix every cache file with this string
 *	));
 */

/**
 * Configure the cache handlers that CakePHP will use for internal
 * metadata like class maps, and model schema.
 *
 * By default File is used, but for improved performance you should use APC.
 *
 * Note: 'default' and other application caches should be configured in app/Config/bootstrap.php.
 *       Please check the comments in bootstrap.php for more info on the cache engines available
 *       and their settings.
 */
$engine = 'File';
if (extension_loaded('apc') && function_exists('apc_dec') && (php_sapi_name() !== 'cli' || ini_get('apc.enable_cli'))) {
    $engine = 'Apc';
}

// In development mode, caches should expire quickly.
$duration = '+7 days';
if (Configure::read('debug') > 0) {
	$duration = '+10 seconds';
}

// Prefix each application on the same server with a different string, to avoid Memcache and APC conflicts.
$prefix = 'topmenu_';

/**
 * Configure the cache used for general framework caching. Path information,
 * object listings, and translation cache files are stored with this configuration.
 */
Cache::config('_cake_core_', array(
	'engine' => $engine,
	'prefix' => $prefix . 'cake_core_',
	'path' => CACHE . 'persistent' . DS,
	'serialize' => ($engine === 'File'),
	'duration' => $duration
));

/**
 * Configure the cache for model and datasource caches. This cache configuration
 * is used to store schema descriptions, and table listings in connections.
 */
Cache::config('_cake_model_', array(
	'engine' => $engine,
	'prefix' => $prefix . 'cake_model_',
	'path' => CACHE . 'models' . DS,
	'serialize' => ($engine === 'File'),
	'duration' => $duration
));


/**
 * REGEX ===============================================================
 */

/**
 * Regex for canadian or american postal code
 */
Configure::write('regex.postal_code', "/^(?:[a-zA-Z][0-9][a-zA-Z] {0,1}[0-9][a-zA-Z][0-9])|(?:\d{5}([\-]?\d{4})?)$/");

/**
 * Regex that matches a the first half of a postal code only 
 */
Configure::write('regex.postal_code_small', "/^[a-zA-Z][0-9][a-zA-Z]$/");

/**
 * Regex that matches a half of full postal code
 */
Configure::write('regex.postal_code_3to7_char', "/^[a-zA-Z][0-9][a-zA-Z]( {0,1}[0-9][a-zA-Z][0-9]){0,1}$/");

/**
 * Regex that matches a visa or credit number (very rudimentary)
 */
Configure::write('regex.credit_card_number', "^[4-5] {0,1}([0-9] {0,1}){12,15}$");	// Visa and master card only

/**
 * Regex that matches the CVV2 number on the back of the credit card
 */
Configure::write('regex.cvv2', "^[0-9]{3,4}$");										// CVV2 number


/**
 * FRAUD TRESHOLDS =======================================================
 */

/**
 * If the average of the orders total in the given period is under this treshold than do not flag for fraud
 */
Configure::write('fraud.order_average_treshold', 30);	

/**
 * The amount or order at which with start to flag for warnings
 */
Configure::write('fraud.order_amount_treshold', 4);

/**
 * Period of time to look back in the user's order history in hours 
 */
Configure::write('fraud.period', 48);

/**
 * Emails which should receive the fraud emails. <br/>
 * Comma seperated list
 */
Configure::write('fraud.emails', 'stacey.cavery@gmail.com');

/**
 * Platform ================================================================
 */
Configure::write('platform.main_domain', 'topmenu.com');									// Domain name of the main doamin on this server

Configure::write('platform.image_domain', 'topmenu.com');									// Where are we fetching the images
Configure::write('platform.default_domain', 'topmenu');										// default website domain name without the top level domain
Configure::write('platform.platform_domain', 'clickitsready');								// Platform domain name without the top level domain
Configure::write('platform.restoName', 'Restaurant Ginza');									// Platform name
Configure::write('platform.url', '/restaurant/plateau-mont-royal/restaurant-ginza');		// URL of restaurant on topmenu.com
Configure::write('platform.folder', 'clickitsready');										// Web folder name use for this platform
