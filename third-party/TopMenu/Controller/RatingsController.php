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
 * Ratings Controller
 *
 * @property Rating $Rating
 * @property PaginatorComponent $Paginator
 */
class RatingsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

     public function beforeFilter() {

        parent::beforeFilter();
        $this->Auth->allow(
            'add_rating',
            'user_add',
			'view',
			'rating_close'
        );
    }
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Rating->recursive = 0;
		$this->set('ratings', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Rating->exists($id)) {
			throw new NotFoundException(__('Invalid rating'));
		}
		$options = array('conditions' => array('Rating.' . $this->Rating->primaryKey => $id));
		$this->set('rating', $this->Rating->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Rating->create();
			if ($this->Rating->save($this->request->data)) {
				$this->Session->setFlash(__('The rating has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rating could not be saved. Please, try again.'));
			}
		}
		$locations = $this->Rating->Location->find('list');
		$users = $this->Rating->User->find('list');
		$this->set(compact('locations', 'users'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Rating->exists($id)) {
			throw new NotFoundException(__('Invalid rating'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Rating->save($this->request->data)) {
				$this->Session->setFlash(__('The rating has been saved'), 'default', array('class' => 'flash_success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The rating could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Rating.' . $this->Rating->primaryKey => $id));
			$this->request->data = $this->Rating->find('first', $options);
		}
		$locations = $this->Rating->Location->find('list');
		$users = $this->Rating->User->find('list');
		$this->set(compact('locations', 'users'));
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Rating->id = $id;
		if (!$this->Rating->exists()) {
			throw new NotFoundException(__('Invalid rating'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Rating->delete()) {
			$this->Session->setFlash(__('Rating deleted'), 'default', array('class' => 'flash_success'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Rating was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
    
    /**
     * Save user's rating for a specific location
     * 
     * @param string $locationId
     * @param float $rating
     * @param string $userId     
     * @deprecated November-14-2013 use: user_add
     */
    public function add_rating($locationId, $userId, $rating){        
        
        // Don't save incognito users
        if (empty($userId)){           
            $this->Session->setFlash(__('Please login to rate')); // notice message
        }elseif(empty($locationId)){
            $this->Session->setFlash(__('Please choose a restaurant')); // notice message
        }else{
            $this->Rating->create();           
            echo $this->Rating->save(array(
                'Rating' => array(
                    'location_id' => $locationId, 
                    'user_id' => $userId, 
                    'rating' => $rating)));
            $this->Session->setFlash(__('Your rating has been save', 'default', array('class' => 'flash_success')));
            $this->autoRender=false;
        }	
    }
	
	/**
	 * Display the "Write your review" form
	 * 
	 * @param type $id			rating id
	 * @param type $locationId	location id
	 * @param type $orderId		order id
	 * @throws NotFoundException
	 */
	public function user_add($id, $userId, $orderId){
		
		$this->loadModel('Order');	
		$this->loadModel('Location');	
		
		// Check if rating is open for editing
		$rating = $this->Rating->isOpen($id, $userId);
		if (!$rating) {
			$this->redirect(array('controller' => 'ratings', 'action' => 'rating_close', 'language' => $this->langSuffix, $id));
		}	

		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Rating->save($this->request->data)) {
				$this->Session->setFlash(__('The review has been saved, thank you!'), 'default', array('class' => 'flash_success'));
				$this->redirect('/' . $this->langSuffix);
			} else {
				$this->Session->setFlash(__('The review could not be saved. Please, try again.'));
			}
		} else {
			
			$this->set('location_name', $this->Location->findById($rating['Rating']['location_id'], 'Location.name'));
			$this->set('id', $id);
			$this->set('order', $this->Order->find('first', array(
					'conditions' => array('Order.id' => $orderId),
					'fields' => array('Order.id', 'Order.created'),
					'contain' => array(
						'OrderDetail' => array(
							'fields' => array('OrderDetail.name', 'OrderDetail.price'))))));

			$rating['Rating']['review'] = '';	// remove 
			$this->request->data = $rating;
		}
	}

	public function view($locationUrl = NULL) {

		$this->loadModel('Profile');
		$this->loadModel('Location');

		$locationArray = $this->Location->findByUrl($locationUrl, array('id'));
		$locationId = $locationArray['Location']['id'];

		// get and set reviews
		$reviews = $this->Rating->find('all', array(
			'conditions' => array(
				'Rating.location_id' => $locationId,
                'Rating.rating > ' => 0,
				'Rating.status' => 'active'),
			'fields' => array(
				'Rating.rating',
				'Rating.user_id',
				'Rating.review',
				'Rating.created')));

		// get user info
		foreach ($reviews as &$review) {
			$tmpArray = $this->Profile->find('first', array(
				'conditions' => array(
					'Profile.id' => $review['Rating']['user_id']),
				'fields' => array('Profile.first_name', 'Profile.last_name')));
			$review['Profile'] = $tmpArray['Profile'];
		}

		$this->set('locationId', $locationId);
		$this->set('reviews', $reviews);
	}
	
	public function rating_close($id){
        $this->set('rating', $this->Rating->findById($id));
	}
}

