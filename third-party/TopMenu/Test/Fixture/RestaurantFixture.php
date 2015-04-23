<?php
/**
 * RestaurantFixture
 *
 */
class RestaurantFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'address' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'city' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'postal_code' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 7, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'telephone' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'website' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'delivery_hours' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'delivery_hours_en' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'conditions' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'conditions_en' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rebate_text' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rebate_text_en' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rebate_banner' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'rebate_banner_en' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'logo' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'pdf_menu_fr' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'pdf_menu_en' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'visa' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'mastercard' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'american' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'interac' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'enroute' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'paypal' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'online_ordering' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'delivery' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'pickup' => array('type' => 'string', 'null' => false, 'default' => '1', 'length' => 4, 'key' => 'index', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'url_en' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'url_fr' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'commission' => array('type' => 'float', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'ID_restaurant' => array('column' => 'id', 'unique' => 0),
			'pickup' => array('column' => 'pickup', 'unique' => 0),
			'ID_restaurant_2' => array('column' => 'id', 'unique' => 0)
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
			'id' => '5222a864-9de4-4987-9f83-7ceffe51d21f',
			'address' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor sit amet',
			'postal_code' => 'Lorem',
			'name' => 'Lorem ipsum dolor sit amet',
			'telephone' => 'Lorem ipsum dolor ',
			'website' => 'Lorem ipsum dolor sit amet',
			'email' => 'Lorem ipsum dolor sit amet',
			'delivery_hours' => 'Lorem ipsum dolor sit amet',
			'delivery_hours_en' => 'Lorem ipsum dolor sit amet',
			'conditions' => 'Lorem ipsum dolor sit amet',
			'conditions_en' => 'Lorem ipsum dolor sit amet',
			'rebate_text' => 'Lorem ipsum dolor sit amet',
			'rebate_text_en' => 'Lorem ipsum dolor sit amet',
			'rebate_banner' => 'Lorem ipsum dolor sit amet',
			'rebate_banner_en' => 'Lorem ipsum dolor sit amet',
			'logo' => 'Lorem ipsum dolor sit amet',
			'pdf_menu_fr' => 'Lorem ipsum dolor sit amet',
			'pdf_menu_en' => 'Lorem ipsum dolor sit amet',
			'visa' => 1,
			'mastercard' => 1,
			'american' => 1,
			'interac' => 1,
			'enroute' => 1,
			'paypal' => 1,
			'online_ordering' => 1,
			'delivery' => 1,
			'pickup' => 'Lo',
			'active' => 1,
			'url_en' => 'Lorem ipsum dolor sit amet',
			'url_fr' => 'Lorem ipsum dolor sit amet',
			'commission' => 1
		),
	);

}
