<?php
/**
 * OrderFixture
 *
 */
class OrderFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'restaurant_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'location_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_id' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'subtotal' => array('type' => 'float', 'null' => false, 'default' => null),
		'gst_percent' => array('type' => 'float', 'null' => false, 'default' => null),
		'pst_percent' => array('type' => 'float', 'null' => false, 'default' => null),
		'hst_percent' => array('type' => 'float', 'null' => false, 'default' => null),
		'gst' => array('type' => 'float', 'null' => false, 'default' => null),
		'pst' => array('type' => 'float', 'null' => false, 'default' => null),
		'hst' => array('type' => 'float', 'null' => false, 'default' => null),
		'pst_name_en' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'pst_name_fr' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'delivery_charge' => array('type' => 'float', 'null' => false, 'default' => null),
		'tip' => array('type' => 'float', 'null' => true, 'default' => null),
		'total' => array('type' => 'float', 'null' => false, 'default' => null),
		'redeemed_points' => array('type' => 'integer', 'null' => false, 'default' => null),
		'redeemed_points_value' => array('type' => 'float', 'null' => false, 'default' => null),
		'points_earned' => array('type' => 'integer', 'null' => false, 'default' => null),
		'paid_by' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'transaction_id' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'commission_percentage' => array('type' => 'float', 'null' => false, 'default' => null),
		'paid_to_client' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
		'dated' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'first_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'last_name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'address' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'address2' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'city' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'state' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'postal_code' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'door_code' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'street_no' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 10, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cross_street' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'phone' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 15, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'email' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'special_instruction' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'coupon_code' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 20, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'coupon_discount' => array('type' => 'float', 'null' => false, 'default' => null),
		'language' => array('type' => 'string', 'null' => false, 'default' => 'en', 'length' => 2, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'status' => array('type' => 'string', 'null' => false, 'default' => 'unprocessed', 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'order_goes_to' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 32, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'future_order_time' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'expected_delivery_time' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'rejection_reason' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'referrer' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'digits' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4),
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
			'id' => '521b7071-eea8-4b60-8289-34e1fe51d21f',
			'restaurant_id' => 'Lorem ipsum dolor sit amet',
			'location_id' => 'Lorem ipsum dolor sit amet',
			'user_id' => 'Lorem ipsum dolor sit amet',
			'subtotal' => 1,
			'gst_percent' => 1,
			'pst_percent' => 1,
			'hst_percent' => 1,
			'gst' => 1,
			'pst' => 1,
			'hst' => 1,
			'pst_name_en' => 'Lorem ipsum dolor sit amet',
			'pst_name_fr' => 'Lorem ipsum dolor sit amet',
			'delivery_charge' => 1,
			'tip' => 1,
			'total' => 1,
			'redeemed_points' => 1,
			'redeemed_points_value' => 1,
			'points_earned' => 1,
			'paid_by' => 'Lorem ipsum dolor sit amet',
			'transaction_id' => 'Lorem ipsum dolor sit amet',
			'commission_percentage' => 1,
			'paid_to_client' => 1,
			'dated' => '2013-08-26 15:12:49',
			'first_name' => 'Lorem ipsum dolor sit amet',
			'last_name' => 'Lorem ipsum dolor sit amet',
			'address' => 'Lorem ipsum dolor sit amet',
			'address2' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor sit amet',
			'state' => 'Lorem ipsum dolor sit amet',
			'postal_code' => 'Lorem ip',
			'door_code' => 'Lorem ipsum dolor sit amet',
			'street_no' => 'Lorem ip',
			'cross_street' => 'Lorem ipsum dolor sit amet',
			'phone' => 'Lorem ipsum d',
			'email' => 'Lorem ipsum dolor sit amet',
			'special_instruction' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'coupon_code' => 'Lorem ipsum dolor ',
			'coupon_discount' => 1,
			'language' => '',
			'status' => 'Lorem ipsum dolor sit amet',
			'order_goes_to' => 'Lorem ipsum dolor sit amet',
			'future_order_time' => '2013-08-26 15:12:49',
			'expected_delivery_time' => '2013-08-26 15:12:49',
			'rejection_reason' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'referrer' => 'Lorem ipsum dolor sit amet',
			'digits' => 1
		),
	);

}
