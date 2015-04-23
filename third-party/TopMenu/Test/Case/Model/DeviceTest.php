<?php
App::uses('Device', 'Model');

/**
 * Device Test Case
 *
 */
class DeviceTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.device',
		'app.location',
		'app.sector',
		'app.coupon',
		'app.device_order',
		'app.invoice',
		'app.restaurant',
		'app.domain',
		'app.theme',
		'app.menu',
		'app.item_group',
		'app.menu_item_option',
		'app.menu_item',
		'app.menu_item_group',
		'app.order_detail',
		'app.order',
		'app.user',
		'app.group',
		'app.profile',
		'app.forgotten_password',
		'app.restaurants_user',
		'app.locations_user',
		'app.review_code',
		'app.review',
		'app.cuisine',
		'app.cuisines_restaurant',
		'app.cuisines_location',
		'app.location_gallery',
		'app.phone_click',
		'app.rating',
		'app.schedule',
		'app.feature',
		'app.features_location'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Device = ClassRegistry::init('Device');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Device);

		parent::tearDown();
	}

}
