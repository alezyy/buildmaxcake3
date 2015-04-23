<?php

App::uses('AppModel', 'Model');

class GatewayResponseMessage extends AppModel {

	/**
	 * Takes a response from the device and return the translated version<br/>
	 * The error message given by the gateway is use as a key to find the human friendly (and localized) corresponding 
	 * message in the database.
	 * @param	string	$responseMessage	response message retrieve from gateway
	 * @param	string	$lang				Language expected to be return <b>two char string<b>
	 * @return	string						translated string
	 */
	public function translateString($responseMessage, $lang) {

		// May receive string or array. 
		$humanFriendlyString = "";
		$strippedMessage = is_array($responseMessage) ? $responseMessage[0] : empty($responseMessage) ? '' : $responseMessage; // LOL I'm bad (actually lazy)
		
		$strippedMessageArray = explode(';', $strippedMessage);
			
		foreach ($strippedMessageArray as $sma) {
			$conditions	 = array('GatewayResponseMessage.original_message LIKE' => trim($sma));
			$result		 = $this->find('first', array('conditions' => $conditions));
			$humanFriendlyString .= (empty($result['GatewayResponseMessage']['message_' . $lang])) ? "" : "<li>" . $result['GatewayResponseMessage']['message_' . $lang] . ";</li> ";
			// is that some mother fucking markup in the model!! Biiitch; have been coding for 14 hours strait //todo
		}

		if(empty($humanFriendlyString)){
			return __('Order rejected by payment gateway. Please verify your billing informations');	
		}
		
		return __('Order rejected by payment gateway. Error message(s): <ul>' . $humanFriendlyString . '</ul>');
	}

}
