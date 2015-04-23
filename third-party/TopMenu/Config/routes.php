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
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Redirections
 */
Router::redirect(
    '/pages/terms_conditions_en/language:fr', 
    array('controller' => 'pages', 'action' => 'terms_conditions', 'language' => 'fr'),
    array('status' => 301)
);
Router::redirect(
    '/pages/terms_conditions_fr/language:fr', 
    array('controller' => 'pages', 'action' => 'terms_conditions', 'language' => 'fr'),
    array('status' => 301)
);
Router::redirect(
    '/pages/terms_conditions_en/language:en', 
    array('controller' => 'pages', 'action' => 'terms_conditions', 'language' => 'en'),
    array('status' => 301)
);
Router::redirect(
    '/pages/terms_conditions_fr/language:en', 
    array('controller' => 'pages', 'action' => 'terms_conditions', 'language' => 'en'),
    array('status' => 301)
);

Router::redirect(
    '/:language/legals-termes', 
    array('controller' => 'pages', 'action' => 'terms'),
    array('status' => 301)
);

Router::redirect(
    '/en/city/val-dor', '/en/city/val-d-or', array('status' => 301)
);
Router::redirect(
    '/fr/city/val-dor', '/fr/city/val-d-or', array('status' => 301)
);


Router::redirect(
    '/city', 
    array('controller' => 'sectors', 'action' => 'view', 'language' => 'fr'),
    array('status' => 301, 'persist' => true)
);

Router::redirect('/fr/city/:sector', 
    array(
        'controller' => 'locations',
        'action'     => 'search',
        'language'   => 'fr',
        '?'          => 't=nh'), 
    array('status'  => 301, 'persist' => array('sector')));

Router::redirect('/en/city/:sector', 
    array(
        'controller' => 'locations',
        'action'     => 'search',
        'language'   => 'en',
        '?'          => 't=nh'), 
    array('status'  => 301, 'persist' => array('sector')));

Router::redirect(
    '/legals-termes', array('controller' => 'pages', 'action' => 'terms'), array('status' => 301)
);

// Main Route	
 	Router::connect(
		'/:language', 
		array('controller' => 'homes', 'action' => 'index'),
		array('language' => '[a-z]{2}')
	);
	Router::connect('/', array('controller' => 'homes', 'action' => 'index'));
	
Router::connect(
    '/fr/secteurs/:sector', 
    array(
        'controller' => 'locations', 
        'action' => 'search', 
        'language' => 'fr'), array('pass' => array('sector')));

Router::connect(
    '/en/area/:sector', array('controller' => 'locations', 'action' => 'search', 'language' => 'en'), array('pass' => array('sector')));

Router::connect(
    '/fr/secteurs/:sector', 
    array('controller' => 'locations', 'action' => 'search'), 
    array('language' => '[a-z]{2}', 'pass' => array('sector')));
	
Router::connect(
    '/en/area/:sector', array('controller' => 'locations', 'action' => 'search', 'language' => 'en'), array(
    array('pass' => array('sector')))
);

Router::connect(
		'/:language/cuisines',
		array('controller' => 'cuisines', 'action' => 'view'),
		array('language' => '[a-z]{2}'));	
	
	Router::connect(
		'/:language/cuisines/:cuisine',
		array('controller' => 'cuisines', 'action' => 'search'),
		array(
            'cuisine' => '[A-z0-9-]+$',
            'language' => '[a-z]{2}'));

	Router::connect(
		'/:language/restaurant/:pc',
		array('controller' => 'locations', 'action' => 'search'),
		array(
            'language' => '[a-z]{2}',
            'pc' => '[A-z][0-9][A-z]'));

	Router::connect(
		'/:language/restaurant/:nh',
		array('controller' => 'locations', 'action' => 'search'),
		array(
            'language' => '[a-z]{2}',
            'nh' => '[a-z0-9-]+$'));
	
	Router::connect(
		'/:language/recherche_restaurant/*',
		array('controller' => 'locations', 'action' => 'invalid'),
		array('language' => '[a-z]{2}')
	);
    
    // STATIC PAGES
    
/**
 * Sitemap
 */
Router::connect(
    '/:language/sitemap', array('controller' => 'pages', 'action' => 'sitemap'), array('language' => '[a-z]{2}')
);

/**
 * About us
 */
Router::connect(
    '/fr/a-propos-de-nous', array('language' => 'fr', 'controller' => 'pages', 'action' => 'about_us')
);

