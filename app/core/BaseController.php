<?php

namespace core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class BaseController
{

    protected function renderView($view, $args = array(), $headerLocation = '', $viewsPath = '../app/view'){
        $loader = new FilesystemLoader($viewsPath);

        $loader->addPath(dirname(__DIR__).'/template/', 'template');

        $twig = new Environment($loader);
        $template = $twig->load($view);
        if ($headerLocation !== ''){
            $host = $_SERVER['HTTP_HOST'];
            header('Location: http://'.$host . '/'.$headerLocation);

        }

        return $template->render($args);
    }


    /**
     *  Finds a class where the name is the class who is using the trait without the 'Controller' and with
     * 'Policy' and executes the method passed with your arguments(optional) and the Session User id
     * @param string $method
     * Method who will be executed in policy.
     * @param array $args
     * Arguments who will be passed in method.
     * @return boolean
     */
    protected function authorize(string $method, $args){
        $policy = str_replace( 'Controller', 'Policy',static::class);
        return call_user_func(array(new $policy(), $method), $args);
    }

    protected function guest(){
        if (isset($_SESSION['user'])){
            echo $this->renderView('dashboard.html', array(), 'dashboard');
            return false;
        } else {
            return true;
        }
    }

    protected function loggedUser(){
        if (!isset($_SESSION['user'])){
            echo $this->renderView('auth/login.html', array(), 'auth/login');
            return true;
        } else {
            return true;
        }
    }

}