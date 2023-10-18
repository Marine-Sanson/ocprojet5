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
use App\mapper\RouteMapper;
use App\service\CommentService;
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
     * Summary of _instance
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
     */
    private function __construct(
        private readonly TemplateInterface $_template,
        private readonly CommentService $_commentService
        ) { }

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
            self::$instance = new CommentController($template, CommentService::getInstance());  
        }
        return self::$instance;
    }

    /**
     * Summary of displayValidationPage
     * 
     * @return void
     */
    public function displayValidationPage(): void
    {
        $template = RouteMapper::ValidationComments->getTemplate();
        $comments = $this->_commentService->getPendingComments();
        $data["comments"] = $this->commentsToDisplay($comments);

        $this->_template->display($template, $data);
    }

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
        $isvalid = $this->_commentService->validCommentId($commentId);
        if ($isvalid) {
            $this->_commentService->validateComments($commentId);
            $data[MessageMapper::Message->getMessageLabel()] = MessageMapper::CommentValidationSuccess->getMessage();
        }
        if (!$isvalid) {
            $data[MessageMapper::Error->getMessageLabel()] = MessageMapper::GeneralError->getMessage();
        }
        $comments = $this->_commentService->getPendingComments();
        $data["comments"] = $this->commentsToDisplay($comments);

        $this->_template->display($template, $data);
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
        $template = RouteMapper::ValidationComments->getTemplate();
        $isvalid = $this->_commentService->validCommentId($commentId);
        if ($isvalid) {
            $this->_commentService->deleteComments($commentId);
            $data[MessageMapper::Message->getMessageLabel()] = MessageMapper::CommentDeleteSuccess->getMessage();
        }
        if (!$isvalid) {
            $data[MessageMapper::Error->getMessageLabel()] = MessageMapper::GeneralError->getMessage();
        }

        $comments = $this->_commentService->getPendingComments();
        $data["comments"] = $this->commentsToDisplay($comments);

        $this->_template->display($template, $data);
    }

    /**
     * Summary of commentsToDisplay
     * 
     * @param array $comments comments
     * 
     * @return array
     */
    public function commentsToDisplay(array $comments): array
    {
        $commentsToDisplay = [];
        foreach ($comments as $comment) {
            $comment["content"] = $this->toDisplay($comment["content"]);

            $commentsToDisplay[] = $comment;
        }
        return $commentsToDisplay;
    }
}