Router::connect(
    '/en/about-us', array('language' => 'en', 'controller' => 'pages', 'action' => 'about_us')
);
Router::redirect(
    '/fr/about-us', array('controller' => 'pages', 'action' => 'about_us', 'language' => 'fr'), array('status' => 301)
);
Router::redirect(
    '/en/a-propos', array('language' => 'en', 'controller' => 'pages', 'action' => 'about_us', 'language' => 'en'), array('status' => 301)
);
Router::redirect(
    '/en/a-propos-de-nous', array('language' => 'en', 'controller' => 'pages', 'action' => 'about_us', 'language' => 'en'), array('status' => 301)
);

/**
* FAQ
*/
	
	Router::connect(
		'/:language/faq',
		array('controller' => 'pages', 'action' => 'user_guide'),
		array('language' => '[a-z]{2}')
	);


/**
 * Sitemap
 */
Router::connect('/sitemap', array('controller' => 'sitemaps', 'action' => 'sitemap'));


// Admin Routing
	Router::connect(
		'/:language/admin',
		array('controller' => 'admins', 'action' => 'index', 'admin' => true),
		array('language' => '[a-z]{2}')
	);
	Router::connect(
		'/:language/admin/:controller/:action/*',
		array('admin' => true),
		array('language' => '[a-z]{2}')
	);

/**
 * Support
 */
Router::connect(
    '/:language/support', array('controller' => 'contacts', 'action' => 'index'), array('language' => '[a-z]{2}')
);
Router::connect(
    '/:language/support/contact', array('controller' => 'contacts', 'action' => 'form'), array('language' => '[a-z]{2}')
);
Router::connect(
    '/:language/support', array('controller' => 'contacts', 'action' => 'index'), array('language' => '[a-z]{2}')
);
Router::connect(
    '/fr/support/pamphlet', array('controller' => 'contacts', 'action' => 'flyers', 'language' => 'fr')
);
Router::connect(
    '/en/support/flyers', array('controller' => 'contacts', 'action' => 'flyers', 'language' => 'en')
);
Router::connect(
    '/:language/support/contact', array('controller' => 'contacts', 'action' => 'index'), array('language' => '[a-z]{2}')
);

/**
 * Owner add your restaurant to topmenu
 */
Router::connect(
    '/en/support/restaurant-owner-add-your-restaurant', array('controller' => 'restaurants', 'action' => 'add_restaurant', 'language' => 'en')
);
Router::connect(
    '/fr/support/proprio-ajoutez-votre-restaurant', array('controller' => 'restaurants', 'action' => 'add_restaurant', 'language' => 'fr')
);
Router::redirect(
    '/fr/restaurant/ajouter', array('controller' => 'restaurants', 'action' => 'add_restaurant', 'language' => 'fr'), array('status' => 301));
Router::redirect(
    '/en/restaurant/ajouter', array('controller' => 'restaurants', 'action' => 'add_restaurant', 'language' => 'en'), array('status' => 301));

/**
 * Old stuff I dont know if we should keep
 */
Router::connect(
    '/:language/contact', array('controller' => 'contacts', 'action' => 'index'), array('language' => '[a-z]{2}')
);

Router::connect(
    '/:language/support/contact/confirmation', array('controller' => 'contacts', 'action' => 'confirmation'), array('language' => '[a-z]{2}')
);

Router::connect(
		'/:language/legals',
		array('controller' => 'pages', 'action' => 'terms'),
		array('language' => '[a-z]{2}')
	);

/**
 * Policies index
 */
Router::connect(
    '/fr/termes-legaux', array('controller' => 'pages', 'action' => 'display', 'terms', 'language' => 'fr')
);
Router::connect(
    '/en/policies', array('controller' => 'pages', 'action' => 'display', 'terms', 'language' => 'en')
);
Router::redirect(
    '/fr/policies', array('controller' => 'pages', 'action' => 'display', 'terms', 'language' => 'fr'), array('status' => 301));

Router::redirect(
    '/en/termes-legaux', array('controller' => 'pages', 'action' => 'display', 'terms', 'language' => 'en'), array('status' => 301));

/**
 * Privacy
 */
