<?php

namespace todo_list;

use core\BaseController;

class TodoListController extends BaseController
{

    private $todoList;

    public function __construct()
    {
        $this->todoList = new \TodoList();
    }

    public function destroy($id){
        if ($this->loggedUser()){
           echo json_encode($this->todoList->destroy($id));
        }
    }

    public function store($request){
        if ($this->loggedUser()){
            $data = json_decode($request);

            if ($data = $this->todoList->create($data)){
                echo json_encode($data);
            }
        }

    }
}