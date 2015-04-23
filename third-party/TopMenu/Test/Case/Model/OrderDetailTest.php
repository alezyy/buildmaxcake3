<?php
App::uses('OrderDetail', 'Model');

/**
 * OrderDetail Test Case
 *
 */
class OrderDetailTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.order_detail',
		'app.order',
		'app.restaurant',
		'app.domain',
		'app.invoice',
		'app.menu',
		'app.review',
		'app.location',
		'app.sector',
		'app.device',
		'app.device_order',
		'app.schedule',
		'app.feature',
		'app.features_location',
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
		'app.menu_item'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->OrderDetail = ClassRegistry::init('OrderDetail');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->OrderDetail);

		parent::tearDown();
	}

}
