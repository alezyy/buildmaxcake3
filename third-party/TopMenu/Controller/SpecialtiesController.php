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
 * Specialties Controller
 *
 * @property Specialty $Specialty
 * @property PaginatorComponent $Paginator
 */
class SpecialtiesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Image', 'UploadValidation');

/**
 * Helpers
 * @var array
 */
	public $helpers = array('Image');


	public function beforeFilter() {
		parent::beforeFilter();
		switch ($this->request->action){
			case 'admin_add':
			case 'admin_edit':
	           $this->Security->validatePost = false;
	        break;
        }
	}


/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Specialty->recursive = 0;
		$this->Specialty->recursive = 0;
		$query = null;
        if ($this->request->is('post')) {
            if (isset($this->request->data['Query']['search'])) {
                $this->Session->write('specialty.query', $this->request->data['Query']['search']);
            }
        }
        if ($this->Session->read('specialty.query')) {
            $query = $this->Session->read('specialty.query');
            $this->request->data['Query']['search'] = $query;
        }
        $conditions = array(
            'OR' => array(
				'Specialty.name_en LIKE' => '%' . $query . '%',
				'Specialty.name_fr LIKE' => '%' . $query . '%',
				'Specialty.url LIKE'      => '%' . $query . '%'
            )
        );

        $this->Paginator->settings = array(
            'conditions' => $conditions
        );
		$this->set('specialties', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Specialty->exists($id)) {
			throw new NotFoundException(__('Invalid specialty'));
		}
		$options = array('conditions' => array('Specialty.' . $this->Specialty->primaryKey => $id));
		$this->set('specialty', $this->Specialty->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Specialty->create();

			$this->Image->process('image');

			$save = $this->UploadValidation->validate();

			if ($save && $this->Specialty->save($this->request->data)) {
				$this->Session->setFlash(
					__('The specialty has been saved'),
					'default',
					array('class' => 'flash_success')
				);

				$this->Image->finishAdd(
					$this->request->data['Specialty']['image'],
					$this->Specialty->getLastInsertID()
				);
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The specialty could not be saved. Please, try again.'));
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
		if (!$this->Specialty->exists($id)) {
			throw new NotFoundException(__('Invalid specialty'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {

			$this->Image->process('image');

			$save = $this->UploadValidation->validate();


			if ($save && $this->Specialty->save($this->request->data)) {
				$this->Session->setFlash(__('The specialty has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The specialty could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Specialty.' . $this->Specialty->primaryKey => $id));
			$this->request->data = $this->Specialty->find('first', $options);
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
		$this->Specialty->id = $id;
		if (!$this->Specialty->exists()) {
			throw new NotFoundException(__('Invalid specialty'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Specialty->delete()) {
			$this->Session->setFlash(__('Specialty deleted'), 'default', array('class' => 'flash_success'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Specialty was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
}
