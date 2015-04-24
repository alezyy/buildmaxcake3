<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

use App\Controller\User;

class UserAccountComponent extends Component
{

  	public $components = array();
  
  /*	public function startup(Controller $controller) {	
		$this->controller = $controller;
		} 

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
