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
/**
 * CakePHP Component & Model Code Completion
 * @author Mincho
 *
 * ==============================================
 * CakePHP Core Components
 * ==============================================
 * @property AuthComponent $Auth
 * @property AclComponent $Acl
 * @property CookieComponent $Cookie
 * @property EmailComponent $Email
 * @property RequestHandlerComponent $RequestHandler
 * @property SecurityComponent $Security
 * @property SessionComponent $Session
 */


App::uses('Controller', 'Controller');
App::import('Component', 'Session');

/**
 * AppController class.
 *
 * @extends Controller
 */
class AppController extends Controller {

	public $langSuffix = 'en';

	/**
	 * components
	 *
	 * @var mixed
	 * @access public
	 */
	public $components = array(
		'Acl',
		'Auth' => array(
			'authenticate' => 'BcryptForm',
			'authorize' => array(
				'Actions' => array(
					'actionPath' => 'controllers/',
					'admin' => false
				)
			),
			'loginAction' => array(
				'controller' => 'users',
				'action' => 'login',
				'admin' => false
			),
			'loginRedirect' => array(
				'controller' => 'homes',
				'action' => 'index',
				'admin' => false
			),
			'logoutRedirect' => array(
				'controller' => 'homes',
				'action' => 'index',
				'admin' => false
			)
		),
        'Cookie',
		'Session',
		'Security',
		'AjaxRedirect',
		'x509',
		'RequestHandler'
	);

	/**
	 * helpers
	 *
	 * (default value: array('Html', 'Form', 'Session'))
	 *
	 * @var string
	 * @access public
	 */
	public $helpers = array(
		'Html', 
		'Form', 
		'Session', 
		'Date',
		'GoogleMap'
	);

	/**
	 * Debug value from config
	 * @var integer
	 */
	public $debugValue = 0;

	/**
	 * __construct function.
	 *
	 * @access public
	 * @param mixed $request (default: null)
	 * @param mixed $response (default: null)
	 * @return void
	 */
	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
		$this->debugValue = Configure::read('debug');
		$this->debugToolbar = Configure::read('debug_toolbar');

		$this->Component = new ComponentCollection();
		$this->Session   = new SessionComponent($this->Component);

		if ($this->debugValue && ($this->debugValue > 0)) {
			// Debug Toolbar
			// Remember to init and update the submodule
			// Currently plugins/DebugKit/webroot needs to be
			// symbolically linked to app/webroot/debug_kit (not sure why)
			// + uncomment the entry in bootstrap.php
			if ($this->debugToolbar) {
				$this->components[] = 'DebugKit.Toolbar';
			}
		}

