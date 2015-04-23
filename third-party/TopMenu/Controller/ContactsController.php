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

class ContactsController extends AppController
{
	public $name = 'Contacts';

	public function beforeFilter() {

		parent::beforeFilter();
		$this->Auth->allow('index', 'form', 'flyers');
	}
 
	public function index() {
		$this->set('title_for_layout', __('Contact Us'));
		if(!empty($this->request->data)) {
							
				$this->Contact->create($this->request->data);
 
			if(!$this->Contact->validates()) {
				$this->Session->setFlash(__('Please correct your input.'));
				$this->validateErrors($this->Contact);
			} else {
 
				$this->request->data['Contact']['message'] =  nl2br($this->request->data['Contact']['message']);
				
				// Envoi de l'email				
				$this->Contact->sendMail($this->request->data['Contact']);
 
				$this->redirect(array('action' => 'confirmation'));
			}
		}
	}
	public function form() {
		$this->set('title_for_layout', __('Contact Us'));
		if(!empty($this->request->data)) {
							
				$this->Contact->create($this->request->data);
 
			if(!$this->Contact->validates()) {
				$this->Session->setFlash(__('Please correct your input.'));
				$this->validateErrors($this->Contact);
			} else {
 
				$this->request->data['Contact']['message'] =  nl2br($this->request->data['Contact']['message']);
				
				// Envoi de l'email				
				$this->Contact->sendMail($this->request->data['Contact']);
 
				$this->redirect(array('action' => 'confirmation'));
			}
		}
	}
	public function flyers() {
		$this->set('title_for_layout', __('Issue with the flyers'));
		if(!empty($this->request->data)) {
							
				$this->Contact->create($this->request->data);
 
			if(!$this->Contact->validates()) {
				$this->Session->setFlash(__('Please correct your input.'));
				$this->validateErrors($this->Contact);
			} else {
 
				$this->request->data['Contact']['message'] =  nl2br($this->request->data['Contact']['message']);
				
				// Envoi de l'email				
				$this->Contact->sendMail($this->request->data['Contact']);
 
				$this->redirect(array('action' => 'confirmation'));
			}
		}
	}
	
	public function did_not_receive_print(){
		
		if(!empty($this->request->data)) {
			
				// Envoi de l'email
				$this->Contact->sendMailProd($this->request->data); 
				$this->redirect(array('action' => 'confirmation'));											
		}else{
			$this->redirect(array('action' => 'index'));
		}
		
	}
 
	// Page de remerciement
	public function confirmation() {}
}