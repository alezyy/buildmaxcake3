<?php
App::uses('Schedule', 'Model');

/**
 * Schedule Test Case
 *
 */
class ScheduleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.schedule',
		'app.location',
		'app.sector',
		'app.restaurant',
		'app.domain',
		'app.menu',
		'app.coupon',
		'app.invoice',
		'app.order',
		'app.review',
		'app.cuisine',
		'app.cuisines_restaurant',
		'app.cuisines_location',
		'app.device',
		'app.device_order',
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
		$this->Schedule = ClassRegistry::init('Schedule');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Schedule);

		parent::tearDown();
	}

}
