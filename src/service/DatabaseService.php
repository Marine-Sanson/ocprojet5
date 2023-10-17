<?php
/**
 * DatabaseService File Doc Comment
 * 
 * PHP Version 8.1.10
 * 
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\service;

use PDO;

/**
 * DatabaseService Class Doc Comment
 * 
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class DatabaseService
{
    /**
     * Summary of db
     * Represents a connection between PHP and a database server.
     * 
     * @var PDO $_db
     */
    private PDO $_db;

     /**
      * Summary of _instance
      * 
      * @var DatabaseService
      */
    private static $_instance;

    /**
     * Summary of __construct get a connection between PHP and a database server
     */
    private function __construct()
    {
        $this->_db = new PDO(
            "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8",
            $_ENV['DB_USER'],
            $_ENV['DB_PASS']
        );
    }

    /**
     * Summary of getDb
     * 
     * @return DatabaseService
     */
    public static function getInstance(): DatabaseService
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new DatabaseService();  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of execute
     * 
     * @param string       $request    the sql request
     * @param array | null $parameters if needed
     * 
     * @return array
     */
    public function execute(string $request, ?array $parameters): array
    {
        $query = $this->_db->prepare(
            $request
        );
        $query->execute($parameters);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
