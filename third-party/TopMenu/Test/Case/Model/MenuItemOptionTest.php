<?php
App::uses('MenuItemOption', 'Model');

/**
 * MenuItemOption Test Case
 *
 */
class MenuItemOptionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.menu_item_option'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->MenuItemOption = ClassRegistry::init('MenuItemOption');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MenuItemOption);

		parent::tearDown();
	}

}
