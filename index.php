<?php

    require 'vendor/autoload.php';

    use App\service\Router;
    use App\service\SessionService;

    $newSession = SessionService::getInstance();
    $newSession->start();

//    var_dump("<pre>");
//    var_dump($_SESSION);
//    var_dump("</pre>");

    $router = Router::getInstance();
    $router->route();
