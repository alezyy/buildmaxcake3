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
 * DeliveryArea Model
 *
 * @property Location $Location
 */
class DeliveryArea extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'postal_code';

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
		'postal_code' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'postal_code_3letters' => array(
				'rule' => '/^[A-Za-z][0-9][A-Za-z]$/',
				'message' => 'Postal code format must be: H0H',
				'allowEmpty' => false,
				'required' => false
			)
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
	

	public function afterSave($created, $options = array()) {
		parent::afterSave($created, $options);
		$location_id = $this->find('first', array(
			'fields' => 'DeliveryArea.location_id',
			'conditions' => array(
				'DeliveryArea.id' => $this->data['DeliveryArea']['id']
			)
		));

		$this->Location->forceUpdate($location_id['DeliveryArea']['location_id']);
	}

	public function beforeDelete($cascade = true) {
		parent::beforeDelete($cascade);
		$this->location_id = $this->find('first', array(
			'fields' => 'DeliveryArea.location_id',
			'conditions' => array(
				'DeliveryArea.id' => $this->id
			)
		));
	}

	public function afterDelete() {
		parent::afterDelete();
		$this->Location->forceUpdate($this->location_id['DeliveryArea']['location_id']);
	}
	
	/**
	 * @deprecated	30/10/2013		Use <i>deliversThereAndCharges($locationId, $destinationCode)</i> instead
	 * 
	 * Check if delivery for a the given location is possible for the given destination
     * Also, give's the amount of money charged for deliveries to this postal code.
     * 
	 * @param string $locationId	
	 * @param string $destinationPc Postal Code of the delivery destination (ex.: client's home).<br/>Full Postal codes will be truncated after 3 character. 
	 * 
	 * @return mixed FALSE			if no delivery to this area is unavailable.<br/> float price of the delivery
	 */
	public function getDeliveryCharge($locationId, $destinationPc) {

		$pcFirstPart = 3;		// first part of postal code (for a larger area)
		$postalCode= substr($postalCode, 0, $pcFirstPart);	// get only 3 first char of postal code
		
		// query
		$result = $this->find('first', array(
			'conditions' => array(
				'DeliveryArea.location_id' => $locationId,
				'DeliveryArea.postal_code' => $destinationPc),
			'fields' => array('DeliveryArea.delivery_charge')));

		if (empty($result)){
            return FALSE;            
        }else{
            return $result['delivery_charge'];
        }        
	}
    
    /**
     * Check if delivery for a the given location is possible for the given destination
     * Also, give's the amount of money charged for deliveries to this postal code.<br/>
	 * <b>Warning: this method may returns an int or boolean. 0 means true</b>
     *
     * @param string $locationId		Location delivering the food id
     * @param string $destinationCode	Postal code of the destination of the delivery.<br/>
     *									<i>Only the first three characters will be used</i>
     *  
     * @return int/boolean  float of the Amount the restaurant will charge.<br/>
     *                      FALSE if no record where found, meaning the restaurant does not deliver to this location<br/>
	 *						    -------------------<br/>
	 *						|<b>HERE 0 MEANS TRUE</b>|<br/>	
	 *						    -------------------
	 * 
	 * @
     * 
     */
    public function deliversThereAndCharges($locationId, $destinationCode){
    	// Format String
    	if (strlen($destinationCode) > 3) {
    		$destinationCode = strtoupper(substr($destinationCode, 0, 3));
    	} else {
    		$destinationCode = strtoupper($destinationCode);
    	}

        $result = $this->find('first', 
            array(
                'conditions' => array(
                    'DeliveryArea.location_id' => $locationId,
                    'DeliveryArea.postal_code LIKE' => $destinationCode),
                'fields' => array('DeliveryArea.delivery_charge', 'DeliveryArea.delivery_min')
            )
        );
		
			
        if (empty($result)){
            return FALSE;            
        } else {
            return $result['DeliveryArea'];
        }        
    }
	
	/**
	 * Get the delivery Minimum order (in dollars) and the delivery charge for the given restaurant for the given postal code
	 * @param UUID $locationId
	 * @param string $postalCode
	 */
	public function getDeliveryMinAndChargeForPostalCode($locationId, $postalCode){
		$postalCode = substr($postalCode,3);	// get only the first thee char of postal code
		
		if(strlen($postalCode) !== 3){
			throw new ValidationException(__('Incorrect postal code'));
		}	
		
		 $return = $this->find('first', 
            array(
                'conditions' => array(
                    'DeliveryArea.location_id' => $locationId,
                    'DeliveryArea.postal_code LIKE' => $postalCode.'%'),
                'fields' => array('DeliveryArea.delivery_charge', 'DeliveryArea.delivery_min')));  
		
	}
}
