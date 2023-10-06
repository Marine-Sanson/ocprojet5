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
        private int $id,
        private string $firstName,
        private string $username,
        private string $password,
        private string $role,
        private bool $isAllowed
    ) {

    }

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
     * Summary of setId
     * 
     * @param int $id id
     * 
     * @return \App\model\UserConnectionModel
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
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
     * Summary of setFirstName
     * 
     * @param string $firstName firstName
     * 
     * @return \App\model\UserConnectionModel
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
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
     * Summary of setUsername
     * 
     * @param string $username username
     * 
     * @return \App\model\UserConnectionModel
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
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
     * Summary of setPassword
     * 
     * @param string $password password
     * 
     * @return \App\model\UserConnectionModel
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
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
     * Summary of setRole
     * 
     * @param string $role role
     * 
     * @return \App\model\UserConnectionModel
     */
    public function setRole(string $role): self
    {
        $this->role = $role;
        return $this;
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
     * Summary of setIsAllowed
     * 
     * @param bool $isAllowed isAllowed
     * 
     * @return \App\model\UserConnectionModel
     */
    public function setIsAllowed(bool $isAllowed): self
    {
        $this->isAllowed = $isAllowed;
        return $this;
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
