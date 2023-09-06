<?php

    require 'vendor/autoload.php';

    use App\service\Router;
    use App\service\SessionService;

    $session = SessionService::getInstance();
    $isConnected = $session->get("connected");

    if(!isset($isConnected))
    {
        $session->set("connected", false);
        $session->set("button", "connect");
    }

    var_dump("<pre>");
    var_dump($_SESSION);
    var_dump("</pre>");

    $router = Router::getInstance();
    $router->route();
