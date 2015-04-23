<?php
/**
 * MenuItemOptionFixture
 *
 */
class MenuItemOptionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'menu_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'menu_item_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name_en' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name_fr' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'price' => array('type' => 'float', 'null' => false, 'default' => null),
		'multiselect' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1),
		'required' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1),
		'number_of_free_values' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
		'half_and_half' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'status' => array('type' => 'string', 'null' => false, 'default' => 'active', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
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
			'id' => '521b7581-9b94-43b4-bb1e-612bfe51d21f',
			'menu_id' => 'Lorem ipsum dolor sit amet',
			'menu_item_id' => 'Lorem ipsum dolor sit amet',
			'name_en' => 'Lorem ipsum dolor sit amet',
			'name_fr' => 'Lorem ipsum dolor sit amet',
			'price' => 1,
			'multiselect' => 1,
			'required' => 1,
			'number_of_free_values' => 1,
			'half_and_half' => 1,
			'status' => 'Lorem ipsum dolor sit amet'
		),
	);

}
