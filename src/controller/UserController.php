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
    public TemplateInterface $template;

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
    private $_userService;

    const URL = "login";
    const LOGIN_VIEW = "login.html.twig";
    const CONNECT = "connection";
    const DISCONNECT = "disconnect";

    /**
     * Summary of __construct call an instance of TemplateInterface
     * 
     * @param TemplateInterface $template template engine
     */
    public function __construct(TemplateInterface $template)
    {
        $this->template = $template;
        $this->_userService = UserService::getInstance();
    }

     /**
      * Summary of getInstance
      * That method create the unique instance of the class, if it doesn't exist and return it
      * 
      * @param \App\service\TemplateInterface $template template engine
      * 
      * @return \App\controller\UserController
      */
    public static function getInstance(TemplateInterface $template) :UserController
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new UserController($template);  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of checkConnection
     * 
     * @return array $data $template
     */
    public function checkConnection() :array
    {
        $username = self::cleanInput($_POST["username"]);
        $password = $_POST["password"];

        $checkConnectionData = $this->_userService->checkData($username, $password);
        $data = [];

        if (!$checkConnectionData) {
            $template = self::LOGIN_VIEW;
            $data = [
                MessageService::ERROR => MessageService::CONNECTION_ERROR
            ];
        } else {
            $userEntity = $this->_userService->getUser($username, $password);
            if ($userEntity) {
                $userMapper = new UserMapper;
                $connectionModel = $userMapper->transformToUserConnectionModel($userEntity);
                $result = $this->_userService->connect($password, $connectionModel);
                $template = $result["template"];
                $data = $result["data"];
            } else {
                $template = self::LOGIN_VIEW;
                $data = [
                    MessageService::ERROR => MessageService::LOGIN_PROBLEM
                ];
            }
        }
        $result = [
            "template" => $template,
            "data" => $data
        ];

        return $result;
    }

    /**
     * Summary of disconnect - destroy the session
     * 
     * @return array $data
     */
    public function disconnect() : array
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
    public function hashPassword(string $password) :string
    {
        return password_hash($password, PASSWORD_DEFAULT, ["cost" => "14"]);
    }

}
