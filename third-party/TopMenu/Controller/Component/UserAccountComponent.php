<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('Component', 'Controller', 'User');

/**
 * CakePHP UserAccountComponent
 * @author pechartrand
 */
class UserAccountComponent extends Component {

    public $components = array();

    public function startup(Controller $controller) {	
		$this->controller = $controller;
	}
    
    /**
     * Adds the given id to the browser's cookie
     * @param string $id user id
     */
    public function setAccountCookie($id){
        
        if($this->controller->Cookie->check('Accounts')){
            $accounts = $this->controller->Cookie->read('Accounts');
            if(array_key_exists($id, $accounts) === false){
                
                // push new id to cookie                    
                $this->controller->Cookie->write("Accounts.$id.last_login", time());
                $this->controller->Cookie->write("Accounts.$id.last_ip", $this->controller->request->clientIp());
            }                        
        }else{
            
            // create cookie with this user id
            $this->controller->Cookie->write("Accounts.$id.last_login", time());
            $this->controller->Cookie->write("Accounts.$id.last_ip", $this->controller->request->clientIp());
        }            
    }
    
    /**
     * Evaluates if this browser is use by a frauder by looking at the number of accounts use by the user.
     * If the more than one account is use on this browser consider this a fraudulent user
     */
    public function isFraudulentBrowser(){
        
        $userModel = ClassRegistry::init('User');
        
        $accounts = $this->controller->Cookie->read('Accounts');
        
        // If one of the accounts is topmenu acount then this is not fraud
        foreach ($accounts as $k => $a) {            
            $user = $userModel->findById($k);
            if($user['User']['group_id'] < 5){
                return false;
            }
        }
        return (count($accounts) > 1);
    }
}
