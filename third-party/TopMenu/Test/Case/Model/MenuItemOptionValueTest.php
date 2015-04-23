<?php
App::uses('MenuItemOptionValue', 'Model');

/**
 * MenuItemOptionValue Test Case
 *
 */
class MenuItemOptionValueTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.menu_item_option_value',
		'app.menu_item_option',
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
		'app.menu_item',
		'app.menu_item_group',
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
		'app.item_group'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MenuItemOptionValue = ClassRegistry::init('MenuItemOptionValue');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MenuItemOptionValue);

		parent::tearDown();
	}

}
