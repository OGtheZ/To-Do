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
            $user = new User(Uuid::uuid4(), $_POST['userName'], password_hash($_POST['password'], PASSWORD_DEFAULT));
            $this->userRepository->save($user);
            header("Location: /");
        } else {header("Location: /");}
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