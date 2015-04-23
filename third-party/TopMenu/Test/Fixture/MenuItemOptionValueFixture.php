<?php
/**
 * MenuItemOptionValueFixture
 *
 */
class MenuItemOptionValueFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'menu_item_option_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name_en' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name_fr' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'price' => array('type' => 'float', 'null' => false, 'default' => null),
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
			'id' => '521b75f1-4dcc-426e-9432-7175fe51d21f',
			'menu_item_option_id' => 'Lorem ipsum dolor sit amet',
			'name_en' => 'Lorem ipsum dolor sit amet',
			'name_fr' => 'Lorem ipsum dolor sit amet',
			'price' => 1,
			'status' => 'Lorem ipsum dolor sit amet'
		),
	);

}
