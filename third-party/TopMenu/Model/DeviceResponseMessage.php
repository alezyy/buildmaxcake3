<?php

App::uses('AppModel', 'Model');
class DeviceResponseMessage extends AppModel{

	/**
	 * Takes a response from the device and return the translated version
	 * @param	string	$response	response given by device
	 * @param	string	$lang		Language expected to be return <b>two char string<b>
	 * @return	string				translated string
	 */
	public function translateString($response, $lang){
		$result = $this->find('first', array(
			'conditions' => array(
				array(
					'OR' => array(
						'device_string_en' => $response,
						'device_string_fr' => $response)))));		
		
		if(empty($result['DeviceResponseMessage']['human_string_'.$lang])){
			return __('We are presently having communication problems with this restaurant. Please try again later or with a different restaurant.');
		}
		
		return $result['DeviceResponseMessage']['human_string_'.$lang];		
	}
}

?>
