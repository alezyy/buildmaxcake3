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
class AjaxFormComponent extends Component {
	
	
	
	public function startup(Controller $controller) {	
		$this->controller = $controller;
	}

	/**
	 * Transform the validation errors of model into a json array ready to use with for displaying validations erros on
	 * the HTML from
	 * @param string $modelName Name of the model of the form. As to be as it appears in the name propertyof the inputs in forms
	 * @param array $validationErrors validation errors array return by $this->Model->validationError
	 */
	public function validationErrors($modelName, $validationErrors){
		
		$result = array();
		foreach ($validationErrors as $key => $value) {
			$tmpKey = ucwords(str_replace('_', ' ', $key));
			$tmpKey = $modelName.str_replace(' ', '', $tmpKey);
			$result[$tmpKey] = $value;			
		}
		
		return $result;
	}	
	
}
