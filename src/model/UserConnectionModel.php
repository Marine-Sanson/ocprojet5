<?php
/**
 * UserConnectionModel File Doc Comment
 *
 * PHP Version 8.1.10
 *
 * @category Model
 * @package  App\model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\model;

/**
 * UserConnectionModel Class Doc Comment
 *
 * @category Model
 * @package  App\model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class UserConnectionModel
{
    /**
     * Summary of __construct ConnectionModel
     *
     * @param int    $id        id of the user
     * @param string $firstName first name of the user
     * @param string $username  username must be unique, used to login
     * @param string $password  password - saved encrypt in the DB
     * @param string $role      may be user or supAdmin
     * @param bool   $isAllowed to know if this user is allowed
     */
    public function __construct(
        private readonly int $id,
        private readonly string $firstName,
        private readonly string $username,
        private readonly string $password,
        private readonly string $role,
        private readonly bool $isAllowed
    ) { }
    // end of __construct()


    /**
     * Summary of getId
     *
     * @return int
     */
    public function getId(): int
    {

        return $this->id;

    }

    /**
     * Summary of getFirstName
     *
     * @return string
     */
    public function getFirstName(): string
    {

        return $this->firstName;
        
    }

    /**
     * Summary of getUsername
     *
     * @return string
     */
    public function getUsername(): string
    {

        return $this->username;

    }

    /**
     * Summary of getPassword
     *
     * @return string
     */
    public function getPassword(): string
    {

        return $this->password;

    }

    /**
     * Summary of getRole
     *
     * @return string
     */
    public function getRole(): string
    {

        return $this->role;

    }

    /**
     * Summary of getIsAllowed
     *
     * @return bool
     */
    public function getIsAllowed(): bool
    {

        return $this->isAllowed;

    }

    /**
     * Summary of toArray
     *
     * @return array
     */
    public function toArray() :array
    {

        return [
            "id" => $this->id,
            "firstName" => $this->firstName,
            "username" => $this->username,
            "password" => $this->password,
            "role" => $this->role,
            "isAllowed" => $this->isAllowed
        ];
    }

}
