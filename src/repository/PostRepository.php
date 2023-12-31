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

use App\entity\PostEntity;
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
     * Summary of instance
     *
     * @var PostRepository
     */
    private static $instance;


    /**
     * Summary of __construct
     *
     * @param \App\service\DatabaseService $db DatabaseService
     */
    private function __construct(private readonly DatabaseService $db)
    {

    }//end __construct()


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

    }//end getInstance()


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
            'id_user'          => $newPostModel->getUserId(),
            'title'            => $newPostModel->getTitle(),
            'summary'          => $newPostModel->getSummary(),
            'content'          => $newPostModel->getContent(),
            'creation_date'    => $newPostModel->getCreationDate()->format('Y-m-d H:i:s'),
            'last_update_date' => $newPostModel->getCreationDate()->format('Y-m-d H:i:s')
        ];
        $this->db->execute($request, $parameters);
        $newReq = 'SELECT LAST_INSERT_ID()';
        $lastInsertId = $this->db->execute($newReq, null);
        return $lastInsertId[0]["LAST_INSERT_ID()"];

    }//end insertNewPost()


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
            'id'               => $updatePost->getId(),
            'title'            => $updatePost->getTitle(),
            'summary'          => $updatePost->getSummary(),
            'content'          => $updatePost->getContent(),
            'last_update_date' => $updatePost->getLastUpdateDate()->format('Y-m-d H:i:s')
        ];
        $this->db->execute($request, $parameters);

    }//end updatePost()


    /**
     * Summary of getAllPosts
     *
     * @return array
     */
    public function getAllPosts(): array
    {

        $request = 'SELECT
        id,
        id_user AS idUser,
        title,
        summary,
        content,
        creation_date AS creationDate,
        last_update_date AS lastUpdateDate
        FROM posts 
        ORDER BY last_update_date DESC';

        return $this->db->fetchAllPosts($request);

    }//end getAllPosts()


    /**
     * Summary of getOnePostData
     *
     * @param int $postId id of the post
     *
     * @return array
     */
    public function getOnePostData(int $postId): PostEntity
    {

        $request = 'SELECT 
            id,
            id_user AS idUser,
            title,
            summary,
            content,
            creation_date AS creationDate,
            last_update_date AS lastUpdateDate
            FROM posts WHERE posts.id = :id ';
        $parameters = [
            'id' => $postId
        ];

        return $this->db->fetchPost($request, $parameters);

    }//end getOnePostData()


    /**
     * Summary of getListOfPosts
     *
     * @return array
     */
    public function getListOfPosts(): array
    {

        $request = 'SELECT
        id,
        id_user AS idUser,
        title,
        summary,
        content,
        creation_date AS creationDate,
        last_update_date AS lastUpdateDate
        FROM posts 
        ORDER BY last_update_date DESC LIMIT 3';

        return $this->db->fetchAllPosts($request);

    }//end getListOfPosts()


    /**
     * Summary of getPostTitle
     *
     * @param integer $postId postId
     *
     * @return string
     */
    public function getPostTitle(int $postId): string
    {

        $request = 'SELECT title FROM posts WHERE id = :id';
        $parameters = [
            'id' => $postId
        ];

        $title = $this->db->execute($request, $parameters);

        return $title[0]["title"];

    }//end getPostTitle()


}//end class