Router::connect(
    '/fr/termes-legaux/politique-confidentialite', array('controller' => 'pages', 'action' => 'confidentiality', 'language' => 'fr')
);
Router::redirect(
    '/en/termes-legaux/politique-confidentialite', array('controller' => 'pages', 'action' => 'confidentiality', 'language' => 'en')
);
Router::redirect(
    '/fr/policies/privacy', array('controller' => 'pages', 'action' => 'confidentiality', 'language' => 'fr')
);
Router::connect(
    '/en/policies/privacy', array('controller' => 'pages', 'action' => 'confidentiality', 'language' => 'en')
);
Router::redirect('/fr/politique-confidentialité', array('controller' => 'pages', 'action' => 'confidentiality', 'language' => 'fr'), array('status' => 301));
Router::redirect('/en/politique-confidentialité', array('controller' => 'pages', 'action' => 'confidentiality', 'language' => 'en'), array('status' => 301));

/**
 * Usage conditions
 */
Router::connect(
    '/fr/termes-legaux/conditions', array('controller' => 'pages', 'action' => 'terms_conditions', 'language' => 'fr')
);
Router::redirect(
    '/fr/policies/terms', array('controller' => 'pages', 'action' => 'confidentiality', 'language' => 'fr')
);
Router::redirect(
    '/en/termes-legaux/conditions', array('controller' => 'pages', 'action' => 'confidentiality', 'language' => 'en')
);
Router::connect(
    '/en/policies/terms', array('controller' => 'pages', 'action' => 'terms_conditions', 'language' => 'en')
);
Router::redirect('/fr/conditions-generales', array('controller' => 'pages', 'action' => 'confidentiality', 'language' => 'fr'), array('status' => 301));
Router::redirect('/en/conditions-generales', array('controller' => 'pages', 'action' => 'confidentiality', 'language' => 'en'), array('status' => 301));

/**
 * Coupon condition
 */
Router::connect(
    '/fr/termes-legaux/coupons', array('controller' => 'pages', 'action' => 'coupons_legal', 'language' => 'fr')
);
Router::connect(
    '/en/policies/coupons', array('controller' => 'pages', 'action' => 'coupons_legal', 'language' => 'en')
);
Router::redirect(
    '/en/termes-legaux/coupons', array('controller' => 'pages', 'action' => 'coupons_legal', 'language' => 'en')
);
Router::redirect(
    '/fr/policies/coupons', array('controller' => 'pages', 'action' => 'coupons_legal', 'language' => 'fr')
);
Router::redirect('/fr/conditions-coupons', array('controller' => 'pages', 'action' => 'confidentiality', 'language' => 'fr'), array('status' => 301));
Router::redirect('/en/conditions-coupons', array('controller' => 'pages', 'action' => 'confidentiality', 'language' => 'en'), array('status' => 301));

Router::connect(
		'/:language/contact/non_recu',
		array('controller' => 'contacts', 'action' => 'did_not_receive_print'),
		array('language' => '[a-z]{2}')
	);
    
	
/**
 * Login
 */
Router::connect(
    '/fr/connexion/:success', array('controller' => 'users', 'action' => 'login', 'language' => 'fr'), array(
    'pass' => array('success')));
Router::connect(
    '/en/login/:success', array('controller' => 'users', 'action' => 'login', 'language' => 'en'), array(
    'pass' => array('success')));
Router::connect(
    '/fr/connexion/*', array('controller' => 'users', 'action' => 'login', 'language' => 'fr'));
Router::connect(
    '/en/login/*', array('controller' => 'users', 'action' => 'login', 'language' => 'en'));
Router::connect(
    '/:language/connexion/*', array('controller' => 'users', 'action' => 'login'), array(
    'language' => '[a-z]{2}'));
Router::redirect(
    '/en/connexion/*', array('language' => 'en', 'controller' => 'pages', 'action' => 'login', 'language' => 'en'), array('status' => 301));

// Backwards compatible login link (SEO)
	Router::connect(
		'/:language/login/:success',
		array('controller' => 'users', 'action' => 'login'),
		array(
			'pass' => array('success'), 
			'language' => '[a-z]{2}')
	);
	// Backwards compatible login link (SEO)
	Router::connect(
		'/:language/login/*',
		array('controller' => 'users', 'action' => 'login'),
		array(
			'language' => '[a-z]{2}')
	);


	Router::connect(
		'/:language/deconnexion',
		array('controller' => 'users', 'action' => 'logout'),
		array('language' => '[a-z]{2}')
	);


	Router::connect(
		'/:language/enregistrer/:success',
		array('controller' => 'users', 'action' => 'register',),
		array(
			'pass' => array('success'), 
			'language' => '[a-z]{2}')
	);

	// Backwards compatible register link (SEO)
	Router::connect(
		'/:language/register/:success',
		array('controller' => 'users', 'action' => 'register'),
		array(
			'pass' => array('success'), 
			'language' => '[a-z]{2}')
	);

