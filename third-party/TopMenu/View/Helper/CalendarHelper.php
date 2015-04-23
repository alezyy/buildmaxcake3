<?php
App::uses('AppHelper', 'View/Helper');
class CalendarHelper extends AppHelper {

	public $helpers = array('Html', 'Form');

	public function __construct($view, $settings = array()) {
		parent::__construct($view, $settings);
//		$this->Html->script('dhtmlxcalendar', array('inline' => false));
//		$this->Html->css('dhtmlxcalendar', null, array('inline' => false));
//		$this->Html->css('dhtmlxcalendar_dhx_skyblue', null, array('inline' => false));
		$this->__buildCode($settings);
	}
	private function __buildCode($settings = array()) {
		$week = 7;
		$hide_time = true;
		$date_format = "%Y-%m-%d";
		$position = "right";

		extract($settings);


		switch ($hide_time) {
			case true:
				$timestr = 'myCalendar.hideTime();';
				break;
			case false:
				$timestr = '';
				break;
		}
		$code = 'var myCalendar;
function doOnLoad(e) {
	if (myCalendar == null) {
    	myCalendar = new dhtmlXCalendarObject(e);
		myCalendar.setWeekStartDay(' . $week . ');
	    ' . $timestr . '
	    myCalendar.setDateFormat("' . $date_format . '");
	    myCalendar.setPosition("' . $position . '");
    }
    else
    {
    	myCalendar.attachObj(document.getElementById(e));
    }
}';
		$this->Html->scriptBlock($code, array('inline' => false));
	}
	public function calendar($input, $data = array(), $inline = false){
		$id = 'cal_' . sha1(microtime());
		$data['id'] = $id;
		$data['type'] = 'text';
		$data['autocomplete'] = 'off';
		$data['placeholder'] = __('Click to Select Date');

		$code = '$(document).ready( function () { doOnLoad("' . $id . '"); } );';
		if ($inline)
			echo $this->Html->scriptBlock($code, array('inline' => true));
		else
			$this->Html->scriptBlock($code, array('inline' => false));
		$this->Form->unlockField($input);
		if (isset($data['append'])) {
			return $this->Html->tag('div', $this->Form->input($input, $data), array(
				'class' => 'input-append'
			));
		}
		return $this->Form->input($input, $data);
	}
}