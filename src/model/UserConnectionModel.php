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
    ) {

    }//end __construct()


    /**
     * Summary of getId
     *
     * @return int
     */
    public function getId(): int
    {

        return $this->id;

    }//end getId()


    /**
     * Summary of getFirstName
     *
     * @return string
     */
    public function getFirstName(): string
    {

        return $this->firstName;

    }//end getFirstName()


    /**
     * Summary of getUsername
     *
     * @return string
     */
    public function getUsername(): string
    {

        return $this->username;

    }//end getUsername()


    /**
     * Summary of getPassword
     *
     * @return string
     */
    public function getPassword(): string
    {

        return $this->password;

    }//end getPassword()


    /**
     * Summary of getRole
     *
     * @return string
     */
    public function getRole(): string
    {

        return $this->role;

    }//end getRole()


    /**
     * Summary of isUserAllowed
     *
     * @return bool
     */
    public function isUserAllowed(): bool
    {

        return $this->isAllowed;

    }//end isUserAllowed()


    /**
     * Summary of toArray
     *
     * @return array
     */
    public function toArray() :array
    {

        return [
            "id"        => $this->id,
            "firstName" => $this->firstName,
            "username"  => $this->username,
            "password"  => $this->password,
            "role"      => $this->role,
            "isAllowed" => $this->isAllowed
        ];

    }//end toArray()


}//end class
