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

use App\entity\UserEntity;
use App\mapper\UserMapper;
use App\model\UserConnectionModel;
use App\repository\UserRepository;
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
    private static $instance;

    /**
     * Summary of __construct
     *
     * @param \App\mapper\UserMapper         $_userMapper     UserMapper
     * @param \App\repository\UserRepository $_userRepository UserRepository
     * @param \App\service\SessionService    $_session        SessionService
     */
    private function __construct(
        private readonly UserMapper $_userMapper,
        private readonly UserRepository $_userRepository,
        private readonly SessionService $_session
    ) {

    }//end __construct()


     /**
      * Summary of getInstance
      * That method create the unique instance of the class, if it doesn't exist and return it
      *
      * @return \App\service\UserService
      */
    public static function getInstance(): UserService
    {

        if (self::$instance === null) {
            self::$instance = new UserService(
                UserMapper::getInstance(),
                UserRepository::getInstance(),
                SessionService::getInstance()
            );
        }

        return self::$instance;

    }//end getInstance()

    /**
     * Summary of connect
     * verify password connect the user and put the data needed in the session
     *
     * @param string                 $password   come from form
     * @param \App\entity\UserEntity $userEntity UserEntity
     *
     * @return bool
     */
    public function connect(string $password, UserEntity $userEntity): bool
    {

        return password_verify($password, $userEntity->getPassword());

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
     * Summary of getUser
     *
     * @param string $username come from the connection form
     *
     * @return \App\entity\UserEntity | null
     */
    public function getUser(string $username): ?UserEntity
    {

        $result = $this->_userRepository->getUser($username);

        $user = null;

        if ($result !== []) {
            $creationDate = $result[0]["creation_date"];
            $creationDate = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));

            $updateDate = $result[0]["last_update_date"];
            $updateDate = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));

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
        }//end if

        return $user;

    }

    /**
     * Summary of connection
     *
     * @param string $username username
     * @param string $password password
     *
     * @return UserConnectionModel|null
     */
    public function connection(string $username, string $password): ?UserConnectionModel
    {

        $userEntity = $this->getUser($username);

        if ($userEntity === false) {
            return null;            
        }

        $connect = $this->connect($password, $userEntity);

        if ($connect === false) {
            return null;
        }

        $connectionModel = $this->getUserConnectionModel($userEntity);

        return $connectionModel;

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

    /**
     * Summary of getUsedUsernames
     *
     * @return array
     */
    public function getUsedUsernames(): array
    {

        return $this->_userRepository->getAllUsernames();

    }

    /**
     * Summary of getAllUsers
     *
     * @return array
     */
    public function getAllUsers(): array
    {

        $users = $this->_userRepository->getAllUsers();
        $list = [];
        foreach ($users as $user) {
            $list[] = $this->transformToUserConnectionModel($user);
        }

        return $list;

    }

    /**
     * Summary of transformToUserConnectionModel
     *
     * @param array $user user
     *
     * @return \App\model\UserConnectionModel
     */
    public function transformToUserConnectionModel(array $user): UserConnectionModel
    {

        $isUserAllowed = false;

        if ($user["is_allowed"] === 1) {
            $isUserAllowed = true;
        }
        
        return new UserConnectionModel(
            $user["id"],
            $user["first_name"],
            $user["username"],
            $user["password"],
            $user["role"],
            $isUserAllowed
        );

    }

    /**
     * Summary of modifyRole
     *
     * @param int    $userId    id of the user
     * @param string $role      role of the user
     * @param int    $isAllowed 1 if the user is allowed
     *
     * @return void
     */
    public function modifyRole(int $userId, string $role, int $isAllowed): void
    {

        $this->_userRepository->updateRole($userId, $role, $isAllowed);

    }

}
