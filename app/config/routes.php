<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
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
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\Router;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass('Route');

Router::prefix('admin', function ($routes) {
    $routes->fallbacks();
});


Router::scope('/', function ($routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */

    $routes->connect('/', ['controller' => 'Homes', 'action' => 'index', 'home']);

    $routes->connect('/pages', ['controller' => 'Pages', 'action' => 'display', 'page']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

  //  $routes->connect('/login',  ['controller' => 'users', 'action' => 'login']);



  /*  Router::connect(
    '/en/login/:success', array('controller' => 'users', 'action' => 'login', 'language' => 'en'), array(
    'pass' => array('success')));
 */


 //   $routes->connect('/login',  ['controller' => 'users', 'action' => 'login']);
 //   $routes->connect('/logout',  ['controller' => 'users', 'action' => 'logout']);
  
  /*  $routes->connect('/posts',  ['controller' => 'Posts', 'action' => 'index']);
    $routes->connect('/posts/index/*',  ['controller' => 'Posts', 'action' => 'index']);
    $routes->connect('/Posts/add',  ['controller' => 'Posts', 'action' => 'add']);
    $routes->connect('/posts/edit/*',  ['controller' => 'Posts', 'action' => 'edit']);
    $routes->connect('/posts/delete/*',  ['controller' => 'Posts', 'action' => 'delete']);
    $routes->connect('/posts/*',  ['controller' => 'Posts', 'action' => 'index']);
    	
*/

      /*
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
	Router::connect('/about', array('controller' => 'pages', 'action' => 'display', 'about'));
	Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
	Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
	Router::connect('/posts', array('controller' => 'posts', 'action' => 'index'));
	Router::connect('/posts/index/*', array('controller' => 'posts', 'action' => 'index'));
	Router::connect('/posts/add', array('controller' => 'posts', 'action' => 'add'));
	Router::connect('/posts/edit/*', array('controller' => 'posts', 'action' => 'edit'));
	Router::connect('/posts/delete/*', array('controller' => 'posts', 'action' => 'delete'));
	Router::connect('/posts/*', array('controller' => 'posts', 'action' => 'view'));
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
        */
     
	


    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `InflectedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'InflectedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'InflectedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks('InflectedRoute');
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
