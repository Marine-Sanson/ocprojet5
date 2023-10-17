<?php
/**
 * CommentRepository File Doc Comment
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

use App\entity\CommentEntity;
use App\service\DatabaseService;

/**
 * CommentRepository Class Doc Comment
 * 
 * @category Repository
 * @package  App\repository
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class CommentRepository
{

    /**
     * Summary of _instance
     * 
     * @var CommentRepository
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
     * @return \App\controller\CommentController
     */
    public static function getInstance(): CommentRepository
    { 
        if (self::$instance === null) {
            self::$instance = new CommentRepository(DatabaseService::getInstance());  
        }
    
        return self::$instance;
    }

    /**
     * Summary of insertComment
     * 
     * @param \App\entity\CommentEntity $newComment comment from the form
     * 
     * @return int
     */
    public function insertComment(CommentEntity $newComment): int
    {
        $request = 'INSERT INTO comments (id_post, id_user, content, creation_date, last_update_date, is_validate) 
                    VALUES (:id_post, :id_user, :content, :creation_date, :last_update_date, :is_validate)';
        $parameters = [
            'id_post' => $newComment->getPostId(),
            'id_user' => $newComment->getUserId(),
            'content' => $newComment->getContent(),
            'creation_date' => $newComment->getCreationDate()->format('Y-m-d H:i:s'),
            'last_update_date' => $newComment->getLastUpdateDate()->format('Y-m-d H:i:s'),
            'is_validate' => 0
        ];
        $this->_db->execute($request, $parameters);
        $newReq = 'SELECT LAST_INSERT_ID()';
        $lastInsertId = $this->_db->execute($newReq, null);
        return $lastInsertId[0]["LAST_INSERT_ID()"];
    }

    /**
     * Summary of getOnePostComments
     * 
     * @param int $postId id of the post
     * 
     * @return array
     */
    public function getOnePostComments(int $postId): array
    {
        $request = 'SELECT id_user, content, comments.last_update_date, username FROM comments 
                    JOIN users ON comments.id_user = users.id 
                    WHERE id_post = :id AND is_validate = :is_validate';
        $parameters = [
            'id' => $postId,
            'is_validate' => 1
        ];
        return $this->_db->execute($request, $parameters);
    }

    /**
     * Summary of getPendingComments
     * 
     * @return array
     */
    public function getPendingComments(): array
    {
        $request = 'SELECT
            comments.id,
            comments.id_user,
            id_post,
            comments.content,
            comments.last_update_date,
            is_validate,
            username,
            title
        FROM comments
        JOIN users ON comments.id_user = users.id
        JOIN posts ON comments.id_post = posts.id
        WHERE is_validate = :is_validate ORDER BY last_update_date DESC';
        $parameters = [
            'is_validate' => 0
        ];
        return $this->_db->execute($request, $parameters);
    }

    /**
     * Summary of updateCommentValidation
     * 
     * @param int $commentId id of the comment

     * @return void
     */
    public function updateCommentValidation(int $commentId): void
    {
        $request = 'UPDATE comments SET is_validate = :is_validate WHERE id = :id';
        $parameters = [
            'id' => $commentId,
            'is_validate' => 1
        ];

        $this->_db->execute($request, $parameters);
    }

    /**
     * Summary of deleteComment
     * 
     * @param int $commentId id of the comment
     * 
     * @return void
     */
    public function deleteComment(int $commentId): void
    {
        $request = 'DELETE FROM comments WHERE id = :id';
        $parameters = [
            'id' => $commentId
        ];

        $this->_db->execute($request, $parameters);
    }
}
