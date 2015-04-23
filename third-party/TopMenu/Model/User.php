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
 *@property User $User
 */
App::uses('AppModel', 'Model');
App::uses('BcryptFormAuthenticate', 'Controller/Component/Auth');
App::uses('SessionComponent', 'Controller/Component');
App::uses('ComponentCollection', 'Controller');
/**
 * User Model
 *
 * @property Lodge $Lodge
 * @property Group $Group
 * @property Profile $Profile
 * @property SupportTicketPost $SupportTicketPost
 */
class User extends AppModel {

	public $displayField = 'email';
/**
 * Language to set in  Config.language
 * @var string
 */
	public $language = 'en';

/**
 * Error message to be returned
 * @var string
 */
	public $error = "";


/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'email' => array(
			'notEmpty' => array(
				'rule'         => array('notEmpty'),
				'message'      => 'Email cannot be empty',
				//'allowEmpty' => false,
				//'required'   => false,
				//'last'       => false, // Stop validation after this rule
				//'on'         => 'create', // Limit validation to 'create' or 'update' operations
			),
			'email' => array(
				'rule' => 'email',
				'message' => 'Please enter a valid email address'
			),
			'isUnique' => array(
				'rule'    => 'isUnique',
				'message' => 'Username taken… Please try again.'
			)
		),
		'password_old' => array(
			'checkPass' => array(
				'rule'    => 'checkPassword',
				'message' => 'Password incorrect! Please try again.'
			)
		),
		'password' => array(
			'between' => array(
				'rule'    => array('between', 4, 25),
				'message' => 'Your password must be between 4 and 25 characters long.',
			),
			'strength' => array(
				'rule'    => 'ratePasswordStrength',
				'message' => 'Your password must score \'Average\' or better. Please use the password strength meter.',
			),
		),
		'password_confirm' => array(
			'notEmpty' => array(
				'rule'    => 'notEmpty',
				'message' => 'You must type your password again to confirm.'
			),
			'comparison' => array(
				'rule'    => 'comparePasswords',
				'message' => 'Passwords do not match!'
			)
		),
		'forgot_email' => array(
			'email' => array(
				'rule' => array('email', true),
				'message' => 'Please enter a valid email address…',
				'allowEmpty' => false
			),
			'emailExists' => array(
				'rule' => 'emailExists',
				'message' => 'I can\'t find that email address. Please enter the email address used when signing up.'
			),
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Group' => array(
			'className'  => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields'     => '',
			'order'      => ''
		)
	);

     /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'DeliveryAddresses' => array('foreignKey' => 'user_id'),
		'Order' => array('foreignKey' => 'user_id'));
        
        /**
         * hasOne assoications
         * @var type 
         */
	public $hasOne = array(
		'Profile' => array(
			'className'    => 'Profile',
			'foreignKey'   => 'id',
			'dependent'    => true,
			'conditions'   => '',
			'fields'       => '',
			'order'        => '',
			'limit'        => '',
			'offset'       => '',
			'exclusive'    => '',
			'finderQuery'  => '',
			'counterQuery' => ''
		),
		'ForgottenPassword'               
	);

/**
 * hasAndBelongsToMany association
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Location'
	);

/**
 * Acts As (What behaviors to load)
 * @var array
 */
	public $actsAs = array('Email', 'Containable');

	/**
	 * parentNode function.
	 *
	 * @access public
	 * @return void
	 */
	public function parentNode() {
		$return = null;

		if (isset($this->data['User']['group_id'])) {
			$groupId = $this->data['User']['group_id'];
		} elseif (isset($this->id)) {
			$groupId = $this->field('group_id');
		}
		if (isset($groupId) && $groupId) {
			$return = array(
				'Group' => array(
					'id' => $groupId
				)
			);
		}
		return $return;
	}
	/**
	 * bindNode function.
	 *
	 * @access public
	 * @param  mixed $user
	 * @return void
	 */
	public function bindNode($user) {
		$return = array();
		if (isset($user['User']['group_id'])) {
			$return = array(
				'model' => 'Group',
				'foreign_key' => $user['User']['group_id']
			);
		}
		return $return;
	}
	/**
	 * beforeSave function.
	 *
	 * @access public
	 * @return void
	 */
	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$salt = BcryptFormAuthenticate::generateSalt();
			$hash = BcryptFormAuthenticate::hash(
				$this->data[$this->alias]['password'],
				$salt
			);
			$this->data[$this->alias]['password'] = $hash;
			$this->data[$this->alias]['salt'] = $salt;
		}
		return true;
	}


