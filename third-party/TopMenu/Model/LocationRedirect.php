<?php
App::uses('AppModel', 'Model');
/**
 * LocationRedirect Model
 *
 * @property Location $Location
 */
class LocationRedirect extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'old_url';


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

	public $validate = array(
		'location_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
				// 'allowEmpty' => false,
				// 'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			)
		),
		'old_url' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Must not be empty!',
				// 'allowEmpty' => false,
				// 'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Old URL must be unique!'
			)
		)
	);

	public function getLocationId($old_url) {
		$result = $this->find('first', array(
			'conditions' => array(
				'LocationRedirect.old_url' => $old_url
			),
			'fields' => array(
				'LocationRedirect.location_id'
			)
		));

		return $result;
	}

}
