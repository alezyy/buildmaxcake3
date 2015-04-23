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
App::uses('Schedule', 'Model');

/**
 * Devices Controller
 *
 * @property Device $Device
 * @property PaginatorComponent $Paginator
 */
class DevicesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	public $helpers = array('Bootstrap');






/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		
		$this->Device->recursive = 0;
		$this->Paginator->settings = array(
			'contain' => array(
				'Location'
			),
			'fields' => array(
				'Device.id',
				'Device.description',
				'Device.timeout',
				'Device.last_connection',
				'Device.username',
				'Device.location_id',
				'Location.name',
                'Location.phone',
				'Location.id'
			),
            'limit' => 1000
		);
		$this->Device->order = array('Device.last_connection' => 'DESC');
		$devices = $this->Paginator->paginate();
		
		// Alert the restaurant to open is device?
        $i = 1;
		foreach ($devices as &$device) {
			$device['Device']['line_number'] = str_pad($i++, 3,0, STR_PAD_LEFT);
			$device['Device']['alert_restaurant'] = $this->Device->shouldDeviceBeOnlineAndIsNot($device['Location']['id']);			
		}
		
		$this->set('devices', $devices);
	}

/**
 * Send a broadcast to all devices
 * @return [type] [description]
 */
	public function admin_broadcast() {
		Configure::write('Exception', array(
		    'handler' => 'ErrorHandler::handleException',
		    'renderer' => 'ExceptionRenderer',
		    'log' => false
		));
		
		throw new ForbiddenException(__('Broadcasting is currently disabled.'));
		
		if ($this->request->is('post')) {
			if (isset($this->request->data['Device']['message'])) {
				$message = preg_replace('/(\r|\n|\r\n)/', '``', $this->request->data['Device']['message']);

				$this->Device->Location->DeviceOrder->sendSystemMessage($message);
				$this->Session->setFlash(__('Broadcast sent!'), 'default', array('class' => 'flash_success'));
				$this->redirect(array(
					'action' => 'index',
					'admin' => true
				));
			}
		}
	}


/**
 * admin_location_index method
 *
 * @return void
 */
	public function admin_location_index($location_id) {
		$this->Device->recursive = 0;

		$conditions = array(
			'Device.location_id' => $location_id

		);

		$this->Paginator->settings = array(
			'conditions' => $conditions,
			'contain' => array(
				'Location'
			),
			'fields' => array(
				'Device.id',
				'Device.description',
				'Device.timeout',
				'Device.last_connection',
				'Device.username',
				'Device.location_id',
				'Location.name',
				'Location.id'
			)
		);

		$this->Device->order = array('Device.last_connection' => 'DESC');
		$this->set('devices', $this->Paginator->paginate());
		$this->set(compact('location_id'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($location_id, $id = null) {
		if (!$this->Device->exists($id)) {
			throw new NotFoundException(__('Invalid device'));
		}
		$this->Device->recursive = 0;
		$options = array('conditions' => array('Device.' . $this->Device->primaryKey => $id));
		$this->set('device', $this->Device->find('first', $options));
		$this->set(compact('location_id'));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add($location_id) {
		if ($this->request->is('post')) {
			$this->Device->create();
			$this->Device->Location->id = $location_id;

			if (!$this->Device->Location->exists()) {
				throw new NotFoundException(__('Invalid Location'));
			}

			$this->request->data['Device']['location_id'] = $location_id;

			$username = $this->Device->generateUsername();
			$salt     = $this->Device->generateSalt();
			$password = $this->Device->generatePassword();
			$hash     = $this->Device->generateHash($password, $salt);

			$this->request->data['Device']['username'] = $username;
			$this->request->data['Device']['salt']     = $salt;
			$this->request->data['Device']['password'] = $hash;
			$this->request->data['Device']['created']  = date('Y-m-d H:i:s');

			$message = __('The device <b>%s</b> has been saved', $this->request->data['Device']['description']);
			$message .= '<br/><br/>';
			$message .= __('<b>Username:</b> <code>%s</code>', $username);
			$message .= '<br/>';
			$message .= __('<b>Password:</b> <code>%s</code>', $password);
			$message .= '<br/><br/>';
			$message .= __('Once you leave this page, or close this alert the password will not be retreivable.');



			if ($this->Device->save($this->request->data)) {
				$this->Session->setFlash(
					$message,
					'default',
					array('class' => 'flash_success')
				);
				return $this->redirect(array('action' => 'location_index', $location_id));
			} else {
				$this->Session->setFlash(__("The device could not be saved. Please, try again."));
			}
		}
		$locations = $this->Device->Location->find('list');
		$this->set(compact('locations', 'location_id'));
	}

/**
 * Generates new credentials for a device
 * @param  string $location_id
 * @param  string $i
 */
	public function admin_generate_new_credentials($location_id, $id) {
		if ($this->request->is('post')) {
			$this->Device->Location->id = $location_id;
			$this->Device->id = $id;

			if (!$this->Device->Location->exists()) {
				throw new NotFoundException(__('Invalid Location'));
			}
			if (!$this->Device->exists()) {
				throw new NotFoundException(__('Invalid Device'));
			}

			$description = $this->Device->read('description');

			$data = array(
				'Device' => array(
					'id' => $id
				)
			);

			$username = $this->Device->generateUsername();
			$salt     = $this->Device->generateSalt();
			$password = $this->Device->generatePassword();
			$hash     = $this->Device->generateHash($password, $salt);

			$data['Device']['username'] = $username;
			$data['Device']['salt']     = $salt;
			$data['Device']['password'] = $hash;

			$message = __(
				'The device <b>%s</b> has been issued new credentials',
				$description['Device']['description']
			);
			$message .= '<br/><br/>';
			$message .= __('<b>Username:</b> <code>%s</code>', $username);
			$message .= '<br/>';
			$message .= __('<b>Password:</b> <code>%s</code>', $password);
			$message .= '<br/><br/>';
			$message .= __('Once you leave this page, or close this alert the password will not be retreivable.');



			if ($this->Device->save($data)) {
				$this->Session->setFlash(
					$message,
					'default',
					array('class' => 'flash_success')
				);
				return $this->redirect(array('action' => 'location_index', $location_id));
			}
		}
		$this->Session->setFlash(__("The device could not be saved. Please, try again."));
		return $this->redirect(array('action' => 'location_index', $location_id));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($location_id, $id = null) {
		if (!$this->Device->exists($id)) {
			throw new NotFoundException(__('Invalid device'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Device->save($this->request->data)) {
				$this->Session->setFlash(__('The device has been saved.'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'location_index', $location_id));
			} else {
				$this->Session->setFlash(__('The device could not be saved. Please, try again.'));
			}
		} else {
			$options = array(
				'conditions' => array('Device.id' => $id),
				'fields' => array(
					'id',
					'location_id',
					'description',
					'last_connection',
					'timeout'
				)
			);
			$this->request->data = $this->Device->find('first', $options);
		}
		$locations = $this->Device->Location->find('list');
		$this->set(compact('locations',  'location_id'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($location_id, $id = null) {
		$this->Device->id = $id;
		if (!$this->Device->exists()) {
			throw new NotFoundException(__('Invalid device'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Device->delete()) {
			$this->Session->setFlash(__('Device deleted'), 'default', array('class' => 'flash_success'));
			return $this->redirect(array('action' => 'location_index', $location_id));
		}
		$this->Session->setFlash(__('Device was not deleted'));
		return $this->redirect(array('action' => 'location_index', $location_id));
	}
	

}
