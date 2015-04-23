<?php

App::uses('Controller', 'Controller');
App::uses('ComponentCollection', 'Controller');
App::uses('LanguageSuffixComponent', 'Controller/Component');

// A fake controller to test against
class TestPagematronController extends Controller {

	public $paginate = null;

}

/**
 * Description of LanguageSuffixeComponentTest
 *
 * @author Pec
 */
class LanguageSuffixComponentTest extends CakeTestCase {

	public $PagematronComponent = null;
	public $Controller = null;

	public function setUp() {
		parent::setUp();
		// Setup our component and fake test controller
		$Collection = new ComponentCollection();
		$this->LanguageSuffixComponent = new LanguageSuffixComponent($Collection);
		$CakeRequest = new CakeRequest();
		$CakeResponse = new CakeResponse();
		$this->Controller = new TestPagematronController($CakeRequest, $CakeResponse);
	}

	public function testswitchArrayValues() {

		

			$array =  array(
				'Search' => array(
					'Second' => array('test', 'deux_en', 'trois'),
					'thrid' => array('test2', 'deux2', 'trois2'),
					'0' => 'Location.name',
					'1' => 'Location.id',
					'2' => 'Location.url',
					'3' => 'Location.logo',
					'4' => 'Location.building_number',
					'5' => 'Location.street',
					'6' => 'Location.postal_code',
					'7' => 'Location.location',
					'8' => 'Location.latitude',
					'9' => 'Location.longitude',
					'10' => 'Location.description_en',
					'11' => 'Cuisine.name_en',
					'12' => 'DeliveryArea.postal_code',
					'13' => 'DeliveryArea.delivery_charge',
					'14' => 'DeliveryArea.featured'), 
				'Search2' => array('test', 'aksjdfl'));

		$expected = array(
				'Search' =>
					array(
						'Second' => 
							array(
								'test', 
								'deux_fr', 
								'trois'),
						'thrid' => 
							array(
								'test2', 
								'deux2', 
								'trois2'),
					'0' => 'Location.name',
					'1' => 'Location.id',
					'2' => 'Location.url',
					'3' => 'Location.logo',
					'4' => 'Location.building_number',
					'5' => 'Location.street',
					'6' => 'Location.postal_code',
					'7' => 'Location.location',
					'8' => 'Location.latitude',
					'9' => 'Location.longitude',
					'10' => 'Location.description_fr',
					'11' => 'Cuisine.name_fr',
					'12' => 'DeliveryArea.postal_code',
					'13' => 'DeliveryArea.delivery_charge',
					'14' => 'DeliveryArea.featured'), 
				'Search2' => array('test', 'aksjdfl'));
		$result = $this->LanguageSuffixComponent->switchArrayValues($array, 'fr');
//		print_r($result);
		$this->assertEquals($expected, $result);
	}


}

?>
