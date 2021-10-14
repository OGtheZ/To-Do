<?php

namespace App\Controllers;

use App\Models\User;
use App\Repositories\MysqlUsersRepository;
use App\Repositories\UsersRepository;
use App\View;
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
        return new View("/users/index.twig", []);
    }

    public function register()
    {
        return new View("/users/register.twig", []);
    }

    public function store()
    {
        if($_POST['password'] !== $_POST["password-confirm"] || $_POST['userName'] === "" || $_POST['password'] === "")
        {
            header("Location: /register");
        }
        else
        {
            $user = new User(Uuid::uuid4(),
                $_POST['userName'],
                password_hash($_POST['password'], PASSWORD_DEFAULT));

            $this->userRepository->save($user);
            header("Location: /");
        }
    }

    public function login()
    {
        if ($_POST['userName'] === "" || $_POST["password"] === "") header("Location: /");
        $userData  = $this->userRepository->getOneByName();

        if($userData == false){
            header("Location: /");
        } else {
            if(password_verify($_POST["password"], $userData["password"])) {
                $_SESSION["id"] = $userData["id"];
                header("Location: /tasks");
            } else {header("Location: /");
            }
        }
    }


    public function logout()
    {
        unset($_SESSION['id']);
        header("Location: /");
    }
}