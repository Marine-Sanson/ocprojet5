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

use App\controller\ContactController;
use App\controller\HomeController;
use App\controller\PostController;
use App\controller\RegisterController;
use App\controller\UserController;
use App\service\SessionService;
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
    public static function getInstance(): Router
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
    public function parseRoute(): array
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
    public function route(): void
    {
        $route = $this->parseRoute();
        switch ($route["route"]) {
            case HomeController::URL:
                $homeController = HomeController::getInstance($this->_templateEngine);
                $homeController->displayHome();
                break;
            case PostController::URL:
                $postController = PostController::getInstance($this->_templateEngine);
                if (isset($route["param"])) {
                    $postController->showPostDetails($route["param"]);
                    break;
                }
                $postController->showPosts();
                break;
            case UserController::URL:
                $userController = UserController::getInstance($this->_templateEngine);
                if (!isset($_POST["action"])) {
                    $userController->displayLoginPage();
                    break;
                }
                if ($_POST["action"] === UserController::CONNECT) {
                    $userController->login($_POST["username"], $_POST["password"]);
                    break;
                }
                if ($_POST["action"] === UserController::DISCONNECT) {
                    $userController->logout();
                    break;
                }
                echo $this->_templateEngine->render('404.html.twig', []);
                break;
            case RegisterController::URL:
                $registerController = RegisterController::getInstance($this->_templateEngine);
                if (isset($_POST["action"])) {
                    $registerController->manageRegister();
                    break;
                }
                $registerController->displayRegisterPage();
                break;
                case ContactController::URL: 
                $contactController = ContactController::getInstance($this->_templateEngine);
                if (isset($_POST["action"]) && $_POST["action"] === $contactController::ACTION) {
                    $contactController->manageContact();
                    break;
                }
                $contactController->displayContactPage();
                break;

            default:
                echo $this->_templateEngine->render('404.html.twig', []);
                break;
        }
    }
}
