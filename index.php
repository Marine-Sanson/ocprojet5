<?php

    require 'vendor/autoload.php';

    use App\service\Router;

    session_start();
    if(!isset($_SESSION["connected"]))
    {
        $_SESSION["connected"] = [];
    }

    $router = Router::getInstance();
    $router->route();
