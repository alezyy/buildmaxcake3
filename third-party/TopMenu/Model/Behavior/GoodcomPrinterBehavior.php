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
App::uses('CakeTime', 'Utility');

/**
 * Handles the generation of the string that
 * we feed to the Goodcom printers
 */
class GoodcomPrinterBehavior extends ModelBehavior {

/**
 * Timezone
 * @var string
 */
	protected $_timezone = 'America/Montreal';


/**
 * The order string
 * @var string
 */
	private $_string = '';

/**
 * Sets the timezone
 * @param Model  $Model
 * @param string $timezone 
 */
	public function setTimezone(Model $Model, $timezone) {
		$this->_timezone = $timezone;
	}

/**
 * Returns the formatted string
 * @return [type] [description]
 */
	public function getString() {
		return $this->_string;
	}

/**
 * Adds a semicolon to the string
 */
	public function semicolon() {
		$this->_string .= ';';
	}

/**
 * Adds a comma to the string
 */
	public function comma() {
		$this->_string .= ',';
	}

/**
 * Adds a star to the string
 */
	public function star(Model $Model, $number = 1) {
		$this->_string .= str_pad('*', $number, '*');
	}

/**
 * Adds a pound to the string
 */
	public function pound(Model $Model) {
		$this->_string .= '#';
	}

/**
 * Outputs a formatted item block
 * 
 * @param  array  $items  'ItemName' => price
 */
	public function itemBlock(Model $Model, $items = array()) {

		foreach($items as $key => $value) {
			$key_length = strlen($key);

			if ($key_length < 20) {
				$total_padding  = 30 - $key_length;
				$this->_string .= sprintf("%-s%{$total_padding}s", $key, $value);
			} else {
				$key            = wordwrap($key, 30, '``');
				$this->_string .= sprintf("%-s", $key);
				$this->_string .= sprintf("``%30s", $value);
			}
		}
	}

/**
 * Prints a right alignt
 * @param  string $text
 * @param  int    $padding
 */
	public function textRight(Model $Model, $text, $padding = 29) {
		//$total_padding = $padding - strlen($text);
		$this->_string .= sprintf("%{$padding}s", $text);
	}

/**
 * Adds an element to the string
 * @param string $string
 */
	public function text(Model $Model, $string) {
		$args = func_get_args();
		array_shift($args);
		array_shift($args);

		if (empty($args)) {
			$args = array('');
		}
		$this->_string .= vsprintf($string, $args);
	}

/**
 * Adds a newline
 * @param  integer $number   Number of line breaks to append
 * @param  bool    $return   True: Return the characters
 *                           False: output to $this->_string
 */
	public function newLine(Model $Model, $number  = 1, $return = false) {
		$output = str_pad('``', ($number * 2), '``');
		if (!$return) {
			$this->_string .= $output;
		} else {
			return $output;
		}
	}
/**
 * Adds a horizontal rule to the string
 */
	public function hr(Model $Model) {
		$this->_string .= '/-';
		$this->newLine($Model);
	}
/**
 * Adds a signature panel to the string
 */
	public function signature(Model $Model) {
		$this->newLine($Model, 4);
		$this->text($Model, 'x________________________');
		$this->newLine($Model);
		$this->text($Model, __('Signature'));
		$this->newLine($Model);
	}
/**
 * Formats the date and corrects the time offset
 * @param  Model  $Model
 * @param  [type] $date
 * @return string
 */
	public function formatDate(Model $Model, $date) {
		return CakeTime::i18nFormat(strtotime($date), "%a %d %b %Y - %k:%M", false);
	}

/**
 * Clears the class
 */
	public function clear() {
		$this->_string = '';
	}


/**
 * Sanitizes data, can handle both strings, and multi-dimentional arrays
 */
	public function sanitize(Model $Model, $data) {
		$out = array();
		if (is_string($data)) {
			return $this->_sanitize($data);
		} elseif (is_array($data)) {
			foreach ($data as $key => $val) {
				if (is_string($val)) {
					$out[$key] = $this->_sanitize($val);
				} elseif (is_array($val)) {
					$out[$key] = $this->sanitize($Model, $val);
				}
			}

		}
		return $out;
	}

/**
 * Sanitizes a string of user input
 */
	private function _sanitize($string) {
		$string = str_ireplace('#', '', $string);
		$string = str_ireplace('*', '', $string);
		$string = str_ireplace(';', '', $string);
		$string = str_ireplace(',', '', $string);
		$string = str_ireplace('\r', '', $string);
		$string = str_ireplace("\r", '', $string);
		$string = str_ireplace('\a', '', $string);
		$string = str_ireplace('/r', '', $string);
		$string = str_ireplace('/-', '', $string);
		return $string;
	}


}