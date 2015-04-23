<?php
App::uses('Contest', 'Model');

/**
 * Contest Test Case
 *
 */
class ContestTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.contest'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Contest = ClassRegistry::init('Contest');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Contest);

		parent::tearDown();
	}

}
