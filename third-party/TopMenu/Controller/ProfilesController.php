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
 * @version 	  2
 *                                                                   
 */
App::uses('AppController', 'Controller');

/**
 * Profiles Controller
 *
 * @property Profile $Profile
 */
class ProfilesController extends AppController {

	public $uses = array(
		'User',
		'Profile',
		'Country',
		'Order',
		'Province',
		'Country',
		'City');
    
    public $actAs = array('Containable');

	public function beforeFilter() {
		parent::beforeFilter();
		switch ($this->request->action) {
			case 'edit':				
				$this->Security->validatePost = FALSE;
				$this->Security->csrfUseOnce = FALSE;
				break;
		}
	}

	/**
	 * components
	 *
	 * @var mixed
	 * @access public
	 */
	public $components = array(
		'Image',
		'UploadValidation',
		'AjaxForm'
	);

	/**
	 * helpers
	 *
	 * @var mixed
	 * @access public
	 */
	public $helpers = array('Image');

	/**
	 * view method
	 *
	 * @param string $id
	 * @return void
	 */
	public function index() {
		$this->view = 'view';
		$this->set('title_for_layout', __(' My Account'));
		$this->Profile->recursive = -1;
		$this->Profile->id = $this->Auth->user('id');
		$this->set('profile', $this->Profile->read());
	}

	/**
	 * edit method
	 *
	 * @param string $id
	 * @return void
	 */
	public function edit() {
		// retrieve current user            
		$id = $this->Auth->user('id');
		$this->Profile->id = $id;
		$this->Profile->recursive = 0;

		$this->set('title_for_layout', __(' Update My Profile'));

		// Handle form submission
		if ($this->request->is('post') || $this->request->is('put')) {
			$save = false;  // submission is valid flag
			//
			// Process uploaded images

			$this->Image->process('image');
			$save = $this->UploadValidation->validate();


			// Change password?
			if (empty($this->request->data['User']['password'])) {
				unset($this->request->data['User']['password']);
				unset($this->request->data['User']['password_confirm']);
			}
			$this->request->data['User']['id'] = $id;

			// Process data submission
			$saved = false;
			if ($save && $this->Profile->save($this->request->data)) {
				if ($this->Profile->saveAll($this->request->data)) {
					// I really don't like this double save going on here, but for the moment I
					// can't think of a better way to get the image processing working when dealing
					// with associated data. saveAll doesn't work with the image uploading.
					
					// update session 
					$this->Profile->id = $id; // update model data
					$this->_updateSession();
					$saved = true;
				}
			}
			
			if ($this->request->is('ajax')) {
				
				// Ajax form 
				Configure::write('debug', 0);
				$this->layout = 'ajax';				
				
				if($saved) {				
					
					// Save data
					$message = __('Your data was saved');
					$this->set('response', TRUE);
				}else{
					
					// Output validation errors
					$message = __('Your data could not be saved. Please, try again.');		
					$response = array_merge(
							$this->AjaxForm->validationErrors('Profile', $this->Profile->validationErrors),
							$this->AjaxForm->validationErrors('User', $this->User->validationErrors));
					$this->set('response', json_encode($response));
				}
				
				$this->render('json/edit');
				
			} else {
				switch ($saved) {
					case true:
						$this->Session->setFlash(__('Your data was saved'), 'default', array('class' => 'flash_success'));
						break;
					default:
						$this->Session->setFlash(__('Your data could not be saved. Please, try again.'));
						break;
				}
			}
		} else {
			$this->request->data = $this->Profile->find(
					'first', array(
				'conditions' => array(
					'Profile.id' => $id
				)
					)
			);
		}
		// Get array of province, countries and cities
		$province = $this->Province->get_provinces(Configure::read('I18N.COUNTRY_CODE_2'), $this->langSuffix);
		$country = $this->Country->get_countries();
		$city = $this->City->getCities('Quebec');

		$this->set(compact('city', 'country', 'province'));
	}
	
	private function _updateSession(){
	
		try {
			$this->Session->write('Auth.Profile.name', $this->Profile->field('name'));
			$this->Session->write('Auth.Profile.first_name', $this->Profile->field('first_name'));
			$this->Session->write('Auth.Profile.last_name', $this->Profile->field('last_name'));
			$dateObirth = strtotime($this->Profile->field('date_of_birth'));
			$this->Session->write('Auth.Profile.date_of_birth.year', date('Y', $dateObirth));
			$this->Session->write('Auth.Profile.date_of_birth.month', date('m', $dateObirth));
			$this->Session->write('Auth.Profile.date_of_birth.day', date('d', $dateObirth));
		} catch (Exception $exc) {
			return false;
		}
	}
    
    /**
     * Returns a json object of the email, name and first name of user in the primary gold of populating autocomplete
     * input box
     */
    public function autoCompleteUserBox(){
//        $this->autoRender = false;
//        $this->layout = 'ajax';
                     
        debug($this->Profile->find('all', array(
            'contain' => 'User')));
        
        

//        echo json_encode($this->Profile->find('all', array(
//        echo print_r($this->Profile->find('all', array(
//            'fields' => array('Profile.id', 'Profile.first_name', 'Profile.last_name'),
//            'contains' => array('User.email'))));
//        
//        echo "</pre>";
    }
}
