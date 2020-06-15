<?php

namespace user;

use User;

class UserController extends \core\BaseController {

    private $user;

    public function __construct()
    {
        $this->user = new User;
    }

    public function index(){

    }


    public function create(){
        echo $this->renderView('user/create.html');
    }

    public function store($request){
        if (!$this->user->isUniqueEmail($request['email'])){
            $response['errors'] = 'Email já em uso';
            echo $this->renderView('user/create.html',$response);
        }

        if ($request['confirm_password'] !== $request['password']){
            $response['errors'] = 'Senhas não conferem';
            echo $this->renderView('user/create.html',$response);
        }

        $request['password'] = password_hash($request['password'], PASSWORD_BCRYPT);

        $response = $this->user->create($request);

        if (isset($response['errors'])){
            echo $this->renderView('user/create.html',$response);
        } else {
            echo $this->renderView('auth/login.html',$response, 'auth/login');
       }
    }



}