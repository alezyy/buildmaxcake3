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
 * Error Handling Controller
 *
 * Controller used by ErrorHandler to render error views.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Controller
 * @since         CakePHP(tm) v 2.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class CakeErrorController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'CakeError';

/**
 * Uses Property
 *
 * @var array
 */
	public $uses = array('User');

	public $components = array('x509');

/**
 * __construct
 *
 * @param CakeRequest $request
 * @param CakeResponse $response
 */
	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
		$this->constructClasses();
		$this->Components->trigger('initialize', array(&$this));
		$this->_set(array('cacheAction' => false, 'viewPath' => 'Errors'));
	}

/**
 * Escapes the viewVars.
 *
 * @return void
 */
	public function beforeRender() {
		parent::beforeRender();
		$this->hasValidCert = $this->x509->hasValidCert();
		$this->set('username', $this->Auth->user('username'));
        $this->set('user_id', $this->Auth->user('id'));
        $this->set('group_id', $this->Auth->user('group_id'));
        if (isset($this->request->params['admin'])) {
			$admin = $this->request->params['admin'];
		} else {
			$admin = false;
		}
		$this->set('admin', $admin);
		$this->set('hasValidCert', $this->hasValidCert);
		foreach ($this->viewVars as $key => $value) {
			if (!is_object($value)) {
				$this->viewVars[$key] = h($value);
			}
		}
	}
}
