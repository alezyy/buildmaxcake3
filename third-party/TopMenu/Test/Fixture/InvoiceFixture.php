<?php
/**
 * InvoiceFixture
 *
 */
class InvoiceFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'restaurant_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'location_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'from_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'to_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'status' => array('type' => 'string', 'null' => false, 'default' => 'unpaid', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'total_amount' => array('type' => 'float', 'null' => false, 'default' => null),
		'paid_amount' => array('type' => 'float', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '521b79fc-5030-4471-845b-19defe51d21f',
			'restaurant_id' => 'Lorem ipsum dolor sit amet',
			'location_id' => 'Lorem ipsum dolor sit amet',
			'from_date' => '2013-08-26',
			'to_date' => '2013-08-26',
			'status' => 'Lorem ipsum dolor sit amet',
			'total_amount' => 1,
			'paid_amount' => 1
		),
	);

}
