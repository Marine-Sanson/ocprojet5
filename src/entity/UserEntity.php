<?php
/**
 * UserEntity File Doc Comment
 *
 * PHP Version 8.1.10
 *
 * @category Entity
 * @package  App\entity
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\entity;

/**
 * UserEntity Class Doc Comment
 *
 * @category Entity
 * @package  App\entity
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class UserEntity
{


    /**
     * Summary of __construct UserEntity
     *
     * @param int|null $id             id - autoincrement in the DB
     * @param string   $name           name of the user
     * @param string   $firstName      first name of the user
     * @param string   $username       username must be unique, used to login
     * @param string   $email          email of the user
     * @param string   $password       password - saved encrypt in the DB
     * @param string   $role           may be user or supAdmin
     * @param string   $creationDate   creation dat in the db
     * @param string   $lastUpdateDate lat update in the db
     * @param bool     $isAllowed      to know if this user is allowed
     */
    public function __construct(
        private readonly ?int $id,
        private readonly string $name,
        private readonly string $firstName,
        private readonly string $username,
        private readonly string $email,
        private readonly string $password,
        private readonly string $role,
        private readonly string $creationDate,
        private readonly string $lastUpdateDate,
        private readonly bool $isAllowed
    ) {

    }//end __construct()


    /**
     * Summary of getId
     *
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }//end getId()


    /**
     * Summary of getName
     *
     * @return string
     */
    public function getName(): string
    {

        return $this->name;

    }//end getName()


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
     * Summary of getEmail
     *
     * @return string
     */
    public function getEmail(): string
    {

        return $this->email;

    }//end getEmail()


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
     * Summary of getCreationDate
     *
     * @return string
     */
    public function getCreationDate(): string
    {

        return $this->creationDate;

    }//end getCreationDate()


    /**
     * Summary of getLastUpdateDate
     *
     * @return string
     */
    public function getLastUpdateDate(): string
    {

        return $this->lastUpdateDate;

    }//end getLastUpdateDate()


    /**
     * Summary of isUserAllowed
     *
     * @return bool
     */
    public function isUserAllowed(): bool
    {

        return $this->isAllowed;

    }//end isUserAllowed()


}//end class
