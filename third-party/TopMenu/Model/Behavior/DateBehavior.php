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

class DateBehavior extends ModelBehavior {
/**
 * Gets a friendly date (e.g. 1 Year 21 Days)
 * @param  Model  $model The current model, passed by default when called from
 *                       a given model
 * @param  string $date  A date string
 * @return string        Either the friendly date string, or "Now!" if the time
 *                       has passed
 */
	public function getFriendlyDate(Model $model, $date) {
		$time_string = "";
		$seconds = strtotime($date) - strtotime(date("Y-m-d H:i:s"));
		$timeDivs = array(
			__('Year')   => 365 * 24 * 60 * 60,
			__('Month')  => 30 * 24 * 60 * 60,
			__('Day')    => 24 * 60 * 60,
			__('Hour')   => 60 * 60,
			__('Minute') => 60,
			__('Second') => 1,
	    );
		$i = 0;
		foreach ($timeDivs as $label => $amount) {
			if ($seconds >= $amount && $i < 2) {
				$howMany     = floor($seconds / $amount);
				$seconds     = $seconds -  ($howMany * $amount);
				$time_string .= $howMany . " " . $label . ($howMany > 1 ? "s" : "") . " ";
			    $i++;
		    }
		}
		if (!$i) {
			return __('Now!');
		} else {
			return $time_string;
		}
	}
}