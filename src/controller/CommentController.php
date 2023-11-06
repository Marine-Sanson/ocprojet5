<?php
/**
 * CommentController File Doc Comment
 *
 * PHP Version 8.1.10
 *
 * @category Controller
 * @package  App\controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\controller;

use App\controller\AbstractController;
use App\mapper\MessageMapper;
use App\mapper\RoleMapper;
use App\mapper\RouteMapper;
use App\model\CommentModel;
use App\service\CommentService;
use App\service\SessionService;
use App\service\TemplateInterface;

/**
 * CommentController Class Doc Comment
 *
 * @category Controller
 * @package  App\controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class CommentController extends AbstractController
{

    /**
     * Summary of instance
     *
     * @var CommentController
     */
    private static $instance;

    const URL = "validation";
    const VALIDATION = "validate";
    const DELETE = "delete";


    /**
     * Summary of __construct
     *
     * @param \App\service\TemplateInterface $_template       TemplateInterface
     * @param \App\service\CommentService    $_commentService CommentService
     * @param \App\service\SessionService    $_sessionService SessionService
     */
    private function __construct(
        private readonly TemplateInterface $_template,
        private readonly CommentService $_commentService,
        private readonly SessionService $_sessionService
    ) {

    }//end __construct()


    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     *
     * @param \App\service\TemplateInterface $template template
     *
     * @return \App\controller\CommentController
     */
    public static function getInstance(TemplateInterface $template): CommentController
    {

        if (self::$instance === null) {
            self::$instance = new CommentController($template, CommentService::getInstance(), SessionService::getInstance());
        }

        return self::$instance;

    }//end getInstance()


    /**
     * Summary of displayValidationPage
     *
     * @return void
     */
    public function displayValidationPage(): void
    {
        $template = RouteMapper::ValidationComments->getTemplate();
        $data = [];
        $isAllowed = $this->_sessionService->getUser()->isUserAllowed();

        if (isset($isAllowed) === false || $isAllowed !== true) {
            $data[MessageMapper::Error->getMessageLabel()] = MessageMapper::GeneralError->getMessage();
        }

        if (isset($data[MessageMapper::Error->getMessageLabel()]) === false) {
            $comments = $this->_commentService->getPendingComments();
            $data["comments"] = $this->commentsToDisplay($comments);
        }

        $this->_template->display($template, $data);

    }//end displayValidationPage()


    /**
     * Summary of validateComment
     *
     * @param int $commentId id of the comment
     *
     * @return void
     */
    public function validateComment(int $commentId): void
    {

        $template = RouteMapper::ValidationComments->getTemplate();
        $data = [];
        $isAllowed = $this->_sessionService->getUser()->isUserAllowed();

        if (isset($isAllowed) === false || $isAllowed !== true) {
            $data[MessageMapper::Error->getMessageLabel()] = MessageMapper::GeneralError->getMessage();
        }

        if (isset($data[MessageMapper::Error->getMessageLabel()]) === false) {
            $isvalid = $this->_commentService->validCommentId($commentId);
            if ($isvalid === false) {
                $data[MessageMapper::Error->getMessageLabel()] = MessageMapper::GeneralError->getMessage();
            }
        }

        if (isset($data[MessageMapper::Error->getMessageLabel()]) === false) {
            $this->_commentService->validateComments($commentId);
            $data[MessageMapper::Message->getMessageLabel()] = MessageMapper::CommentValidationSuccess->getMessage();
        }

        $comments = $this->_commentService->getPendingComments();
        $data["comments"] = $this->commentsToDisplay($comments);

        $this->_template->display($template, $data);

    }//end validateComment()


    /**
     * Summary of deleteComment
     *
     * @param int $commentId id of the comment
     *
     * @return void
     */
    public function deleteComment(int $commentId): void
    {
        $template = RouteMapper::ValidationComments->getTemplate();
        $data = [];
        $isAllowed = $this->_sessionService->getUser()->isUserAllowed();

        if (isset($isAllowed) === false || $isAllowed !== true) {
            $data[MessageMapper::Error->getMessageLabel()] = MessageMapper::GeneralError->getMessage();
        }

        if (isset($data[MessageMapper::Error->getMessageLabel()]) === false) {
            $isvalid = $this->_commentService->validCommentId($commentId);
            if ($isvalid === false) {
                $data[MessageMapper::Error->getMessageLabel()] = MessageMapper::GeneralError->getMessage();
            }
        }

        if (isset($data[MessageMapper::Error->getMessageLabel()]) === false) {
            $this->_commentService->deleteComments($commentId);
            $data[MessageMapper::Message->getMessageLabel()] = MessageMapper::CommentDeleteSuccess->getMessage();
        }

        $comments = $this->_commentService->getPendingComments();
        $data["comments"] = $this->commentsToDisplay($comments);

        $this->_template->display($template, $data);

    }//end deleteComment()


    /**
     * Summary of commentsToDisplay
     *
     * @param array<CommentModel> $comments comments
     *
     * @return array
     */
    public function commentsToDisplay(array $comments): array
    {

        $commentsToDisplay = [];
        foreach ($comments as $comment) {
            $comment->setPostTitle($this->toDisplay($comment->getPostTitle()));
            $comment->setContent($this->toDisplay($comment->getContent()));

            $commentsToDisplay[] = $comment;
        }

        return $commentsToDisplay;

    }//end commentsToDisplay()


}//end class
