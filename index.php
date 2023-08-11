<?php

    require 'vendor/autoload.php';
    use App\service\Router;

    $router = Router::getInstance();
    $router->route();
