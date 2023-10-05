<?php
/**
 * PostRepository File Doc Comment
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

use App\model\NewPostModel;
use App\service\DatabaseService;
use DateTime;

/**
 * PostRepository Class Doc Comment
 * 
 * @category Repository
 * @package  App\repository
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class PostRepository
{
    /**
     * Summary of _db
     * 
     * @var DatabaseService $_db connection between PHP and a database server
     */
    private DatabaseService $_db;

    /**
     * Summary of _instance
     * 
     * @var PostRepository
     */
    private static $_instance;

    /**
     * Summary of __construct
     */
    private function __construct()
    {
        $this->_db = DatabaseService::getInstance();
    }

    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     * 
     * @return \App\service\PostService
     */
    public static function getInstance(): PostRepository
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new PostRepository();  
        }
    
        return self::$_instance;
    }
    
    /**
     * Summary of insertNewPost
     * 
     * @param \App\model\NewPostModel $newPostModel newPostModel
     * 
     * @return int
     */
    public function insertNewPost(NewPostModel $newPostModel): int
    {
        $request = 'INSERT INTO posts (
            id_user,
            title,
            summary,
            content,
            creation_date,
            last_update_date
            ) 
            VALUES (
            :id_user,
            :title,
            :summary,
            :content,
            :creation_date,
            :last_update_date
                )';
        $parameters = [
            'id_user' => $newPostModel->getIdUser(),
            'title' => $newPostModel->getTitle(),
            'summary' => $newPostModel->getSummary(),
            'content' => $newPostModel->getContent(),
            'creation_date' => $newPostModel->getCreationDate()->format('Y-m-d H:i:s'),
            'last_update_date' => $newPostModel->getCreationDate()->format('Y-m-d H:i:s')
        ];
        $this->_db->execute($request, $parameters);
        $newReq = 'SELECT LAST_INSERT_ID()';
        $lastInsertId = $this->_db->execute($newReq, null);
        $id = $lastInsertId[0]["LAST_INSERT_ID()"];

        return $id;
    }

    /**
     * Summary of getAllPostsWithAuthors
     * 
     * @return array
     */
    public function getPostsWithAuthors()
    {
        $request = 'SELECT posts.*, username FROM posts 
                    JOIN users ON posts.id_user = users.id 
                    ORDER BY last_update_date DESC LIMIT 12';

        $result = $this->_db->execute($request, null);

        return $result;
    }

    /**
     * Summary of getAllPostsWithAuthors
     *             // VOIR AVEC ANTOINE COMMENT GERER CA
     * 
     * @return array
     */
    public function getAllPostsWithAuthors()
    {
        $request = 'SELECT posts.*, username FROM posts 
                    JOIN users ON posts.id_user = users.id 
                    ORDER BY last_update_date DESC';

        $result = $this->_db->execute($request, null);

        return $result;
    }

    /**
     * Summary of getOnePostData
     * 
     * @param int $id id of the post
     * 
     * @return array
     */
    public function getOnePostData(int $id): array
    {
        $request = 'SELECT posts.*, username FROM posts JOIN users ON posts.id_user = users.id WHERE posts.id = :id ';
        $parameters = [
            'id' => $id
        ];
        $result = $this->_db->execute($request, $parameters);

        return $result[0];
    }

    /**
     * Summary of getLastPosts
     * 
     * @return array
     */
    public function getListOfPosts(): array
    {
        $request = 'SELECT posts.*, username FROM posts 
        JOIN users ON posts.id_user = users.id ORDER BY last_update_date DESC LIMIT 3';
        $parameters = [];
        $result = $this->_db->execute($request, $parameters);

        return $result;
    }
}
