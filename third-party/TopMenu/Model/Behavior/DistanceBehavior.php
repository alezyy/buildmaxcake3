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

/**
 * Behavior for all distance calculations
 */
class DistanceBehavior extends ModelBehavior {

/**
 * Calculates the distance between two points
 * When calling, don't use the first parameter (as with all behaviors)
 *
 * @param  Model $Model
 * @param  float $latitudeFrom
 * @param  float $longitudeFrom
 * @param  float $latitudeTo
 * @param  float $longitudeTo
 * @return float
 */
	public static function distance(
		Model &$Model,
		$latitudeFrom,
		$longitudeFrom,
		$latitudeTo,
		$longitudeTo
	) {
		// The radius of the planet, in meters
		$earthRadius = 6371000;

	  	// convert from degrees to radians
		$latFrom = deg2rad($latitudeFrom);
		$lonFrom = deg2rad($longitudeFrom);
		$latTo   = deg2rad($latitudeTo);
		$lonTo   = deg2rad($longitudeTo);

		// Calculate the distance using Vincenty's formula
		$lonDelta = $lonTo - $lonFrom;
		$a        = pow(cos($latTo) * sin($lonDelta), 2);
		$a        += pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
		$b        = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

		$angle  = atan2(sqrt($a), $b);
		$return = ($angle * $earthRadius) / 1000;
		$return = round($return, 2);

	 	return $return;
	}
}