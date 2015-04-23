<?php
App::uses('BlogCategory', 'Model');

/**
 * BlogCategory Test Case
 *
 */
class BlogCategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.blog_category',
		'app.article'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BlogCategory = ClassRegistry::init('BlogCategory');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BlogCategory);

		parent::tearDown();
	}

}
