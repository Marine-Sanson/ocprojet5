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

namespace App\model;

use DateTime;

/**
 * User Class Doc Comment
 * 
 * @category Model
 * @package  App\model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class User
{
    /**
     * Summary of id
     * 
     * @var int|null $id autoincrement in the DB
     */
    public ?int $id = null;
    /**
     * Summary of name
     * 
     * @var string $name name of the user
     */
    public string $name;
    /**
     * Summary of firstName
     * 
     * @var string $firstName first name of the user
     */
    public string $firstName;

    /**
     * Summary of username
     * Must be unique, used to login
     * 
     * @var string $username name used in the app
     */
    public string $username;
    /**
     * Summary of email
     *
     * @var string $email email of the user
     */
    public string $email;
    /**
     * Summary of password
     * Must be verified
     * 
     * @var string $password saved encrypt in the DB
     */
    public string $password;
    /**
     * Summary of role
     * May be user or supAdmin
     * 
     * @var string $role
     */
    public string $role;
    /**
     * Summary of creationDate
     * 
     * @var DateTime
     */
    public DateTime $creationDate;
    /**
     * Summary of lastUpdateDate
     * 
     * @var DateTime $lastUpdateDate
     */
    public DateTime $lastUpdateDate;
    /**
     * Summary of is_allowed
     * 
     * @var bool $is_allowed
     */
    public bool $is_allowed;

    /**
     * Summary of __construct User
     * 
     * @param int|null $id             id
     * @param string   $name           name
     * @param string   $firstName      first name
     * @param string   $username       username
     * @param string   $email          email
     * @param string   $password       password
     * @param string   $role           may be user or supAdmin
     * @param DateTime $creationDate   creation dat in the db
     * @param DateTime $lastUpdateDate lat update in the db
     * @param bool     $is_allowed     to know if this user is allowed
     */
    public function __construct(
        ?int $id, string $name, string $firstName, string $username, 
        string $email, string $password, string $role, 
        DateTime $creationDate, DateTime $lastUpdateDate, bool $is_allowed
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->firstName = $firstName;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->creationDate = $creationDate;
        $this->lastUpdateDate = $lastUpdateDate;
        $this->is_allowed = $is_allowed;
    }
}
