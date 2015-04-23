<?php
App::uses('AppHelper', 'View/Helper');


class DayHelper extends AppHelper {

	public $helpers = array('Html', 'Form');

	private $days = array();

	public function __construct(View $view) {
		parent::__construct($view);
		$this->days = array(
			__('Sunday'),
			__('Monday'),
			__('Tuesday'),
			__('Wednesday'),
			__('Thursday'),
			__('Friday'),
			__('Saturday')
		);
	}

	public function day_input($field_name, $options = array()) {
		$options['options'] = $this->days;
		return $this->Form->input(
			$field_name,
			$options
		);
	}

	public function day($day) {
		if ($day >= 0 && $day < 7) {
			return $this->days[$day];
		}
		return false;
	}

}