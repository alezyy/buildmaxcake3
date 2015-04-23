<?php
/**
 *   _____                                                                       
 *  /__   \  ___   _ __     /\/\    ___  _ __   _   _      ___   ___   _ __ ___  
 *    / /\/ / _ \ | '_ \   /    \  / _ \| '_ \ | | | |    / __| / _ \ | '_ ` _ \ 
 *   / /   | (_) || |_) | / /\/\ \|  __/| | | || |_| | _ | (__ | (_) || | | | | |
 *   \/     \___/ | .__/  \/    \/ \___||_| |_| \__,_|(_) \___| \___/ |_| |_| |_|
 *                |_|                                                                                           
 *               
 * @copyright     Copyright (c) Top Menu Web, Inc. (https://www.topmenu.com) & Respective Owners
 * @link          https://www.topmenu.com/ Top Menu Web Inc.
 * @version       2
 *                                                                   
 */


App::uses('AppController', 'Controller');

/**
 * Restaurants Controller
 *
 * @property Restaurant $Restaurant
 * @property PaginatorComponent $Paginator
 */
class RestaurantsController extends AppController {



    public $helpers = array('Image');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(
			'add_restaurant_confirmation',
			'add_restaurant'));
        
    }

	/**
	* addRestaurant
	*/
	   public function add_restaurant() {
		   if(!empty($this->request->data)) {
			   $this->Restaurant->create($this->request->data);
			   if(!$this->Restaurant->validates()) {
				   $this->Session->setFlash('Please correct the errors in red.');
				   $this->validateErrors($this->Restaurant);
			   } else {
	
				   
				   $result = $this->Restaurant->sendEmail(
					   array('address' => 'contact@topmenu.com', 'name' => 'contact@topmenu.com'),
					   'Requête d\'ajout de restaurant',
					   $this->request->data['Restaurant'],
					   array('template' => 'add_restaurant_request'));					   
				   
				   
				   if($result){
						$this->redirect(array('controller'=> 'restaurants', 'action' => 'add_restaurant_confirmation'));
				   }
				   
				   $this->Session->setFlash(__('Sorry, email was not sent'));
			   }
		   }
	   }
	   
	   
	   public function add_restaurant_confirmation(){
		   
	   }
}

