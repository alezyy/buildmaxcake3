<?php
App::uses('SlideshowImage', 'Model');

/**
 * SlideshowImage Test Case
 *
 */
class SlideshowImageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.slideshow_image'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SlideshowImage = ClassRegistry::init('SlideshowImage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SlideshowImage);

		parent::tearDown();
	}

}
