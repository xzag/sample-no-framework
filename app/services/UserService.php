<?php

namespace app\services;

use app\models\User;
use app\requests\ProfileRequest;
use app\requests\SignupRequest;

class UserService
{
    /**
     * @var \PDO
     */
    private $_connection;

    public function __construct($connection)
    {
        $this->_connection = $connection;
    }

    public function findByCredentials($login, $password)
    {
        $statement = $this->_connection->prepare('SELECT * FROM users WHERE login = :login AND password = :password');
        $statement->execute([
            ':login' => mb_strtolower($login),
            ':password' => sha1($password)
        ]);
        return $statement->fetchObject(User::class);
    }

    public function findByEmailOrLogin($email, $login)
    {
        $statement = $this->_connection->prepare('SELECT * FROM users WHERE login = :login OR email = :email');
        $statement->execute([
            ':login' => mb_strtolower($login),
            ':email' => mb_strtolower($email)
        ]);
        return $statement->fetchObject(User::class);
    }

    public function getById($id)
    {
        $statement = $this->_connection->prepare('SELECT * FROM users WHERE id = :id');
        $statement->execute([
            ':id' => $id,
        ]);
        return $statement->fetchObject(User::class);
    }

    /**
     * @param SignupRequest $request
     * @return mixed
     */
    public function make($request)
    {
        $statement = $this->_connection->prepare('INSERT INTO users (login, email, `name`, `password`) VALUES (:login, :email, :name, :password)');
        return $statement->execute([
            ':login' => mb_strtolower($request->login),
            ':email' => mb_strtolower($request->email),
            ':password' => sha1($request->password),
            ':name' => $request->name
        ]);
    }

    /**
     * @param $id
     * @param ProfileRequest $request
     */
    public function update($id, $request)
    {
        if (empty($request->password)) {
            $statement = $this->_connection->prepare('UPDATE users SET name = :name WHERE id = :id');
            return $statement->execute([
                ':name' => $request->name,
                ':id' => $id
            ]);
        } else {
            $statement = $this->_connection->prepare('UPDATE users SET name = :name, password = :password WHERE id = :id');
            return $statement->execute([
                ':password' => sha1($request->password),
                ':name' => $request->name,
                ':id' => $id
            ]);
        }

    }
}