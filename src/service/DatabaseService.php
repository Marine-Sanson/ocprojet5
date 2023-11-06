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

use App\entity\CommentEntity;
use App\entity\PostEntity;
use App\entity\UserEntity;
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
      * Summary of instance
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
     * @param string     $request    the sql request
     * @param array|null $parameters if needed
     *
     * @return array
     */
    public function execute(string $request, ?array $parameters): array
    {

        $query = $this->db->prepare($request);
        $query->execute($parameters);

        return $query->fetchAll(PDO::FETCH_ASSOC);

    }//end execute()


    /**
     * Summary of fetchPost
     *
     * @param string $request    SQL request
     * @param array  $parameters parameters
     *
     * @return \App\entity\PostEntity
     */
    public function fetchPost(string $request, array $parameters): PostEntity
    {
        $query = $this->db->prepare($request);

        $query->setFetchMode(PDO::FETCH_CLASS, PostEntity::class, null);

        $query->execute($parameters);

        return $query->fetch();

    }//end fetchPost()


    /**
     * Summary of fetchAllPosts
     *
     * @param string $request SQL request
     *
     * @return array
     */
    public function fetchAllPosts(string $request): array
    {

        $query = $this->db->prepare($request);
        $query->setFetchMode(PDO::FETCH_CLASS, PostEntity::class, null);

        $query->execute();

        return $query->fetchAll();

    }//end fetchAllPosts()


    /**
     * Summary of fetchAllComments
     *
     * @param string $request    request
     * @param array  $parameters parameters
     *
     * @return array
     */
    public function fetchAllComments(string $request, array $parameters): array
    {

        $query = $this->db->prepare($request);

        $query->setFetchMode(PDO::FETCH_CLASS, CommentEntity::class, null);

        $query->execute($parameters);

        return $query->fetchAll();

    }//end fetchAllComments()


    /**
     * Summary of fetchUser
     *
     * @param string $request    request
     * @param array  $parameters parameters
     *
     * @return UserEntity|null UserEntity or null
     */
    public function fetchUser(string $request, array $parameters): ?UserEntity
    {
        $query = $this->db->prepare($request);

        $query->setFetchMode(PDO::FETCH_CLASS, UserEntity::class, null);

        $query->execute($parameters);

        $user = $query->fetch();

        if ($user === false) {
            $user = null;
        }

        return $user;

    }//end fetchUser()


    /**
     * Summary of fetchAllUser
     *
     * @param string $request request
     *
     * @return array<UserEntity>
     */
    public function fetchAllUsers(string $request): array
    {

        $query = $this->db->prepare($request);

        $query->setFetchMode(PDO::FETCH_CLASS, UserEntity::class, null);

        $query->execute();

        return $query->fetchAll();

    }//end fetchAllUsers()


}//end class
