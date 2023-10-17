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
use App\model\UpdatePostModel;
use App\service\DatabaseService;

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
     * Summary of _instance
     * 
     * @var PostRepository
     */
    private static $instance;

    
    /**
     * Summary of __construct
     * 
     * @param \App\service\DatabaseService $_db DatabaseService
     */
    private function __construct(private DatabaseService $_db)
    {

    }


    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     * 
     * @return \App\repository\PostRepository
     */
    public static function getInstance(): PostRepository
    { 
        if (self::$instance === null) {
            self::$instance = new PostRepository(DatabaseService::getInstance());  
        }
    
        return self::$instance;
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
        return $lastInsertId[0]["LAST_INSERT_ID()"];
    }

    /**
     * Summary of updatePost
     * 
     * @param \App\model\UpdatePostModel $updatePost UpdatePostModel
     * 
     * @return void
     */
    public function updatePost(UpdatePostModel $updatePost): void
    {
        $request = 'UPDATE posts SET 
        title = :title,
        summary = :summary,
        content = :content,
        last_update_date = :last_update_date
        WHERE id = :id';
        $parameters = [
            'id' => $updatePost->getId(),
            'title' => $updatePost->getTitle(),
            'summary' => $updatePost->getSummary(),
            'content' => $updatePost->getContent(),
            'last_update_date' => $updatePost->getLastUpdateDate()->format('Y-m-d H:i:s')
        ];
        $this->_db->execute($request, $parameters);
    }

    /**
     * Summary of getAllPostsWithAuthors
     * 
     * @return array
     */
    public function getPostsWithAuthors(): array
    {
        $request = 'SELECT posts.*, username FROM posts 
                    JOIN users ON posts.id_user = users.id 
                    ORDER BY last_update_date DESC LIMIT 12';

        return $this->_db->execute($request, null);
    }

    /**
     * Summary of getAllPostsWithAuthors
     *             // VOIR AVEC ANTOINE COMMENT GERER CA
     * 
     * @return array
     */
    public function getAllPostsWithAuthors(): array
    {
        $request = 'SELECT posts.*, username FROM posts 
                    JOIN users ON posts.id_user = users.id 
                    ORDER BY last_update_date DESC';

        return $this->_db->execute($request, null);
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
     * Summary of getListOfPosts
     * 
     * @return array
     */
    public function getListOfPosts(): array
    {
        $request = 'SELECT
        posts.id,
        posts.id_user,
        posts.title,
        posts.summary,
        posts.content,
        posts.creation_date,
        posts.last_update_date,
        username
        FROM posts 
        JOIN users ON posts.id_user = users.id ORDER BY last_update_date DESC LIMIT 3';
        $parameters = [];
        return $this->_db->execute($request, $parameters);
    }
}
