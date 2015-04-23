<?php
App::uses('Domain', 'Model');

/**
 * Domain Test Case
 *
 */
class DomainTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.domain',
		'app.restaurant',
		'app.invoice',
		'app.location',
		'app.sector',
		'app.coupon',
		'app.device_order',
		'app.device',
		'app.location_gallery',
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
		'app.phone_click',
		'app.rating',
		'app.review',
		'app.schedule',
		'app.cuisine',
		'app.cuisines_restaurant',
		'app.cuisines_location',
		'app.feature',
		'app.features_location',
		'app.theme'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Domain = ClassRegistry::init('Domain');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Domain);

		parent::tearDown();
	}

}
