<?php
namespace App\service;

use App\controller\TestController;

class Router
{
    public function parseRoute()
    {
        $route = [];
        if (isset($_GET["route"])) {
                $routeParam = explode("/", $_GET["route"]);
                $route["route"] = $routeParam[0];
        } else {
                $route["route"] = "home";
        }

        if (isset($routeParam) && count($routeParam) === 2) {
                $id = $routeParam["1"];
        } else {
                $id = null;
        }

        $route["param"] = $id;
        return $route;
    }

    public function route()
    {
        $route = $this->parseRoute();
        
        $loader = new \Twig\Loader\FilesystemLoader('src/view');
            $twig = new \Twig\Environment(
                $loader, [
                'cache' => false, // __DIR__ . '/tmp'
            ]
            );

            if ($route["route"] === "home") 
            {
                echo $twig->render('home.phtml');
            }
            else if ($route["route"] === "posts")
            {
                $id = $route["param"];
                echo $twig->render('posts.phtml', ['id' => $id]);
            } else if ($route["route"] === "test") {
                $controller = new TestController();
                $controller->index($route["param"]);
            }
            else 
            {
                echo $twig->render('404.phtml');
            }
    }
}
