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

use App\service\MessageService;
use App\service\RouteService;
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
    const CONNECT = "connection";
    const DISCONNECT = "disconnect";

    /**
     * Summary of __construct
     * call an instance of TemplateInterface
     * 
     * @param TemplateInterface $template template engine
     */
    private function __construct(TemplateInterface $template)
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
        $template = RouteService::LOGIN_VIEW;

        echo $this->_template->render($template, []);
    }

    /**
     * Summary of login
     * 
     * @param string $username username
     * @param string $password password
     * 
     * @return void
     */
    public function login(string $username, string $password)
    {
        $template = RouteService::LOGIN_VIEW;
        $data = [];
        $username = $this->sanitize($username);
        $user = $this->_userService->connection($username, $password);

        if ($user === null) {
            $data[MessageService::ERROR] = MessageService::LOGIN_PROBLEM;
        }

        if (!isset($data[MessageService::ERROR])) {
            $this->_sessionService->setUser($user);

            $data["session"] = $this->_sessionService->getSession();
    
            $template = RouteService::HOME_VIEW;
            $data[MessageService::MESSAGE] = $user->firstName . MessageService::LOGIN_SUCCESS;
        }

        echo $this->_template->render($template, $data);
    }

    /**
     * Summary of logout
     * 
     * @return void
     */
    public function logout()
    {
        $template = RouteService::HOME_VIEW;
        if ($this->_sessionService->isUserConnected()) {

            $this->_sessionService->cleanSession();
            $data = [
                MessageService::MESSAGE => MessageService::DISCONNECT
            ];
        }
        $data["session"] = $this->_sessionService->getSession();

        echo $this->_template->render($template, $data);
    }

}
