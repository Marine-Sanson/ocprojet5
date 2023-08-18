<?php
/**
 * User File Doc Comment
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
use PDO;

/**
 * AbstractManager Class Doc Comment
 * 
 * @category Repository
 * @package  App\repository
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);
abstract class AbstractManager
{
    /**
     * Summary of db
     * Represents a connection between PHP and a database server.
     * 
     * @var PDO $db
     */
    protected PDO $db;

    /**
     * Summary of __construct get a connection between PHP and a database server
     */
    function __construct()
    {
        $this->db = new PDO(
            'mysql:host=localhost;dbname=ocprojet5;charset=utf8',
            'root',
            ''
            );
    }

    /**
     * Summary of getDb
     * 
     * @return PDO
     */
    public function getDb()
    {
        return $this->db;
    }
}
