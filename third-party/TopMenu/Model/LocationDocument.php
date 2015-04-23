<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP LocationDocument
 * @author pechartrand
 */
class LocationDocument extends AppModel {
            
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
        'name'       => array(
            'notEmpty' => array(
                'rule'    => array('notEmpty'),
                'message' => 'Phone must not be empty!',            
            ),
        ),        
    );
    
    public function beforeSave($options = array()) {

        // implementing ON UPDATE CURRENT_TIMESTAMP
        $now = date("Y-m-d H:i:s", time());
        $this->data['DeliveryAddress']['last_update'] = $now;
    }
}
