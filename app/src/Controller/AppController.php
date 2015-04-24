<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use SessionHandlerInterface;
use Cake\Event\Event ;



/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    public $langSuffix = 'en';
    public $theme = 'Bootstrap';
    public $helpers = [
    'Less.Less', // required for parsing less files
    'Bootstrap.Form',
    'Html',
    'Form',
    'Session',  // use  $this->request->session()  instead in our view
    'Date',
    'GoogleMap'
            ];

    public $component = [
	'Acl',
	'Auth' => [ 
                  'authenticate' => 'BcryptForm',
		   'authorize' => [
				'Actions' => [
					'actionPath' => 'controllers/',
					'admin' => false
				            ]
			             ]	
	                    ],

	 'loginAction' =>   [	'controller' => 'users',
				'action' => 'login',
				'admin' => false
			    ],
	 'loginRedirect' => [   'controller' => 'homes',
				'action' => 'index',
				'admin' => false
			    ],
	  'logoutRedirect' => [
				'controller' => 'homes',
				'action' => 'index',
				'admin' => false
			     ] ,
          'Cookie',
	  'Session',
	  'Security',
	  'AjaxRedirect',
	  'x509',
	  'RequestHandler'                
        ] ;


	/**
	 * Debug value from config
	 * @var integer
	 */
	public $debugValue = 0;
	

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('Bootstrap.Flash');
	// Always enable the CSRF component.
        $this->loadComponent('Csrf');
	    $this->loadComponent('Auth') ;

    }


	/**
	 * beforeFilter function.
	 *
	 * @access public
	 * @return void
	 */
	public function beforeFilter(Event $event) {
		// parent::beforeFilter($event);

    if ($this->request->prefix === null) {
            $this->Auth->allow();
       }

	}

     public function isAuthorized($user) {
        if ($this->request->prefix === 'admin') {
            return (bool)$user['role'] === 'admin';
        }
    }


	
    /**
     * Other Variables
     */

     //   $this->set('language_bar', Configure::read('TopMenu.languages'));
    //    $this->set('hasValidCert', $this->hasValidCert);
    //      $this->set('admin', $admin);
    //    $this->set('admin_routing', $admin_routing);
    //    $this->set('registration', Configure::read('User.registration_enabled'));

   //     $this->set('username', $this->Auth->user('username'));
   //     $this->set('user_id', $this->Auth->user('id'));
   //     $this->set('group_id', $this->Auth->user('group_id'));

   //    $this->set('langSuffix', $this->langSuffix);
   //     $this->set('language', $this->langSuffix);

       


    /**
     * Default meta tags
     */

          

       // $commonKeywords = ('Delivery, Topmenu, Restaurants, Order, Montreal') ;
       /* $metaDescriptionString = __("Topmenu provides online food delivery and pickup from restaurants in Montreal.");
        $this->set('meta_viewport', "<meta name='viewport' content='width=device-width, user-scalable=no'>\n");
        $this->set('meta_keywords', "<meta name='keywords' content='$commonKeywords' />\n");
        $this->set('meta_description', "<meta name='description' content='$metaDescriptionString' />\n");
        $this->set('meta_city', "<meta name='city' content='Montreal' />\n");
        $this->set('meta_state', "<meta name='state' content='Quebec' />\n");
       */



       //  $this->Auth->allow('read_session');



	public function beforeRender(Event $event) {
	//	parent::beforeRender($event);

	}



}
