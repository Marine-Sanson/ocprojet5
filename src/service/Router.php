<?php
declare(strict_types=1);

namespace App\service;

use App\controller\HomeController;
use App\controller\TestController;
use App\service\TwigService;

/**
 * Summary of Router
 * This class parse the url and call the controller wanted
 */
class Router
{
    /**
     * Summary of _twig
     * 
     * @var TwigService
     */
    private TemplateInterface $_templateEngine;
    /**
     * Summary of _instance
     * 
     * @var Router
     */
    private static $_instance;

    private HomeController $homeController;

    /**
     * Summary of __construct
     * 
     * call an instance of HomeController
     * call an instance of TwigService
     */
    private function __construct()
    {
        $this->_templateEngine = TwigService::getInstance();
    }


    /**
     * Summary of getInstance
     * That methode create the unique instance of the class, if it doesn't
     * exist and return it
     * 
     * @return \App\service\Router
     */
    public static function getInstance() :Router
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new Router();  
        }
    
        return self::$_instance;
    }

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
            $id = intval($routeParam["1"]);
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

        if ($route["route"] === "home") {
            $homeController = $homeController::getInstance($this->_templateEngine);
        } else if ($route["route"] === "posts") {
            $id = $route["param"];
            echo $this->_templateEngine->render('posts.phtml', ['id' => $id]);
        } else if ($route["route"] === "test") {
            $controller = new TestController();
            $controller->index($route["param"]);
        } else {
            echo $this->_templateEngine->render('404.phtml');
        }
    }
}
