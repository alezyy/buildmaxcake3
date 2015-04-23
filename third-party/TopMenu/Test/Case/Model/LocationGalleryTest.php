<?php
App::uses('LocationGallery', 'Model');

/**
 * LocationGallery Test Case
 *
 */
class LocationGalleryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.location_gallery',
		'app.location',
		'app.sector',
		'app.coupon',
		'app.device_order',
		'app.device',
		'app.invoice',
		'app.menu',
		'app.item_group',
		'app.menu_item_option',
		'app.menu_item',
		'app.menu_item_group',
		'app.order_detail',
		'app.order',
		'app.restaurant',
		'app.domain',
		'app.review',
		'app.cuisine',
		'app.cuisines_restaurant',
		'app.cuisines_location',
		'app.user',
		'app.group',
		'app.profile',
		'app.forgotten_password',
		'app.restaurants_user',
		'app.locations_user',
		'app.review_code',
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
		$this->LocationGallery = ClassRegistry::init('LocationGallery');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LocationGallery);

		parent::tearDown();
	}

}
