<?php
/**
 * CommentService File Doc Comment
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
use App\repository\CommentRepository;
use App\service\UserService;
use DateTime;

/**
 * CommentService Class Doc Comment
 * 
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class CommentService
{
    /**
     * Summary of _postService
     * 
     * @var CommentRepository
     */
    private CommentRepository $_commentRepository;

    /**
     * Summary of _instance
     * 
     * @var CommentService
     */
    private static $_instance;
    
    const ACTION = "addComment";

    /**
     * Summary of __construct
     */
    private function __construct()
    {
        $this->_commentRepository = CommentRepository::getInstance();
    }

    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     * 
     * @return \App\service\CommentService
     */
    public static function getInstance(): CommentService
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new CommentService();
        }
    
        return self::$_instance;
    }

    /**
     * Summary of getComments
     * 
     * @param mixed $postId id of the post
     * 
     * @return array
     */
    public function getpostComments(int $postId): array
    {
        return $this->_commentRepository->getOnePostComments($postId);
        // foreach ($comments as $comment) {
        //     $comment["content"] = $this->toDisplay($comment["content"]);
        // }
        
        // var_dump("<pre>");
        // var_dump($comments);
        // var_dump("</pre>");
    }

    /**
     * Summary of manageComment
     * 
     * @param string $username username
     * @param int    $postId   postId
     * @param string $content  content
     * 
     * @return \App\entity\CommentEntity
     */
    public function manageComment(string $username, int $postId, string $content): CommentEntity
    {
            $currentDate = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));

            $userService = UserService::getInstance();
            $userId = $userService->getUserId($username);
            
            return new CommentEntity(null, $postId, $userId, $content, $currentDate, $currentDate, false);
    }

    /**
     * Summary of createNewComment
     * 
     * @param \App\entity\CommentEntity $validateComment CommentEntity after validation
     * 
     * @return array
     */
    public function createNewComment(CommentEntity $validateComment): array
    {
        $createNewComment = $this->_commentRepository->insertComment($validateComment);
        if ($createNewComment) {
            $data = [
                MessageService::MESSAGE => MessageService::COMMENT_CREATED
            ];
        } else {
            $data = [
                MessageService::ERROR => MessageService::GENERAL_ERROR
            ];
        }
    
        return $data;
    }
}