/**
 * emailExists function.
 *
 * @access public
 * @param mixed $data
 * @return void
 */
	public function emailExists($data) {
		$count = $this->find('count', array(
					'conditions' => array(
						'User.email' => $data['forgot_email']
					)
				));
		if ($count) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 * comparePasswords function.
	 *
	 * @access public
	 * @return void
	 */
	public function comparePasswords() {
		if ($this->data['User']['password'] == $this->data['User']['password_confirm']) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 * checkPassword function.
	 *
	 * @access public
	 * @return void
	 */
	public function checkPassword() {
		$user_id = AuthComponent::user('id');
		$result = $this->find('first', array(
			'conditions' => array(
				'User.id' => $user_id,
			),
			'fields' => array(
				'User.email',
				'User.password'
			)
		));
		$return = false;
		if ($result) {
			$salt = $this->getSalt($result['User']['email']);
			$hash = BcryptFormAuthenticate::hash(
				$this->data['User']['password_old'],
				$salt
			);
			if ($result['User']['password'] == $hash) {
				$return = true;
			}
		}
		return $return;
	}


/**
 * Checks to see if a password is strong enough, validation rule
 * @param  string $password
 * @return boolean
 */
	public function ratePasswordStrength($password) {
		return $this->passwordStrength($password['password']) >= 30 ? true : false;
	}

/**
 * Scores a users chosen password and returns a percentage value
 * @param  string $password
 * @return float          ( points/total_points ) * 100
 */
	public function passwordStrength($password) {
		$score       = 0;
		$total       = 0;
		$occurrences = $this->getOccurrences($password);
		$length      = strlen($password);

	/**
	 * Password Length
	 * Worth: 10 Points
	 */
		if (
			$length    >= 3
			&& $length <= 4
		) {
			$score += 2;
		} else if (
			$length    >= 5
			&& $length <= 7
		) {
			$score += 5;
		} else if ($length >= 8) {
			$score += 10;
		}
		$total += 10;


/**
 * Types of Letters
 * Worth 5 Points
 */

		if (
			$occurrences['upper']    === 0
			&& $occurrences['lower'] !== 0
		) {
			$score += 3;
		} else if (
			$occurrences['upper']    !== 0
			&& $occurrences['lower'] === 0
		) {
			$score += 4;
		} else if (
			$occurrences['upper']    !== 0
			&& $occurrences['lower'] !== 0
		) {
			$score += 5;
		}
		$total += 5;

/**
 * Number Digits
 * Worth 5 Points
 */
		if (
			$occurrences['digits']    >= 1
			&& $occurrences['digits'] <= 3
		) {
			$score += 4;
		} else if ($occurrences['digits'] >= 4) {
			$score += 5;
		}
		$total += 5;

/**
 * Number of Symbols
 * Worth 5 Points
 */
		if ($occurrences['symbols'] >= 1) {
			$score += 4;
		} else if ($occurrences['symbols'] > 3) {
			$score += 5;
		}
		$total += 5;

/**
 * Is Alphanumeric
 * Worth 5 Points
 */
		if (
			$occurrences['digits']   !== 0
			&& $occurrences['mixed'] !== 0
		) {
			$score += 5;
		}
		$total += 5;

/**
 * Is Alphanumeric and contains special chars
 * Worth 5 Points
 */
		if (
			$occurrences['digits']     !== 0
			&& $occurrences['mixed']   !== 0
			&& $occurrences['symbols'] !== 0
		) {
			$score += 5;
		}
		$total += 5;
/**
 * is Alphanumeric, has special chars, and both upper and lower case letters
 * Worth 10 Points
 */
		if (
			$occurrences['digits']     !== 0
			&& $occurrences['upper']   !== 0
			&& $occurrences['lower']   !== 0
			&& $occurrences['symbols'] !== 0
		) {
			$score += 10;
		}
		$total += 10;

		return ($score / $total) * 100;
	}


/**
 * Gets number of occurrences in the password
 * @param  {string} password
 * @return {object}
 */
	private function getOccurrences($password) {
		$lookup = array(
			'upper'   => "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
			'lower'   => "abcdefghijklmnopqrstuvwxyz",
			'digits'  => "0123456789",
			'symbols' => "!@#$%^&*()_{}|[]\\;\'\",./<>?`~-=_+"
		);
		$occurrences = array(
			'upper'   => 0,
			'lower'   => 0,
			'mixed'   => 0,
			'digits'  => 0,
			'symbols' => 0
		);
		foreach ($lookup as $label => $checkStr) {
			for ($i = 0; $i < strlen($password); $i++) {
				$char = substr($password, $i, 1);
				if (strpos($checkStr, $char) > -1) {
						$occurrences[$label]++;
				}
			}
		}
		$occurrences['mixed'] = $occurrences['upper'] + $occurrences['lower'];
		return $occurrences;
	}


	/**
	 * getActivationHash function.
	 *
	 * @access public
	 * @return void
	 */
	public function getActivationHash()
	{
		if (!isset($this->id)) {
			return false;
		}
		return substr(Security::hash(Configure::read('Security.salt') . $this->field('created')), 0, 16);
	}
	/**
	 * getForgotPasswordHash function.
	 *
	 * @access public
	 * @return void
	 */
	public function getForgotPasswordHash($date = null) {
		if (!isset($this->id)) {
			return false;
		}
		if ($date === null) {
			$date = date('Y-m-d H:i:s');
		}
		return substr(Security::hash(Configure::read('Security.salt') . $this->field('created') . $date), 0, 16);
	}


	public function login(CakeRequest $request, AuthComponent $auth, $hasValidCert = false) {
		$convert = false;
		$found = false;
		$hash = null;
		$stored_salt = null;

		if (empty($request->data['User']['email']) || empty($request->data['User']['password'])) {
			$this->error = __('Please enter an email address and password.');
			return false;
		}

		if ($stored_hash = $this->getHash($request->data['User']['email'])) {
			if ($stored_salt = $this->getSalt($request->data['User']['email'])) {
				$found = true;
				$hash = $request->data['User']['password'];
			}
		}
		if (!$found && $stored_hash = $this->getOldHash($request->data['User']['email'])) {
			if ($stored_salt = $this->getOldSalt($request->data['User']['email'])) {
				$found = true;
				$convert = true;
				$hash = md5($request->data['User']['password']);
			}
		}

		$hash = BcryptFormAuthenticate::hash($hash, $stored_salt);
		if ($hash == $stored_hash) {
			$id = $this->getUserId($request->data['User']['email']);
			$group_id = $this->getGroupId($id);

			// Secure Admin
			if (Configure::read('TopMenu.secure_admin')) {
				if ($group_id == 1 && !$hasValidCert) {
					$this->error = __('Sorry, administration accounts require a client certificate issued by TopMenu Inc.');
					return false;
				}
			}

			$data = array(
				'id'       => $id,
				'group_id' => $group_id,
				'email' => $request->data['User']['email'],
				'language' => $this->getLanguage($id)
			);

			if (empty($data['language'])) {
				$data['language'] = 'fr';
			}

			if (empty($data['timezone'])) {
				$data['timezone'] = 'America/Montreal';
			}

	        if ($auth->login($data)) {
	        	$this->id = $auth->user('id');
	        	if (!$this->isActive($id)) {
	        		$this->error = __('User account isn\'t activated! Please check your email.');
	        		$auth->logout();
	        		return false;
	        	}

	        	if ($convert && $this->newPassword($id, $request->data['User']['password'])) {
		        	$this->removeOldHashAndSalt($id);
	        	}
	    		$this->saveField('last_login', date('Y-m-d H:i:s'));
	    		$this->saveField('last_ip', $request->clientIp());
	    		$this->language = $data['language'];

	    		$Session = new SessionComponent(new ComponentCollection());


				Configure::write('Config.language', $data['language']);
				$Session->write('Config.langauge', $data['language']);

	        	return true;
	        }
		}

		$this->error = __('Invalid email or password. Please try again.');
		return false;
	}

/**
 * Gets the user's CURRENT password hash
 *
 * @access public
 * @param mixed $email
 * @return void
 */
	public function getHash($email) {
		$result = $this->find('first', array(
			'conditions' => array(
				'User.email' => $email
			),
			'fields' => 'User.password'
		));
		if ($result) {
			return $result['User']['password'];
		}

		return false;
	}

/**
 * Gets CURRENT password salt
 *
 * @access public
 * @param mixed $email
 * @return void
 */
	public function getSalt($email) {
		$result = $this->find('first', array(
			'conditions' => array(
				'User.email' => $email
			),
			'fields' => 'User.salt'
		));
		if ($result) {
			return $result['User']['salt'];
		}
		return false;
	}


	/**
	 * getOldHash function.
	 *
	 * @access public
	 * @param mixed $email
	 * @return void
	 */
	public function getOldHash($email) {
		$result = $this->find('first', array(
			'conditions' => array(
				'User.email' => $email
			),
			'fields' => 'User.old_hash'
		));
		if ($result) {
			return $result['User']['old_hash'];
		}
		return false;
	}

	/**
	 * getOldSalt function.
	 *
	 * @access public
	 * @param mixed $email
	 * @return void
	 */
	public function getOldSalt($email) {
		$result = $this->find('first', array(
			'conditions' => array(
				'User.email' => $email
			),
			'fields' => 'User.old_salt'
		));
		if ($result) {
			return $result['User']['old_salt'];
		}
		return false;
	}

	/**
	 * getUserId function.
	 *
	 * @access public
	 * @param mixed $email
	 * @return void
	 */
	public function getUserId($email) {
		$result = $this->find('first', array(
			'conditions' => array(
				'User.email' => $email
			),
			'fields' => 'User.id'
		));
		if ($result) {
			return $result['User']['id'];
		}
		return false;
	}

	/**
	 * getGroupId function.
	 *
	 * @access public
	 * @param mixed $user_id
	 * @return void
	 */
	public function getGroupId($user_id) {
		$result = $this->find('first', array(
			'conditions' => array(
				'User.id' => $user_id
			),
			'fields' => 'User.group_id'
		));
		if ($result) {
			return $result['User']['group_id'];
		}
		return false;
	}

/**
 * Gets a user's preferred language
 * @param  [type] $user_id [description]
 * @return [type]          [description]
 */
	public function getLanguage($user_id) {
		$result = $this->find('first', array(
			'conditions' => array(
				'User.id' => $user_id
			),
			'contain' => array('Profile'),
			'fields' => 'Profile.language',
			'recursive' => 0
		));
		if ($result) {
			return $result['Profile']['language'];
		}
		return false;
	}

	/**
	 * newPassword function.
	 *
	 * @access public
	 * @param mixed $user_id
	 * @param mixed $password
	 * @return void
	 */
	public function newPassword($user_id, $password) {
		$this->id = $user_id;
		if ($this->exists()) {
			$data = array(
				'User' => array(
					'password' => $password
				)
			);
			if ($this->save($data, false)) {
				return true;
			}
		}
		return false;
	}

	/**
	 * removeOldHashAndSalt function.
	 *
	 * @access public
	 * @param mixed $user_id
	 * @return void
	 */
	public function removeOldHashAndSalt($user_id) {
		$this->id = $user_id;
		if ($this->exists()) {
			$data = $this->read('password');
			if (isset($data['User']['password']) && !empty($data['User']['password'])) {
				$this->saveField('old_hash', null);
				$this->saveField('old_salt', null);
				return true;
			}
		}
		return false;
	}

	public function change_password($data) {
		$data['User']['force_reset'] = false;
		if ($this->save($data)) {
			return true;
		}
		return false;
	}
	/**
	 * isActive function.
	 *
	 * @access public
	 * @return void
	 */
	public function isActive() {
		if (!isset($this->id)) {
			return false;
		}
		$count = $this->find('count', array(
			'conditions' => array(
				'User.id' => $this->id,
				'User.is_active' => 1
			)
		));
		if ($count) {
			return true;
		} else {
			return false;
		}
	}
/**
 * Checks if a user is requried to change their password
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
	public function requireReset($id) {
		$reset = $this->read('force_reset', $id);
		return $reset['User']['force_reset'];
	}

	/**
	 * cleanInactive function.
	 *
	 * @access public
	 * @param mixed $time
	 * @return void
	 */
	public function cleanInactive($time) {
		$results = $this->find('all', array(
			'conditions' => array(
				'User.is_active' => 0,
				'User.created <' => date('Y-m-d H:i:s', strtotime($time))
			),
			'fields' => array(
				'User.id'
			)
		));
		if ($results) {
			foreach ($results as $result) {
				$this->delete($result['User']['id']);
			}
		}
	}

	/**
	 * forgotPasswordMail function.
	 *
	 * @access private
	 * @param mixed $user_id
	 * @param mixed $hash
	 * @return void
	 */
	public function forgotPasswordMail($user_id, $hash, $created, $forMobile = FALSE) {
		$user = $this->find('first', array(
			'conditions' => array(
				'User.id' => $user_id
			),
			'fields' => array(
				'User.id',
				'User.email',
				'Profile.language'
			),
			'contain' => array(
				'Profile'
			),
			'recursive' => 0
		));
		if ($user === false) {
			$this->log(__METHOD__." failed to retrieve User data for user.id: {$user_id}");
			return false;
		}
		
		$action = $forMobile ? 'change_forgotten_password' : 'forgot_password';
		$message = array(
	    	'name' => $user['User']['email'],
	    	'forgot_url' => Router::url(array(
	    		'controller' => 'users',
	    		'action' => $action,
	    		'language' => Configure::read('Config.language'),
	    		$user['User']['id'],
	    		$hash
	    	), true),
			'expires' => strtotime($created . '+ 24 Hour')
	    );
	    $response = $this->sendEmail(
	    	array(
				'name'    => $user['User']['email'],
				'address' => $user['User']['email']
	    	),
	    	__('Forgotten Password'),
	    	$message,
	    	array(
	    		'template' => 'forgot_password'
	    	)
	    );
	}



	/**
	 * sendActivationEmail function.
	 *
	 * @access private
	 * @param mixed $user_id
	 * @return void
	 */
	public function sendActivationEmail($user_id) {
		$user = $this->find('first', array(
			'conditions' => array(
				'User.id' => $user_id
			),
			'fields' => array(
				'User.id',
				'User.email',
				'Profile.language'
			),
			'contain' => array(
				'Profile'
			),
			'recursive' => 0
		));
		if ($user === false) {
			debug(__METHOD__." failed to retrieve User data for user.id: {$user_id}");
			return false;
		}

	    $message = array(
			'name'         => $user['User']['email'],
			'expires'      => strtotime(date('Y-m-d H:i:s') . '+ 72 Hour'),
			'activate_url' => Router::url(array(
	    		'controller' => 'users',
	    		'action' => 'activate',
	    		'language' => Configure::read('Config.language'),
	    		$user['User']['id'],
	    		$this->getActivationHash()
	    	), true)
	    );


	    $response = $this->sendEmail(
	    	array(
				'name'    => $user['User']['email'],
				'address' => $user['User']['email']
	    	),
	    	__('Activate your topmenu.com account!'),
	    	$message,
	    	array(
	    		'template' => 'activate'
	    	)
	    );
	}

	/**
	 * Sends the welcome email to the user
	 *
	 * @access private
	 * @param mixed $user_id
	 * @return void
	 */
	public function sendWelcomeEmail($user_id) {
		$user = $this->find('first', array(
			'conditions' => array(
				'User.id' => $user_id
			),
			'fields' => array(
				'User.id',
				'User.email',
				'Profile.language'
			),
			'contain' => array(
				'Profile'
			),
			'recursive' => 0
		));
		if ($user === false) {
			debug(__METHOD__." failed to retrieve User data for user.id: {$user_id}");
			return false;
		}

	    $message = array(
			'name'      => $user['User']['email'],
	    );

	    $response = $this->sendEmail(
	    	array(
				'name'    => $user['User']['email'],
				'address' => $user['User']['email']
	    	),
	    	__('Welcome to Topmenu!'),
	    	$message,
	    	array(
	    		'template' => 'welcome'
	    	)
	    );
	}
	
		/**
	 * Gets all the necessary user fields to send him an email
	 * 
	 * @param 	string 	$id user id
	 * @return	array		necessary fields
	 */
	public function getUserForEmail($id){
		
		return $this->find('first', array(							
		'conditions' => array('User.id' => $id),			
			'fields' => array('User.id', 'User.email'),
			'contain' => array(
				'Profile' => array(
					'fields' => array(
						'Profile.first_name', 'Profile.last_name', 'Profile.language', 'Profile.gender')))));
	}
	
	/**
	 * Check if a user already made an order before those im being a customer
	 * @param string $id UUID of the user	 
	 * @return bool 
	 */	
	public function isCustomer($id){		
		$isCustomer = $this->Order->find('first', array('conditions' => array('Order.user_id' => $id, 'Order.overall_status' => 'complete')));
		return !empty($isCustomer);
		
	}
	
	/**
	 * Offer first Order Coupon to the user (user may have this discount if he as not made a credit card order before)
	 * @param string $id UUID of the user	 
	 * @return bool 
	 */	
	public function giveFirstOrderDiscount($id){
		
		$isCustomer = $this->Order->find('first', array(
            'conditions' => array(
                'Order.user_id' => $id, 
                'Order.method_of_payment' => 'creditcard', 
                'Order.overall_status' => 'complete')));
		return empty($isCustomer);
	}
}
