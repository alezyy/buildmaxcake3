<?php

namespace App\Controller\Admin;
use App\Controller\AppController;
class UsersController extends AppController {
    public function index() {
        $users = $this->paginate();
        $this->set(compact('users'));
    }
}

