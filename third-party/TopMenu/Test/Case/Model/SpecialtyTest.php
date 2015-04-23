<?php
App::uses('Specialty', 'Model');

/**
 * Specialty Test Case
 *
 */
class SpecialtyTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.specialty',
		'app.cuisine',
		'app.restaurant',
		'app.domain',
		'app.menu',
		'app.coupon',
		'app.invoice',
		'app.order',
		'app.review',
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
		$this->Specialty = ClassRegistry::init('Specialty');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Specialty);

		parent::tearDown();
	}

}
