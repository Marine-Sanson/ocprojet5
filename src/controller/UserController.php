<?php
/**
 * UserController File Doc Comment
 * 
 * PHP Version 8.1.10
 * 
 * @category Controller
 * @package  App\controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\controller;

use App\mapper\UserMapper;
use App\service\MessageService;
use App\service\SessionService;
use App\service\TemplateInterface;
use App\service\UserService;

/**
 * UserController Class Doc Comment
 * 
 * @category Controller
 * @package  App\controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class UserController extends AbstractController
{
    /**
     * Summary of template
     * 
     * @var TemplateInterface
     */
    private TemplateInterface $_template;

    /**
     * Summary of _instance
     * 
     * @var UserController
     */
    private static $_instance;

    /**
     * Summary of _userService
     * 
     * @var UserService
     */
    private UserService $_userService;

    /**
     * Summary of _sessionService
     * 
     * @var SessionService
     */
    private SessionService $_sessionService;

    const URL = "login";
    const LOGIN_VIEW = "login.html.twig";
    const CONNECT = "connection";
    const DISCONNECT = "disconnect";

    /**
     * Summary of __construct
     * call an instance of TemplateInterface
     * 
     * @param TemplateInterface $template template engine
     */
    public function __construct(TemplateInterface $template)
    {
        $this->_template = $template;
        $this->_userService = UserService::getInstance();
        $this->_sessionService = SessionService::getInstance();
    }

     /**
      * Summary of getInstance
      * That method create the unique instance of the class, if it doesn't exist and return it
      * 
      * @param \App\service\TemplateInterface $template template engine
      * 
      * @return \App\controller\UserController
      */
    public static function getInstance(TemplateInterface $template): UserController
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new UserController($template);  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of displayLoginPage
     * 
     * @return void
     */
    public function displayLoginPage(): void
    {
        $template = self::LOGIN_VIEW;

        echo $this->_template->render($template, []);
    }

    /**
     * Summary of checkAction
     * 
     * @return void
     */
    public function checkAction(): void
    {
        $template = self::LOGIN_VIEW;
        $data = [];

        switch ($_POST["action"]) {
            case self::CONNECT:
                $username = self::cleanInput($_POST["username"]);
                $password = $_POST["password"];
                $checkConnectionData = $this->_userService->checkData($username, $password);

                if ($checkConnectionData) {
                    $userEntity = $this->_userService->getUser($username, $password);

                    if ($userEntity) {
                        $connect = $this->_userService->connect($password, $userEntity);

                        if ($connect) {
                            $connectionModel = $this->_userService->getUserConnectionModel($userEntity);
                            $this->_userService->startUserSession($connectionModel);

                            $sessionData = $this->_sessionService->getSession();

                            $data["session"] = [$sessionData];

                            $template = HomeController::HOME_VIEW;
                            $data[] = [
                                MessageService::MESSAGE => ucfirst($connectionModel->firstName) . MessageService::LOGIN_SUCCESS
                            ];

                        } else {
                            $data[] = [
                                MessageService::ERROR => MessageService::LOGIN_ERROR
                            ];
                        }
                    } else {
                        $data[] = [
                            MessageService::ERROR => MessageService::LOGIN_PROBLEM
                        ];
                    }

                    echo $this->_template->render($template, $data);
                    break;
                }

                $data = [
                    MessageService::ERROR => MessageService::CONNECTION_ERROR
                ];
                echo $this->_template->render($template, $data);
                break;

            case self::DISCONNECT:
                $homeController = HomeController::getInstance($this->_template);
                $template = $homeController::HOME_VIEW;
                $session = SessionService::getInstance();
                if ($session->isUserConnected()) {
                    $result = $this->disconnect();
                    $data = $result["data"];
                }
                $sessionData = $this->_sessionService->getSession();
                $data["session"] = [$sessionData];
                echo $this->_template->render($template, $data);
                break;
            default:
                echo $this->_template->render($template, $data);
                break;
            }
    }

    /**
     * Summary of disconnect - destroy the session
     * 
     * @return array $data
     */
    public function disconnect():  array
    {
        $session = SessionService::getInstance();
        $session->clear();
        $session->destroy();
        
        $data = [
            MessageService::MESSAGE => MessageService::DISCONNECT
        ];
        $result = [
            "data" => $data
        ];

        return $result;
    }

    /**
     * Summary of hashPassword - will hash the user password before insert it to the db
     * 
     * @param string $password password entered by the user
     * 
     * @return string
     */
    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT, ["cost" => "14"]);
    }

}
