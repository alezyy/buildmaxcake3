<?php
App::uses('PhoneClick', 'Model');

/**
 * PhoneClick Test Case
 *
 */
class PhoneClickTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.phone_click',
		'app.location',
		'app.sector',
		'app.restaurant',
		'app.domain',
		'app.invoice',
		'app.menu',
		'app.order',
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
		'app.device',
		'app.device_order',
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
		$this->PhoneClick = ClassRegistry::init('PhoneClick');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PhoneClick);

		parent::tearDown();
	}

}
