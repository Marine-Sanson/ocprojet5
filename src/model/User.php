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
     * @var int|null $id autoincrement in the DB
     */
    private ?int $id;
    /**
     * Summary of name
     * 
     * @var string $name name of the user
     */
    private string $name;
    /**
     * Summary of firstName
     * 
     * @var string $firstName first name of the user
     */
    private string $firstName;

    /**
     * Summary of userName
     * Must be unique, used to login
     * 
     * @var string $userName name used in the app
     */
    private string $userName;
    /**
     * Summary of email
     * @var string $email email of the user
     */
    private string $email;
    /**
     * Summary of password
     * Must be verified
     * 
     * @var string $password saved encrypt in the DB
     */
    private string $password;
    /**
     * Summary of role
     * May be user or supAdmin
     * 
     * @var string $role
     */
    private string $role;
    /**
     * Summary of is_allowed
     * 
     * @var bool $is_allowed
     */
    private bool $is_allowed;

    /**
     * Summary of id
     * 
     * @return int|null
     */
    public function getId(): ?int {
        return $this->id;
    }
    
    /**
     * Summary of id
     * 
     * @param  $id Summary of id
     * @return self
     */
    public function setId(?int $id): self {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }
    
    /**
     * @param string $name 
     * @return self
     */
    public function setName(string $name): self {
        $this->name = $name;
        return $this;
    }

    /**
     * Summary of firstName
     * 
     * @return string
     */
    public function getFirstName(): string {
        return $this->firstName;
    }
    
    /**
     * Summary of firstName
     * 
     * @param string $firstName Summary of firstName
     * @return self
     */
    public function setFirstName(string $firstName): self {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * Summary of userName
     * 
     * @return string
     */
    public function getUserName(): string {
        return $this->userName;
    }
    
    /**
     * Summary of userName
     * 
     * @param string $userName Summary of userName
     * @return self
     */
    public function setUserName(string $userName): self {
        $this->userName = $userName;
        return $this;
    }

    /**
     * Summary of email
     * @return string
     */
    public function getEmail(): string {
        return $this->email;
    }
    
    /**
     * Summary of email
     * @param string $email Summary of email
     * @return self
     */
    public function setEmail(string $email): self {
        $this->email = $email;
        return $this;
    }


    /**
     * Summary of password
     * Must be verified
     * 
     * @return string
     */
    public function getPassword(): string {
        return $this->password;
    }
    
    /**
     * Summary of password
     * Must be verified
     * 
     * @param string $password Summary of password
     * @return self
     */
    public function setPassword(string $password): self {
        $this->password = $password;
        return $this;
    }

    /**
     * Summary of role
     * May be user or supAdmin
     * 
     * @return string
     */
    public function getRole(): string {
        return $this->role;
    }
    
    /**
     * Summary of role
     * May be user or supAdmin
     * 
     * @param string $role Summary of role
     * @return self
     */
    public function setRole(string $role): self {
        $this->role = $role;
        return $this;
    }

    /**
     * Summary of is_allowed
     * 
     * @return bool
     */
    public function getIs_allowed(): bool {
        return $this->is_allowed;
    }
    
    /**
     * Summary of is_allowed
     * 
     * @param bool $is_allowed Summary of is_allowed
     * @return self
     */
    public function setIs_allowed(bool $is_allowed): self {
        $this->is_allowed = $is_allowed;
        return $this;
    }
}
