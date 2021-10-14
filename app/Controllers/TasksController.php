<?php

namespace App\Controllers;

use App\Models\Task;
use App\Repositories\CsvTasksRepository;
use App\Repositories\MysqlTasksRepository;
use App\Repositories\TasksRepository;
use App\View;
use Ramsey\Uuid\Uuid;
use Twig\Environment;

class TasksController
{
    private TasksRepository $tasksRepository;
    private Environment $twig;
    public function __construct()
    {
        $this->tasksRepository = new MysqlTasksRepository();
        $loader = new \Twig\Loader\FilesystemLoader('app/Views');
        $this->twig = new \Twig\Environment($loader, []);
    }

    public function index(): View
    {
        $tasks = $this->tasksRepository->getAll($_GET);

        return new View('/tasks/index.twig', [
            'tasks' => $tasks
        ]);
    }

    public function create()
    {
        return new View('/tasks/createTask.twig', []);
    }

    public function store()
    {
        if($_POST["title"]!=="")
        {
            $task = new Task(Uuid::uuid4(), $_POST["title"]);
            $this->tasksRepository->save($task);
            header("Location: /tasks");
        }
    }

    public function delete(array $vars)
    {
        $id = $vars['id'] ?? null;
        if ($id == null) header("Location: /");

        $task = $this->tasksRepository->getOne($id);

        if ($task !== null)
        {
            $this->tasksRepository->delete($task);
        }

        header("Location: /tasks");
    }
    public function show(array $vars)
    {
        $id = $vars['id'] ?? null;
        if ($id == null) header("Location: /tasks");

        $task = $this->tasksRepository->getOne($id);
        if($task === null) header("Location: /tasks");

        return new View('/tasks/showTask.twig', ["task" => $task]);
    }
}