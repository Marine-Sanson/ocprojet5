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

use App\controller\CommentController;
use App\controller\ContactController;
use App\controller\HomeController;
use App\controller\PostController;
use App\controller\UserController;
use App\controller\UserRegisterController;
use App\controller\UserUpgradeController;
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
     * Summary of _instance
     * 
     * @var Router
     */
    private static $instance;

    /**
     * Summary of __construct
     * Call an instance of TwigService
     * 
     * @param \App\service\TwigService $_templateEngine TwigService
     */
    private function __construct(private TwigService $_templateEngine)
    {

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
        if (self::$instance === null) {
            self::$instance = new Router(TwigService::getInstance());  
        }
    
        return self::$instance;
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
        $route["route"] = "home";
        if (isset($_GET["route"])) {
            $routeParam = explode("/", $_GET["route"]);
            $route["route"] = $routeParam[0];
        }

        $id = null;
        if (isset($routeParam) && count($routeParam) === 2) {
            $id = (int) ($routeParam["1"]);
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
        if (isset($_POST)) {
            $post = $this->postToArray($_POST);
        }
        if(isset($post["action"])) {
            $postAction = $post["action"];
        }

        switch ($route["route"]) {

            case HomeController::URL:
                $homeController = HomeController::getInstance($this->_templateEngine);
                $homeController->displayHome();
                break;
                
            case PostController::URL:
                $postController = PostController::getInstance($this->_templateEngine);
                if (isset($route["param"]) === false) {
                    if (isset($postAction) && $postAction === PostController::ACTION) {
                        $postController->addPost($post);
                        break;
                    }
                    $postController->showPosts();
                    break;
                }
                if (isset($route["param"])) {
                    if (isset($postAction)) {
                        $this->onePostAction($route["param"], $postController, $post);
                        break;
                    }
                    $postController->showPostDetails($route["param"]);
                    break;
                }
                $this->_templateEngine->display(RouteMapper::Page404->getTemplate(), []);
                break;

            case UserController::URL:
                $userController = UserController::getInstance($this->_templateEngine);
                if (isset($postAction) === false) {
                    $userController->displayLoginPage();
                    break;
                }
                if (isset($postAction)) {
                    $this->connectAction($userController, $post);
                    break;
                }
                $this->_templateEngine->display(RouteMapper::Page404->getTemplate(), []);
                break;

            case UserUpgradeController::URL:
                $userUpgradeController = UserUpgradeController::getInstance($this->_templateEngine);
                if (isset($postAction) && $postAction === UserUpgradeController::ACTION) {
                    $userUpgradeController->manageUserUpgrade($post);
                    break;
                }
                $userUpgradeController->displayUserUpgradePage();
                break;

            case CommentController::URL:
                $commentController = CommentController::getInstance($this->_templateEngine);
                if (isset($postAction)) {
                    $this->commentAction($commentController, $post);
                    break;
                }

                $commentController->displayValidationPage();
                break;

            case UserRegisterController::URL:
                $userRegisterController = UserRegisterController::getInstance($this->_templateEngine);
                if (isset($postAction) && $postAction === UserRegisterController::ACTION) {
                    $userRegisterController->manageUserRegister($post);
                    break;
                }
                $userRegisterController->displayUserRegisterPage();
                break;

            case ContactController::URL: 
                $contactController = ContactController::getInstance($this->_templateEngine, ContactService::getInstance());
                if (isset($postAction) && $postAction === ContactController::ACTION) {
                    $contactController->manageContact($post);
                    break;
                }
                $contactController->displayContactPage();
                break;

            default:
                $this->_templateEngine->display(RouteMapper::Page404->getTemplate(), []);
                break;
        }
    }

    private function postToArray(array $superPost): array
    {
        $post = [];
        return array_replace($post, $superPost);
    }

    private function commentAction(CommentController $commentController, array $post): void
    {
        switch ($post["action"]) {

            case CommentController::VALIDATION:
                $commentController->validateComment((int) $post["commentId"]);
                break;

            case CommentController::DELETE:
                $commentController->deleteComment((int) $post["commentId"]);
                break;

            default :
                $this->_templateEngine->display(RouteMapper::Page404->getTemplate(), []);
                break;
        }
    }

    private function connectAction(UserController $userController, array $post): void
    {
        switch ($post["action"]) {

            case UserController::CONNECT:
                $userController->login($post["username"], $post["password"]);
                break;

            case UserController::DISCONNECT:
                $userController->logout();
                break;

            default :
                $this->_templateEngine->display(RouteMapper::Page404->getTemplate(), []);
                break;
        }
    }

    private function onePostAction(int $routeParam, PostController $postController, array $post): void
    {
        switch ($post["action"]) {

            case CommentService::ACTION:
                $postController->addComment($routeParam, $post);
                break;

            case PostController::MODIFY:
                $postController->modifyPost($routeParam, $post);
                break;

            default :
                $this->_templateEngine->display(RouteMapper::Page404->getTemplate(), []);
                break;
        }
    }

}
