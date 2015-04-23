<?php
App::uses('DeliveryArea', 'Model');

/**
 * DeliveryArea Test Case
 *
 */
class DeliveryAreaTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.delivery_area',
		'app.location',
		'app.sector',
		'app.coupon',
		'app.user',
		'app.group',
		'app.profile',
		'app.forgotten_password',
		'app.restaurant',
		'app.domain',
		'app.theme',
		'app.invoice',
		'app.order',
		'app.order_detail',
		'app.menu_item',
		'app.menu',
		'app.menu_item_group',
		'app.menu_item_option',
		'app.review_code',
		'app.review',
		'app.cuisine',
		'app.specialty',
		'app.cuisines_location',
		'app.cuisines_restaurant',
		'app.restaurants_user',
		'app.locations_user',
		'app.device_order',
		'app.device',
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
		$this->DeliveryArea = ClassRegistry::init('DeliveryArea');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DeliveryArea);

		parent::tearDown();
	}

}
