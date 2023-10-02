<?php
/**
 * UserService File Doc Comment
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

use App\controller\HomeController;
use App\controller\UserController;
use App\entity\UserEntity;
use App\mapper\UserMapper;
use App\model\UserConnectionModel;
use App\repository\UserRepository;
use App\service\SessionInterface;
use App\service\SessionService;
use DateTime;

/**
 * UserService Class Doc Comment
 * 
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class UserService
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
     * @var UserService
     */
    private static $_instance;

    /**
     * Summary of session
     * 
     * @var SessionInterface
     */
    private SessionInterface $_session;
    /**
     * Summary of _userRepository
     * 
     * @var UserRepository
     */
    private UserRepository $_userRepository;

    /**
     * Summary of _userMapper
     * 
     * @var UserMapper
     */
    private UserMapper $_userMapper;

    /**
     * Summary of __construct
     */
    private function __construct()
    {
        $this->_session = SessionService::getInstance();
        $this->_userRepository = new UserRepository();
        $this->_userMapper = UserMapper::getInstance();

    }
     /**
      * Summary of getInstance
      * That method create the unique instance of the class, if it doesn't exist and return it
      * 
      * @return \App\service\UserService
      */
    public static function getInstance(): UserService
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new UserService();
        }
    
        return self::$_instance;
    }

    /**
     * Summary of connect
     * verify password connect the user and put the data needed in the session
     * 
     * @param string                 $password   come from form
     * @param \App\entity\UserEntity $userEntity UserEntity
     * 
     * @return array
     */
    public function connect(string $password, UserEntity $userEntity): bool
    {
        return password_verify($password, $userEntity->password);
    }

    /**
     * Summary of getUserConnectionModel
     * 
     * @param UserEntity $userEntity UserEntity
     * 
     * @return \App\model\UserConnectionModel
     */
    public function getUserConnectionModel(UserEntity $userEntity): UserConnectionModel
    {
        return $this->_userMapper->transformToUserConnectionModel($userEntity);
    }

    /**
     * Summary of startUserSession
     * 
     * @param \App\model\UserConnectionModel $connectionModel UserConnectionModel
     * 
     * @return void
     */
    public function startUserSession(UserConnectionModel $connectionModel): void
    {
        $this->_session->setUser($connectionModel);
    }

    /**
     * Summary of getUser
     * 
     * @param string $username come from the connection form
     * @param string $password come from the connection form
     * 
     * @return \App\entity\UserEntity | null
     */
    public function getUser(string $username, string $password): ?UserEntity
    {
        $result = $this->_userRepository->getUser($username);

        if ($result !== []) {

            $creationDate = $result[0]["creation_date"];
            $creationDate = DateTime::createFromFormat(
                "Y-m-d H:i:s", 
                date("Y-m-d H:i:s")
            );

            $updateDate = $result[0]["last_update_date"];
            $updateDate = DateTime::createFromFormat(
                "Y-m-d H:i:s", 
                date("Y-m-d H:i:s")
            );

            $allowed = boolval($result[0]["is_allowed"]);

            $user = new UserEntity(
                $result[0]["id"], 
                $result[0]["name"], 
                $result[0]["first_name"], 
                $result[0]["username"], 
                $result[0]["email"], 
                $result[0]["password"], 
                $result[0]["role"], 
                $creationDate, 
                $updateDate,
                $allowed
            );
        } else {
            $user = null;
        }
        return $user;
    }

    /**
     * Summary of checkData
     * verify the data entered by the user and verify if they are empty
     * 
     * @param string $username come from the connection form
     * @param string $password come from the connection form
     * 
     * @return bool
     */
    public function checkData(string $username, string $password)
    {
        if ($username === "" || $password === "") {
            return false;
        }
        
        return true;
    }

    /**
     * Summary of getUserId
     * 
     * @param string $username username
     * 
     * @return int
     */
    public function getUserId(string $username): int
    {
        return $this->_userRepository->getUserId($username);
    }
}
