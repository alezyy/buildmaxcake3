<?php
App::uses('LocationRedirect', 'Model');

/**
 * LocationRedirect Test Case
 *
 */
class LocationRedirectTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.location_redirect',
		'app.location',
		'app.coupon',
		'app.user',
		'app.group',
		'app.profile',
		'app.forgotten_password',
		'app.delivery_addresses',
		'app.order',
		'app.order_detail',
		'app.menu_item',
		'app.menu',
		'app.menu_category',
		'app.menu_item_option',
		'app.menu_item_option_value',
		'app.menu_item_options_menu_item',
		'app.device_order',
		'app.review_code',
		'app.locations_user',
		'app.device',
		'app.delivery_area',
		'app.invoice',
		'app.restaurant',
		'app.domain',
		'app.theme',
		'app.review',
		'app.cuisine',
		'app.specialty',
		'app.restaurants_specialty',
		'app.locations_specialty',
		'app.cuisines_location',
		'app.cuisines_restaurant',
		'app.restaurants_user',
		'app.location_gallery',
		'app.phone_click',
		'app.rating',
		'app.schedule',
		'app.street_address',
		'app.feature',
		'app.features_location',
		'app.sector',
		'app.locations_sector'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->LocationRedirect = ClassRegistry::init('LocationRedirect');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->LocationRedirect);

		parent::tearDown();
	}

}
