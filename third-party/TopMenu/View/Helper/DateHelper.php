<?php
App::uses('AppHelper', 'View/Helper');
App::uses('CakeTime', 'Utility');
/*
 * Date Helper
 *
 */
class DateHelper extends AppHelper {

	public $helpers = array('Session');
/**
 * Formats dates (wrapper for php function)
 * @param  mixed $date   Date to be formatted
 * @param  string $format See PHP manual for valid formats (strftime)
 * @return mixed         Formatted date on success, null on fail
 */
	public function formatDate($date, $timezone = null, $format = null) {
		if ($format === null) {
			$format = "%a %d %b %Y - %k:%M";
		}
		if ($timezone === null) {
            $timezone = 'America/Montreal';
		}
		if (!empty($date)) {
			return CakeTime::i18nFormat(strtotime($date), $format, false, $timezone);
		} else {
			return null;
		}
	}

}