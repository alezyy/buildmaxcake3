<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP LocationAddress
 * @author pechartrand
 */
class LocationAddress extends AppModel {
    
    public $virtualFields = array(
        'inline_address' => 'CONCAT(DeliveryAddress.name, ": ", DeliveryAddress.door_code, " ", DeliveryAddress.address, " ", DeliveryAddress.address2,  ", ", DeliveryAddress.city)'
    );
    
    /**
	 * Default ordering field of the table
	 */
	public $order = 'LocationAddress.updated DESC';
    
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'user_id'     => array(
            'uuid' => array(
                'rule' => array('uuid'),            
            ),
        ),
        'phone'       => array(
            'notEmpty' => array(
                'rule'    => array('notEmpty'),
                'message' => 'Phone must not be empty!',            
            ),
        ),        
        'address'     => array(
            'notEmpty' => array(
                'rule'    => array('notEmpty'),
                'message' => 'Address field must not be empty!',          
            ),
        ),
        'city'        => array(
            'notEmpty' => array(
                'rule'    => array('notEmpty'),
                'message' => 'City must not be empty!',
            ),
        ),
        'postal_code' => array(
            'notEmpty'    => array(
                'rule'    => 'notEmpty',
                'message' => 'Please enter your postal code!'
            ),
            'postal_code' => array(
                'rule'       => array('custom', "/^[A-Z][0-9][A-Z] {0,1}[0-9][A-Z][0-9]$/"),
                'message'    => 'Postal code format must be: H0H 0H0',
            )
        )
    );
    
    public function beforeSave() {

        // implementing ON UPDATE CURRENT_TIMESTAMP
        $now = date("Y-m-d H:i:s", time());
        $this->data['DeliveryAddress']['last_update'] = $now;

        // format postal code
        $this->data['DeliveryAddress']['postal_code'] = strtoupper($this->data['DeliveryAddress']['postal_code']);
    }

}
