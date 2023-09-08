<?php
/**
 * Router File Doc Comment
 * 
 * PHP Version 8.1.10
 * 
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\service;

use App\controller\HomeController;
use App\controller\UserController;
use App\service\TwigService;

 /**
  * Router Class Doc Comment
  * This class parse the url and call the controller wanted
  * 
  * @category Service
  * @package  App\service
  * @author   Marine Sanson <marine_sanson@yahoo.fr>
  * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
  * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
  */
class Router
{
    /**
     * Summary of _templateEngine
     * 
     * @var TemplateInterface
     */
    private TemplateInterface $_templateEngine;
    /**
     * Summary of _instance
     * 
     * @var Router
     */
    private static $_instance;

    /**
     * Summary of __construct
     * 
     * Call an instance of TwigService
     */
    private function __construct()
    {
        $this->_templateEngine = TwigService::getInstance();
    }


    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't
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
     * This method parse the url $_GET["route"] and return an array $route
     * with route and param if needed
     * 
     * @return array with route and param
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
     * This method call parseRoute and load the right controller
     * 
     * @return void
     */
    public function route() :void
    {
        $route = $this->parseRoute();

        switch ($route["route"]) {
        case HomeController::URL:
            $homeController = HomeController::getInstance($this->_templateEngine);
            $homeController->index($route["param"]);                       // temp function
            break;
        case "posts":
            $id = $route["param"];
            echo $this->_templateEngine->render('posts.html.twig', ['id' => $id]);
            break;
        case UserController::URL:
            $userController = UserController::getInstance($this->_templateEngine);
            $data = [];
            if ($_POST === []) {
                $template = 'login.html.twig';
            } else if ($_POST["action"] === "connection") {
                $result = $userController->checkConnection();
                $template = $result["template"];
                $data = $result["data"];
            } else if ($_POST["action"] === "disconnect") {
                $template = 'home.html.twig';
                $session = SessionService::getInstance();
                if ($session->isUserConnected()) {
                    $result = $userController->disconnect();
                    $data = $result["data"];
                }
            }
            echo $userController->template->render($template, $data);
            break;
        default:
            echo $this->_templateEngine->render('404.html.twig', []);
            break;
        }
    }
}
