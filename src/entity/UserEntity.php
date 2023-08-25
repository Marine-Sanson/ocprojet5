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
        public ?int $id, 
        public string $name, 
        public string $firstName, 
        public string $username, 
        public string $email, 
        public string $password,
        public string $role,
        public DateTime $creationDate, 
        public DateTime $lastUpdateDate, 
        public bool $isAllowed
    ) {

    }
}
