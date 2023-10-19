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

    }//end __construct()


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

    }//end getInstance()


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

        if (isset($_GET["route"]) === true) {
            $routeParam = explode("/", $_GET["route"]);
            $route["route"] = $routeParam[0];
        }

        $id = null;

        if (isset($routeParam) === true && count($routeParam) === 2) {
            $id = (int) ($routeParam["1"]);
        }

        $route["param"] = $id;
        return $route;

    }//end parseRoute()


    /**
     * Summary of route
     * This method call parseRoute and load the right controller
     *
     * @return void
     */
    public function route(): void
    {

        $route = $this->parseRoute();
        $post = null;
        if (isset($_POST) === true) {
            $post = $this->postToArray($_POST);
        }

        switch ($route["route"]) {
            case HomeController::URL:
                $homeController = HomeController::getInstance($this->_templateEngine);
                $homeController->displayHome();
                break;

            case PostController::URL:
                $this->postControllerUrl($route, $post);
                break;

            case UserController::URL:
                $this->userControllerUrl($post);
                break;

            case UserUpgradeController::URL:
                $this->userUpgradeControllerUrl($post);
                break;

            case CommentController::URL:
                $this->commentControllerUrl($post);
                break;

            case UserRegisterController::URL:
                $this->userRegisterControllerUrl($post);
                break;

            case ContactController::URL:
                $this->contactControllerUrl($post);
                break;

            default:
                $this->_templateEngine->display(RouteMapper::Page404->getTemplate(), []);
                break;
        }//end switch

    }//end route()


    /**
     * Summary of postToArray
     *
     * @param array $superPost $_POST
     *
     * @return array
     */
    private function postToArray(array $superPost): array
    {

        $post = [];
        return array_replace($post, $superPost);

    }//end postToArray()


    /**
     * Summary of postControllerUrl
     *
     * @param array $route route
     * @param array $post  post
     *
     * @return void
     */
    private function postControllerUrl(array $route, array $post)
    {

        $postController = PostController::getInstance($this->_templateEngine);

        switch ($route) {
            case ($route["param"] === null):

                if (isset($post["action"]) === true && $post["action"] === PostController::ACTION) {
                    $postController->addPost($post);
                    break;
                }

                $postController->showPosts();
                break;

            case (isset($route["param"])):

                if (isset($post["action"]) === true) {
                    switch ($post["action"]) {
                        case CommentService::ACTION:
                            $postController->addComment($route["param"], $post);
                            break;

                        case PostController::MODIFY:
                            $postController->modifyPost($route["param"], $post);
                            break;

                        default :
                            $this->_templateEngine->display(RouteMapper::Page404->getTemplate(), []);
                            break;
                    }
                }

                $postController->showPostDetails($route["param"]);
                break;

            default :
                $this->_templateEngine->display(RouteMapper::Page404->getTemplate(), []);
                break;
        }//end switch

    }//end postControllerUrl()


    /**
     * Summary of userControllerUrl
     *
     * @param array $post post
     *
     * @return void
     */
    private function userControllerUrl(array $post): void
    {

        $userController = UserController::getInstance($this->_templateEngine);

        switch ($post) {
            case (null):
                $userController->displayLoginPage();
                break;

            case (isset($post["action"])):

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

            default:
                $this->_templateEngine->display(RouteMapper::Page404->getTemplate(), []);
                break;
        }//end switch

    }//end userControllerUrl()


    /**
     * Summary of userUpgradeControllerUrl
     *
     * @param array $post post
     *
     * @return void
     */
    private function userUpgradeControllerUrl(array $post): void
    {

        $userUpgradeCtrl = UserUpgradeController::getInstance($this->_templateEngine);

        switch ($post) {
            case (null):
                $userUpgradeCtrl->displayUserUpgradePage();
                break;

            case (isset($post["action"]) === true && $post["action"] === UserUpgradeController::ACTION):
                $userUpgradeCtrl->manageUserUpgrade($post);
                break;

            default:
                $this->_templateEngine->display(RouteMapper::Page404->getTemplate(), []);
                break;
        }

    }//end userUpgradeControllerUrl()


    /**
     * Summary of commentControllerUrl
     *
     * @param array $post post
     *
     * @return void
     */
    private function commentControllerUrl(array $post): void
    {

        $commentController = CommentController::getInstance($this->_templateEngine);
        switch ($post) {
            case (null):
                $commentController->displayValidationPage();
                break;

            case (isset($post["action"])):

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

            default:
                $this->_templateEngine->display(RouteMapper::Page404->getTemplate(), []);
                break;
        }//end switch

    }//end commentControllerUrl()


    /**
     * Summary of userRegisterControllerUrl
     *
     * @param array $post post
     *
     * @return void
     */
    private function userRegisterControllerUrl(array $post): void
    {

        $userRegisterCtrl = UserRegisterController::getInstance($this->_templateEngine);

        switch ($post) {
            case (null):
                $userRegisterCtrl->displayUserRegisterPage();
                break;

            case (isset($post["action"]) && $post["action"] === UserRegisterController::ACTION):
                $userRegisterCtrl->manageUserRegister($post);
                break;

            default:
                $this->_templateEngine->display(RouteMapper::Page404->getTemplate(), []);
                break;
        }

    }//end userRegisterControllerUrl()


    /**
     * Summary of contactControllerUrl
     *
     * @param array $post post
     *
     * @return void
     */
    private function contactControllerUrl(array $post): void
    {

        $contactController = ContactController::getInstance($this->_templateEngine, ContactService::getInstance());

        switch ($post) {
            case (null):
                $contactController->displayContactPage();
                break;

            case (isset($post["action"]) && $post["action"] === ContactController::ACTION):
                $contactController->manageContact($post);
                break;

            default :
                $this->_templateEngine->display(RouteMapper::Page404->getTemplate(), []);
                break;
        }

    }//end contactControllerUrl()


}
