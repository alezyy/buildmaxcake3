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
 * Sectors Controller
 *
 * @property Sector $Sector
 * @property PaginatorComponent $Paginator
 */
class SectorsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Image', 'UploadValidation');

/**
 * Helpers
 * 
 * @var array
 */
	public $helpers = array('Image');

/**
 * beforeFilter
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(
			'find', 'view'
		);
	}


/**
 * Finds restaurants by sector
 * @param  string $sector 
 * @return [type]        
 */
    public function find($sector = 'all') {
        $restaurantsList = $this->Sector->find(
        	'all',
        	array(
        		'conditions' => array('Sector.url' => $sector)
        	)
        );
        $this->set('restaurantList', $restaurantsList);
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Sector->recursive = 0;
        $query                   = null;
        if ($this->request->is('post')) {
            if (isset($this->request->data['Query']['search'])) {
                $this->Session->write('sector.query', $this->request->data['Query']['search']);
            }
        }
        if ($this->Session->read('sector.query')) {
            $query                                  = $this->Session->read('sector.query');
            $this->request->data['Query']['search'] = $query;

            $conditions = array(
                'OR' => array(
                    'Sector.name_en LIKE' => '%' . $query . '%',
                    'Sector.name_fr LIKE' => '%' . $query . '%',
                    'Sector.code LIKE'    => '%' . $query . '%',
                    'Sector.url LIKE'     => '%' . $query . '%'
                )
            );

            $this->Paginator->settings = array(
                'conditions' => $conditions
            );
        }

        $this->set('sectors', $this->Paginator->paginate());
    }

    /**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Sector->exists($id)) {
			throw new NotFoundException(__('Invalid sector'));
		}
		$options = array('conditions' => array('Sector.' . $this->Sector->primaryKey => $id));
		$this->set('sector', $this->Sector->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Sector->create();
			$this->Image->process('image');

			$save = $this->UploadValidation->validate();

			if ($save && $this->Sector->save($this->request->data)) {
				$this->Session->setFlash(__('The sector has been saved'), 'default', array('class' => 'flash_success'));
			} else {
				$this->Session->setFlash(__('The sector could not be saved. Please, try again.'));
				$this->Image->delete('image');
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Sector->exists($id)) {
			throw new NotFoundException(__('Invalid sector'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Image->process('image');

			$save = $this->UploadValidation->validate();

			if ($save && $this->Sector->save($this->request->data)) {
				$this->Session->setFlash(__('The sector has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The sector could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Sector.' . $this->Sector->primaryKey => $id));
			$this->request->data = $this->Sector->find('first', $options);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Sector->id = $id;
		if (!$this->Sector->exists()) {
			throw new NotFoundException(__('Invalid sector'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Sector->delete()) {
			$this->Session->setFlash(__('Sector deleted'), 'default', array('class' => 'flash_success'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Sector was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
    
    /**
     * List, as links to the search page for this sector, all the sectors
     * 
     * @param string $start Show all Sectors starting with this letter and all the following letter in the alphabet
     * @param string $end Stop showing sectors starting with this letter or starting with any other letter coming after (alphabetically) this one
     */
    public function view($start = 'A', $end = 'Z'){
         $this->Sector->recursive = 0;
        $results = $this->Sector->find('all', array(
            'fields' => array('name', 'url', 'code'),
            'conditions' => array(
                'Sector.name BETWEEN ? AND ?' => array($start, $end))));
        
       if (!empty($this->request->params['requested'])) {
		   return $results;
		}

        $this->set('sectors', $results);
    }
}
