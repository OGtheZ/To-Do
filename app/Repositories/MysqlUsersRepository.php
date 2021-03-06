<?php

namespace App\Repositories;

use App\Models\User;
use PDO;
use PDOException;

class MysqlUsersRepository implements UsersRepository
{
    private PDO $connection;

    public function __construct()
    {
        $config = json_decode(file_get_contents("config.json"), true);
        $dsn = "mysql:host={$config["host"]};dbname={$config["db"]};charset=UTF8";
        try {
            $this->connection = new PDO($dsn, $config["user"], $config["password"]);
        } catch(PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function save(User $user): void
    {
        $sql = "INSERT INTO users (id, name, password) VALUES (?, ?, ?)";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            $user->getId(),
            $user->getName(),
            $user->getPassword()
        ]);
    }

    public function getOneByName()
    {
        $sql = "SELECT * FROM users WHERE name = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$_POST["userName"]]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}