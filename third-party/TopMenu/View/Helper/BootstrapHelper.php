<?php
App::uses('AppHelper', 'View/Helper');
/*
 * Bootstrap Helper
 *
 */
class BootstrapHelper extends AppHelper {

	public $helpers = array('Html');

	public function __construct($view, $settings = array()) {
		parent::__construct($view, $settings);
	}
	public function address($data = array(), $header = ''){
		$return = '';
		if (!empty($header)) {
			$return .= $this->Html->tag('strong', h($header));
		}

		$address = h($data['address']);
		$address2 = h($data['address2']);
		$city = h($data['city']);
		$province = h($data['province']);
		$country = h($data['country']);
		$postal = h($data['postal']);


		$return .= '<br />';
		$return .= $address . '<br />';
		if (!empty($address2)) {
			$return .= $address2 . '<br />';
		}
		$return .= $city . ', ';
		$return .= $province . ', ';
		$return .= strtoupper($postal) . '<br />';
		$return .= $country . '<br />';

		return $this->Html->tag('address', $return);
	}
	public function label($text = '', $type = null, $options = array()){
		switch ($type) {
			default:
				$options['class'] ='label';
			break;
			case 'success':
				$options['class'] = 'label label-success';
			break;
			case 'warning':
				$options['class'] = 'label label-warning';
			break;
			case 'important':
			case 'error':
				$options['class'] = 'label label-important';
			break;
			case 'notice':
			case 'info':
				$options['class'] = 'label label-info';
			break;
			case 'inverse':
				$options['class'] = 'label label-inverse';
			break;
		}

		return $this->Html->tag(
			'span',
			h($text),
			$options
		);
	}

	public function badge($text = '', $type = null, $options = array()){
		switch ($type) {
			default:
				$options['class'] ='badge';
			break;
			case 'success':
				$options['class'] = 'badge badge-success';
			break;
			case 'warning':
				$options['class'] = 'badge badge-warning';
			break;
			case 'important':
			case 'error':
				$options['class'] = 'badge badge-important';
			break;
			case 'notice':
			case 'info':
				$options['class'] = 'badge badge-info';
			break;
			case 'inverse':
				$options['class'] = 'badge badge-inverse';
			break;
		}

		return $this->Html->tag(
			'span',
			h($text),
			$options
		);
	}
}