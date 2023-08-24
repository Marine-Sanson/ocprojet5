<?php

    require 'vendor/autoload.php';

    use App\service\Router;

    session_start();
    if(!isset($_SESSION["connected"]))
    {
        $_SESSION["connected"] = false;
        $_SESSION["button"] = "connect";
    }

//    var_dump("<pre>");
//    var_dump($_SESSION);
//    var_dump("</pre>");

    $router = Router::getInstance();
    $router->route();
