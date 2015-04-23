<?php
App::uses('Review', 'Model');

/**
 * Review Test Case
 *
 */
class ReviewTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.review',
		'app.restaurant',
		'app.domain',
		'app.menu',
		'app.coupon',
		'app.invoice',
		'app.order',
		'app.cuisine',
		'app.cuisines_restaurant',
		'app.location',
		'app.sector',
		'app.device',
		'app.device_order',
		'app.schedule',
		'app.feature',
		'app.features_location',
		'app.cuisines_location'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Review = ClassRegistry::init('Review');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Review);

		parent::tearDown();
	}

}
