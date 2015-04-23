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
App::uses('CakeEmail', 'Network/Email');
App::uses('BcryptFormAuthenticate', 'Controller/Component/Auth');

/**
 * UsersController class.
 *
 * @extends AppController
 */
class UsersController extends AppController {

	/**
	 * uses
	 *
	 * (default value: array('User','Country', 'ForgottenPassword'))
	 *
	 * @var string
	 * @access public
	 */
    public $uses = array('User', 'Country', 'Order', 'Profile', 'Province');


	/**
	 * helpers
	 *
	 * @var mixed
	 * @access public
	 */
	public $helpers = array(
		'Calendar' => array(
			'date_format' => '%Y-%m-%d %H:%i:%s',
			'hide_time'   => false
		)
            
	);

	/**
	 * components
	 *
	 * @var mixed
	 * @access public
	 */
	public $components = array(
        'RequestHandler',
        'Paginator',
        'Image',
        'UserAccount'
	   // 'Ip'
	);

	/**
	 * paginate
	 *
	 * @var mixed
	 * @access public
	 */
	public $paginate = array(
        'limit' => 25,
    );
	

	/**
	 * beforeFilter function.
	 *
	 * @access public
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow(
			'login',
			'logout',
			'register',
			'thanks',
			'activate',
			'forgot_confirm',
			'forgot_password',
			'change_forgotten_password'
		);
		$redirect = array(
//			'login',
			'register',
			'thanks',
			'activate',
			'forgot_confirm',
			'forgot_password'
		);
		foreach ($redirect as $action) {
			if ($action == $this->request->action) {
				if ($this->Auth->user('id')) {
					$this->redirect('/');
				}
			}
		}
        
        switch ($this->request->action) {
            case 'autoCompleteUserBox':
                $this->Security->csrfCheck    = FALSE;
                $this->Security->validatePost = FALSE;
                break;
        }
		
//		// Set where to redirect on login and register		
//		$end = end((explode('/', $this->referer())));			// check if refer is login or register
//		switch ($end) {
//			case 'login':
//			case 'connexion':
//			case 'enregistrement':
//			case 'register':
//				break;
//
//			default:
//				$this->Session->write('loginRedirect' ,$this->referer());
//				break;			
//		}				
	}


	/**
	 * _get_countries function.
	 *
	 * @access private
	 * @return void
	 */
	private function _get_countries() {
		return $this->Country->get_countries();
	}


