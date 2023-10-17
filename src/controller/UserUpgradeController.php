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
    private static $instance;

    const URL = "roles";
    const ACTION = "roles";

    /**
     * Summary of __construct
     * call an instance of TemplateInterface
     * 
     * @param \App\service\TemplateInterface $template        TemplateInterface
     * @param \App\service\UserService       $_userService    UserService
     * @param \App\service\SessionService    $_sessionService SessionService
     */
    private function __construct(TemplateInterface $template, private UserService $_userService, private SessionService $_sessionService)
    {
        $this->_template = $template;
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
        if (self::$instance === null) {
            self::$instance = new UserUpgradeController($template, UserService::getInstance(), SessionService::getInstance());  
        }
    
        return self::$instance;
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

        $this->_template->display($template, $data);
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
    public function manageUserUpgrade(int $userId, string $role, int $isAllowed): void
    {
        $template = RouteMapper::UserUpgradeView->getTemplate();
        $data = [];
        $this->_userService->modifyRole($userId, $role, (int) $isAllowed);
        $users = $this->_userService->getAllUsers();
        $data["users"] = $users;
        $data[MessageMapper::Message->getMessageLabel()] = MessageMapper::UpdateSuccess->getMessage();

        $this->_template->display($template, $data);
    }
}
