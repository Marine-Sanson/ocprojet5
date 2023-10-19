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
use App\mapper\MessageMapper;
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
     * Summary of _instance
     *
     * @var CommentService
     */
    private static $instance;
    
    const ACTION = "addComment";


    /**
     * Summary of __construct
     *
     * @param \App\repository\CommentRepository $_commentRepository CommentRepository
     */
    private function __construct(private readonly CommentRepository $_commentRepository)
    {

    }//end __construct()


    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     *
     * @return \App\service\CommentService
     */
    public static function getInstance(): CommentService
    {

        if (self::$instance === null) {
            self::$instance = new CommentService(CommentRepository::getInstance());
        }
    
        return self::$instance;

    }//end getInstance()

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

        if ($createNewComment === false) {
            $data = [
                MessageMapper::Error->getMessageLabel() => MessageMapper::GeneralError->getMessage()
            ];
        }

        if (isset($data[MessageMapper::Error->getMessageLabel()]) === false) {
            $data = [
                MessageMapper::Message->getMessageLabel() => MessageMapper::CommentCreated->getMessage()
            ];
        }

        return $data;

    }

    /**
     * Summary of getPendingComments
     *
     * @return array
     */
    public function getPendingComments(): array
    {

        return $this->_commentRepository->getPendingComments();

    }

    /**
     * Summary of validateComments
     *
     * @param int $commentId id of the comment
     *
     * @return void
     */
    public function validateComments(int $commentId): void
    {

        $this->_commentRepository->updateCommentValidation($commentId);

    }

    /**
     * Summary of deleteComments
     *
     * @param int $commentId id of the comment
     *
     * @return void
     */
    public function deleteComments(int $commentId): void
    {

        $this->_commentRepository->deleteComment($commentId);

    }

    /**
     * Summary of validCommentId
     *
     * @param mixed $commentId commentId
     *
     * @return bool
     */
    public function validCommentId($commentId): bool
    {

        $comments = $this->getPendingComments();
        $pendingCommentsIds = [];
        foreach ($comments as $comment) {
            $pendingCommentsIds[] = $comment["id"];
        }

        $isValid = in_array($commentId, $pendingCommentsIds);

        if ($isValid === true) {
            return true;
        }

        return false;

    }

}