		if (isset($this->request->params['language'])) {
			$this->Session->write('Config.language', $this->request->params['language']);
            Configure::write('Config.language', $this->request->params['language']);
        }


	}

	/**
	 * beforeFilter function.
	 *
	 * @access public
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();

        // Create the switch language bar
        $this->_buildLanguageSwitcherUrl();

        // get the part of the URL that doesnt change (for canonical url stuff)
        $canonicalUrl = substr(Router::url($this->request->here), 3);
        $this->set('canonicalUrl', ($canonicalUrl) ? $canonicalUrl : '');

        // Check if previous page was the login page
		if ($this->Session->check('justSignIn')){
			$this->set('justSignIn', true);
			$this->Session->delete('justSignIn');
		}


		$secure_only = Configure::read('secure_only');

		if ($secure_only === true) {
			$this->Security->requireSecure();
		}


		if($this->name == 'CakeError'){
			$this->layout = 'error';
		} else {
			$this->layout = 'default';


			/**
			 * Check in cookies if user as specified is site version preference
			 */
			if (filter_input(INPUT_COOKIE, 'siteversion') === 'mobile') {
				$this->is_mobile = TRUE;
			} else {
				$this->is_mobile = FALSE;
			}

			/**
			 * Check to see if we have a tablet
			 */
			// Add strings related to tablets to match in the user agent
			$this->is_tablet = FALSE;
			$this->request->addDetector(
				'tablet', array('callback' => function ($request) {
				$userAgent = strtolower($request->header('User-Agent'));
				if (preg_match('/ipad/', $userAgent)) {				 // iPad's and iPad mini
					return TRUE;
				} elseif (preg_match('/android/', $userAgent)) {		 // is Android
					return (!preg_match('/mobile/', $userAgent));	 // Android without mobile is tablet
				} elseif (preg_match('/tablet/', $userAgent)) {	   // Windows tablets
					return TRUE;
				}
			})
			);

			/**
			 * Check to see if the user is on pc, mobile or tablet
			 */
			$cookieSiteVersion = filter_input(INPUT_COOKIE, 'siteversion');
			if (empty($cookieSiteVersion)) {
				if (!$this->request->is('tablet')) {
					if ($this->RequestHandler->isMobile()) {  // Phones (mobile and not tablet)
						$this->is_mobile = TRUE;
						$this->is_tablet = FALSE;
						$this->set('is_mobile', TRUE);
						$this->set('is_tablet', FALSE);
					} else {
						$this->set('is_mobile', FALSE); // PC (Not mobile)
						$this->set('is_tablet', FALSE);
					}
				} else {   // Tablets
					$this->is_tablet = TRUE;
					$this->is_mobile = FALSE;
					$this->set('is_mobile', FALSE);
					$this->set('is_tablet', TRUE);
				}
			} elseif (filter_input(INPUT_COOKIE, 'siteversion') === 'desktop') {
				// check if user specified the version of the site he wants to see
				$this->is_tablet = TRUE;
				$this->set('is_tablet', TRUE);
				$this->is_mobile = FALSE;
				$this->set('is_mobile', FALSE);
			} elseif (filter_input(INPUT_COOKIE, 'siteversion') === 'mobile') {
				$this->is_mobile = TRUE;
				$this->set('is_mobile', TRUE);
				$this->is_tablet = FALSE;
				$this->set('is_tablet', FALSE);
			}
		}

		$this->hasValidCert = $this->x509->hasValidCert();

		/**
		 * i18n Stuff
		 */
		$this->_i18n();

		$this->loadModel('User');
		$this->loadModel('Sector');
		$this->loadModel('Cuisine');

		/**
		 * Check to see if admin routing was used
		 */
		$admin = false;
		$admin_routing = false;

		$group = $this->Auth->user('group_id');
		if (($group >= 1 && $group <= 3) || $group == 6) {
			$admin = true;
		}

		$this->Auth->flash['params']['class'] = 'alert alert-danger';

		$this->Auth->authError = __('Please log in to continue');


		if (isset($this->request->params['admin'])) {
			$admin_routing = $this->request->params['admin'];
			if ($admin_routing) {
				$secure_admin = Configure::read('TopMenu.secure_admin');
				if ($secure_admin) {
					if (!$this->hasValidCert) {
						$this->Session->setFlash(__('You are not authorized to access that location...'), 'flash_danger');
						$this->redirect($this->referer());
					}
				}
				$this->layout = 'admin';
			}
		} else {
			$admin_routing = false;
		}


		/**
		 * Authenticated User stuff
		 */

		$this->_authed();

		/**
		 * Other Variables
		 */
		$this->set('language_bar', Configure::read('TopMenu.languages'));
		$this->set('hasValidCert', $this->hasValidCert);
		$this->set('admin', $admin);
		$this->set('admin_routing', $admin_routing);
		$this->set('registration', Configure::read('User.registration_enabled'));

		$this->set('username', $this->Auth->user('username'));
		$this->set('user_id', $this->Auth->user('id'));
		$this->set('group_id', $this->Auth->user('group_id'));

		$this->set('langSuffix', $this->langSuffix);
		$this->set('language', $this->langSuffix);

		/**
		 * Default meta tags
		 */

		$commonKeywords = __('Delivery, Topmenu, Restaurants, Order, Montreal') ;
		$metaDescriptionString = __("Topmenu provides online food delivery and pickup from restaurants in Montreal.");
		$this->set('meta_viewport', "<meta name='viewport' content='width=device-width, user-scalable=no'>\n");
		$this->set('meta_keywords', "<meta name='keywords' content='$commonKeywords' />\n");
		$this->set('meta_description', "<meta name='description' content='$metaDescriptionString' />\n");
		$this->set('meta_city', "<meta name='city' content='Montreal' />\n");
		$this->set('meta_state', "<meta name='state' content='Quebec' />\n");

