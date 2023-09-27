<?php
/**
 * PostController File Doc Comment
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
use App\entity\CommentEntity;
use App\service\CommentService;
use App\service\MessageService;
use App\service\PostService;
use App\service\TemplateInterface;
use App\service\UserService;
use DateTime;

/**
 * PostController Class Doc Comment
 * 
 * @category Controller
 * @package  App\controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class PostController extends AbstractController
{
    /**
     * Summary of _instance
     * 
     * @var PostController
     */
    private static $_instance;

    /**
     * Summary of _postService
     * 
     * @var PostService
     */
    private $_postService;

    /**
     * Summary of _commentService
     * 
     * @var CommentService
     */
    private $_commentService;
    
    const URL = "posts";
    const POSTS_VIEW = 'posts.html.twig';
    const ONEPOST_VIEW = 'one-post.html.twig'; // a changer

    /**
     * Summary of __construct call an instance of TemplateInterface
     * 
     * @param TemplateInterface $template template engine
     */
    public function __construct(public TemplateInterface $template)
    {
        $this->_postService = PostService::getInstance();
        $this->_commentService = CommentService::getInstance();
    }

    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     * 
     * @param \App\service\TemplateInterface $template template engine
     * 
     * @return \App\controller\PostController
     */
    public static function getInstance(TemplateInterface $template) :PostController
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new PostController($template);
        }
    
        return self::$_instance;
    }

    /**
     * Summary of showPosts
     * 
     * @return void
     */
    public function showPosts() :void
    {
        $result = $this->_postService->getPosts();
        echo $this->template->render($this::POSTS_VIEW, ['posts' => $result]);
    }

    /**
     * Summary of showPostDetails
     * 
     * @param int $postId id of the post
     * 
     * @return void
     */
    public function showPostDetails(int $postId) :void
    {
        $message = null;
        if (isset($_POST["action"])) {
            if ($_POST["action"] === $this->_commentService::ACTION) {
                $isSubmitted = $this->isSubmitted($this->_commentService::ACTION);
                $isValid = $this->isValid($_POST);
                if ($isSubmitted && $isValid) {
                    $comment = $this->_commentService->manageComment();
                    $validateComment = $this->validCommentForm($comment);

                    $message = $this->_commentService->createNewComment($validateComment);
                } else {
                    $message = [
                        MessageService::ERROR => MessageService::GENERAL_ERROR
                    ];
                }
            }
        }
        $postDetails = $this->_postService->getPostDetails($postId);
        echo $this->template->render(
            self::ONEPOST_VIEW, [
                'id' => $postId,
                'post' => $postDetails["post"],
                'comments' => $postDetails["comments"],
                'message' => $message
            ]
        );
    }

    /**
     * Summary of validCommentForm
     * 
     * @param \App\entity\CommentEntity $comment comment
     * 
     * @return \App\entity\CommentEntity
     */
    public function validCommentForm(CommentEntity $comment) :CommentEntity
    {
        $comment->content = $this->cleanInput($comment->content);

        return $comment; 
    }
}
