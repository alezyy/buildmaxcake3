<?php

App::uses('Order', 'Model');

class OrderTest extends CakeTestCase {
    public $fixtures = array('app.order');

    public function setUp() {
        parent::setUp();        
        $this->Order = ClassRegistry::init('Order');
    }

    public function testUpdateCurrent() {
        $result = $this->Order->updateCurrent(
            array(
                0=> array(                                      // items
                    'id' => '52335c2d-bbc8-457a-9d7a-3465fe51d21f', 
                    'price' => 2.5,                                   
                    'quantity' => 2,                                
                    'name' => 'test item',
                    'options' => 'null'
                ),      
                1=> array(                                      // items
                    'id' => '52335c2d-bbc8-457a-9d7a-3465fe51d21f', 
                    'price' => 5,                                   
                    'quantity' => 1,                                
                    'name' => 'test item',
                    'options' => 'null'
                )),      
            10,                                                 // delivery charge
            '52335bb2-bbbc-414c-8263-3465fe51d21f',             // location's id
            '52387e1f-8418-4100-82ac-29cefe51d21f',             // user's id
            10,                                                 // just the tip
            array(                                           // tax array retrieve from theTax model
                array(
                    'name' => 'TPS',
                    'percent' => 5,
                    'compound' => 0),
                array(
                    'name' => 'TVQ',
                    'percent' => 9.975,
                    'compound' => 1)));     
        $order['subtotal'] = 0;             // total before taxes and tip	
        
        $expected = 33;

        $this->assertEquals($expected, $result);
    }
}
