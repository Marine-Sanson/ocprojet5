<?php

    require 'vendor/autoload.php';

    use App\service\Router;
    use App\service\SessionService;
    use Dotenv\Dotenv;

    $newSession = SessionService::getInstance();
    $newSession->start();

    $dotenv = Dotenv::createImmutable(__DIR__, '.env.local');
    $dotenv->load();

    $router = Router::getInstance();
    $router->route();
