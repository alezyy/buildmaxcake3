<?php
App::uses('Cuisine', 'Model');

/**
 * Cuisine Test Case
 *
 */
class CuisineTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cuisine',
		'app.specialty',
		'app.restaurant',
		'app.domain',
		'app.theme',
		'app.invoice',
		'app.location',
		'app.sector',
		'app.coupon',
		'app.user',
		'app.group',
		'app.profile',
		'app.forgotten_password',
		'app.delivery_addresses',
		'app.restaurants_user',
		'app.locations_user',
		'app.device_order',
		'app.order',
		'app.order_detail',
		'app.menu_item',
		'app.menu',
		'app.menu_item_group',
		'app.menu_item_option',
		'app.review_code',
		'app.device',
		'app.delivery_area',
		'app.location_gallery',
		'app.phone_click',
		'app.rating',
		'app.review',
		'app.schedule',
		'app.cuisines_location',
		'app.feature',
		'app.features_location',
		'app.locations_specialty',
		'app.cuisines_restaurant',
		'app.restaurants_specialty'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Cuisine = ClassRegistry::init('Cuisine');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Cuisine);

		parent::tearDown();
	}

/**
 * testGetCuisineList method
 *
 * @return void
 */
	public function testGetCuisineList() {
	}

/**
 * testGetCuisineCount method
 *
 * @return void
 */
	public function testGetCuisineCount() {
	}

}
