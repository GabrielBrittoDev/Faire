<?php


class TodoList
{

    public function create($todoList){
        $conn = Connection::getConn();

        $sql = 'INSERT INTO todo_lists (title, user_id) VALUES (?,?);';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $todoList->title, PDO::PARAM_STR);
        $stmt->bindValue(2, $todoList->user_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0){
            $id = $conn->lastInsertId();

            $stmt = $conn->prepare('SELECT * FROM todo_lists WHERE id = ?');
            $stmt->bindValue(1, $id, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetchObject('TodoList');
        } else {
            return ['error' => 'Erro ao criar tarefa'];
        }
    }

    public function destroy($id){
        $conn = Connection::getConn();
        $sql = 'DELETE FROM todo_lists WHERE id = ?';

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);

        $stmt->execute();

        if ($stmt->rowCount() > 0){
            return ['success' => true];
        }
        return ['success' => false];

    }


    public function findByUserId(int $userId)
    {
        $conn = Connection::getConn();

        $sql = 'SELECT 
                    tl.id AS tl_id, tl.title AS tl_title, tl.user_id AS tl_user_id, tl.created_at AS tl_created_at, tl.updated_at AS tl_updated_at,
                    t.* FROM todo_lists tl LEFT JOIN todos t ON tl.id = t.todo_list_id WHERE tl.user_id = ?';

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(1, $userId, PDO::PARAM_INT);
        $stmt->execute();
        $todoLists = array();
        $previousTodoListId = -1;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $todos = [];
            $todoList = new TodoList();
            foreach ($row as $key => $value) {
                if (substr($key, 0, 3) === 'tl_') {
                    if ($previousTodoListId !== $row['tl_id']) {
                        $key = str_replace('tl_', '', $key);
                        $todoList->$key = $value;
                    }
                    continue;
                }
                $todos[$key] = $value;
            }
            if ($previousTodoListId == $row['tl_id']) {
                array_push(end($todoLists)->todos, $todos);
            } else {
                if ($todos['id'] != null){
                    $todoList->todos[] = $todos;
                }
                array_push($todoLists, $todoList);
            }
            $previousTodoListId = $row['tl_id'];
        }
        return $todoLists;
    }
}