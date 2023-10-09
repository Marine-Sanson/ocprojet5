<?php
/**
 * PromotingController File Doc Comment
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
use App\service\RoleService;

/**
 * PromotingController Class Doc Comment
 * 
 * @category Controller
 * @package  App\controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class PromotingController extends AbstractController
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
     * @var PromotingController
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

    const URL = "roles";
    const ACTION = "roles";

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
      * @return \App\controller\PromotingController
      */
    public static function getInstance(TemplateInterface $template): PromotingController
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new PromotingController($template);  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of displayPromotingPage
     * 
     * @return void
     */
    public function displayPromotingPage(): void
    {
        $data = [];
        $role = $this->_sessionService->getUser()["role"];

        if (!isset($role) || $role !== RoleService::Supadmin->getLabel()) {
            $template = RouteService::HomeView->getLabel();
            $data[MessageService::ERROR] = MessageService::GENERAL_ERROR;
        }

        if (isset($role) && $role === RoleService::Supadmin->getLabel()) {
            $template = RouteService::PromotingView->getLabel();
            $users = $this->_userService->getAllUsers();
            $data["users"] = $users;
        }

        echo $this->_template->render($template, $data);
    }

    /**
     * Summary of managePromoting
     * 
     * @param int    $userId    id of the user
     * @param string $role      role of the user
     * @param string $isAllowed 1 if the user is allowed
     * 
     * @return void
     */
    public function managePromoting(int $userId, string $role, string $isAllowed): void
    {
        $template = RouteService::PromotingView->getLabel();
        $this->_userService->modifyRole($userId, $role, intval($isAllowed));
        $users = $this->_userService->getAllUsers();
        $data["users"] = $users;
        $data[MessageService::MESSAGE] = MessageService::UPDATE_SUCCES;

        echo $this->_template->render($template, $data);
    }
}
