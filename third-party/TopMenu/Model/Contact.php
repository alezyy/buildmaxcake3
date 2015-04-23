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
App::uses('AppModel', 'Model');

class Contact extends AppModel {

	public $name = 'Contact';
	// Nous n'utiliserons pas de table dans la base
	public $useTable = false;

	/**
	 * Behaviors
	 * @var array
	 */
	public $actsAs = array('Email');
	// Nous donnons donc à Cake la structure d'un enregistrement
	public $_schema = array(
		'first_name' => array(
			'type' => 'string',
			'length' => 30
		),
		'last_name' => array(
			'type' => 'string',
			'length' => 30
		),
		'email' => array(
			'type' => 'string',
			'length' => 50
		),
		'message' => array(
			'type' => 'text'
		)
	);
	// Règles de validation des données
	public $validate = array(
		'first_name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false,
			'message' => 'Please enter your name.'
		),
		'last_name' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false,
			'message' => "Please enter your last name."
		),
		'email' => array(
			'rule' => 'email',
			'required' => true,
			'allowEmpty' => false,
			'message' => "Email address must be valid!"
		),
		'message' => array(
			'rule' => 'notEmpty',
			'required' => true,
			'allowEmpty' => false,
			'message' => "Please enter a message."
		)
	);

	/**
	 * Sends an email using the contact form page
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function sendMail($data) {

		$this->sendEmail(
			array(
				'name' => 'Support', 
				'address' => Configure::read('Topmenu.support_email')), 
			__('Contact Form'), 
			$data, 
			array('template' => 'contact_form')
		);
	}
	
	public function sendMailProd($data) {
		$this->sendEmail(
			array(
				'name' => 'Equipe de production',
				'address' => Configure::read('Topmenu.email.print_department')), 
			__('Topmenu not receive'), 
			$data, 
			array('template' => 'missing_print'));
	}

}
