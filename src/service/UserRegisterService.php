<?php
/**
 * UserRegisterService File Doc Comment
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
use App\model\UserRegisterModel;
use App\repository\UserRepository;
use App\service\UserService;



/**
 * UserRegisterService Class Doc Comment
 * 
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class UserRegisterService
{
    /**
     * Summary of _userService
     * 
     * @var UserService
     */
    private UserService $_userService;

    /**
     * Summary of _userRepository
     * 
     * @var UserRepository
     */
    private UserRepository $_userRepository;
    
    /**
     * Summary of _instance
     * 
     * @var UserRegisterService
     */
    private static $_instance;

     /**
      * Summary of getInstance
      * That method create the unique instance of the class, if it doesn't exist and return it
      * 
      * @return \App\service\UserRegisterService
      */
    private function __construct()
    {
        $this->_userService = UserService::getInstance();
        $this->_userRepository = UserRepository::getInstance();
    }

    /**
     * Summary of getInstance
     * 
     * @return \App\service\UserRegisterService
     */
    public static function getInstance(): UserRegisterService
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new UserRegisterService();  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of verifyUsername
     * 
     * @param string $username username
     * 
     * @return bool
     */
    public function verifyUsername(string $username): bool
    {
        $usedUsernames = $this->_userService->getUsedUsernames();
        $arrayToVerify = [];
        foreach ($usedUsernames as $key => $usedUsername) {
            array_push($arrayToVerify, strtolower($usedUsername["username"]));
        }
        $verifyUsername = in_array(strtolower($username), $arrayToVerify);
        if ($verifyUsername) {
            return true;
        }
        return false;
    }

    /**
     * Summary of transformToRegister
     * 
     * @param string $firstName firstName
     * @param string $name      name
     * @param string $username  username
     * @param string $email     email
     * @param string $password  password
     * 
     * @return \App\model\UserRegisterModel
     */
    public function transformToUserRegisterModel(
        string $firstName,
        string $name,
        string $username,
        string $email,
        string $password
    ): UserRegisterModel {
        return new UserRegisterModel($firstName, $name, $username, $email, $password);
    }

    /**
     * Summary of saveRegisterData
     * 
     * @param \App\model\UserRegisterModel $userRegisterModel UserRegisterModel
     * 
     * @return bool
     */
    public function saveUserRegisterData(UserRegisterModel $userRegisterModel): bool
    {
        $userId = $this->_userRepository->insertNewUser($userRegisterModel);

        if (!$userId) {
            return false;
        }
        return true;
    }

}
