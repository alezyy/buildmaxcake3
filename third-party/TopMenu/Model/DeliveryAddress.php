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
 * @version       2
 *                                                                   
 */


App::uses('AppModel', 'Model');

/**
 * DeliveryAddress Model
 *
 * @property User $User
 */
class DeliveryAddress extends AppModel {
	
	public $virtualFields = array(
        'inline_address' => 'CONCAT(DeliveryAddress.name, " - ", DeliveryAddress.address, " ", DeliveryAddress.address2, ", ", DeliveryAddress.city, ", ", DeliveryAddress.province, ", ", DeliveryAddress.postal_code)'
	);

	/**
	 * Default ordering field of the table
	 */
	public $order = 'DeliveryAddress.updated DESC';
	
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'user_id' => array(
            'uuid' => array(
                'rule' => array('uuid'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'phone' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Phone must not be empty!',				
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
//			'phone' => array(
//				'rule' => array('phone',null, 'ca' ),
//				'message' => 'Use this format: 000 000-0000, 000 (the extension is not required): '
//			)
        ),
        // 'cross_street' => array(
        //     'notempty' => array(
        //         'rule' => array('notempty'),
        //         'message' => 'Must not be empty!',
        //     //'allowEmpty' => false,
        //     //'required' => false,
        //     //'last' => false, // Stop validation after this rule
        //     //'on' => 'create', // Limit validation to 'create' or 'update' operations
        //     ),
        // ),
        'name' => array(
            'notempty' => array(
                'rule' => 'notempty',                
                'message' => 'Please enter an address name.'
            ),
            'unique' => array(
                'rule' => array("checkUnique", array("name", "user_id")),
                'required' => 'create',
                'message' => 'The address name already exists.',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),

        'address' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Address field must not be empty!',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'city' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'City must not be empty!',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'province' => array(
//            'notempty' => array(
//                'rule' => array('notempty'),
//                'message' => 'Province must not be empty!',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
//            ),
        ),
        'postal_code' => array(
            
            'notempty' => array(
                'rule' => 'notempty',                
                 'message' => 'Please enter your postal code!'
            ),
			'postal_code' => array(
				'rule' => '',
				'message' => 'Postal code format must be: H0H 0H0',
				'allowEmpty' => false,
				'required' => false
			)
		)
	);

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id', 
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

	public function beforeSave($options = array()) {
		
		// implementing ON UPDATE CURRENT_TIMESTAMP
		$now = date("Y-m-d H:i:s", time());
		$this->data['DeliveryAddress']['last_update'] = $now;
				
		// format postal code
		$this->data['DeliveryAddress']['postal_code'] = strtoupper($this->data['DeliveryAddress']['postal_code']);
		
	}	

	/**
	 * Retrieve the last delivery adress used by the user. If a postal code is provided this method returns
	 * the last used address at this postal code
	 * 
	 * @param	string			$userId 
	 * $param	string			$postalCode	A 3, 6 or 7 character long 			
	 * @return	boolean/array	The delivery address or false if no address where found
	 */
	public function getLastAddedAddress($userId, $postalCode = NULL) {
		
		$conditions = array();
		$conditions['DeliveryAddress.user_id'] = $userId;

		if($postalCode){
			if( strlen($postalCode) === 3){
				$conditions['DeliveryAddress.postal_code LIKE'] = "$postalCode%";	// 
			}else{
				$conditions['DeliveryAddress.postal_code LIKE'] = substr($postalCode, 0, 3) ."%" . substr($postalCode, -3);
			}
		}

		$delDest = $this->find('first', array(// default address to use
			'conditions' => $conditions,
			'fields' => array('id', 'door_code', 'postal_code', 'country', 'province', 'city', 'address', 'address2', 'phone', 'inline_address'),
			'order' => array('DeliveryAddress.last_used DESC')));
		if (isset($delDest['DeliveryAddress'])) {
			return $delDest['DeliveryAddress'];
		} else {
			return false;
		}
	}
}
