<?php


class User
{

    public function isUniqueEmail($email){
        $conn = Connection::getConn();

        $stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->bindValue(1, $email, \PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->rowCount() == 0;
    }

    public function create($user){
            $conn = Connection::getConn();
            $sql = 'INSERT INTO users (name, email, password) VALUES (?,?,?)';
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $user['name'], \PDO::PARAM_STR);
            $stmt->bindValue(2, $user['email'], \PDO::PARAM_STR);
            $stmt->bindValue(3, $user['password'], \PDO::PARAM_STR);
            if ($stmt->execute()) {
                return $response = ['message' => 'Usuario cadastrado com sucesso'];
            } else {
                unset($user['password']);
                unset($user['confirm_password']);
                return $response = ['errors' => ['Erro ao cadastrar Usuário'], 'user' => $user];
            }
    }

    public function login($credentials){
        $conn = Connection::getConn();
        $sql = 'SELECT * FROM users WHERE email = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $credentials['email'], \PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() > 0){
            $user = $stmt->fetchObject('User');
            if (password_verify($credentials['password'], $user->password)){
                unset($user->password);
                $_SESSION['user'] = $user;
                return ['message'=> 'Login feito com sucesso!', 'user' => $user];
            } else {
                return ['error' => 'Senha incorreta!'];
            }
        } else {
            return ['error' => 'Email não encontrado'];
        }

    }


}