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
 * LocationGallery Model
 *
 * @property Location $Location
 */
class LocationGallery extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'caption';
    
    public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->virtualFields['caption'] = 'LocationGallery.caption_' . $this->langSuffix;
    }
    
    public function beforeSave($options = array()) {
        parent::beforeSave($options);
        if (!$this->id) {
            if (empty($this->data['LocationGallery']['caption_fr']) && !empty($this->data['LocationGallery']['caption_fr'])) {
                $this->data['LocationGallery']['description_en'] = $this->data['LocationGallery']['captin_fr'];
            }

            if (empty($this->data['LocationGallery']['caption_en']) && !empty($this->data['LocationGallery']['caption_fr'])) {
                $this->data['LocationGallery']['caption_en'] = $this->data['Gallery']['caption_fr'];
            }
        }
    }

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
		'caption_fr' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
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
}
