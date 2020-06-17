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
        $errors = array();

        if (!$this->user->isUniqueEmail($request['email'])){
            $errors[] = 'Email já em uso';
        }

        if ($request['confirm_password'] !== $request['password']){
            $errors[] = 'Senhas não conferem';
        }

        if (!empty($errors)){
            echo $this->renderView('user/create.html',compact('errors'));
            return;
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