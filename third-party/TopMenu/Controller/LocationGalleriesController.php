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
 * LocationGalleries Controller
 *
 * @property LocationGallery $LocationGallery
 * @property PaginatorComponent $Paginator
 */
class LocationGalleriesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Image', 'UploadValidation', 'RequestHandler');

/**
 * Helpers
 * 
 * @var array
 */
	public $helpers = array('Image');
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(
            'view'
        );
    }

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index($location_id) {
		$this->LocationGallery->recursive = 0;
		$this->Paginator->settings = array(
			'conditions' => array(
				'LocationGallery.location_id' => $location_id
			)
		);
		$this->set(compact('location_id'));
		$this->set('locationGalleries', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($location_id, $id = null) {
		if (!$this->LocationGallery->exists($id)) {
			throw new NotFoundException(__('Invalid location gallery'));
		}
		$options = array(
			'conditions' => array(
				'LocationGallery.id'          => $id,
				'LocationGallery.location_id' => $location_id
			),
			'recursive' => 0
		);
		$this->set(compact('location_id'));
		$this->set('locationGallery', $this->LocationGallery->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add($location_id) {
		if ($this->request->is('post')) {
			$this->LocationGallery->create();
			$this->request->data['LocationGallery']['location_id'] = $location_id;

			$this->Image->process('image');
			$save = $this->UploadValidation->validate();

			if ($save && $this->LocationGallery->save($this->request->data)) {
				$this->Session->setFlash(
					__('The location gallery has been saved'),
					'default',
					array('class' => 'flash_success')
				);
				$this->Image->finishCreate(
					$this->request->data['LocationGallery']['image'],
					$this->LocationGallery->getLastInsertID()
				);
				return $this->redirect(array('action' => 'index', $location_id));
			} else {
				$this->Session->setFlash(__('The location gallery could not be saved. Please, try again.'));
				$this->Image->delete('image');
			}
		}
		$locations = $this->LocationGallery->Location->find('list');
		$this->set(compact('locations', 'location_id'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($location_id, $id = null) {
		$this->LocationGallery->id = $id;
		if (!$this->LocationGallery->exists()) {
			throw new NotFoundException(__('Invalid location gallery'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Image->process('image', array(
				'200x200'
			));
			$save = $this->UploadValidation->validate();
			if ($save && $this->LocationGallery->save($this->request->data)) {
				$this->Session->setFlash(
					__('The location gallery has been saved'),
					'default', 
					array('class' => 'flash_success')
				);
				return $this->redirect(array('action' => 'index', $location_id));
			} else {
				$this->Session->setFlash(__('The location gallery could not be saved. Please, try again.'));
			}
		} else {
			$options = array(
				'conditions' => array(
					'LocationGallery.id' => $id,
					'LocationGallery.location_id' => $location_id
				)
			);
			$this->request->data = $this->LocationGallery->find('first', $options);
		}
		$locations = $this->LocationGallery->Location->find('list');
		$this->set(compact('locations', 'location_id'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($location_id, $id = null) {
		$this->LocationGallery->id = $id;
		if (!$this->LocationGallery->exists()) {
			throw new NotFoundException(__('Invalid location gallery'));
		}
		$this->request->onlyAllow('post', 'delete');



		if ($this->LocationGallery->delete()) {
			$this->Session->setFlash(
				__('Location gallery deleted'),
				'default', 
				array('class' => 'flash_success')
			);
			return $this->redirect(array('action' => 'index', $location_id));
		}
		$this->Session->setFlash(__('Location gallery was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
    
    /**      
     * 
     * @param string $locationUrl url like id for the location
     */
    public function view($locationUrl){
        $this->loadModel('Location');
        $id = $this->Location->find('first', array(
            'conditions' => array('Location.url' => $locationUrl),
            'fields' => 'Location.id'
        ));
        $lg = $this->LocationGallery->find('all',array(
            'conditions' => array('LocationGallery.location_id' => $id['Location']['id'])));
        
        $this->set('gallery',  $lg);
        // render element for ajax request and view for non ajax request
        if ($this->RequestHandler->isAjax()) {
            $this->render(DS . 'LocationGalleries' . DS . 'view');
        } 
    }
}
