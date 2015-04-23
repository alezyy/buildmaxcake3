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
App::uses('Component', 'Controller');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CakePHP OrderSession
 * @author pechartrand
 */
class BreadCrumbsComponent extends Component {

	public $components = array('Auth', 'Session');

//	public function initialize(Controller $controller) {
//		$this->controller = $controller;
//		$this->Auth->loggedIn();
//	}
//
//	public function startup(Controller $controller) {
//		$this->controller = $controller;
//	}

	/**
	 * Adds a crumb to the breadcrumbs. Will overwrite existing crumbs with same key.<br/>
	 * To set the crumb as active the calling controller must to this: <br/>
	 * <pre>
	 * $this->set('activeBreadCrumb', $title);
	 * </pre>
	 * 
	 * @param string 	$key			Key representing the breadcrumb in the breadcrumb array
	 * @param string 	$controller		Controller part of the url array
	 * @param string 	$action			Action part of the url array
	 * @param string 	$title			String that will be output
	 * @param boolean 	$forceTail		if true, added crumb will always be at then end (also moving existing crumb to the end)
	 * @param mixe 		$parameters		String or array of the parameter of the url array
	 */
	public function add($key, $controller, $action, $title, $parameters = NULL, $forceTail = FALSE) {
		
		if($forceTail){
			$this->Session->delete('Breadcrumbs.' . $key);
		}	
		
		$this->Session->write('Breadcrumbs.' . $key);
		$this->Session->write('Breadcrumbs.' . $key . '.Controller', $controller);
		$this->Session->write('Breadcrumbs.' . $key . '.Action', $action);
		$this->Session->write('Breadcrumbs.' . $key . '.Title', $title);
		$this->Session->write('Breadcrumbs.' . $key . '.Parameter', $parameters);

	}

	/**
	 * Removes one crumb from the breadcrumbs
	 * @param string 	$key	String representing the crumb key to be deleted
	 */
	public function delete($key) {
		$this->Session->delete('Breadcrumbs.' . $key);
	}

	/**
	 * 	Clear all of the breadcrumbs
	 */
	public function deleteAll() {
		$this->Session->delete('Breadcrumbs');
	}

}