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

App::uses('FormAuthenticate', 'Controller/Component/Auth');

class BcryptFormAuthenticate extends FormAuthenticate {

/**
 * The cost factor for the hashing.
 *
 * @var integer
 */
	public static $cost = 10;

/**
 * Password method used for logging in.
 *
 * @param string $password Password.
 * @return string Hashed password.
 */
	protected function _password($password) {
		return self::hash($password);
	}

/**
 * Create a blowfish / bcrypt hash.
 *
 *
 * @param string $password Password.
 * @param string $salt 22 character salt
 * @return string Hashed password.
 */
	public static function hash($password, $salt = null) {
		if ($salt === null) {
			$salt = substr(Configure::read('Security.salt'), 0, 22);
		}
		return crypt($password, '$2a$' . self::$cost . '$' . $salt);
	}

/**
 * Generates a 22 character random salt
 * @return [type] [description]
 */
	public static function generateSalt() {
		$alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWZYZ0123456789';
		$alphabet = str_split($alphabet);
		$salt = '';

		for ($i = 0; $i < 22; $i++) {
			$char = $alphabet[rand(0, (sizeof($alphabet) - 1))];
			if (!is_numeric($char)) {
				switch (rand(0,1)) {
					case 0:
						$salt .= $char;
					break;

					case 1:
						$salt .= strtolower($char);
					break;
				}
			} else {
				$salt .= $char;
			}
		}

		return $salt;
	}
}