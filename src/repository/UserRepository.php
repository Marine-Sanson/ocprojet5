<?php
/**
 * UserRepository File Doc Comment
 * 
 * PHP Version 8.1.10
 * 
 * @category Repository
 * @package  App\repository
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\repository;

use App\repository\AbstractManager;
use PDO;

/**
 * UserRepository Class Doc Comment
 * 
 * @category Repository
 * @package  App\repository
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class UserRepository extends AbstractManager
{

    /**
     * Summary of getUser
     * 
     * @param string $username username
     * 
     * @return array with all the data of a User
     */
    public function getUser(string $username) :array
    {
        $query = $this->db->prepare(
            'SELECT * FROM users 
            WHERE username = :username'
        );
        $parameters = [
            'username' => $username
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
