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
use App\mapper\CommentMapper;
use App\mapper\DateTimeMapper;
use App\mapper\MessageMapper;
use App\model\CommentModel;
use App\repository\CommentRepository;
use App\repository\PostRepository;
use App\repository\UserRepository;
use App\service\UserService;

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
     * Summary of instance
     *
     * @var CommentService
     */
    private static $instance;

    const ACTION = "addComment";


    /**
     * Summary of __construct
     *
     * @param \App\mapper\CommentMapper         $_commentMapper     CommentMapper
     * @param \App\mapper\DateTimeMapper        $_dateTimeMapper    DateTimeMapper
     * @param \App\repository\CommentRepository $_commentRepository CommentRepository
     * @param \App\repository\PostRepository    $_postRepository    PostRepository
     * @param \App\repository\UserRepository    $_userRepository    UserRepository
     */
    private function __construct(
        private readonly CommentMapper $_commentMapper,
        private readonly DateTimeMapper $_dateTimeMapper,
        private readonly CommentRepository $_commentRepository,
        private readonly PostRepository $_postRepository,
        private readonly UserRepository $_userRepository
    ) {

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
            self::$instance = new CommentService(
                CommentMapper::getInstance(),
                DateTimeMapper::getInstance(),
                CommentRepository::getInstance(),
                PostRepository::getInstance(),
                UserRepository::getInstance()
            );
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

        $comments = $this->_commentRepository->getOnePostComments($postId);

        $listOfComments = [];
        foreach ($comments as $comment) {
            $username = $this->_userRepository->getUsername($comment->getUserId());
            $commentModel = $this->_commentMapper->getCommentModel($comment, $username);

            $listOfComments[] = $commentModel;
        }

        return $listOfComments;

    }//end getpostComments()


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

            $currentDate = $this->_dateTimeMapper->getCurrentDate();
            $currentDate = $this->_dateTimeMapper->toString($currentDate);

            $userService = UserService::getInstance();
            $userId = $userService->getUserId($username);

            $comment = (new CommentEntity())
                ->setUserId($userId)
                ->setPostId($postId)
                ->setContent($content)
                ->setCreationDate($currentDate);

            return $comment;

    }//end manageComment()


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

    }//end createNewComment()


    /**
     * Summary of getPendingComments
     *
     * @return array
     */
    public function getPendingComments(): array
    {

        $commentEntities = $this->_commentRepository->getPendingComments();
        $commentModels = $this->_commentMapper->getCommentModels($commentEntities);

        return array_map(
            function (CommentModel $commentModel) {
                $username = $this->_userRepository->getUsername($commentModel->getIdUser());
                $title = $this->_postRepository->getPostTitle($commentModel->getIdPost());
                $commentModel->setAuthor($username);
                $commentModel->setPostTitle($title);
                return $commentModel;
            },
            $commentModels
        );

    }//end getPendingComments()


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

    }//end validateComments()


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

    }//end deleteComments()


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
            $pendingCommentsIds[] = $comment->getId();
        }

        $isValid = in_array($commentId, $pendingCommentsIds);

        if ($isValid === true) {
            return true;
        }

        return false;

    }//end validCommentId()


}//end class
