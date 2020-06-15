<?php

class DashboardController extends \core\BaseController
{
    private $todoList;
    private $todo;

    public function __construct()
    {
        $this->todo = new Todo();
        $this->todoList = new TodoList();
    }

    public function index(){
        if ($this->loggedUser()){
            $id = $_SESSION['user']->id;
            $todoLists = $this->todoList->findByUserId($id);
            echo $this->renderView('dashboard.html', ['todoLists' => $todoLists, 'user' => $_SESSION['user']]);
        }
    }
}