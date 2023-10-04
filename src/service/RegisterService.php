<?php
/**
 * RegisterService File Doc Comment
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
use App\model\RegisterModel;
use App\repository\UserRepository;
use App\service\UserService;



/**
 * RegisterService Class Doc Comment
 * 
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class RegisterService
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
     * @var RegisterService
     */
    private static $_instance;

     /**
      * Summary of getInstance
      * That method create the unique instance of the class, if it doesn't exist and return it
      * 
      * @return \App\service\RegisterService
      */
    private function __construct()
    {
        $this->_userService = UserService::getInstance();
        $this->_userRepository = UserRepository::getInstance();
    }

    /**
     * Summary of getInstance
     * 
     * @return \App\service\RegisterService
     */
    public static function getInstance(): RegisterService
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new RegisterService();  
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
     * @return \App\model\RegisterModel
     */
    public function transformToRegister(
        string $firstName,
        string $name,
        string $username,
        string $email,
        string $password
    ): RegisterModel {
        return new RegisterModel($firstName, $name, $username, $email, $password);
    }

    /**
     * Summary of saveRegisterData
     * 
     * @param \App\model\RegisterModel $registerModel RegisterModel
     * 
     * @return bool
     */
    public function saveRegisterData(RegisterModel $registerModel): bool
    {
        $userId = $this->_userRepository->insertNewUser($registerModel);

        if (!$userId) {
            return false;
        }
        return true;
    }

}
