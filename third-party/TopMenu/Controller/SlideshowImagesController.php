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
 * SlideshowImages Controller
 *
 * @property SlideshowImage $SlideshowImage
 * @property PaginatorComponent $Paginator
 */
class SlideshowImagesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Image', 'UploadValidation');

	public $helpers = array('Image');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->SlideshowImage->recursive = 0;
		$query = null;
        if ($this->request->is('post')) {
            if (isset($this->request->data['Query']['search'])) {
                $this->Session->write('slideshowimage.query', $this->request->data['Query']['search']);
            }
        }
        if ($this->Session->read('slideshowimage.query')) {
            $query = $this->Session->read('slideshowimage.query');
            $this->request->data['Query']['search'] = $query;
        }
        $conditions = array(
            'OR' => array(
				'SlideshowImage.name_en LIKE' => '%' . $query . '%',
				'SlideshowImage.name_fr LIKE' => '%' . $query . '%',
            )
        );

        $this->Paginator->settings = array(
            'conditions' => $conditions
        );

        $this->SlideshowImage->order = array('SlideshowImage.name_en' => 'ASC');
		$this->set('slideshowImages', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->SlideshowImage->exists($id)) {
			throw new NotFoundException(__('Invalid slideshow image'));
		}
		$options = array('conditions' => array('SlideshowImage.' . $this->SlideshowImage->primaryKey => $id));
		$this->set('slideshowImage', $this->SlideshowImage->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->SlideshowImage->create();
			$this->Image->process('image_fr');
			$this->Image->process('image_en');
			$save = $this->UploadValidation->validate();

			if ($save && $this->SlideshowImage->save($this->request->data)) {
				$this->Session->setFlash(
					__('The slideshow image has been saved'),
					'default',
					array('class' => 'flash_success')
				);
				$this->Image->finishCreate(
					$this->request->data['SlideshowImage']['image_fr'],
					$this->SlideshowImage->getLastInsertID()
				);
				$this->Image->finishCreate(
					$this->request->data['SlideshowImage']['image_en'],
					$this->SlideshowImage->getLastInsertID()
				);

				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The slideshow image could not be saved. Please, try again.'));
				$this->Image->delete('image_fr');
				$this->Image->delete('image_en');
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
		if (!$this->SlideshowImage->exists($id)) {
			throw new NotFoundException(__('Invalid slideshow image'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Image->process('image_fr');
			$this->Image->process('image_en');
			$save = $this->UploadValidation->validate();

			if ($save && $this->SlideshowImage->save($this->request->data)) {
				$this->Session->setFlash(__('The slideshow image has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The slideshow image could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('SlideshowImage.' . $this->SlideshowImage->primaryKey => $id));
			$this->request->data = $this->SlideshowImage->find('first', $options);
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
		$this->SlideshowImage->id = $id;
		if (!$this->SlideshowImage->exists()) {
			throw new NotFoundException(__('Invalid slideshow image'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->SlideshowImage->delete()) {
			$this->Session->setFlash(__('Slideshow image deleted'), 'default', array('class' => 'flash_success'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Slideshow image was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
}
