<?php
App::uses('ReviewCode', 'Model');

/**
 * ReviewCode Test Case
 *
 */
class ReviewCodeTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.review_code',
		'app.order'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->ReviewCode = ClassRegistry::init('ReviewCode');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ReviewCode);

		parent::tearDown();
	}

}
