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
 * Cuisines Controller
 *
 * @property Cuisine $Cuisine
 * @property PaginatorComponent $Paginator
 */
class CuisinesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public $paginate = array(
        'limit' => 20,
    );
/**
 * beforeFilter
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow(
			'find', 'view', 'search'
		);
	}
 
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Cuisine->recursive = 0;
		$this->set('cuisines', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Cuisine->exists($id)) {
			throw new NotFoundException(__('Invalid cuisine'));
		}
		$options = array('conditions' => array('Cuisine.' . $this->Cuisine->primaryKey => $id));
		$this->set('cuisine', $this->Cuisine->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Cuisine->create();
			if ($this->Cuisine->save($this->request->data)) {
				$this->Session->setFlash(__('The cuisine has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cuisine could not be saved. Please, try again.'));
			}
		}
		$locations = $this->Cuisine->Location->find('list');
		$this->set(compact('locations'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Cuisine->exists($id)) {
			throw new NotFoundException(__('Invalid cuisine'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Cuisine->save($this->request->data)) {
				$this->Session->setFlash(__('The cuisine has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The cuisine could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Cuisine.' . $this->Cuisine->primaryKey => $id));
			$this->request->data = $this->Cuisine->find('first', $options);
		}
		$locations = $this->Cuisine->Location->find('list');
		$this->set(compact('locations'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Cuisine->id = $id;
		if (!$this->Cuisine->exists()) {
			throw new NotFoundException(__('Invalid cuisine'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Cuisine->delete()) {
			$this->Session->setFlash(__('Cuisine deleted'), 'default', array('class' => 'flash_success'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Cuisine was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
	
    /**
     * List as link to the search page all the cuisines type available on the site
     * @param string $start Show all Sectors starting with this letter and all the following letter in the alphabet
     * @param string $end Stop showing sectors starting with this letter or starting with any other letter coming after (alphabetically) this one
     */
    public function view(){
        $this->Cuisine->recursive = 0;
        $langSuffix = $this->langSuffix;
        $cuisines = $this->Cuisine->find('all');
        
        if (!empty($this->request->params['requested'])) {
		   return $cuisines;
		}
        $this->set(compact('cuisines', 'langSuffix'));
        $this->set('title_for_layout', __('All Cuisines types'));
    }

    /**
     * List all the locations that offer a particular cuisine
     * @param string $cuisineTypes is the name of the cuisine type
     */
    public function search(){
    	$cuisineType = $this->params['cuisine'];
    	$this->Cuisine->recursive = 1;
    	$langSuffix = $this->langSuffix;
    	
    	// Get all locations offering cuisine type = $cuisineTypes
    	$locations = $this->Cuisine->find('first', array(
	        'conditions' => array('Cuisine.url' => $cuisineType),
	        'fields' => array('Cuisine.url', 'Cuisine.name_'.$langSuffix),
	    ));

        $this->Cuisine->recursive = -1;
        $cuisines = $this->Cuisine->find('all', array(
			'order'=>array('Cuisine.name_'.$langSuffix.' ASC')
		));

        if(!empty($locations)){
        	$this->set('locations', $locations['Location']);
        }
        $this->set('cuisines', $cuisines);
        $this->set('cuisineName', $locations['Cuisine']['name_'.$langSuffix]);
        $this->set('title_for_layout', __('Restaurants offering '). $locations['Cuisine']['name_'.$langSuffix]);
    }

}
