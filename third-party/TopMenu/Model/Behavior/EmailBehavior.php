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

App::uses('ModelBehavior', 'Model');
App::uses('Core', 'ConnectionManager');
App::uses('TopmenuEmail', 'Network/Email');

class EmailBehavior extends ModelBehavior {

/**
 * Sends email
 * @param  Model  $model    Automatically provided by cake, pretend this
 *                          parameter does not exist
 * @param  array  $to       Can either be a string (email only) or an 
 *                          array('To Name' => 'email address')
 * @param  string $subject  Subject of the email
 * @param  array  $data     Data to be included in the view
 * @param  array  $options  Array of options to be used
 * @return void
 */
	public function sendEmail(
		Model $model,
		$to = array(),
		$subject,
		$data = array(),
		$options = array()
	) {
		
		$template = 'default';
		$layout = 'topmenu';
		$format = 'both';

		extract($options);

		$to = array(
			$to['address'] => $to['name']
		);


		$email = new TopmenuEmail();
		$email->config(Configure::read('Email.Config'))
			  ->to($to)
			  ->subject($subject)
			  ->template($template, $layout)
			  ->emailFormat($format);

		if (isset($domain)) {
			$email->domain($domain);
		}

		$res = false;

		if (is_array($data)) {
			$email->viewVars($data);
			$res = $email->send();
		} else {
			$res = $email->send($data);
		}

		return $res;
		
	}
}