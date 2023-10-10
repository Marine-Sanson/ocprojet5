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
use App\service\CommentService;
use App\service\MessageService;
use App\service\RouteService;
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
     * Summary of template
     * 
     * @var TemplateInterface
     */
    private TemplateInterface $_template;

    /**
     * Summary of _commentRepository
     * 
     * @var CommentService
     */
    private CommentService $_commentService;

    /**
     * Summary of _instance
     * 
     * @var CommentController
     */
    private static $_instance;

    const URL = "validation";
    const VALIDATION = "validate";
    const DELETE = "delete";

    /**
     * Summary of __construct
     * 
     * @param \App\service\TemplateInterface $template template
     */
    private function __construct(TemplateInterface $template)
    {
        $this->_template = $template;
        $this->_commentService = CommentService::getInstance();
    }

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
        if (is_null(self::$_instance)) {
            self::$_instance = new CommentController($template);  
        }
        return self::$_instance;
    }

    /**
     * Summary of displayValidationPage
     * 
     * @return void
     */
    public function displayValidationPage(): void
    {
        $template = RouteService::ValidationComments->getLabel();
        $comments = $this->_commentService->getPendingComments();
        $data["comments"] = $this->commentsToDisplay($comments);

        echo $this->_template->render($template, $data);
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
        $template = RouteService::ValidationComments->getLabel();
        $isvalid = $this->_commentService->validCommentId($commentId);
        if ($isvalid) {
            $this->_commentService->validateComments($commentId);
            $data[MessageService::MESSAGE] = MessageService::VALIDATE_SUCCESS;
        }
        if (!$isvalid) {
            $data[MessageService::ERROR] = MessageService::GENERAL_ERROR;
        }
        $comments = $this->_commentService->getPendingComments();
        $data["comments"] = $this->commentsToDisplay($comments);

        echo $this->_template->render($template, $data);
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
        $template = RouteService::ValidationComments->getLabel();
        $isvalid = $this->_commentService->validCommentId($commentId);
        if ($isvalid) {
            $this->_commentService->deleteComments($commentId);
            $data[MessageService::MESSAGE] = MessageService::DELATE_SUCCESS;
        }
        if (!$isvalid) {
            $data[MessageService::ERROR] = MessageService::GENERAL_ERROR;
        }

        $comments = $this->_commentService->getPendingComments();
        $data["comments"] = $this->commentsToDisplay($comments);

        echo $this->_template->render($template, $data);
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
