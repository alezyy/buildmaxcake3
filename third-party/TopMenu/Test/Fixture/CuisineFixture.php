<?php
/**
 * CuisineFixture
 *
 */
class CuisineFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name_en' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'name_fr' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'url' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'restaurant_count' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 7),
		'image' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
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
			'id' => '522e907f-0734-4d87-ae25-6d68fe51d21f',
			'name_en' => 'Brazilian',
			'name_fr' => 'Brésilien',
			'url' => 'brazilian',
			'restaurant_count' => '0',
			'image' => null,
			'status' => 'active',
			'created' => '2013-09-10 03:22:39',
			'modified' => '2013-09-10 03:22:39'
		),
		array(
			'id' => '522e907f-0988-4613-8225-6d68fe51d21f',
			'name_en' => 'Lamb',
			'name_fr' => 'Agneau',
			'url' => 'lamb',
			'restaurant_count' => '3',
			'image' => null,
			'status' => 'inactive',
			'created' => '2013-09-10 03:22:39',
			'modified' => '2013-09-10 03:22:39'
		),
		array(
			'id' => '522e907f-09c8-44f4-8bf8-6d68fe51d21f',
			'name_en' => 'Low Fat',
			'name_fr' => 'Faible en gras',
			'url' => 'low fat',
			'restaurant_count' => '0',
			'image' => null,
			'status' => 'active',
			'created' => '2013-09-10 03:22:39',
			'modified' => '2013-09-10 03:22:39'
		),
		array(
			'id' => '522e907f-0d80-4fa3-ab4d-6d68fe51d21f',
			'name_en' => 'Veau',
			'name_fr' => 'Veau',
			'url' => 'veau',
			'restaurant_count' => '7',
			'image' => null,
			'status' => 'inactive',
			'created' => '2013-09-10 03:22:39',
			'modified' => '2013-09-10 03:22:39'
		),
		array(
			'id' => '522e907f-0e50-479c-8fc8-6d68fe51d21f',
			'name_en' => 'Vietnamese',
			'name_fr' => 'Vietnamienne',
			'url' => 'vietnamese',
			'restaurant_count' => '5',
			'image' => null,
			'status' => 'active',
			'created' => '2013-09-10 03:22:39',
			'modified' => '2013-09-10 03:22:39'
		),
		array(
			'id' => '522e907f-10ec-4954-9e03-6d68fe51d21f',
			'name_en' => 'Panini',
			'name_fr' => 'Panini',
			'url' => 'panini',
			'restaurant_count' => '137',
			'image' => null,
			'status' => 'inactive',
			'created' => '2013-09-10 03:22:39',
			'modified' => '2013-09-10 03:22:39'
		),
		array(
			'id' => '522e907f-1ea8-462c-8e6d-6d68fe51d21f',
			'name_en' => 'Healthy',
			'name_fr' => 'Santé',
			'url' => 'healthy',
			'restaurant_count' => '0',
			'image' => null,
			'status' => 'active',
			'created' => '2013-09-10 03:22:39',
			'modified' => '2013-09-10 03:22:39'
		),
		array(
			'id' => '522e907f-22e8-44cd-bcdb-6d68fe51d21f',
			'name_en' => 'Vegetarian',
			'name_fr' => 'Végétarien',
			'url' => 'vegetarian',
			'restaurant_count' => '0',
			'image' => null,
			'status' => 'active',
			'created' => '2013-09-10 03:22:39',
			'modified' => '2013-09-10 03:22:39'
		),
		array(
			'id' => '522e907f-2770-46cc-acec-6d68fe51d21f',
			'name_en' => 'Jamaican',
			'name_fr' => 'Jamaïquain',
			'url' => 'jamaican',
			'restaurant_count' => '1',
			'image' => null,
			'status' => 'active',
			'created' => '2013-09-10 03:22:39',
			'modified' => '2013-09-10 03:22:39'
		),
		array(
			'id' => '522e907f-2844-4f2a-a239-6d68fe51d21f',
			'name_en' => 'Kosher-Style',
			'name_fr' => 'Kosher-Style',
			'url' => 'kosher-style',
			'restaurant_count' => '0',
			'image' => null,
			'status' => 'active',
			'created' => '2013-09-10 03:22:39',
			'modified' => '2013-09-10 03:22:39'
		),
	);

}