//        $this->theme = $this->_getTheme();
        
        $this->Auth->allow('read_session');
	}

	public function beforeRender() {
		parent::beforeRender();

		 if (isset($this->is_mobile) && $this->is_mobile) {
            $view_file = new File(APP . 'View' . DS . $this->name . DS . 'mobile/' . $this->request->action . '.ctp');
            $prefix = '';
            $layout = 'default';

            if ($view_file->exists()) {
                $prefix = '/mobile/';
                $layout = 'mobile';
            } else {
                $view_file = new File(APP . 'View' . DS . $this->langSuffix . DS . $this->name . DS . 'mobile/' . $this->request->action . '.ctp');
                if ($view_file->exists()) {
                    $prefix = '/mobile/';
                    $layout = $this->layout;
                }
            }

			$viewPath = DS . $this->name . $prefix .  $this->request->action;	// path to view <PluralModelName/mobile/action>
            $this->layout = ($this->layout !== 'default') ? $this->layout : $layout;  // ajax response should never be wrap with a layout

            $this->view = $viewPath;
						
		}

	}

	/**
 * Checks if a user is logged in, if not it redirects them  to the  base url
 * @return void
 */
	public function authed_ajax() {
		if ($this->request->is('ajax')) {
			$this->AjaxRedirect->redirectIfUnAuthed($this);
		}
	}

/**
 * Add language stuff to redirects
 *
 */
	public function redirect($url, $status = null, $exit = true) {
        parent::redirect(router_url_language($url), $status, $exit);
    }

/**
 * Add language stuff to flash messages
 *
 */
    public function flash($message, $url, $pause = 1, $layout = 'flash') {
        parent::flash($message, router_url_language($url), $pause);
    }
    
    /**
     * Action that returns the json encoded value from the session or null if the index does not exist;
     * @param string $index Cakephp Session Index (Order.Order.method_of_payment)
     */
    public function read_session($index){   
        $this->layout = 'ajax';
        if($this->Session->check($index)){
            $result = json_encode($this->Session->read($index));
        }else{
            $result = NULL;
        }
        echo $result;
        $this->autoRender = false;
    }

/**
 * Check to see if a user is required to change their password
 *
 */
	private function _authed() {
		if ($this->Auth->user('id')) {
			/**
			 * Check to see if a password reset is required of this user
			 */
			if ($this->request->action != 'change_password') {
				$force_reset = $this->User->requireReset($this->Auth->user('id'));
				if ($force_reset) {
					if ($this->request->is('ajax')) {
						$this->AjaxRedirect->redirectIfUnAuthed($this, true);
					}
					$this->Session->setFlash(__('You are required to change your password!'), 'flash_warning');
					$this->redirect(array(
						'controller' => 'users',
						'action' => 'change_password'
					));
				}
			}
		}
	}


/**
 * Handles all the i18n stuff
 */
	private function _i18n() {

		if ($this->Session->check('Config.language') && $this->Session->read('Config.language')) {
			Configure::write('Config.language', $this->Session->read('Config.language'));
		} else {

			// Default
			Configure::write('Config.language', 'fr');
			$this->Session->write('Config.language', 'fr');

		}


		$locale = Configure::read('Config.language');
		if (
			$locale
			&& file_exists(APP . 'View' . DS . $locale . DS . $this->viewPath)
			&& $this->viewPath != 'Pages'
		) {
			// e.g. use /app/View/fra/Pages/tos.ctp instead of /app/View/Pages/tos.ctp
			if (!$this->request->is('ajax')) {
				$this->viewPath = $locale . DS . $this->viewPath;
			}
		}



		$this->langSuffix = Configure::read('Config.language');


		if (strlen($this->langSuffix) > 2) {
			$this->langSuffix = substr($this->langSuffix, 0, 2);
		}

	}

    private function _buildLanguageSwitcherUrl() {

        $url = array();

        // Build array string in CakePHP Route style
        foreach ($params = $this->params->params as $k => $v) {


            if ($k === 'language' && $v === 'en') {
                // Switch the language
                $url[$k] = 'fr';
            } elseif ($k === 'language' && $v === 'fr') {
                // Switch the language
                $url[$k] = 'en';
            } else {

                // Others param
                if ($k !== 'pass') {
                    if (!empty($v)) {
                        $url[$k] = $v;
                    }
                }
            }
        }

        // append quety string
        if (!empty($this->request->query)) {
            $url['?'] = $this->request->query;
        }

        // Send to view
        $this->set('changeLanguageUrl', $url);
    }

}

