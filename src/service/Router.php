<?php
namespace App\service;

use App\controller\TestController;
use App\service\TwigService;

/**
 * Summary of Router
 * This class parse the url and call the controller wanted
 */
class Router
{
    /**
     * Summary of parseRoute
     * This methode parse the url $_GET["route"] and return an array $route
     * with route and param if needed
     * 
     * @return array
     */
    public function parseRoute() :array
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

    /**
     * Summary of route
     * This methode call parseRoute and load the right controller
     * 
     * @return void
     */
    public function route()
    {
        $route = $this->parseRoute();
        $twig = TwigService::twigLoader();

        if ($route["route"] === "home") {
            echo $twig->render('home.phtml');
        } else if ($route["route"] === "posts") {
            $id = $route["param"];
            echo $twig->render('posts.phtml', ['id' => $id]);
        } else if ($route["route"] === "test") {
            $controller = new TestController();
            $controller->index($route["param"]);
        } else {
            echo $twig->render('404.phtml');
        }
    }
}
