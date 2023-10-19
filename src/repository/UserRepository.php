<?php
/**
 * UserRepository File Doc Comment
 * 
 * PHP Version 8.1.10
 * 
 * @category Repository
 * @package  App\repository
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\repository;

use App\model\UserRegisterModel;
use App\service\DatabaseService;
use DateTime;

/**
 * UserRepository Class Doc Comment
 * 
 * @category Repository
 * @package  App\repository
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class UserRepository
{

    /**
     * Summary of _instance
     * 
     * @var UserRepository
     */
    private static $instance;

    
    /**
     * Summary of __construct
     * 
     * @param \App\service\DatabaseService $db DatabaseService
     */
    private function __construct(private DatabaseService $db)
    {

    }//end __construct()

    
    /**
     * Summary of getInstance
     * 
     * @return \App\repository\UserRepository
     */
    public static function getInstance(): UserRepository
    {

        if (self::$instance === null) {
            self::$instance = new UserRepository(DatabaseService::getInstance());
        }
    
        return self::$instance;

    }//end getInstance()

    /**
     * Summary of insertNewUser
     * 
     * @param \App\model\UserRegisterModel $userRegisterModel UserRegisterModel
     * 
     * @return int
     */
    public function insertNewUser(UserRegisterModel $userRegisterModel): int
    {

        $date = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
        $request = 'INSERT INTO users (
                name,
                first_name,
                username,
                email,
                password,
                role,
                creation_date,
                last_update_date,
                is_allowed
                ) 
            VALUES (
                :name,
                :first_name,
                :username,
                :email,
                :password,
                :role,
                :creation_date,
                :last_update_date,
                :is_allowed
                )';
        $parameters = [
            'name' => $userRegisterModel->getName(),
            'first_name' => $userRegisterModel->getFirstName(),
            'username' => $userRegisterModel->getUsername(),
            'email' => $userRegisterModel->getEmail(),
            'password' => $userRegisterModel->getPassword(),
            'role' => 'user',
            'creation_date' => $date->format('Y-m-d H:i:s'),
            'last_update_date' => $date->format('Y-m-d H:i:s'),
            'is_allowed' => 0
        ];
        $this->db->execute($request, $parameters);
        $newReq = 'SELECT LAST_INSERT_ID()';
        $lastInsertId = $this->db->execute($newReq, null);
        return $lastInsertId[0]["LAST_INSERT_ID()"];

    }

    /**
     * Summary of getUser
     * 
     * @param string $username username
     * 
     * @return array with all the data of a User
     */
    public function getUser(string $username): array
    {

        $request = 'SELECT
            id,
            name,
            first_name,
            username,
            email,
            password,
            role,
            creation_date,
            last_update_date,
            is_allowed
        FROM users WHERE username = :username';
        $parameters = [
            'username' => $username
        ];
        return $this->db->execute($request, $parameters);

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

        $request = 'SELECT id FROM users WHERE username = :username';
        $parameters = [
            'username' => $username
        ];
        $id = $this->db->execute($request, $parameters);

        return $id[0]["id"];

    }

    /**
     * Summary of getAllUsernames
     * 
     * @return array
     */
    public function getAllUsernames(): array
    {

        $request = 'SELECT username FROM users';

        return $this->db->execute($request, []);

    }

    /**
     * Summary of getAllUsers
     * 
     * @return array
     */
    public function getAllUsers(): array
    {

        $request = 'SELECT id, first_name, username, password, role, is_allowed FROM users';

        return $this->db->execute($request, []);

    }

    /**
     * Summary of updateRole
     * 
     * @param int    $userId    id of the user
     * @param string $role      role of the user
     * @param int    $isAllowed 1 if the user is allowed
     * 
     * @return void
     */
    public function updateRole(int $userId, string $role, int $isAllowed): void
    {

        $request = 'UPDATE users SET role = :role, is_allowed =:is_allowed WHERE id = :id';
        $parameters = [
            'id' => $userId,
            'role' => $role,
            'is_allowed' => $isAllowed
        ];
        $this->db->execute($request, $parameters);

    }

}
