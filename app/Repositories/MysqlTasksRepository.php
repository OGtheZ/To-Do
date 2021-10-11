<?php

namespace App\Repositories;

use App\Models\Collections\TasksCollection;
use App\Models\Task;
use PDO;
use PDOException;

class MysqlTasksRepository implements TasksRepository
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

    function getAll(array $filters = []): TasksCollection
{
    $sql = "SELECT * FROM tasks";
    $params = [];
    if (isset($filters['status']))
    {
        $sql .= " WHERE status = ?";
        $params[] = $filters['status'];
    }
    $sql .= " ORDER by created_at DESC";

    $statement = $this->connection->prepare($sql);
    $statement->execute($params);

    $tasks = $statement->fetchAll(PDO::FETCH_ASSOC);
    $collection = new TasksCollection();
    foreach ($tasks as $task)
    {
        $collection->add(new Task(
            $task['id'],
            $task['title'],
            $task['status'],
            $task['created_at']
        ));
    }
    return $collection;
}

public function getOne(string $id): ?Task
{
    $sql = "SELECT * FROM tasks WHERE id = ?";
    $statement = $this->connection->prepare($sql);
    $statement->execute([$id]);
    $task = $statement->fetch();

    return new Task(
        $task['id'],
        $task['title'],
        $task['status'],
        $task['created_at']
    );
}

public function save(Task $task): void
{
    $sql = "INSERT INTO tasks (id, title, status, created_at) VALUES (?, ?, ?, ?)";
    $statement = $this->connection->prepare($sql);
    $statement->execute([
        $task->getId(),
        $task->getTitle(),
        $task->getStatus(),
        $task->getCreatedAt()
    ]);
}

public function delete(Task $task): void
{
    $sql = "DELETE FROM tasks WHERE id = ?";
    $statement = $this->connection->prepare($sql);
    $statement->execute([$task->getId()]);
}
}