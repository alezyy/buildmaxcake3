<?php
App::uses('DeliveryAddress', 'Model');

/**
 * DeliveryAddress Test Case
 *
 */
class DeliveryAddressTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.delivery_address',
		'app.user',
		'app.group',
		'app.profile',
		'app.forgotten_password',
		'app.restaurant',
		'app.domain',
		'app.theme',
		'app.invoice',
		'app.location',
		'app.sector',
		'app.coupon',
		'app.device_order',
		'app.order',
		'app.order_detail',
		'app.menu_item',
		'app.menu',
		'app.item_group',
		'app.menu_item_option',
		'app.menu_item_group',
		'app.review_code',
		'app.device',
		'app.location_gallery',
		'app.phone_click',
		'app.rating',
		'app.review',
		'app.schedule',
		'app.cuisine',
		'app.cuisines_restaurant',
		'app.cuisines_location',
		'app.feature',
		'app.features_location',
		'app.locations_user',
		'app.restaurants_user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->DeliveryAddress = ClassRegistry::init('DeliveryAddress');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DeliveryAddress);

		parent::tearDown();
	}

}
