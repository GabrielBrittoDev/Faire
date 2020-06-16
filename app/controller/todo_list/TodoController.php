<?php

namespace todo_list;

use core\BaseController;

class TodoController extends BaseController{

    private $todo;

    public function __construct(){
        $this->todo = new \Todo();
    }


    public function save($request){
        if ($this->loggedUser()){
            $data = json_decode($request);
            if (isset($data->id)){
                echo json_encode($this->todo->update($data));
            } else {
                echo json_encode($this->todo->create($data));
            }
        }
    }

    public function destroy($id){
        if ($this->loggedUser()){
            echo json_encode($this->todo->destroy($id));
        }
    }

    public function show(int $id){
        if ($this->loggedUser()) {
            if ($data = $this->todo->show($id)) {
                echo json_encode($data);
            }
        }
    }

}