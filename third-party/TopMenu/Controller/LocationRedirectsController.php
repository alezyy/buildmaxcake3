<?php
App::uses('AppController', 'Controller');
/**
 * LocationRedirects Controller
 *
 * @property LocationRedirect $LocationRedirect
 * @property PaginatorComponent $Paginator
 */
class LocationRedirectsController extends AppController {

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
		$query = null;
        if ($this->request->is('post')) {
            if (isset($this->request->data['Query']['search'])) {
                $this->Session->write('location_redirect.query', $this->request->data['Query']['search']);
            }
        }
        if ($this->Session->read('location_redirect.query')) {
            $query = $this->Session->read('location_redirect.query');
            $this->request->data['Query']['search'] = $query;
        }
        $query = str_ireplace(' ', '%', $query);

        $conditions = array(
            'OR' => array(
				'Location.name LIKE'            => '%' . $query . '%',
				'LocationRedirect.old_url LIKE' => '%' . $query . '%'
            )
        );

        $this->Paginator->settings = array(
            'conditions' => $conditions,
            'recursive' => 0
        );

		$this->set('locationRedirects', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->LocationRedirect->exists($id)) {
			throw new NotFoundException(__('Invalid location redirect'));
		}
		$this->LocationRedirect->recursive = 0;
		$options = array('conditions' => array('LocationRedirect.' . $this->LocationRedirect->primaryKey => $id));
		$this->set('locationRedirect', $this->LocationRedirect->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->LocationRedirect->create();
			if ($this->LocationRedirect->save($this->request->data)) {
				$this->Session->setFlash(__('The location redirect has been saved.'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The location redirect could not be saved. Please, try again.'));
			}
		}
		$locations = $this->LocationRedirect->Location->find('list');
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
		if (!$this->LocationRedirect->exists($id)) {
			throw new NotFoundException(__('Invalid location redirect'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->LocationRedirect->save($this->request->data)) {
				$this->Session->setFlash(__('The location redirect has been saved.'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The location redirect could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('LocationRedirect.' . $this->LocationRedirect->primaryKey => $id));
			$this->request->data = $this->LocationRedirect->find('first', $options);
		}
		$locations = $this->LocationRedirect->Location->find('list');
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
		$this->LocationRedirect->id = $id;
		if (!$this->LocationRedirect->exists()) {
			throw new NotFoundException(__('Invalid location redirect'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->LocationRedirect->delete()) {
			$this->Session->setFlash(__('The location redirect has been deleted.'), 'default', array('class' => 'flash_success'));
		} else {
			$this->Session->setFlash(__('The location redirect could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
