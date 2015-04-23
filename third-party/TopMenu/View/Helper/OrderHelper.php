<?php
App::uses('AppHelper', 'View/Helper');
/*
 * Date Helper
 *
 */
class OrderHelper extends AppHelper {
	
		// Delivery type switch button
		public $helpers = array('Common', 'Html');
		public function orderTypeSwitcher($delType,$locationUrl, $locationId, $options = NULL){
		
		// Get the right parameter and title for the link to be output
		if ($delType === 'delivery') {
			$delTypeTitle = __('Click here to pickup the order');
			$delTypeFlag = 'pickup';
		}elseif($delType === 'pickup') {
			$delTypeTitle = __('Click for delivery');
			$delTypeFlag = 'delivery';
		}else{		
			$delTypeTitle = __('Switch to pickup');
			$delTypeFlag = 'pickup';
		}
		
		if($options === NULL){
			$options = array(
					'role' => 'button',
					'class' => 'btn',
					'name' => 'update_order',
					'id' => 'pickup');
		}
		
		// Build the link button
		return $this->Html->link(
				$delTypeTitle, 
				array(
					'controller' => 'locations',
					'action' => 'set_order_type',
					'type' => $delTypeFlag,
					'locationUrl' => $locationUrl,
					'locationId' => $locationId),
				$options);
	}
}