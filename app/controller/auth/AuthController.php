<?php

namespace auth;

use core\BaseController;
use User;

class AuthController extends BaseController
{
    private $user;

    public function __construct()
    {
        $this->user = new User;
    }

    public function login()
    {
        if ($this->guest()) {
            echo $this->renderView('auth/login.html');
        }
    }

    public function signIn($request)
    {
        if ($this->guest()) {
            $response = $this->user->login($request);
            if (!isset($response['error'])) {
                echo $this->renderView('dashboard.html', $response, 'dashboard');
            } else {
                echo $this->renderView('auth/login.html', $response);
            }
        }
    }

    public function logout(){
        if ($this->loggedUser()){
            $_SESSION['user'] = null;

            $this->renderView('auth/login.html',['message' => 'Logout realizado com sucesso!'], 'auth/login');

        }
    }

}