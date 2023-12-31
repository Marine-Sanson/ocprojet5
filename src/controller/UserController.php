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

use App\mapper\MessageMapper;
use App\mapper\RouteMapper;
use App\service\HomeService;
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
     * Summary of instance
     *
     * @var UserController
     */
    private static $instance;

    const URL = "login";
    const CONNECT = "connection";
    const DISCONNECT = "disconnect";


    /**
     * Summary of __construct
     * Call an instance of TemplateInterface
     *
     * @param \App\service\TemplateInterface $_template       TemplateInterface
     * @param \App\service\UserService       $_userService    UserService
     * @param \App\service\SessionService    $_sessionService SessionService
     * @param \App\service\HomeService       $_homeService    HomeService
     */
    private function __construct(
        private readonly TemplateInterface $_template,
        private readonly UserService $_userService,
        private readonly SessionService $_sessionService,
        private readonly HomeService $_homeService
    ) {

    }//end __construct()


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

        if (self::$instance === null) {
            self::$instance = new UserController($template, UserService::getInstance(), SessionService::getInstance(), HomeService::getInstance());
        }

        return self::$instance;

    }//end getInstance()


    /**
     * Summary of displayLoginPage
     *
     * @return void
     */
    public function displayLoginPage(): void
    {

        $template = RouteMapper::LoginView->getTemplate();

        $this->_template->display($template, []);

    }//end displayLoginPage()


    /**
     * Summary of login
     *
     * @param string $username username
     * @param string $password password
     *
     * @return void
     */
    public function login(string $username, string $password): void
    {

        $template = RouteMapper::LoginView->getTemplate();
        $data = [];
        $username = $this->sanitize($username);
        $user = $this->_userService->connection($username, $password);

        if ($user === null) {
            $data[MessageMapper::Error->getMessageLabel()] = MessageMapper::LoginProblem->getMessage();
        }

        if (isset($data[MessageMapper::Error->getMessageLabel()]) === false) {
            $this->_sessionService->setUser($user);

            $data["session"] = $this->_sessionService->getSession();

            $lastPosts = $this->_homeService->getLastPosts();
            $lastPosts = $this->sanitizeLastPosts($lastPosts);

            $data["lastPosts"] = $lastPosts;

            $template = RouteMapper::HomeView->getTemplate();
            $data[MessageMapper::Message->getMessageLabel()] = $user->getFirstName().MessageMapper::LoginSuccess->getMessage();
        }

        $this->_template->display($template, $data);

    }//end login()


    /**
     * Summary of logout
     *
     * @return void
     */
    public function logout(): void
    {

        $template = RouteMapper::HomeView->getTemplate();

        if ($this->_sessionService->isUserConnected() === true) {
            $this->_sessionService->cleanSession();
            $data = [
                MessageMapper::Message->getMessageLabel() => MessageMapper::Disconnect->getMessage()
            ];
        }

        $data["session"] = $this->_sessionService->getSession();

        
        $lastPosts = $this->_homeService->getLastPosts();
        $lastPosts = $this->sanitizeLastPosts($lastPosts);

        $data["lastPosts"] = $lastPosts;

        $this->_template->display($template, $data);

    }//end logout()


}//end class
