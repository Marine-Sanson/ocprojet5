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
     * @var PDO $db
     */
    private PDO $db;

     /**
      * Summary of _instance
      *
      * @var DatabaseService
      */
    private static $instance;

    /**
     * Summary of __construct get a connection between PHP and a database server
     */
    private function __construct()
    {

        $this->db = new PDO(
            "mysql:host=".$_ENV['DB_HOST'].";dbname=".$_ENV['DB_NAME'].";charset=utf8",
            $_ENV['DB_USER'],
            $_ENV['DB_PASS']
        );

    }//end __construct()


    /**
     * Summary of getDb
     *
     * @return DatabaseService
     */
    public static function getInstance(): DatabaseService
    {

        if (self::$instance === null) {
            self::$instance = new DatabaseService();  
        }

        return self::$instance;

    }//end getInstance()

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

        $query = $this->db->prepare(
            $request
        );
        $query->execute($parameters);

        return $query->fetchAll(PDO::FETCH_ASSOC);

    }

}
