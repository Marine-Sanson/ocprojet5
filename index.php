<?php

    require 'vendor/autoload.php';
    use App\Demo\Demo;

    $test = new Demo();
    echo $test->getDemo();

    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment(
        $loader, [
        'cache' => false,
        ]
    );

    echo $twig->render('index.html');
