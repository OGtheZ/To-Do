<?php

use App\View;

require_once "vendor/autoload.php";

session_start();

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/tasks', 'App\Controllers\TasksController@index');
    $r->addRoute('GET', '/tasks/create', 'App\Controllers\TasksController@create');
    $r->addRoute('POST', '/tasks', 'App\Controllers\TasksController@store');
    $r->addRoute('POST', '/tasks/{id}', 'App\Controllers\TasksController@delete');
    $r->addRoute('GET', '/tasks/{id}', 'App\Controllers\TasksController@show');

    $r->addRoute('GET', '/', 'App\Controllers\UsersController@index');
    $r->addRoute('GET', '/register', 'App\Controllers\UsersController@register');
    $r->addRoute('POST', '/', 'App\Controllers\UsersController@store');
    $r->addRoute('POST', '/home', 'App\Controllers\UsersController@login');
    $r->addRoute('POST', '/logout', 'App\Controllers\UsersController@logout');
});

function basePath(): string
{
    return __DIR__;
}

$loader = new \Twig\Loader\FilesystemLoader('app/Views');
$templateLoader = new \Twig\Environment($loader, []);

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo "NOT FOUND!";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo "CANT DO THIS!";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        [$controller, $method] = explode("@", $handler);
        $controller = new $controller;
        $response = $controller->$method($vars);

        if ($response instanceof View)
        {
            echo $templateLoader->render($response->getTemplate(), $response->getVariables());
        }
        break;
}