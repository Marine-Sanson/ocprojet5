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

use DateTime;

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
     * @param DateTime $creationDate   creation dat in the db
     * @param DateTime $lastUpdateDate lat update in the db
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
        private readonly DateTime $creationDate,
        private readonly DateTime $lastUpdateDate,
        private readonly bool $isAllowed
    )
    {

    }//end of __construct()

    /**
     * Summary of getId
     *
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * Summary of getName
     *
     * @return string
     */
    public function getName(): string
    {

        return $this->name;

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
     * Summary of getEmail
     *
     * @return string
     */
    public function getEmail(): string
    {

        return $this->email;

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
     * Summary of getCreationDate
     *
     * @return \DateTime
     */
    public function getCreationDate(): DateTime
    {

        return $this->creationDate;

    }

    /**
     * Summary of getLastUpdateDate
     *
     * @return \DateTime
     */
    public function getLastUpdateDate(): DateTime
    {

        return $this->lastUpdateDate;

    }

    /**
     * Summary of isUserAllowed
     *
     * @return bool
     */
    public function isUserAllowed(): bool
    {

        return $this->isAllowed;

    }

}
