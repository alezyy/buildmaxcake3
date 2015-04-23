<?php
App::uses('MenuItem', 'Model');

/**
 * MenuItem Test Case
 *
 */
class MenuItemTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.menu_item',
		'app.menu',
		'app.location',
		'app.sector',
		'app.restaurant',
		'app.domain',
		'app.invoice',
		'app.order',
		'app.user',
		'app.group',
		'app.profile',
		'app.forgotten_password',
		'app.restaurants_user',
		'app.locations_user',
		'app.order_detail',
		'app.review_code',
		'app.review',
		'app.cuisine',
		'app.cuisines_restaurant',
		'app.cuisines_location',
		'app.device',
		'app.device_order',
		'app.schedule',
		'app.feature',
		'app.features_location',
		'app.item_group',
		'app.menu_item_option',
		'app.menu_item_group'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MenuItem = ClassRegistry::init('MenuItem');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MenuItem);

		parent::tearDown();
	}

}
