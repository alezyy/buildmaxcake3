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
 * Use it to configure core behaviour of Cake.
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
 *
 * Database configuration class.
 * You can specify multiple configurations for production, development and testing.
 *
 * datasource => The name of a supported datasource; valid options are as follows:
 *		Database/Mysql 		- MySQL 4 & 5,
 *		Database/Sqlite		- SQLite (PHP5 only),
 *		Database/Postgres	- PostgreSQL 7 and higher,
 *		Database/Sqlserver	- Microsoft SQL Server 2005 and higher
 *
 * You can add custom database datasources (or override existing datasources) by adding the
 * appropriate file to app/Model/Datasource/Database. Datasources should be named 'MyDatasource.php',
 *
 *
 * persistent => true / false
 * Determines whether or not the database should use a persistent connection
 *
 * host =>
 * the host you connect to the database. To add a socket or port number, use 'port' => #
 *
 * prefix =>
 * Uses the given prefix for all the tables in this database. This setting can be overridden
 * on a per-table basis with the Model::$tablePrefix property.
 *
 * schema =>
 * For Postgres/Sqlserver specifies which schema you would like to use the tables in. Postgres defaults to 'public'. For Sqlserver, it defaults to empty and use
 * the connected user's default schema (typically 'dbo').
 *
 * encoding =>
 * For MySQL, Postgres specifies the character encoding to use when connecting to the
 * database. Uses database default not specified.
 *
 * unix_socket =>
 * For MySQL to connect via socket specify the `unix_socket` parameter instead of `host` and `port`
 */
class DATABASE_CONFIG {

	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => 'Net463877@alezy',
		'database' => 'topmenu_25_mars_2015',
		'prefix' => '',
		'encoding' => 'utf8',
	);


	public $old = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => '',
		'database' => 'topmenu2',
		'prefix' => '',
		'encoding' => 'utf8',
	);

	public $test = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => '',
		'database' => 'topmenu2_test',
		'prefix' => '',
		'encoding' => 'utf8',
	);


	// Evo Canada
	public $EvoCanada = array(
		'datasource'     => 'EvoCanadaSource', 
		'username'       => '',
		'password'       => ''
	);

	// Pushover
	public $Pushover = array(
		'datasource' => 'PushoverSource',
		'token'      => ''
	);
    
    /**
	 * Chase Orbital Gateway API Configuration
	 * @var type 
	 */
	public $OrbitalGateway = array(
		 'datasource'						 => 'OrbitalGatewaySource',
		'username'							 => 'TOPMENUWEB619',
		'password'							 => 'DKX6JVS9Y6LGN',
		'primaryProductionAddress'			 => "https://orbital1.paymentech.net/authorize",
		'secondaryProductionAddress'		 => "https://orbital2.paymentech.net/authorize",
		'primaryCertificationAddressPort'	 => "443",
		'primaryCertificationAddress'		 => "https://orbital1.paymentech.net/authorize",		
		'secondaryCertificationAddress'		 => "https://orbital2.paymentech.net/authorize",		
		'secondaryCertificationAddressPort'	 => "443",
		'xml_doc_type'						 => "<?xml version=\"1.0\" encoding=\"UTF-8\"?><Request></Request>",
		'BIN'								 => "000002",
		'sd_merchant_name'					 => 'TOP MENU WEB INC',
		'sd_merchant_description'			 => 'TOP MENU WEB INC <topmenu.com>',
		'sd_merchant_city'					 => 'Montreal',
		'sd_merchant_phone'					 => '514 989 1065',
		'sd_merchant_url'					 => 'topmenu.com',
		'IndustryType'						 => 'EC',
		'PxPayUserId' => 'TopMenu',
                'PxPayKey'    =>  'fe019f10be830c001b5fd329c36bd1abc74382366862efe71cb4d09fa8c064b0',
		'optional_values'					 => array(
			'MerchantId'	 => "810000018690",
			'TerminalId'	 => "001",
			'CurrencyCode'	 => "124",
			'CurrencyExp'	 => "2"
            )
		

	);



	/**
	 * ElasticSearch 
	 * @var array
	 */
	public $index = array(
	    'datasource' => 'Elastic.ElasticSource',
	    'index' => 'main',
	    'host' => '198.58.111.36',
	    'port' => 9200
	);

}
