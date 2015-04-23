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
 * Redirects Controller
 */
class RedirectsController extends AppController {

	public $uses = array('LocationRedirect', 'Location');
/**
 * beforeFilter
 */
	public function beforeFilter() {
		$this->Auth->allow();
		parent::beforeFilter();
	}

/**
 * Handles redirects for locations (old urls)
 * @param  string $old_url Old url endpoint ( /restaurants/restaurant/<OLD_URL_ENDPOINT> )
 */
	public function location_redirect($old_url) {
		$location_id = $this->LocationRedirect->getLocationId($old_url);		
		if ($location_id) {
			$location_id          = $location_id['LocationRedirect']['location_id'];
			$location_url         = $this->Location->getLocationUrl($location_id);
			$location_sector_slug = $this->Location->getLocationSectorSlug($location_id);

			return $this->redirect(
				array(
					'controller' => 'locations',
					'action'     => 'view',
					'sector'     => $location_sector_slug['Location']['sector_slug'],
					'location'   => $location_url['Location']['url']
				),
				301
			);

		} else {
			$this->loadModel('Location');			
			
			$location_id = $this->Location->findByUrl($old_url);
			if ($location_id) {
                
                // Try to redirect the site by pattern.
				return $this->redirect(
                    array(
                        'controller' => 'locations',
                        'action'     => 'view',
                        'location'   => $old_url), 
                    301);
            }else{

                // Redirect to the invalid restaurant page
                $this->response->statusCode(410);
                $this->set('message', __('Sorry we could not find your page'));
                $this->render('/Elements/404');
            }
		}
	}

/**
 * Handles redirects pointing to the home page
 */
	public function home_redirect($language = 'en') {
		return $this->redirect(
			'/' . $language,
			301
		);
	}

}
