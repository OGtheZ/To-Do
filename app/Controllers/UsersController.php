<?php

namespace App\Controllers;

use App\Models\User;
use App\Repositories\MysqlUsersRepository;
use App\Repositories\UsersRepository;
use Ramsey\Uuid\Uuid;

class UsersController
{
    private UsersRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new MysqlUsersRepository();
    }

    public function index()
    {
        require_once "app/Views/users/index.template.php";
    }

    public function register()
    {
        require_once "app/Views/users/register.template.php";
    }

    public function store()
    {
        if ($_POST['userName'] !== "" || $_POST['password'] !== "")
        {
            $user = new User(Uuid::uuid4(), $_POST['userName'], $_POST['password']);
            $this->userRepository->save($user);
            header("Location: /");
        }
    }

    public function login()
    {
        if ($_POST['userName'] === "" || $_POST["password"] === "") header("Location: /");

        if($this->userRepository->login() === false){
            header("Location : /");
        } else {
            var_dump("did i get here?");
            header("Location : /home/menu");
        }
    }

    public function home()
    {
        require_once "app/Views/users/home.template.php";
    }
}