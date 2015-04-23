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
/**
 * Schedule Model
 *
 * @property Location $Location
 */
class Schedule extends AppModel {

	public $order = 'Schedule.day ASC';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'location_id' => array(
			'uuid' => array(
				'rule' => array('uuid'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'opening_hour' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Opening hour cannot be empty!'
			)
		),
		'closing_hour' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Closing hour cannot be empty!'
			)
		),
		'day' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Must be numeric!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'unique' => array(
				'rule' => array('uniqueDays'),
				'message' => 'You already have an entry for that day!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'split_delivery_time' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Must be numeric!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'location_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function uniqueDays($check, $max = 1) {
		$count = $this->find('count', array(
			'conditions' => array(
				'day' => $check,
				'location_id' => $this->data['Schedule']['location_id']
			)
		));
		if (!$count) {
			return true;
		}
		return false;
	}
        
	/**
	* Gets the schedule for a given day of the week for a given Location
	* 	
	* @param	string	$locationId UUID of a location record
	* @param	int		$dayOfWeek 0 = sunday,  1=monday, ... Defaults to today
	* @return	array	Returns a schdule record
	*/
	public function scheduleOfDay($locationId, $dayOfWeek = NULL) {
		$dayOfWeek = ($dayOfWeek === NULL) ? date('w') : $dayOfWeek;	// get todays day be devault
		return $this->find('first', array(
				'conditions' => array(
					'Schedule.location_id =' => $locationId,
					'Schedule.day = ' => $dayOfWeek)));
	}
        
	/**
	* Return a nice looking string for the schedule of a single day
	* 	
	* @param	string	$locationId UUID of a location record
	* @param	int		$dayOfWeek 0 = sunday,  1=monday, ... Defaults to today
	* @return	array	Returns a schdule record
	*/
	public function niceScheduleOfDay($locationId, $dayOfWeek = NULL) {
		$day = $this->scheduleOfDay($locationId, $dayOfWeek);
		return $this->scheduleNiceArray($day);
	}
	
	/**
	 * Check if the location is currently open 
	 * 
	 * @param	string	$locationId	location's	UUID
	 * @param	string	$locationTimeZone		location's PHP timezone  
	 * @return	bool							True = open<br/>
	 *											False  = close
	 * @deprecated		Data in the Schedule.opening_hour is not maintained<br>
	 *					Maybe one day it will be used again.
	 */
	public function isOpen($locationId, $locationTimeZone = 'America/Montreal'){
		
		$day = date( "w", time());
		$time = date( "H:i:s", time());
		
		$result = $this->find('count', array(
				'conditions' => array(
					'Schedule.location_id' => $locationId,
					'Schedule.day' => $day,
						array(
							'Schedule.opening_hour <' => $time,
							'Schedule.closing_hour >' => $time))));
								
		 return ($result > 0);

	}
	
	/**
	 * Check if the location is currently open <br/>
	 * <b>the time given should be in UTC</b>. It will be converted to the location's timezone
	 * 
	 * @param	string		$locationId	location's	UUID
	 * @param	string		$locationTimeZone		location's timezone in PHP format. If null the timezone will be fetch from the location table
	 * @param	string		$dateTime				valid mysql date of the moment the order is expect to arrive. <br/> Defaults to now.
	 * @return	boolean		If delivery is possible returns true.
	 *												
	 */
	public function isOpenForDelivery($locationId, $locationTimeZone = NULL, $dateTime = NULL, $checkDevice = FALSE) {

		// Check if machine is online
		if ($checkDevice) {
			$deviceModel = ClassRegistry::init('Device');
			if (!$deviceModel->getDeviceStatus($locationId)) {
				return FALSE;
			}
		}

		$now = time();
		if ($locationTimeZone === NULL) {
			$locationTimeZone = 'America/Montreal';
		}
		if ($dateTime === NULL) {
			$dateTime = date("H:i:s", $now);
		} else {
			$dateTime = date("H:i:s", strtotime($dateTime));
		}

		$day = date("w", $now);
		$result = $this->find('count', array(
			'conditions' => array(
				'Schedule.location_id' => $locationId,
				'Schedule.day' => $day,
				'OR' => array(
					array(
						'Schedule.delivery_start1 <' => $dateTime,
						'Schedule.delivery_end1 >' => $dateTime),
					array(
						'Schedule.delivery_start2 <' => $dateTime,
						'Schedule.delivery_end2 >' => $dateTime)))));
		if ($result > 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
		
	/**
	 * Format the a schedule arrary into a human readable one
	 * @todo put in helper instead
	 * @param array		$schedule			Result from Schedule->find();
	 * @param string	$openCloseSeperator Text or HTML seperator that goes between 'From: 09:00AM' and  'To: 5:00PM';
	 * @param string	$splitSeperator		Text or HTML seperator that goes between the splited scheduled
	 * @return array						Array containing the name of the day and the string of the scedule for each day found in Schedule->find()
	 */
	public function scheduleNiceArray($schedule, $openCloseSeperator = ' ', $splitSeperator = ' ') {
		$result = array();
		if (count($schedule) > 1) {
			foreach ($schedule['Schedule'] as $day) {

				$result[$day]['day'] = $this->_dayOfWeekString($day);  // name of day

				if ($day['split_delivery_time']) {
					$result[$day]['string'] = __('From: ') . $day['delivery_start1'];
					$result[$day]['string'] .= $openCloseSeperator;
					$result[$day]['string'] .= __('To: ') . $day['delivery_end1'];
					$result[$day]['string'] .= $splitSeperator;
					$result[$day]['string'] .= __('And From: ') . $day['delivery_start2'];
					$result[$day]['string'] .= $openCloseSeperator;
					$result[$day]['string'] .= __('To: ') . $day['delivery_end2'];
				} else {
					$result[$day]['string'] = __('From: ') . $day['delivery_start1'];
					$result[$day]['string'] .= $openCloseSeperator;
					$result[$day]['string'] .= __('To: ') . $day['delivery_end1'];
				}
			}
		} else {
			
			$result['Schedule']['day'] = $this->_dayOfWeekString($schedule['Schedule']['day']);  // name of day
			
			if ($schedule['Schedule']['split_delivery_time']) {
				$result['Schedule']['string'] = __('From: ') . $schedule['Schedule']['delivery_start1'];
				$result['Schedule']['string'] .= $openCloseSeperator;
				$result['Schedule']['string'] .= __('To: ') . $schedule['Schedule']['delivery_end1'];
				$result['Schedule']['string'] .= $splitSeperator;
				$result['Schedule']['string'] .= __('And From: ') . $schedule['Schedule']['delivery_start2'];
				$result['Schedule']['string'] .= $openCloseSeperator;
				$result['Schedule']['string'] .= __('To: ') . $schedule['Schedule']['delivery_end2'];
			} else {
				$result['Schedule']['string'] = __('From: ') . $schedule['Schedule']['delivery_start1'];
				$result['Schedule']['string'] .= $openCloseSeperator;
				$result['Schedule']['string'] .= __('To: ') . $schedule['Schedule']['delivery_end1'];
			}
		}

		return $result;
	}
	

	
	private function _afterMidnightConversion($day){
		$start = ($day['split_delivery_time'])?$day['delivery_start2']:$day['delivery_start1'];
		$end = ($day['split_delivery_time'])?$day['delivery_end2']:$day['delivery_end1'];
		
	}

}
