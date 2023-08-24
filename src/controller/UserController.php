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

use App\entity\UserEntity;
use App\repository\UserRepository;
use App\service\TemplateInterface;
use App\service\UserService;
use DateTime;

/**
 * UserController Class Doc Comment
 * 
 * @category Controller
 * @package  App\controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class UserController
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

    const URL = "login";

    /**
     * Summary of __construct call an instance of TemplateInterface
     * 
     * @param TemplateInterface $template template engine
     */
    public function __construct(TemplateInterface $template)
    {
        $this->template = $template;
    }

     /**
      * Summary of getInstance
      * That method create the unique instance of the class, if it doesn't
      * exist and return it
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
        $username = $_POST["username"];
        $password = $_POST["password"];

        $userService = new UserService;
        $result = $userService->checkConnection($username, $password);

        return $result;
    }

    /**
     * Summary of disconnect - destroy the session
     * 
     * @return array $data
     */
    public function disconnect() : array
    {
        session_destroy();
        $_SESSION["connected"] = false;
        $data = [
            "message" => "Vous êtes déconnecté"
        ];
        $result = [
            "data" => $data
        ];

        return $result;
    }

    /**
     * Summary of hashPassword - will hash the user password before insert it 
     * to the db
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
