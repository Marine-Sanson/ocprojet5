<?php
/**
 * User File Doc Comment
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

/**
 * User Class Doc Comment
 * 
 * @category Model
 * @package  App\model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class UserController
{
    /**
     * Summary of id
     * 
     * @var int|null $_id autoincrement in the DB
     */
    private ?int $_id;
    /**
     * Summary of name
     * 
     * @var string $_name name of the user
     */
    private string $_name;
    /**
     * Summary of firstName
     * 
     * @var string $_firstName first name of the user
     */
    private string $_firstName;

    /**
     * Summary of userName
     * Must be unique, used to login
     * 
     * @var string $_userName name used in the app
     */
    private string $_userName;
    /**
     * Summary of email
     *
     * @var string $_email email of the user
     */
    private string $_email;
    /**
     * Summary of password
     * Must be verified
     * 
     * @var string $_password saved encrypt in the DB
     */
    private string $_password;
    /**
     * Summary of role
     * May be user or supAdmin
     * 
     * @var string $_role
     */
    private string $_role;
    /**
     * Summary of creationDate
     * 
     * @var DateTime
     */
    private DateTime $_creationDate;
    /**
     * Summary of lastUpdateDate
     * 
     * @var DateTime $_lastUpdateDate
     */
    private DateTime $_lastUpdateDate;
    /**
     * Summary of is_allowed
     * 
     * @var bool $_is_allowed
     */
    private bool $_is_allowed;

    /**
     * Summary of getId
     * 
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->_id;
    }
    
    /**
     * Summary of setId
     * 
     * @param $id id
     * 
     * @return self
     */
    public function setId(?int $id): self
    {
        $this->_id = $id;
        return $this;
    }

    /**
     * Summary of getName
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->_name;
    }
    
    /**
     * Summary of setName
     * 
     * @param string $name name
     * 
     * @return self
     */
    public function setName(string $name): self
    {
        $this->_name = $name;
        return $this;
    }

    /**
     * Summary of firstName
     * 
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->_firstName;
    }
    
    /**
     * Summary of setFirstName
     * 
     * @param string $firstName firstName
     * 
     * @return self
     */
    public function setFirstName(string $firstName): self
    {
        $this->_firstName = $firstName;
        return $this;
    }

    /**
     * Summary of getUserName
     * 
     * @return string
     */
    public function getUserName(): string
    {
        return $this->_userName;
    }
    
    /**
     * Summary of setUserName
     * 
     * @param string $userName userName
     * 
     * @return self
     */
    public function setUserName(string $userName): self
    {
        $this->_userName = $userName;
        return $this;
    }

    /**
     * Summary of getEmail
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->_email;
    }
    
    /**
     * Summary of setEmail
     *
     * @param string $email email
     * 
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->_email = $email;
        return $this;
    }

    /**
     * Summary of getPassword
     * 
     * @return string
     */
    public function getPassword(): string
    {
        return $this->_password;
    }
    
    /**
     * Summary of setPassword
     * 
     * @param string $password password
     * 
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->_password = $password;
        return $this;
    }

    /**
     * Summary of getRole
     * 
     * @return string
     */
    public function getRole(): string
    {
        return $this->_role;
    }
    
    /**
     * Summary of setRole
     * 
     * @param string $role role
     * 
     * @return self
     */
    public function setRole(string $role): self
    {
        $this->_role = $role;
        return $this;
    }

    /**
     * Summary of getCreationDate
     * 
     * @return DateTime
     */
    public function getCreationDate(): DateTime
    {
        return $this->_creationDate;
    }
    
    /**
     * Summary of setCreationDate
     * 
     * @param DateTime $creationDate creationDate
     * 
     * @return self
     */
    public function setCreationDate(DateTime $creationDate): self
    {
        $this->_creationDate = $creationDate;
        return $this;
    }

    /**
     * Summary of getLastUpdateDate
     * 
     * @return DateTime
     */
    public function getLastUpdateDate(): DateTime
    {
        return $this->_lastUpdateDate;
    }
    
    /**
     * Summary of setLastUpdateDate
     * 
     * @param DateTime $lastUpdateDate lastUpdateDate
     * 
     * @return self
     */
    public function setLastUpdateDate(DateTime $lastUpdateDate): self
    {
        $this->_lastUpdateDate = $lastUpdateDate;
        return $this;
    }

     /**
      * Summary of getIsAllowed
      * 
      * @return bool
      */
    public function getIsAllowed(): bool
    {
        return $this->_is_allowed;
    }
    
    /**
     * Summary of setIsAllowed
     * 
     * @param bool $is_allowed is_allowed
     * 
     * @return self
     */
    public function setIsAllowed(bool $is_allowed): self
    {
        $this->_is_allowed = $is_allowed;
        return $this;
    }
}
