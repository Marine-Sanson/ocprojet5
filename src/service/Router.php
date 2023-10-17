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
        if(isset($_POST["action"])) {
            $postAction = $_POST["action"];
        }
        switch ($route["route"]) {

            case HomeController::URL:
                $homeController = HomeController::getInstance($this->_templateEngine);
                $homeController->displayHome();
                break;
                
            case PostController::URL:
                $postController = PostController::getInstance($this->_templateEngine);
                if (!isset($route["param"])) {
                    if (isset($postAction) && $postAction === PostController::ACTION) {
                        $postController->addPost(
                            (int) $_POST["userId"],
                            $_POST["title"],
                            $_POST["summary"],
                            $_POST["content"]
                        );
                        break;
                    }
                    $postController->showPosts();
                    break;
                }
                if (isset($route["param"])) {
                    if (isset($postAction) && $postAction === CommentService::ACTION) {
                        $postController->addComment(
                            $route["param"],
                            (int) $_POST["postId"],
                            $_POST["username"],
                            $_POST["content"]
                        );
                        break;
                    }
                    if (isset($postAction) && $postAction === PostController::MODIFY) {
                        $postController->modifyPost(
                            $route["param"],
                            (int) $_POST["userId"],
                            $_POST["username"],
                            (int) $_POST["postId"],
                            $_POST["title"],
                            $_POST["summary"],
                            $_POST["content"]
                        );
                        break;
                    }
                    $postController->showPostDetails($route["param"]);
                    break;
                }
                $this->_templateEngine->display('404.html.twig', []);
                break;

            case UserController::URL:
                $userController = UserController::getInstance($this->_templateEngine);
                if (!isset($postAction)) {
                    $userController->displayLoginPage();
                    break;
                }
                if ($postAction === UserController::CONNECT) {
                    $userController->login($_POST["username"], $_POST["password"]);
                    break;
                }
                if ($postAction === UserController::DISCONNECT) {
                    $userController->logout();
                    break;
                }
                $this->_templateEngine->display('404.html.twig', []);
                break;

            case UserUpgradeController::URL:
                $userUpgradeController = UserUpgradeController::getInstance($this->_templateEngine);
                if (isset($postAction) && $postAction === UserUpgradeController::ACTION) {
                    $userUpgradeController->manageUserUpgrade(
                        (int) $_POST['userId'],
                        $_POST['role'],
                        (int) $_POST['isAllowed']
                    );
                    break;
                }
                $userUpgradeController->displayUserUpgradePage();
                break;

            case CommentController::URL:
                $commentController = CommentController::getInstance($this->_templateEngine);
                if (isset($postAction) && ($postAction === CommentController::VALIDATION)) {
                    $commentController->validateComment((int) $_POST["commentId"]);
                    break;
                }
                if (isset($postAction) && ($postAction === CommentController::DELETE)) {
                    $commentController->deleteComment((int) $_POST["commentId"]);
                    break;
                }
                $commentController->displayValidationPage();
                break;

            case UserRegisterController::URL:
                $userRegisterController = UserRegisterController::getInstance($this->_templateEngine);
                if (isset($postAction) && $postAction === UserRegisterController::ACTION) {
                    $userRegisterController->manageUserRegister(
                        $_POST["firstName"],
                        $_POST["name"],
                        $_POST["username"],
                        $_POST["email"],
                        $_POST["password"],
                        $_POST["passwordVerify"]
                    );
                    break;
                }
                $userRegisterController->displayUserRegisterPage();
                break;

            case ContactController::URL: 
                $contactController = ContactController::getInstance($this->_templateEngine, ContactService::getInstance());
                if (isset($postAction) && $postAction === ContactController::ACTION) {
                    $contactController->manageContact(
                        $_POST["name"], 
                        $_POST["firstName"], 
                        $_POST["email"], 
                        $_POST["content"]
                    );
                    break;
                }
                $contactController->displayContactPage();
                break;

            default:
                $this->_templateEngine->display('404.html.twig', []);
                break;
        }
    }
}
