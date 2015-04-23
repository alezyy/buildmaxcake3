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
 * HomesController class.
 *
 * @extends AppController
 */
class HomesController extends AppController {

    /**
     * Helpers to load
     * @var array
     */
    public $helpers = array(
        'Bootstrap',
        'Calendar' => array(
        //'date_format' => '%Y-%m-%d'
        ),
        'Date',
    );

    /**
     * Components to load
     * @var array
     */
    public $components = array('RequestHandler');

    /**
     * beforeFilter function.
     *
     * @access public
     * @return void
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(
            'index'
        );
        if ($this->request->action != 'language')
            $this->authed_ajax();
    }

    /**
     * index function.
     *
     * @access public
     * @return void
     */
    public function index() { 

        $cuisines = $this->requestAction(array('controller' => 'cuisines', 'action' =>'view'));

        $sectors = $this->requestAction(array('controller' => 'sectors', 'action' => 'view'));

        if ($this->Session->check('DeliveryDestination.postal_code1')) {
            $this->request->data['Location']['postal_code1'] = $this->Session->read('DeliveryDestination.postal_code');
        }

        if ($this->is_mobile) {
            $this->layout = 'mobile_modal';
        } else {
            $this->layout = 'home';
            $this->set('randomBackground', $this->_random_background());
        }
        $this->set('title_for_layout', __(' Delivery Restaurants Montreal'));
        $this->set(compact('cuisines', 'sectors'));
    }

    /**
     * Generates randomly a file path to an image for the background
     * All files in the $dire must be name 0.jpg, 1.jpg, 2.jpg ... for this function to work
     * @param string $dir path of the directory where the images are
     * @return string filepath of the image
     */
    private function _random_background($dir = 'img/home_page_background') {
        $rand = rand(0, 8); // 8 is the amount of images available in the 		
        return $dir . "/$rand.jpg";
    }

}
