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
use AbstractManager;
use PDO;

class UserRepository extends AbstractManager
{
    public function getLoginData(int $id)
    {
        $query = $this->db->prepare('SELECT user_name, password FROM users WHERE id = : id');
        $parameters = [
            'id' => $id
        ];
        $query->execute($parameters);
        $loginData = $query->fetchAll(PDO::FETCH_ASSOC);

        return $loginData;
    }
}
