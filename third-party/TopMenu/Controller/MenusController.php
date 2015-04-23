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
 * @version       2
 *                                                                   
 */


App::uses('AppController', 'Controller');

/**
 * Menus Controller
 *
 * @property Menu $Menu
 * @property PaginatorComponent $Paginator
 */
class MenusController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'RequestHandler', 'DisplayMenu');

    public function beforeFilter() {
        switch ($this->request->action) {
            case 'admin_add':
            case 'admin_edit':
                $this->Security->validatePost = false;
                break;
        }



        $this->Auth->allow(
            'location_menu'
        );
        parent::beforeFilter();
        // var_dump(APP);
        // var_dump(Configure::read('Topmenu.images'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index($location_id = null) {
        $this->Menu->recursive = 0;

        $conditions = array(
            'Menu.location_id' => $location_id,
        );

        $this->Paginator->settings = array(
            'conditions' => $conditions
        );
        $this->set('menus', $this->Paginator->paginate());
        $this->set(compact('location_id'));
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($location_id = null, $id = null) {
        if (!$this->Menu->exists($id)) {
            throw new NotFoundException(__('Invalid menu'));
        }
        $options = array(
            'conditions' => array('MenuCategory.menu_id' => $id),
            'recursive' => 1,
            'contain' => array(
                'MenuItem'
            )
        );
        $this->set('menu_categories', $this->Menu->MenuCategory->find('all', $options));
        $this->set('menu', $this->Menu->find('first', array(
            'conditions' => array('Menu.id' => $id),
            'recursive' => 0,
            'contain' => array('Location'),
            'fields' => array(
                'Menu.*',
                'Location.id',
                'Location.name'
            )
        )));
        $this->set(compact('location_id'));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add($location_id = null) {
        if ($this->request->is('post')) {


            $this->Menu->create();
            if ($location_id != null) {
                $this->request->data['Menu']['location_id'] = $location_id;
            }
            if ($this->Menu->save($this->request->data)) {
                $this->Session->setFlash(__('The menu has been saved'), 'default', array('class' => 'flash_success'));
                return $this->redirect(array(
                    'action' => 'index',
                    $location_id
                ));
            } else {
                $this->Session->setFlash(__('The menu could not be saved. Please, try again.'));
            }
        }
        $locations = $this->Menu->Location->find('list');
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
        $this->Menu->id = $id;
        if (!$this->Menu->exists()) {
            throw new NotFoundException(__('Invalid menu'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $save = true;

            if ($this->Menu->save($this->request->data)) {
                $this->Session->setFlash(__('The menu has been saved'), 'default', array('class' => 'flash_success'));
                return $this->redirect(array(
                    'action' => 'index',
                    $location_id
                ));
            } else {
                $this->Session->setFlash(__('The menu could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Menu.' . $this->Menu->primaryKey => $id));
            $this->request->data = $this->Menu->find('first', $options);
        }
        $this->set(compact('location_id', 'id'));
    }

    /**
     * admin_delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($location_id, $id = null) {
        $this->Menu->id = $id;
        if (!$this->Menu->exists()) {
            throw new NotFoundException(__('Invalid menu'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Menu->delete(null, true)) {
            $this->Session->setFlash(__('Menu deleted'), 'default', array('class' => 'flash_success'));
            return $this->redirect(array(
                'action' => 'index',
                $location_id
            ));
        }
        $this->Session->setFlash(__('Menu was not deleted'));
        return $this->redirect(array('action' => 'index'));
    }	
}

