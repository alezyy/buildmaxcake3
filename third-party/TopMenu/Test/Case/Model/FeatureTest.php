<?php
App::uses('Feature', 'Model');

/**
 * Feature Test Case
 *
 */
class FeatureTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.feature',
		'app.location',
		'app.sector',
		'app.coupon',
		'app.device_order',
		'app.device',
		'app.invoice',
		'app.restaurant',
		'app.domain',
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
		'app.features_location'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Feature = ClassRegistry::init('Feature');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Feature);

		parent::tearDown();
	}

}
