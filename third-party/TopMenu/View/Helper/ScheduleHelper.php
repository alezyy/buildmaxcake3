<?php
App::uses('AppHelper', 'View/Helper');
App::uses('CakeTime', 'Utility');
/*
 * Date Helper
 *
 */
class ScheduleHelper extends AppHelper {
	/**
	 * Format the a schedule arrary into a human readable one
	 * @todo put in helper instead
	 * @param array		$schedule			Result from Schedule->find();
	 * @param string	$openCloseSeperator Text or HTML seperator that goes between 'From: 09:00AM' and  'To: 5:00PM';
	 * @param string	$splitSeperator		Text or HTML seperator that goes between the splited scheduled
	 * @return array						Array containing the name of the day and the string of the scedule for each day found in Schedule->find()
	 */
	public function scheduleNiceArray($schedule, $openCloseSeperator = ' - ', $splitSeperator = ' ') {
		$result = array();
		if (count($schedule) > 1) {
			foreach ($schedule['Schedule'] as $day) {

				$result[$day]['day'] = $this->_dayOfWeekString($day);  // name of day

				if ($day['split_delivery_time']) {
					$result[$day]['string'] = date('H:i',strtotime($day['delivery_start1']));
					$result[$day]['string'] .= ' - ' . date('H:i',strtotime($day['delivery_end1']));
					$result[$day]['string'] .= ' ---------  ' . date('H:i',strtotime($day['delivery_start2']));
					$result[$day]['string'] .= ' - ' . date('H:i',strtotime($day['delivery_end2']));
				} else {
					$result[$day]['string'] = date('H:i',strtotime($day['delivery_start1']));
					$result[$day]['string'] .= ' - ' . date('H:i',strtotime($day['delivery_end1']));
				}
			}
		} else {
			
			$result['Schedule']['day'] = $this->_dayOfWeekString($schedule['Schedule']['day']);  // name of day
			
			if ($schedule['Schedule']['split_delivery_time']) {
				$result['Schedule']['string'] = date('H:i',strtotime($schedule['Schedule']['delivery_start1']));
				$result['Schedule']['string'] .= ' - ' . date('H:i',strtotime($schedule['Schedule']['delivery_end1']));
				$result['Schedule']['string'] .= ' ---------  ' . date('H:i',strtotime($schedule['Schedule']['delivery_start2']));
				$result['Schedule']['string'] .= ' - ' . date('H:i',strtotime($schedule['Schedule']['delivery_end2']));
			} else {
				$result['Schedule']['string'] = date('H:i',strtotime($schedule['Schedule']['delivery_start1']));
				$result['Schedule']['string'] .= ' - '. date('H:i',strtotime($schedule['Schedule']['delivery_end1']));
			}
		}

		return $result;
	}
	
		/**
	 * Translate the numeric value of the day of the week into a string using our .po files
	 * @param int $numericDayOfWeek
	 * @return string
	 */
	public function _dayOfWeekString($numericDayOfWeek){
		switch ($numericDayOfWeek) {
			
			case 0:
					return __('Sun');
			case 1:
					return __('Mon');
			case 2:
					return __('Tue');
			case 3:
					return __('Thur');
			case 4:
					return __('Wed');
			case 5:
					return __('Fri');
			case 6:
					return __('Sat');
		}
	}

}