/* Register */
Router::connect(
    '/fr/enregistrer', array('controller' => 'users', 'action' => 'register', 'language' => 'fr')
);

Router::connect(
    '/en/enregistrer', array('controller' => 'users', 'action' => 'register', 'language' => 'en')
);

/* Passwords */
Router::connect(
		'/:language/activer/*',
		array('controller' => 'users', 'action' => 'activate'),
		array('language' => '[a-z]{2}')
	);

	Router::connect(
		'/:language/mot-de-passe-oublie/confirmer',
		array('controller' => 'users', 'action' => 'forgot_confirm'),
		array('language' => '[a-z]{2}')
	);

	Router::connect(
		'/:language/mot-de-passe-oublie/*',
		array('controller' => 'users', 'action' => 'change_forgotten_password'),
		array('language' => '[a-z]{2}')
	);

	Router::connect(
		'/:language/changer-mot-de-passe',
		array('controller' => 'users', 'action' => 'change_password'),
		array('language' => '[a-z]{2}')
	);

	Router::connect(
		'/:language/ssl_error',
		array('controller' => 'pages', 'action' => 'display', 'ssl_error'),
		array('language' => '[a-z]{2}')
	);

	// My Account
	Router::connect(
		'/fr/mon-compte',
		array('controller' => 'users', 'action' => 'my_account'),
		array('language' => '[a-z]{2}')
	);	
	Router::connect(
		'/fr/mon-compte',
		array('controller' => 'users', 'action' => 'my_account', 'language' => 'fr'),
		array('language' => '[a-z]{2}')
	);	
	Router::connect(
		'/en/my_account',
		array('controller' => 'users', 'action' => 'my_account', 'language' => 'en'),
		array('language' => '[a-z]{2}')
	);

	Router::connect(
		'/:language/mon-compte/modifier',
		array('controller' => 'profiles', 'action' => 'edit'),
		array('language' => '[a-z]{2}')
	);
	
	// Delivery addresses
	
	Router::connect(
		'/:language/adresse-de-livraison/choisir',
		array(
			'controller' => 'deliveryAddresses',
			'action' => 'choose'),
		array('language' => '[a-z]{2}')
	);
	
	Router::connect(
		'/:language/adresse-de-livraison/ajouter/:success',
		array(
			'controller' => 'deliveryAddresses',
			'action' => 'user_add'),
		array(
			'pass' => array('menu'), 
			'language' => '[a-z]{2}')
	);
		
	Router::connect(
		'/:language/adresse-de-livraison/ajouter',
		array(
			'controller' => 'deliveryAddresses',
			'action' => 'user_add'),
		array(
			'pass' => array('menu'), 
			'language' => '[a-z]{2}')
	);
	
	Router::connect(
		'/:language/adresse-de-livraison/supression/*',
		array(
			'controller' => 'deliveryAddresses',
			'action' => 'delete_confirm'),
		array(
			'pass' => array('menu'), 
			'language' => '[a-z]{2}')
	);
	
	Router::connect(
		'/:language/adresse-de-livraison/edition/*',
		array(
			'controller' => 'deliveryAddresses',
			'action' => 'user_edit'),
		array(
			'pass' => array('menu'), 
			'language' => '[a-z]{2}')
	);
	
	Router::connect(
		'/:language/deliveryAddresses/display_one_address/*',
		array(
			'controller' => 'delivery_addresses',
			'action' => 'display_one_address'),
		array('language' => '[a-z]{2}')
	);
	
	Router::connect(
		'/:language/deliveryAddresses/change_delivery_address_in_session/*',
		array(
			'controller' => 'delivery_addresses',
			'action' => 'change_delivery_address_in_session'),
		array('language' => '[a-z]{2}')
	);
	
	Router::connect(
		'/:language/confirme_adresse_livraison/*',
		array('controller' => 'delivery_addresses', 'action' => 'confirm'),
		array('language' => '[a-z]{2}')
	);	
	
	Router::connect(
		'/:language/adresse_facturation/*',
		array('controller' => 'delivery_addresses', 'action' => 'confirm_billing_address'),
		array('language' => '[a-z]{2}')
	);	
		
	Router::connect(
		'/:language/adresse-de-livraison/:action/*',
		array('controller' => 'delivery_addresses'),
		array('language' => '[a-z]{2}')
	);	

/**
 * Restaurant pages
 */
