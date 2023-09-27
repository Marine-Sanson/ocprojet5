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
     * Summary of _db
     * 
     * @var DatabaseService $_db connection between PHP and a database server
     */
    private DatabaseService $_db;

    /**
     * Summary of insertComment
     * 
     * @param \App\entity\CommentEntity $newComment comment from the form
     * 
     * @return int
     */
    public function insertComment(CommentEntity $newComment) :int
    {
        $id_post = $newComment->id_post;
        $id_user = $newComment->id_user;
        $content = $newComment->content;
        $creationDate = $newComment->creationDate;
        $lastUpdateDate = $newComment->lastUpdateDate;

        $this->_db = DatabaseService::getInstance();
        $request = 'INSERT INTO comments (id_post, id_user, content, creation_date, last_update_date, is_validate) 
                    VALUES (:id_post, :id_user, :content, :creation_date, :last_update_date, :is_validate)';
        $parameters = [
            'id_post' => $id_post,
            'id_user' => $id_user,
            'content' => $content,
            'creation_date' => $creationDate->format('Y-m-d H:i:s'),
            'last_update_date' => $lastUpdateDate->format('Y-m-d H:i:s'),
            'is_validate' => 0
        ];
        $this->_db->execute($request, $parameters);
        $newReq = 'SELECT LAST_INSERT_ID()';
        $lastInsertId = $this->_db->execute($newReq, null);
        $id = $lastInsertId[0]["LAST_INSERT_ID()"];

        return $id;
    }

    /**
     * Summary of getOnePostComments
     * 
     * @param int $postId id of the post
     * 
     * @return array
     */
    public function getOnePostComments(int $postId) :array
    {
        $this->_db = DatabaseService::getInstance();
        $request = 'SELECT comments.*, username FROM comments JOIN users ON comments.id_user = users.id WHERE id_post = :id AND is_validate = :is_validate';
        $parameters = [
            'id' => $postId,
            'is_validate' => 1
        ];
        $result = $this->_db->execute($request, $parameters);

        return $result;
    }
    
}
