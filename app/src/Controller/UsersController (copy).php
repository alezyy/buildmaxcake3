<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Email\Email;
use App\Controller\Component\Auth\BcryptFormAuthenticate ;
use Cake\Controller\Controller ;
use Cake\Event\Event ;

//App::uses('BcryptFormAuthenticate', 'Controller/Component/Auth');



/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
   // public $langSuffix = 'en' ;

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
     * beforeFilter function.
     *
     * @access public
     * @return void
     */
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
     
               
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
//          'login',
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
        
       } 


    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Groups']
        ];
        $this->set('users', $this->paginate($this->Users));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Groups']
        ]);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success('The user has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The user could not be saved. Please, try again.');
            }
        }
        $groups = $this->Users->Groups->find('list', ['limit' => 200]);
        $this->set(compact('user', 'groups'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success('The user has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The user could not be saved. Please, try again.');
            }
        }
        $groups = $this->Users->Groups->find('list', ['limit' => 200]);
        $this->set(compact('user', 'groups'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success('The user has been deleted.');
        } else {
            $this->Flash->error('The user could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }

 
    public function login($success = NULL)
    {

        $this->set('title_for_layout', __(' Login'));
        $this->set('successPage', $success);

       /* if ($this->request->is('post')) { 

        }
        */
    }

    public function register($langSuffix = 'en')
     {
  
       $this->set('langSuffix', $langSuffix) ;

      }


}
