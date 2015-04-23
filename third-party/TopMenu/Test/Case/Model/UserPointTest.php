<?php
App::uses('UserPoint', 'Model');

/**
 * UserPoint Test Case
 *
 */
class UserPointTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.user_point',
		'app.user',
		'app.group',
		'app.profile',
		'app.forgotten_password',
		'app.restaurant',
		'app.domain',
		'app.menu',
		'app.coupon',
		'app.invoice',
		'app.order',
		'app.review',
		'app.cuisine',
		'app.cuisines_restaurant',
		'app.location',
		'app.sector',
		'app.device',
		'app.device_order',
		'app.schedule',
		'app.feature',
		'app.features_location',
		'app.cuisines_location',
		'app.restaurants_user',
		'app.locations_user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UserPoint = ClassRegistry::init('UserPoint');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UserPoint);

		parent::tearDown();
	}

}
