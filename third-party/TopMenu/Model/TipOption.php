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

class TipOption extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';
    
	public $order = 'TipOption.amount ASC';
	

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'amount' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Must not be empty!',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
     //   'location_id' => array(
       //     'uuid' => array(
         //       'rule' => array('uuid'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
           // ),
        //)
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

    /**
     * Grabs a list of tips values for a given location
     * @param  string $id Location's id
     * @return array Tips values for this location if location have any set or array of default values
     */
    public function getTipOptions($id) {
        $results = $this->find('all', array(
            'fields' => array('amount'),
            'conditions' => array('TipOption.location_id' => 'default')));
        
        // If no result where found for this restaurant then return default options
        if(empty($results)){
            return $this->find('all', array(
            'fields' => array('amount'),
            'conditions' => array('TipOption.location_id' => 'default')));
        }else{
            return $results;
        }
    }

}