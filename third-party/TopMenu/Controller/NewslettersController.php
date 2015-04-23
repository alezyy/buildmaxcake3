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
 * Newsletters Controller
 *
 * @property Newsletter $Newsletter
 * @property PaginatorComponent $Paginator
 */
class NewslettersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Newsletter->recursive = 0;
		$this->set('newsletters', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Newsletter->exists($id)) {
			throw new NotFoundException(__('Invalid newsletter'));
		}
		$options = array('conditions' => array('Newsletter.' . $this->Newsletter->primaryKey => $id));
		$this->set('newsletter', $this->Newsletter->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Newsletter->create();
			if ($this->Newsletter->save($this->request->data)) {
				$this->Session->setFlash(__('The newsletter has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The newsletter could not be saved. Please, try again.'));
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
		if (!$this->Newsletter->exists($id)) {
			throw new NotFoundException(__('Invalid newsletter'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Newsletter->save($this->request->data)) {
				$this->Session->setFlash(__('The newsletter has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The newsletter could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Newsletter.' . $this->Newsletter->primaryKey => $id));
			$this->request->data = $this->Newsletter->find('first', $options);
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
		$this->Newsletter->id = $id;
		if (!$this->Newsletter->exists()) {
			throw new NotFoundException(__('Invalid newsletter'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Newsletter->delete()) {
			$this->Session->setFlash(__('Newsletter deleted'), 'default', array('class' => 'flash_success'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Newsletter was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
}
