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
     * @param string $firstName first name of the user
     * @param string $username  username must be unique, used to login
     * @param string $password  password - saved encrypt in the DB
     * @param string $role      may be user or supAdmin
     * @param bool   $isAllowed to know if this user is allowed
     */
    public function __construct(
        public string $firstName, 
        public string $username, 
        public string $password, 
        public string $role, 
        public bool $isAllowed
    ) {

    }

    public function toArray() :array
    {
        return [
            "firstName" => $this->firstName,
            "username" => $this->username,
            "password" => $this->password,
            "role" => $this->role,
            "isAllowed" => $this->isAllowed
        ];

    }
}
