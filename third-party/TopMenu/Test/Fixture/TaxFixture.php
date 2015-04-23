<?php
/**
 * TaxFixture
 *
 */
class TaxFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'tier' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 1),
		'country_country' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 41, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rate' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '10,3'),
		'compound' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
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
			'id' => 1,
			'tier' => 1,
			'country_country' => '',
			'name' => 'Lorem ipsum dolor sit amet',
			'rate' => 1,
			'compound' => 1,
			'name' => 'Lorem ipsum dolor sit amet'
		),
	);

}
