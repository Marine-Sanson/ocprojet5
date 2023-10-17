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
     * Summary of _instance
     * 
     * @var UserRegisterService
     */
    private static $_instance;

    /**
     * Summary of __construct
     * That method create the unique instance of the class, if it doesn't exist and return it
     * 
     * @param \App\service\UserService       $_userService    UserService
     * @param \App\repository\UserRepository $_userRepository UserRepository
     */
    private function __construct(private UserService $_userService, private UserRepository $_userRepository)
    {

    }

    /**
     * Summary of getInstance
     * 
     * @return \App\service\UserRegisterService
     */
    public static function getInstance(): UserRegisterService
    { 
        if (self::$_instance === null) {
            self::$_instance = new UserRegisterService(UserService::getInstance(), UserRepository::getInstance());  
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
        foreach ($usedUsernames as $usedUsername) {
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
     * Summary of saveUserRegisterData
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
