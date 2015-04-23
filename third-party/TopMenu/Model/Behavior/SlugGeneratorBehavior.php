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

class SlugGeneratorBehavior extends ModelBehavior {

/**
 * Generates a URL from a string
 * @param  string $name The string you want to turn into a url
 * @return string
 */
	public function generateUrlFromName(Model $Model, $name) {

		// if (!$Model->Behaviors->attached('Diacritics')) {
		// 	$Model->Behaviors->attach('Diacritics');
		// }

		// $patterns = array(
		// 	'/\ /',
		// 	'/[^a-zA-Z0-9-]/',
		// 	'/[-]{2,}/'
		// );
		
		// $name = trim($name);
		// $name = $Model->remove_accents($name);

		// foreach ($patterns as $pattern) {
		// 	$name = preg_replace($pattern, '-', $name);
		// }
		// if ($name[strlen($name) - 1] == '-') {
		// 	$name = substr($name, 0, (strlen($name)  - 1));
		// }
		// return strtolower($name);



		$output = strtolower(Inflector::slug($name, '-'));
		return $output;
	}
}