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
 * Generates a sitemap and serves it up in XML
 * Accessible through <url>/sitemap.xml
 * 
 */
class SitemapsController extends AppController {

/**
 * We need the RequestHandler to serve up the
 * view in xml
 * 
 * @var array
 */
	public $components = array('RequestHandler');

/**
 * An array of the models we'll be using.
 * 
 * @var array
 */
	public $uses = array('Location');


/**
 * Additonal languages to add to the records (don't include 'en')
 * @var array
 */
	private $additionalLanguages = array();

/**
 * An array of XML we'll build into a string
 * 
 * @var array
 */
	private $xmlArray = array(
		'urlset' => array(
			'xmlns:xsi'           => 'http://www.w3.org/2001/XMLSchema-instance',
			'xmlns:xhtml'         => 'http://www.w3.org/1999/xhtml',
			'@xhtml'              => 'http://www.w3.org/1999/xhtml',
			'@xmlns'              => 'http://www.sitemaps.org/schemas/sitemap/0.9',
			'@xsi:schemaLocation' => 'http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd'
			
		)
	);

/**
 * beforeFilter
 * 
 * @return [type] [description]
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->runIDS = false;
		$this->Auth->allow('sitemap', 'sitemapCsv');
		$this->additionalLanguages = Configure::read('Config.languages');
	}

	

/**
 * Main entry point, decides what to feed the browser
 * 
 */
	public function sitemap() {
		$this->autoRender = false;
		if (isset($this->request->params['ext'])) {
			switch($this->request->params['ext']) {
				case 'xml':
					$this->_sitemapXml();
					break;
				case 'csv':
					$this->_sitemapCsv();
					break;
			}
		}
	}

/**
 * Builds a CSV sitemap (not really for search engines)
 */
	private function _sitemapCsv() {

		$urls = array();
		/**
		 *  Static Pages
		 */

		// home
		$urls['home'] = array(
			'controller' => 'homes',
			'action'     => 'index'
		);

		// register
		$urls['register'] = array(
			'controller' => 'users',
			'action'     => 'register'
		);

		$urls['login'] = array(
			'controller' => 'users',
			'action'     => 'login'
		);




		/**
		 * Records from the database
		 */
		// Locations
		$locations = $this->Location->find('all', array(
			'fields' => array(
				'url',
				'sector_slug'
			),
			'conditions' => array(
				'url !=' => '',
				'status' => 'active'
			)
		));
		foreach ($locations as $location) {
			if (!empty($location['Location']['url']) && !empty($location['Location']['sector_slug'])) {
				$urls[$location['Location']['url']] = array(
					'controller' => 'locations',
					'action'     => 'view',
					'location'   => $location['Location']['url'],
					'sector'     => $location['Location']['sector_slug']
				);
			}
		}

		// Menus
		$locations = $this->Location->find('all', array(
			'fields' => array(
				'url'
			),
			'conditions' => array(
				'url      !=' => '',
				'pdf_menu !=' => '',
				'status'      => 'active'
			)
		));

		$menus = array();
		foreach ($locations as $location) {
			$menus[$location['Location']['url'] . '-PDF-MENU'] = array(
				'controller' => 'pdfs',
				'action'     => 'get_pdf',
				'pdf_id'     => $location['Location']['url'],
				'ext'        => 'pdf'
			);

		}


		// Output the CSV

		$this->autoRender = false;

		$this->response->type('csv');


		$out = 'Name, Url-EN, URL-FR' . "\n";


		foreach ($urls as $key => $url) {
			$url_en             = $url_fr = $url;
			$url_en['language'] = 'en';
			$url_fr['language'] = 'fr';
			$out 			    .= $key . ', ' . Router::url($url_en) . ', ' . Router::url($url_fr) . "\n";
		}

		foreach ($menus as $key => $url) {
			$out .= $key . ', ' . Router::url($url) . "\n";
		}
		
		$this->response->body($out);

		$this->response->download('sitemap.csv');
	}

/**
 * Builds an XML sitemap
 */
	private function _sitemapXml() {
		/**
		 *  Static Pages
		 */

		// home
		$url = array(
			'controller' => 'homes',
			'action'     => 'index'
		);
		$this->_addUrl($url, array(
			'changefreq' => 'daily',
			'priority'   => '1.0'
		));

		// register
		$url = array(
			'controller' => 'users',
			'action'     => 'register'
		);
		$this->_addUrl($url, array(
			'changefreq' => 'daily',
			'priority'   => '0.5'
		));




		/**
		 * Records from the database
		 */
		
		// Locations
		$locations = $this->Location->find('all', array(
			'fields' => array(
				'modified',
				'url',
				'sector_slug'
			),
			'conditions' => array(
				'url !=' => '',
				'status' => 'active'
			)
		));
		foreach ($locations as $location) {
			$url = array(
				'controller' => 'locations',
				'action'     => 'view',
				'location'   => $location['Location']['url'],
				'sector'     => $location['Location']['sector_slug']
			);
			if (!empty($location['Location']['url']) && !empty($location['Location']['sector_slug'])) {
				$this->_addUrl($url, array(
					'lastmod'  => date(DATE_ATOM, strtotime($location['Location']['modified'])),
					'priority' => '0.5'
				));
			}

		}

		// Menus
		$locations = $this->Location->find('all', array(
			'fields' => array(
				'modified',
				'url'
			),
			'conditions' => array(
				'url      !=' => '',
				'pdf_menu !=' => '',
				'status'	  => 'active'
			)
		));
		foreach ($locations as $location) {
			$url = array(
				'controller' => 'pdfs',
				'action'     => 'get_pdf',
				'pdf_id'     => $location['Location']['url'],
				'ext'        => 'pdf'
			);
			$this->_addUrl($url, array(
				'lastmod' => date(DATE_ATOM, strtotime($location['Location']['modified'])),
				'priority' => '0.5'
			), false, false);

		}


		// Build the XML string
		$xml = $this->_buildXML();


		$this->response->type('xml');

		$this->response->body($xml);
	}

/**
 * Adds a url element to the array
 * @param array  $url                  Array of the URL to be parsed by Router
 * @param array  $data                 Data to go in the element (not includeing url)
 * @param boolean $language            Include language param in url?
 * @param boolean $additionalLanguages Add additional supported languages to the element
 *                                     (<xhtml:link> tags)
 */
	private function _addUrl($url, $data, $language = true, $additionalLanguages = true) {
		if ($language) {
			$url['language'] = 'en';
		}
		$data['loc'] = Router::url($url, true);
		if ($additionalLanguages) {
			foreach ($this->additionalLanguages as $additionalLanguage) {
				$temp_url             = $url;
				$temp_url['language'] = $additionalLanguage;
				$temp_url             = Router::url($temp_url, true);
				$data['xhtml:link'][] = array(
					'@rel'      => 'alternate',
					'@hreflang' => $additionalLanguage,
					'@href'     => $temp_url
				);
			}
		}
		$this->xmlArray['urlset']['url'][] = $data;
	}

/**
 * Builds an XML string and returns it
 * @return string Built XML string
 */
	private function _buildXML() {
		$xml = Xml::fromArray($this->xmlArray);
		return $xml->asXML();
	}

}