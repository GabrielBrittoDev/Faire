<?php


class HomeController extends \core\BaseController
{

    public function index(){
        $args = isset($_SESSION['user']) ? ['user' => $_SESSION['user']] : array();
        echo $this->renderView('home.html', $args);
    }

}