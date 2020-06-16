<?php


class Todo
{

    public function create($todo){
        $conn = Connection::getConn();

        $sql = "INSERT INTO todos (title, description, done, todo_list_id) VALUES (:title,:description,:done, :todo_list_id)";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue('title', $todo->title, PDO::PARAM_STR);
        $stmt->bindValue('description', $todo->description, PDO::PARAM_STR);
        $stmt->bindValue('done', $todo->done, PDO::PARAM_BOOL);
        $stmt->bindValue('todo_list_id', $todo->todo_list_id, PDO::PARAM_INT);

        $stmt->execute();

            if ($stmt->rowCount() > 0){
                $id = $conn->lastInsertId();

                $stmt = $conn->prepare('SELECT * FROM todos WHERE id = ?');
                $stmt->bindValue(1, $id, PDO::PARAM_INT);

                $stmt->execute();

                return $stmt->fetchObject('Todo');
            } else {
                return $stmt->errorInfo();
            }

    }

    public function update($todo){
        $conn = Connection::getConn();

        $sql = 'UPDATE todos SET title = ?, description = ?, done = ?, todo_list_id = ? WHERE id = ?';

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $todo->title, PDO::PARAM_STR);
        $stmt->bindValue(2, $todo->description, PDO::PARAM_STR);
        $stmt->bindValue(3, $todo->done, PDO::PARAM_BOOL);
        $stmt->bindValue(4, $todo->todo_list_id, PDO::PARAM_INT);
        $stmt->bindValue(5, $todo->id, PDO::PARAM_INT);

        $stmt->execute();

        if ($stmt->rowCount() > 0){
            return $todo;
        } else {
            return $stmt->errorInfo();
        }

    }

    public function show($id){
        $conn = Connection::getConn();
        $sql = 'SELECT * FROM todos WHERE id = ?';

        $stmt = $conn->prepare($sql);

        $stmt->bindValue(1, $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0 ? $stmt->fetchObject(Todo::class) : ['error' => 'Erro ao carregar tarefa'] ;
    }

    public function destroy($id){
        $conn = Connection::getConn();
        $sql = 'DELETE FROM todos WHERE id = ?';

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);

        $stmt->execute();

        if ($stmt->rowCount() > 0){
            return ['success' => true];
        }
        return ['success' => false];

    }
}