	/**
	 * register function.
	 *
	 * @param string $sucsess page to redirect to on successful submission
	 * 
	 * @access public
	 * @return void
	 */
	public function register($success = 'register') {
		$this->set('title_for_layout', __(' Register for an account'));
		 $this->Session->write('newRegistration', TRUE);
		$this->__checkRegistration();	

		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['User']['group_id'] = 5;
			$this->request->data['Profile']['language'] = Configure::read('Config.language');

            // trim the email, last name, first name and phone before saving the user
            $this->request->data['User']['email']         = trim($this->request->data['User']['email']);
            $this->request->data['Profile']['first_name'] = trim($this->request->data['Profile']['first_name']);
            $this->request->data['Profile']['last_name']  = trim($this->request->data['Profile']['last_name']);

			if ($this->User->saveAll($this->request->data) ) {

				$this->Session->setFlash(__('You have been registered! Plase enter your delivery address.'), 'default', array('class' => 'flash_success'));
				$this->activateNoConfirmation($this->User->id);
				$this->User->login($this->request, $this->Auth, $this->hasValidCert);
					
				// pass the "Auth.redirect" value to the delivery address page
				if($this->Session->check('Auth.redirect')){
					$this->Session->write('loginRedirect', $this->Session->read('Auth.redirect'));
				}
				
				$this->redirect(array(
					'controller' => 'delivery_addresses', 
					'action' => 'user_add',
					$success));

			} else {
				$this->Session->setFlash(__('Registration Failed! Please check your information and try again.'));
			}			
		}
	}



	/**
	 * change_password function.
	 *
	 * @access public
	 * @return void
	 */
	public function change_password() {
		$this->User->id = $this->Auth->user('id');
		$this->set('title_for_layout', __(' Change your password'));
		if ($this->request->is('post')) {
			if ($this->User->change_password($this->request->data)) {
				$this->Session->setFlash(
					__('Password changed successfully!'),
					'default',
					array(
						'class' => 'flash_success'
					)
				);
				$this->set('changedPassword', TRUE);
				$this->redirect($this->Auth->redirectUrl());
			} else {
				$this->Session->setFlash(__('There was a problem changing your password...'));
			}
		}
	}



	/**
	 * login function.
	 *
	 * @access public
	 * @return void
	 */
	public function login($success = NULL) {
						
		$this->set('title_for_layout', __(' Login'));
		$this->set('successPage', $success);
		if ($this->request->is('post')) {

	    	if ($this->User->login($this->request, $this->Auth, $this->hasValidCert)) {
				$this->Profile->id = $this->User->id;	
                
				// check if this user as ordered before
//				$this->Session->write('Auth.User.isCustomer', $this->User->isCustomer($this->User->id));				
				$this->Session->write('Auth.User.isCustomer', true);
                
                // users name
				$this->Session->write('Auth.Profile.name', $this->Profile->field('name'));
				$this->Session->write('Auth.Profile.first_name', $this->Profile->field('first_name'));
				$this->Session->write('Auth.Profile.last_name', $this->Profile->field('last_name'));
                
                // Store user birthday in session
				$dateObirth = strtotime($this->Profile->field('date_of_birth'));
				$this->Session->write('Auth.Profile.date_of_birth.year', date('Y', $dateObirth));
				$this->Session->write('Auth.Profile.date_of_birth.month', date('m', $dateObirth));
				$this->Session->write('Auth.Profile.date_of_birth.day', date('d', $dateObirth));
				
                $this->Session->write('justSignIn', true); // Deprecated?                                                
                                
                // keep track of accounts use in this browser (cookie)
                $this->UserAccount->setAccountCookie($this->User->id);                
                if($this->UserAccount->isFraudulentBrowser()){
                    $this->User->set('fraudulent', true);
                    $this->User->save();
                }else{
                    $this->User->set('fraudulent', false);
                    $this->User->save();
                }
                $this->Session->write('Auth.User.isFraudulent', $this->User->field('fraudulent'));
                                
                // Success mesasge
	    		$this->Session->setFlash(
		    		__('Logged in successfully!'), 'flash_success');
				
				$this->_setDeliveryAdressInSession();
				
				$this->_loginRedirect($success);
				    		
	    	}
			$this->Session->setFlash($this->User->error, 'flash_danger');
	    }		
	}

	/**
	 * logout function.
	 *
	 * @access public
	 * @return void
	 */
	public function logout() {
		$this->Session->setFlash(
			__('Logged out successfully!'),
			'flash_success'
		);
		$last_language = $this->Session->read('Config.language');
		session_destroy();
		$this->Session->write('Config.language', $last_language);
	    $this->redirect($this->Auth->logout());
	}



	/**
	 * activate function.
	 *
	 * @access public
	 * @param mixed $user_id (default: null)
	 * @param mixed $in_hash (default: null)
	 * @return void
	 */
	public function activate($user_id = null, $in_hash = null) {
		$this->__checkRegistration();
		$this->User->id = $user_id;
		$this->set('title_for_layout', __(' Activate your account'));
		if ($this->User->exists() && ($in_hash == $this->User->getActivationHash())) {
			if (!$this->User->isActive()) {
				// Update the active flag in the database
				if ($this->User->saveField('is_active', 1)) {
					// Let the user know they can now log in!}
					$this->User->sendWelcomeEmail($user_id);
					$this->Session->setFlash(
						'Your account has been activated, please log in below',
						'default',
						array('class' => 'flash_success')
					);
					$this->redirect(
						array(
							'controller' => 'users',
							'action'     => 'login'
						)
					);
				}


		 		$this->Session->setFlash(__('There was a problem activating your account. Please contact Customer Support'));
		 		$this->redirect(
			 		array(
						'controller' => 'homes',
						'action'     => 'index'
			 		)
		 		);


			} else {
				$this->Session->setFlash(__('That account has already been activated…'));
				$this->redirect(
					array(
						'controller' => 'homes',
						'action'     => 'index'
					)
				);
			}
		} elseif ($user_id == "resend") {
			$this->User->id = $in_hash;
			if ($this->User->exists() && !$this->User->isActive()) {
				$this->User->sendActivationEmail($this->User->id);
				$this->Session->setFlash(
					__('Activation link resent, please check your mail.'),
					'default',
					array(
						'class' => 'flash_success'
					)
				);
				$this->view = 'resent';
			}
		} elseif (!empty($user_id)) {

		} else {
			$this->Session->setFlash(__('Sorry, that seems to be an invalid link…'));
		}

		// Activation failed, render '/views/user/activate.ctp' which should tell the user.
		$this->set('usrId', $user_id);
		$this->Session->delete('Message.flash');
	}



	/**
	 * activate function.
	 *
	 * @access public
	 * @param mixed $user_id (default: null)
	 * @param mixed $in_hash (default: null)
	 * @return void
	 */
	private function activateNoConfirmation($user_id = null) {
		$this->__checkRegistration();
		$this->User->id = $user_id;
		if ($this->User->exists()) {
			if (!$this->User->isActive()) {
				// Update the active flag in the database
				if ($this->User->saveField('is_active', 1)) {
					// Let the user know they can now log in!}
					$this->User->sendWelcomeEmail($user_id);	
					return true;
				}
			


		 		$this->Session->setFlash(__('There was a problem activating your account. Please contact Customer Support'));
		 		$this->redirect(
			 		array(
						'controller' => 'homes',
						'action'     => 'index'
			 		)
		 		);


			} else {
				$this->Session->setFlash(__('That account has already been activated…'));
				$this->redirect(
					array(
						'controller' => 'homes',
						'action'     => 'index'
					)
				);
			}
		} elseif ($user_id == "resend") {
			$this->User->id = $in_hash;
			if ($this->User->exists() && !$this->User->isActive()) {
				$this->User->sendActivationEmail($this->User->id);
				$this->Session->setFlash(
					__('Activation link resent, please check your mail.'),
					'default',
					array(
						'class' => 'flash_success'
					)
				);
				$this->view = 'resent';
			}
		} elseif (!empty($user_id)) {

		} else {
			$this->Session->setFlash(__('Sorry, that seems to be an invalid link…'));
		}

		// Activation failed, render '/views/user/activate.ctp' which should tell the user.
		$this->set('usrId', $user_id);
		$this->Session->delete('Message.flash');
	}



	/**
	 * thanks function.
	 *
	 * @access public
	 * @return void
	 */
	public function thanks() {
		$this->set('title_for_layout', __(' Thanks!'));
		return true;
	}



	/**
	 * forgot_confirm function.
	 *
	 * @access public
	 * @return void
	 */
	public function forgot_confirm() {
		$this->set('title_for_layout', __(' Forgot Password'));
		return true;
	}



	/**
	 * forgot_password function.
	 *
	 * @access public
	 * @param mixed $id (default: null)
	 * @param mixed $hash (default: null)
	 * @return void
	 */
	public function forgot_password($id = null, $hash = null) {
		$this->set('title_for_layout', __(' Forgot Password'));
		$this->set('modal_id', sha1(microtime()));
		if ($this->request->is('post') && !$id && !$hash) {
			$this->User->set($this->request->data);
			if ($this->User->validates()) {
				$result = $this->User->find('first', array(
					'conditions' => array(
						'User.email' => $this->request->data['User']['forgot_email']
					),
					'fields' => array(
						'User.id'
					)
				));
				if (empty($result)) {
					$this->Session->setFlash(__('There was a problem, please check your information and try again.'));
					return false;
				}
				$oldHash = $this->User->ForgottenPassword->currentHash($result['User']['id']);
				if (!$oldHash) {
					$hash = $this->User->ForgottenPassword->create_hash($result['User']['id']);
				} else {
					$hash = $oldHash;
				}
				if ($hash) {
					$data            = array();
					$data['hash']    = $hash;
					$data['user_id'] = $result['User']['id'];
					$data['created'] = date('Y-m-d H:i:s');
					if (!$oldHash) {
						$save = $this->User->ForgottenPassword->save($data);
					} else {
						$save = false;
					}
					if ($save || $oldHash) {
						$this->User->forgotPasswordMail($data['user_id'], $data['hash'], $data['created'], $this->is_mobile);
						unset($data);
						$this->Session->setFlash(
							__('We have emailed you a link to reset your password.'),
							'default',
							array(
								'class' => 'flash_success'
							)
						);
						$this->redirect(array(
							'controller' => 'users',
							'action'     => 'forgot_confirm',
							'admin'      => false
						));
					}
				} else {
					$this->Session->setFlash(__('There was a problem, please check your information and try again.'));
				}
			} else {
				$this->Session->setFlash(__('There was a problem, please check your information and try again.'));
			}
		} elseif ($id && $hash) {
			
			//They have a hash, let's try to validate it.
			$this->User->id = $id;
			if ($this->User->exists()) {
				$otp = $this->User->ForgottenPassword->validate_hash($id, $hash);
				if ($otp) {
				 	$this->Session->setFlash(__('Almost Done!'), 'default', array('class' => 'flash_success'));
				 	$this->view = 'change_forgotten_password';
					if ($this->request->is('post')) {
				 		$this->User->id = $id;
				 		$this->User->set($this->request->data);
				 		if ($this->User->save()) {
				 			if ($this->User->ForgottenPassword->delete($otp['ForgottenPassword']['id'])) {
				 				$this->User->removeOldHashAndSalt($id);
				 				$this->Session->setFlash(
					 				__('Password successfully reset! Please login bellow.'),
					 				'default',
					 				array(
						 				'class' => 'flash_success'
					 				)
				 				);
				 				$this->redirect(
					 				array(
										'controller' => 'users',
										'action'     => 'login',
										'admin'      => false
					 				)
				 				);
				 			} else {
				 				$this->Session->setFlash(__('Your password was changed, but an error occurred. Please contact a site administrator.'));
				 			}
				 		} else {
				 			$this->Session->setFlash(__('There was a problem changing your password…'));
				 		}
				 	}
				} else {
					$this->Session->setFlash(__('Invalid code...'));
					$this->redirect(
						array(
							'controller' => 'users',
							'action'     => 'forgot_password',
							'admin'      => false
						)
					);
				}
			} else {
				$this->Session->setFlash(__('Invalid code…'));
				$this->redirect(
					array(
						'controller' => 'users',
						'action'     => 'forgot_password',
						'admin'      => false
					)
				);
			}
		}
	}




	/**
	 * admin_login function.
	 *
	 * @access public
	 * @return void
	 */
	public function admin_login() {
		$this->render('login');
		if ($this->request->is('post')) {
		    if ($this->Auth->login()) {
		    	$this->Session->setFlash(
			    	__('Logged in successfully!'),
			    	'default',
			    	array(
				    	'class' => 'flash_success'
			    	)
		    	);
		        $this->redirect(
			        array(
						'controller' => 'users',
						'action'     => 'admin_index'
			        )
		        );
		    } else {
		        $this->Session->setFlash(__('Invalid username or password, try again'));
		    }
	    }
	}

	/**
	 * admin_logout function.
	 *
	 * @access public
	 * @return void
	 */
	public function admin_logout() {
	    $this->Session->delete('Auth.User');
	    $this->Session->setFlash(
		    __('Logged out successfully!'),
		    'default',
		    array(
			    'class' => 'flash_success'
		    )
	    );
        $this->redirect(
	        array(
				'controller' => 'homes',
				'action'     => 'index',
				'admin'      => false
	        )
        );
	}


	/**
	 * admin_index function.
	 *
	 * @access public
	 * @return void
	 */
	public function admin_index() {
		$this->User->recursive = 0;
		$query = null;
        if ($this->request->is('post')) {
            if (isset($this->request->data['Query']['search'])) {
                $this->Session->write('users.query', $this->request->data['Query']['search']);
            }
        }
        if ($this->Session->read('users.query')) {
            $query = $this->Session->read('users.query');
            $this->request->data['Query']['search'] = $query;
        }
        $conditions = array(
            'OR' => array(
				'User.email LIKE' => '%' . $query . '%',
				'Group.name LIKE' => '%' . $query . '%'
            )
        );

        $this->Paginator->settings = array(
            'conditions' => $conditions
        );
		$this->set('users', $this->paginate());
	}


	/**
	 * admin_view function.
	 *
	 * @access public
	 * @param mixed $id (default: null)
	 * @return void
	 */
	public function admin_view($id = null) {
		$this->User->recursive = 0;
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}


	/**
	 * admin_add function.
	 *
	 * @access public
	 * @return void
	 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'), 'default', array('class' => 'flash_success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}


	/**
	 * admin_edit function.
	 *
	 * @access public
	 * @param mixed $id (default: null)
	 * @return void
	 */
	public function admin_edit($id = null) {
		$this->User->id = $id;
		$this->User->recursive = 1;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if (empty($this->request->data['User']['password'])) {
				unset($this->request->data['User']['password']);
				unset($this->request->data['User']['password_confirm']);
			}
			if ($this->User->saveAll($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'), 'default', array('class' => 'flash_success'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
		$groups = $this->User->Group->find('list');
		$locations = $this->User->Location->find('list');
		$this->set(compact('groups', 'locations'));
	}


	/**
	 * admin_delete function.
	 *
	 * @access public
	 * @param mixed $id (default: null)
	 * @return void
	 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'), 'default', array('class' => 'flash_success'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
/**
 * User's profile page
 * @access public
 * @return void
 * @todo Enable sorting by total price in view (build query so the total field is calculated in query instead of in view)
 * 
 */
    public function my_account() {

        $this->loadModel('Rating');
        
        // ORDERS INFO
        $this->Order->recursive = 0;
		$this->Order->contain(array('OrderDetail', 'Location', 'Rating'));
		$fields = array('Order.id', 'Location.name', 'Order.total', 'Order.created','Order.overall_status', 'Order.coupon_discount', 'Rating.id');
        $this->Order->order = array('Order.date' => 'DESC');
		$this->Paginator->settings = array('fields' => $fields, 'order' => array('Order.id' => 'DESC'));
        $result = $this->Paginator->paginate('Order', array('Order.user_id = ' => $this->Auth->user('id')));
        
        $this->set('orders', $result);
    }

    public function index() {
        
    }

/**
 * Checks if registration is enabled, and if not redirects to root
 * and gives an error message
 * @return void
 */
	private function __checkRegistration() {
		if (!Configure::read('User.registration_enabled')) {
			$this->Session->setFlash(__('User registration is currently disabled. Please try again at a later time.'));
			$this->redirect('/');
		}
	}
	
	public function change_forgotten_password($id, $hash){
		if ($this->request->is('post') && !$id && !$hash) {
			$this->User->set($this->request->data);
			if ($this->User->validates()) {
				$result = $this->User->find('first', array(
					'conditions' => array(
						'User.email' => $this->request->data['User']['forgot_email']
					),
					'fields' => array(
						'User.id'
					)
				));
				if (empty($result)) {
					$this->Session->setFlash(__('There was a problem, please check your information and try again.'));
					return false;
				}
				$oldHash = $this->User->ForgottenPassword->currentHash($result['User']['id']);
				if (!$oldHash) {
					$hash = $this->User->ForgottenPassword->create_hash($result['User']['id']);
				} else {
					$hash = $oldHash;
				}
				if ($hash) {
					$data            = array();
					$data['hash']    = $hash;
					$data['user_id'] = $result['User']['id'];
					$data['created'] = date('Y-m-d H:i:s');
					if (!$oldHash) {
						$save = $this->User->ForgottenPassword->save($data);
					} else {
						$save = false;
					}
					if ($save || $oldHash) {
						$this->User->forgotPasswordMail($data['user_id'], $data['hash'], $data['created']);
						unset($data);
						$this->Session->setFlash(
							__('We have emailed you a link to reset your password.'),
							'default',
							array(
								'class' => 'flash_success'
							)
						);
						$this->redirect(array(
							'controller' => 'users',
							'action'     => 'forgot_confirm',
							'admin'      => false
						));
					}
				} else {
					$this->Session->setFlash(__('There was a problem, please check your information and try again.'));
				}
			} else {
				$this->Session->setFlash(__('There was a problem, please check your information and try again.'));
			}
		} elseif ($id && $hash) {
			
			//They have a hash, let's try to validate it.
			$this->User->id = $id;
			if ($this->User->exists()) {
				$otp = $this->User->ForgottenPassword->validate_hash($id, $hash);
				if ($otp) {
				 	$this->Session->setFlash(__('Almost Done!'), 'default', array('class' => 'flash_success'));
				 	$this->view = 'change_forgotten_password';
					if ($this->request->is('post')) {
				 		$this->User->id = $id;
				 		$this->User->set($this->request->data);
				 		if ($this->User->save()) {
				 			if ($this->User->ForgottenPassword->delete($otp['ForgottenPassword']['id'])) {
				 				$this->User->removeOldHashAndSalt($id);
				 				$this->Session->setFlash(
					 				__('Password successfully reset! Please login bellow.'),
					 				'default',
					 				array(
						 				'class' => 'flash_success'
					 				)
				 				);
				 				$this->redirect(
					 				array(
										'controller' => 'users',
										'action'     => 'login',
										'admin'      => false
					 				)
				 				);
				 			} else {
				 				$this->Session->setFlash(__('Your password was changed, but an error occurred. Please contact a site administrator.'));
				 			}
				 		} else {
				 			$this->Session->setFlash(__('There was a problem changing your password…'));
				 		}
				 	}
				} else {
					$this->Session->setFlash(__('Invalid code...'));
					$this->redirect(
						array(
							'controller' => 'users',
							'action'     => 'forgot_password',
							'admin'      => false
						)
					);
				}
			} else {
				$this->Session->setFlash(__('Invalid code…'));
				$this->redirect(
					array(
						'controller' => 'users',
						'action'     => 'forgot_password',
						'admin'      => false
					)
				);
			}
		}
	}
	
	/**
	 * Checks if a search query exist and tries to find a delivery address in the user's deliveryAddresses 
	 * that matches that search. If no matches are found then the last created delvieryAddress.
	 * Finally, if no delivery addresss are found an flashMessage ask the user to create one
	 */
	private function _setDeliveryAdressInSession(){

		// set the delivery address used as current delivery address
		$this->loadModel('DeliveryAddress');				
		$fields = array('DeliveryAddress.id', 
				'DeliveryAddress.name',
				'DeliveryAddress.door_code', 
				'DeliveryAddress.postal_code', 
				'DeliveryAddress.country', 
				'DeliveryAddress.province', 
				'DeliveryAddress.city', 
				'DeliveryAddress.address', 
				'DeliveryAddress.address2', 
				'DeliveryAddress.phone', 
				'DeliveryAddress.cross_street',
				'DeliveryAddress.inline_address');		
		$da = array();		// users delivery adress

		// Try to find a delivery address that match the postal code in the search field
		if ($this->Session->check('DeliveryDestination.postal_code')) {
			
			$pcString = $this->Session->read('DeliveryDestination.postal_code');
			$pcSearchString = (strlen($pcString) < 6) ? $pcString . '%' : $pcString;
			$da = $this->DeliveryAddress->find('first', array(
				'conditions' => array(
					'DeliveryAddress.postal_code LIKE' => $pcSearchString,
					'DeliveryAddress.user_id' => $this->User->id),
				'fields' => $fields));
		}
		
		// Get last created delivery address if previous attempt failed
		if (empty($da)) {
			
			$da = $this->DeliveryAddress->findByUserId($this->User->id, $fields);
		}

		// Set delivery address in session (or error message)
		if(empty($da)){
			$this->Session->setFlash(__('Please go to your account and create a delivery address before ordering'));
		}else{			
			$this->Session->write('DeliveryDestination', $da['DeliveryAddress']);
		}		
	}
	
	//todo put into a component
	private function _loginRedirect($success) {
		switch ($success) {
			case '':
			case NULL:
				// Go to intented page
				$this->redirect($this->Auth->redirectUrl());
				break;
			case 'register': // go to search page
				//$this->Session->setFlash(__('New delivery address saved'), 'default', array('class' => 'flash_success'));
				//todo rebuild search query page wit $this->_setSearchQuery($postalCode);
				$searchQuery = $this->Session->read('Search');
				if ($searchQuery) {
					$this->redirect(
						array(
							'controller' => 'locations',
							'action' => 'search',
							'session'));
				} else {

					// default landing page is: My Account
					$this->redirect(array('action' => 'my_account'));
				}

				break;

			case 'home':
				$this->redirect('/');
				break;

			case 'checkout': // go back to checkout page

				$this->redirect(array(
					'controller' => 'orders',
					'action' => 'checkout'));
				break;

			default:   // variable is the retaurant url, go back to that restaurant
				$this->loadModel('Location');
				$location = $this->Location->findByUrl($success);
				$this->redirect(
					array(
						'controller' => 'locations',
						'action' => 'view',
						'location' => $success,
						'sector' => $location['Location']['sector_slug']));

				break;
		}
	}
    
        /**
     * Returns a json object of the email, name and first name of user in the primary gold of populating autocomplete
     * input box
     */
    public function autoCompleteUserBox(){
        
        $this->autoRender = false;
        $this->layout = 'ajax';
        
        $term = $this->request->query('term');
                     
        $data = $this->User->find('all', array(
            'conditions' => array(
                'or' =>array(
                    array('User.email LIKE' => "%$term%"),
                    array('Profile.last_name LIKE' => "%$term%"),
                    array('Profile.first_name LIKE' => "%$term%"))),
            'fields' => array('User.id', 'User.email'), 
            'contain' => array('Profile.last_name', 'Profile.first_name')));
        $jsonData = array();
        $i = 0;
        foreach ($data as $key => $value) {
            $jsonData[$i]['id'] = $value['User']['id'];
            $jsonData[$i]['desc'] = $value['User']['email'] . " - " . strtoupper($value['Profile']['first_name']) . " " . strtoupper($value['Profile']['last_name']);
            $i++;
        }
        echo json_encode($jsonData );

    }
}