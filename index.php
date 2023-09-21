<?php

    require 'vendor/autoload.php';

    use App\service\Router;
    use App\service\SessionService;
    use Dotenv\Dotenv;

    $newSession = SessionService::getInstance();
    $newSession->start();

    $dotenv = Dotenv::createImmutable(__DIR__, '.env.local');
    $dotenv->load();

    // var_dump("<pre>");
    // var_dump($_SESSION);
    // var_dump("</pre>");

    // $ses = $newSession->getSession();
    // var_dump("<pre>");
    // var_dump($ses);
    // var_dump("</pre>");

    $router = Router::getInstance();
    $router->route();
