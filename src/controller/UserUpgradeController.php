<?php
/**
 * UserUpgradeController File Doc Comment
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
use App\mapper\RoleMapper;
use App\mapper\RouteMapper;
use App\service\SessionService;
use App\service\TemplateInterface;
use App\service\UserService;

/**
 * UserUpgradeController Class Doc Comment
 * 
 * @category Controller
 * @package  App\controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class UserUpgradeController extends AbstractController
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
     * @var UserUpgradeController
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
      * @return \App\controller\UserUpgradeController
      */
    public static function getInstance(TemplateInterface $template): UserUpgradeController
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new UserUpgradeController($template);  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of displayUserUpgradePage
     * 
     * @return void
     */
    public function displayUserUpgradePage(): void
    {
        $data = [];
        $role = $this->_sessionService->getUser()->getRole();

        if (!isset($role) || $role !== RoleMapper::Supadmin->getRole()) {
            $template = RouteMapper::HomeView->getTemplate();
            $data[MessageMapper::Error->getMessageLabel()] = MessageMapper::GeneralError->getMessage();
        }

        if (isset($role) && $role === RoleMapper::Supadmin->getRole()) {
            $template = RouteMapper::UserUpgradeView->getTemplate();
            $users = $this->_userService->getAllUsers();
            $data["users"] = $users;
        }

        echo $this->_template->render($template, $data);
    }

    /**
     * Summary of manageUserUpgrade
     * 
     * @param int    $userId    id of the user
     * @param string $role      role of the user
     * @param string $isAllowed 1 if the user is allowed
     * 
     * @return void
     */
    public function manageUserUpgrade(int $userId, string $role, string $isAllowed): void
    {
        $template = RouteMapper::UserUpgradeView->getTemplate();
        $this->_userService->modifyRole($userId, $role, intval($isAllowed));
        $users = $this->_userService->getAllUsers();
        $data["users"] = $users;
        $data[MessageMapper::Message->getMessageLabel()] = MessageMapper::UpdateSuccess->getMessage();

        echo $this->_template->render($template, $data);
    }
}
