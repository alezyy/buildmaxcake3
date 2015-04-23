<?php

/**
 * UsedCouponFixture
 *
 */
class UsedCouponFixture extends CakeTestFixture {

	public $useDbConfig = 'test';
	
	/**
	 * Fields
	 *
	 * @var array
	 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'location_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'coupon_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
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
			'id' => 'id_0',
			'coupon_id' => '521b8859-1be8-42b3-a2cb-2aa3fe51d21f', 
			'user_id' => 'user_0',
			'location_id' => 'location_0',
			'created' => '2014-02-28 15:27:32'
		),
		array(
			'id' => 'id_1',
			'coupon_id' => '521b8859-1be8-42b3-a2cb-2aa3fe51d21f', 
			'user_id' => 'user_1',
			'location_id' => 'location_1',
			'created' => '2014-02-28 15:27:32'
		),
		array(
			'id' => 'id_2',
			'coupon_id' => '521b8859-1be8-42b3-a2cb-2aa3fe51d21f', 
			'user_id' => 'user_1',
			'location_id' => 'location_1',
			'created' => '2014-02-28 15:27:32'
		),
		array(
			'id' => 'id_3',
			'coupon_id' => '521b8859-1be8-42b3-a2cb-2aa3fe51d21f', 
			'user_id' => 'user_1',
			'location_id' => 'location_1',
			'created' => '2014-02-28 15:27:32'
		),
		array(
			'id' => 'id_4',
			'coupon_id' => '521b8859-1be8-42b3-a2cb-2aa3fe51d21f', 
			'user_id' => 'user_1',
			'location_id' => 'location_1',
			'created' => '2014-02-28 15:27:32'
		),
		array(
			'id' => 'id_5',
			'coupon_id' => '521b8859-1be8-42b3-a2cb-2aa3fe51d21f', 
			'user_id' => 'user_1',
			'location_id' => 'location_1',
			'created' => '2014-02-28 15:27:32'
		),
		array(
			'id' => 'id_6',
			'coupon_id' => '521b8859-1be8-42b3-a2cb-2aa3fe51d21f', 
			'user_id' => 'user_2',
			'location_id' => 'location_2',
			'created' => '2014-02-28 15:27:32'
		),
		array(
			'id' => 'id_7',
			'coupon_id' => '521b8859-1be8-42b3-a2cb-2aa3fe51d21f', 
			'user_id' => '52810434-b8a0-4375-83ce-6a881ec880c8',
			'location_id' => 'location_2',
			'created' => '2014-02-28 15:27:32'
		),
		array('id' => '53359c25-a264-4643-93a1-2450c0c6c6a4',
			'user_id' => '5294b93d-10ac-4832-ac64-558dc0c6c6a3',
			'location_id' => '528103ae-4fb0-48b2-ae8e-6a881ec880c8',
			'coupon_id' => '53359a64-bba0-42d7-b150-1d1fc0c6c6a4',
			'created' => '2014-03-28'),
		array('id' => '53359d42-3218-4194-92a8-2450c0c6c6a4',
			'user_id' => '53359cfd-abac-43cf-a2b3-1d1fc0c6c6a4',
			'location_id' => '528103ae-4fb0-48b2-ae8e-6a881ec880c8',
			'coupon_id' => '53359a64-bba0-42d7-b150-1d1fc0c6c6a4',
			'created' => '2014-03-28'),
		array('id' => '53359df1-9378-4e66-928a-2418c0c6c6a4',
			'user_id' => '53359dad-0670-4301-b58f-2450c0c6c6a4',
			'location_id' => '528103ae-4fb0-48b2-ae8e-6a881ec880c8',
			'coupon_id' => '53359a64-bba0-42d7-b150-1d1fc0c6c6a4',
			'created' => '2014-03-28'),
		array('id' => '53359c25-a264-4643-93a1-2450c0c6c6a6',
			'user_id' => '5294b93d-10ac-4832-ac64-558dc0c6c6a3',
			'location_id' => '528103ae-4fb0-48b2-ae8e-6a881ec880c8',
			'coupon_id' => '53359a64-bba0-42d7-b150-1d1fc0c6c6a5',
			'created' => '2014-03-28'),
		array('id' => '53359d42-3218-4194-92a8-2450c0c6c6a6',
			'user_id' => '53359cfd-abac-43cf-a2b3-1d1fc0c6c6a4',
			'location_id' => '528103ae-4fb0-48b2-ae8e-6a881ec880c8',
			'coupon_id' => '53359a64-bba0-42d7-b150-1d1fc0c6c6a5',
			'created' => '2014-03-28'),
		array('id' => '53359d42-3218-4194-92a8-2450c0c6c6a5',
			'user_id' => '53359cfd-abac-43cf-a2b3-1d1fc0c6c6a4',
			'location_id' => '528103ae-4fb0-48b2-ae8e-6a881ec880c8',
			'coupon_id' => '53359a64-bba0-42d7-b150-1d1fc0c6c6a5',
			'created' => '2014-03-28'),
		array('id' => '53359df1-9378-4e66-928a-2418c0c6c6a6',
			'user_id' => '53359dad-0670-4301-b58f-2450c0c6c6a4',
			'location_id' => '528103ae-4fb0-48b2-ae8e-6a881ec880c8',
			'coupon_id' => '53359a64-bba0-42d7-b150-1d1fc0c6c6a5',
			'created' => '2014-03-28')
	);

}
