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
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');
App::uses('ComponentCollection', 'Controller');
App::import('Component', 'Session');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

/**
 * Default recursion level
 * @var integer
 */
	public $recursive = -1;

/**
 * Language suffix to be included in all models
 * 
 * @var string
 */
//	public $langSuffix = 'en';

/**
 * Separate out validation errors into their own domain for translation
 * @var string
 */
	public $validationDomain = 'validation';


/**
 * The all mighty construct
 * See cake's API for proper documenation on the arguments.
 * 
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$Collection       = new ComponentCollection();
		$Session          = new SessionComponent($Collection);
		$this->langSuffix = $Session->read('Config.language');

		if (!isset($this->langSuffix)) {
			$this->langSuffix = 'fr';
		}

		if (strlen($this->langSuffix) > 2) {
			$this->langSuffix = substr($this->langSuffix, 0, 2);
		}
	}
	
	public function beforeValidate($options = array()) {
		parent::beforeValidate($options);
	
		if (isset($this->validate['postal_code']['rule']) ){
			$this->validate['postal_code']['rule'] = Configure::read('regex.postal_code');		
		}
		elseif (isset($this->validate['postal_code']['postal_code']['rule'])){
			$this->validate['postal_code']['postal_code']['rule'] = Configure::read('regex.postal_code');		
		}
	}

	function checkUnique($data, $fields) { 
        if (!is_array($fields)) { 
                $fields = array($fields); 
        } 
        foreach($fields as $key) { 
                $tmp[$key] = $this->data[$this->name][$key]; 
        } 
        if (isset($this->data[$this->name][$this->primaryKey])) { 
                $tmp[$this->primaryKey] = "<>".$this->data[$this->name][$this->primaryKey]; 

        } 
	    return $this->isUnique($tmp, false); 
	} 
	 
}
