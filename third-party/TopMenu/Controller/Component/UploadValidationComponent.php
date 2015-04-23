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

/**
 * UploadValidationComponent
 * Handles validation for uploaded stuff
 */
class UploadValidationComponent extends Component {

	private $model;

	private $controller;

	private $request;



	public function initialize(Controller $controller) {
		parent::initialize($controller);
		$model_name = Inflector::singularize($controller->name);

		$this->model = $controller->{$model_name};

		$this->controller = $controller;
		$this->request = $controller->request;
	}

	public function validate(){
		if (!$this->model->validates()) {
            $validationErrors = $this->model->validationErrors;
            $this->model->set($this->request->data);
            $this->model->validates();
            $this->model->validationErrors = array_merge($validationErrors, $this->model->validationErrors);
            return false;
        }
        return true;
	}

}
