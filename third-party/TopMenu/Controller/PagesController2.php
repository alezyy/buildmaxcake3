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


/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

    /**
     * Controller name
     *
     * @var string
     */
    public $name = 'Pages';

    /**
     * This controller does not use a model
     *
     * @var array
     */
    public $uses = array();


/**
 * Before Filter, allow access to display function
 */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow();
    }

    /**
     * Displays a view
     *
     * @param mixed What page to display
     * @return void
     */
    

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 */
    public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $titleForLayout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$titleForLayout = Inflector::humanize($path[$count - 1]);
		}

		$this->set(array(
			'page' => $page,
			'subpage' => $subpage,
			'title_for_layout' => $titleForLayout
		));

		$locale = Configure::read('Config.language');
		if (
				$locale && file_exists(APP . 'View' . DS . $locale . DS . $this->viewPath . DS . $page . '.ctp')
		) {
			if (!$this->request->is('ajax')) {
				$this->viewPath = $locale . DS . $this->viewPath;
			}
		}
		if ($page == 'maintenance' || Configure::read('debug') === 4) {
			$this->layout = 'down';
		} elseif ($page == 'home') {
			$this->layout = 'home';
		} else {
			$this->layout = 'default';
		}
		$this->render(implode('/', $path));
	}

	/**
	 * Static pages
	 */
    public function user_guide(){
        $this->render('user_guide_' . $this->langSuffix );
    }
    public function confidentiality(){
        $this->render('confidentiality_' . $this->langSuffix );
    }
    public function about_us(){
        $this->render('about_us_' . $this->langSuffix );
    }
    public function terms_conditions(){
        $this->render('terms_conditions_' . $this->langSuffix );
    }
    public function coupons_legal(){
        $this->render('coupons_legal_' . $this->langSuffix );
    }
	public function terms(){}
	public function sitemap(){}
}