Router::connect('/:language/restaurant', 
    array('controller' => 'locations','action'  => 'search'), 
    array('language' => '[a-z]{2}'));
    

// Old links without secotrl slug	
Router::connect(
    '/:language/restaurant/:location', 
    array(
        'controller' => 'locations',
        'action'     => 'view'), 
    array(
        'pass'     => array('location'),
        'language' => '[a-z]{2}')
);

// restaurant with sector slug
Router::connect(
    '/:language/restaurant/:sector/:location', array(
    'controller' => 'locations',
    'action'     => 'view'), array(
    'pass'     => array('sector', 'location'),
    'language' => '[a-z]{2}')
);

Router::connect(
	'/:language/restaurant/:sector/:location/:distance', 
	array(
		'controller' => 'locations',
		'action' => 'view'), 
	array(
		'pass' => array('sector', 'location', 'distance'),
		'language' => '[a-z]{2}'));	


  
  
Router::connect(
          '/:language/delete_order_or_continue/*',
          array(
              'controller' => 'locations',
              'action' => 'delete_order_confirmation'),
          array(
              'language' => '[a-z]{2}')
          );
  
  
  // Rating
  Router::connect(
          '/:language/evaluation/ajouter-evaluation/*',
          array(
              'controller' => 'ratings',
              'action' => 'add_rating'),
          array(
              'language' => '[a-z]{2}')
          );
          
  

    // Gallery
	Router::connect(
        '/:language/gallery/:gallery', 
		array('controller' => 'locationGalleries', 'action' => 'view'),		
		array('pass' => array('gallery'), 'language' => '[a-z]{2}')
	);
  


	// Menus
  
    Router::connect(
        '/:language/ajouter-article/:item',
        array(
            'controller' => 'menuItems',
            'action' => 'menu_item_modal'),            
        array(
            'pass' => array('item'),
            'language' => '[a-z]{2}'
            )
        );

	// Tip
    Router::connect(
        '/:language/tip_options/add_to_order/*', 
        array(
            'controller' => 'tipOptions', 
            'action' => 'add_to_order'),
        array(
            'language' => '[a-z]{2}'));
    

	// Menu Items

    Router::connect(
        '/:language/menu_items/add_to_order/*', 
        array(
            'controller' => 'menuItems', 
            'action' => 'add_to_order'),
		array('language' => '[a-z]{2}'));

	Router::connect(
	'/:language/item_options/*', 
	array(
		'controller' => 'menuItems', 
		'action' => 'options_modal'),
	array('language' => '[a-z]{2}'));

	Router::connect(
	'/:language/item_image/*', 
	array(
		'controller' => 'menuItems', 
		'action' => 'show_image'),
	array('language' => '[a-z]{2}'));
		
	// Payments
	Router::connect(
        '/:language/paiements/info',
        array(
            'controller' => 'payments', 
            'action' => 'billing_info'),
        array('language' => '[a-z]{2}'));    
	
	Router::connect(
        '/:language/paiements/info/*',
        array(
            'controller' => 'payments', 
            'action' => 'billing_info'),
        array('language' => '[a-z]{2}'));    

    Router::connect(
        '/:language/paiements/check_db/*',
        array(
            'controller' => 'payments', 
            'action' => 'check_db'),
        array(
            'language' => '[a-z]{2}'));

    Router::connect(
        '/:language/paiements/approuve/*',
        array(
            'controller' => 'payments', 
            'action' => 'approved'),
        array(
            'language' => '[a-z]{2}'));

    Router::connect(
        '/:language/paiements/rejete/*',
        array(
            'controller' => 'payments', 
            'action' => 'rejected'),
        array(
            'language' => '[a-z]{2}'));

    Router::connect(
        '/:language/paiements/traitement/*',
        array(
            'controller' => 'payments', 
            'action' => 'processing'),
        array(
            'language' => '[a-z]{2}'));
	
	


    Router::connect(
		'/:language/ratings/user_add/*',
		array('controller' => 'ratings','action' => 'user_add'),        
		array('language' => '[a-z]{2}')
	);
    
    Router::connect(
		'/:language/info/:info',
		array('controller' => 'locations','action' => 'info'),
		array('pass' => array('info'),'language' => '[a-z]{2}')
	);
    
    Router::connect(
		'/:language/locations/set_order_type/:type/:locationUrl/:locationId',
		array('controller' => 'locations','action' => 'set_order_type'),
		array('pass' => array('type', 'locationUrl', 'locationId'),'language' => '[a-z]{2}')
	);

	
	
	// Orders
	Router::connect(
		'/:language/commande',
		array('controller' => 'orders', 'action' => 'checkout'),
		array('language' => '[a-z]{2}'));
	

	Router::connect(
		'/:language/commande/:type',
		array('controller' => 'orders', 'action' => 'checkout'),
		array('language' => '[a-z]{2}', 'type' => '[a-z]+'));
	
	Router::connect(
		'/:language/allez_paiement',
		array('controller' => 'orders', 'action' => 'proceed_to_payment'),
		array('language' => '[a-z]{2}'));
	
	Router::connect(
		'/:language/future_time_form',
		array('controller' => 'orders', 'action' => 'future_time_form'),
		array('language' => '[a-z]{2}'));
	
	Router::connect(
		'/:language/platform_checkout',
		array('controller' => 'orders', 'action' => 'platform_checkout'),
		array('language' => '[a-z]{2}'));	
	
	Router::connect(
		'/:language/update_checkout',
		array('controller' => 'orders', 'action' => 'update_checkout'),
		array('language' => '[a-z]{2}'));	
	
	Router::connect(
		'/:language/appliquer_coupons/*',
		array('controller' => 'orders', 'action' => 'apply_coupon'),
		array('language' => '[a-z]{2}'));	

	// PDF Menus
        
    Router::connect(
        '/:language/menu/:pdf_id', 
        array(
            'controller' => 'pdfs',
            'action'     => 'get_pdf'), 
        array(
            'pass'     => array('pdf_id'),
            'language' => '[a-z]{2}'));
        
	Router::connect(
		'/menu/:pdf_id',
		array(
			'controller' => 'pdfs',
			'action' => 'get_pdf',
		),
		array(
			'pass' => array('pdf_id')
		)
	);	
    
	Router::connect(
		'/menu_inline/:pdf_id',
		array(
			'controller' => 'pdfs',
			'action' => 'render_pdf',
		),
		array(
			'pass' => array('pdf_id')
		)
	);
    
    // Images
    Router::connect(
		'/image/:size/:id',
		array(
			'controller' => 'images',
			'action' => 'get_image',
		),
		array(
			'pass' => array('size', 'id')
		)
	);
	
    // Images
    Router::connect(
		'/image/:size/:id/:slug',
		array(
			'controller' => 'images',
			'action' => 'get_image',
		),
		array(
			'pass' => array('size', 'id', 'slug')
		)
	);

	// Old Redirect stuff
    
	Router::connect(
		'/:language/restaurants/restaurant/:old_url',
		array(
			'controller' => 'redirects',
			'action' => 'location_redirect',
		),
		array(
			'pass' => array('old_url'),
			'language' => '[a-z]{2}'
		)
	);
	Router::connect(
		'/restaurants/restaurant/:old_url',
		array(
			'controller' => 'redirects',
			'action' => 'location_redirect',
		),
		array(
			'pass' => array('old_url')
		)
	);
	
	/**
	 * Old pdf redirection
	 */
	Router::connect(
		'/media/:old_url',
		array(
			'controller' => 'redirects',
			'action' => 'location_redirect',
		),
		array(
			'pass' => array('old_url'),
		)
	);

	Router::connect(
		'/:language/delivery/restaurants/*',
		array(
			'controller' => 'redirects',
			'action' => 'home_redirect',
		),
		array(
			'pass' => array('language'),
			'language' => '[a-z]{2}'
		)
	);

/**
 * Sectors searches
 */
    
// full sector list
Router::connect(
    '/fr/secteurs', array('controller' => 'sectors', 'action' => 'view', 'language' => 'fr'));
Router::connect(
    '/en/area', array('controller' => 'sectors', 'action' => 'view', 'language' => 'en'));

// truncated alphebetically sector list 
Router::connect(
    '/fr/secteurs/:start/:end', array('controller' => 'sectors', 'action' => 'view', 'language' => 'fr'), array('pass' => array('start', 'end')));
Router::connect(
    '/en/area/:start/:end', array('controller' => 'sectors', 'action' => 'view', 'language' => 'en'), array('pass' => array('start', 'end')));

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	Router::connect(
		'/:language/pages/*',
		array(
			'controller' => 'pages',
			'action' => 'display'
		),
		array('language' => '[a-z]{2}')
	);

/**
 * JSON Extension
 */
	Router::parseExtensions('json', 'xml', 'csv', 'fr', 'en', 'pdf', 'png', 'jpg', 'jpeg');

/**
 * Load all plugin routes.  See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
	
	
	
//
