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
     * Summary of id
     *
     * @var integer|null
     */
    private readonly ?int $id;

    /**
     * Summary of name
     *
     * @var string
     */
    private readonly string $name;

    /**
     * Summary of firstName
     *
     * @var string
     */
    private readonly string $firstName;

    /**
     * Summary of username
     *
     * @var string
     */
    private readonly string $username;

    /**
     * Summary of email
     *
     * @var string
     */
    private readonly string $email;

    /**
     * Summary of password
     *
     * @var string
     */
    private readonly string $password;

    /**
     * Summary of role
     *
     * @var string
     */
    private readonly string $role;

    /**
     * Summary of creationDate
     *
     * @var string
     */
    private readonly string $creationDate;

    /**
     * Summary of lastUpdateDate
     *
     * @var string
     */
    private readonly string $lastUpdateDate;

    /**
     * Summary of isAllowed
     *
     * @var bool
     */
    private readonly bool $isAllowed;


    /**
     * Summary of __construct UserEntity
     */
    public function __construct() {

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
