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
 * Schedules Controller
 *
 * @property Schedule $Schedule
 * @property PaginatorComponent $Paginator
 */
class SchedulesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');


	public $helpers = array('Day');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index($location_id) {
		$this->Schedule->recursive = 0;
		$this->Paginator->settings = array(
			'conditions' => array(
				'Schedule.location_id' => $location_id
			)
		);
		$this->Schedule->order = array('Schedule.day' => 'ASC');
		$this->set(compact('location_id'));
		$this->set('schedules', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($location_id, $id) {
		if (!$this->Schedule->exists($id)) {
			throw new NotFoundException(__('Invalid schedule'));
		}
		$this->Schedule->recursive = 0;
		$options = array(
			'conditions' => array(
				'Schedule.id'          => $id,
				'Schedule.location_id' => $location_id
			)
		);
		$this->set('schedule', $this->Schedule->find('first', $options));
		$this->set(compact('location_id'));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add($location_id) {
		if ($this->request->is('post')) {
			$this->Schedule->create();
			$this->request->data['Schedule']['location_id'] = $location_id;
			if ($this->Schedule->save($this->request->data)) {
				$this->Session->setFlash(__('The schedule has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index', $location_id));
			} else {
				$this->Session->setFlash(__('The schedule could not be saved. Please, try again.'));
			}
		}

		$this->set(compact('location_id'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($location_id, $id = null) {

		if (!$this->Schedule->exists($id)) {
			throw new NotFoundException(__('Invalid schedule'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Schedule->save($this->request->data)) {
				$this->Session->setFlash(__('The schedule has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index', $location_id));
			} else {
				$this->Session->setFlash(__('The schedule could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Schedule.' . $this->Schedule->primaryKey => $id));
			$this->request->data = $this->Schedule->find('first', $options);
		}

		$this->set(compact('location_id'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($location_id, $id = null) {
		$this->Schedule->id = $id;
		if (!$this->Schedule->exists()) {
			throw new NotFoundException(__('Invalid schedule'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Schedule->delete()) {
			$this->Session->setFlash(__('Schedule deleted'), 'default', array('class' => 'flash_success'));
			return $this->redirect(array('action' => 'index', $location_id));
		}
		$this->Session->setFlash(__('Schedule was not deleted'));
		return $this->redirect(array('action' => 'index', $location_id));
	}
}
