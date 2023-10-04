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
use App\service\CommentService;
use App\service\MessageService;
use App\service\PostService;
use App\service\TemplateInterface;

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
    private PostService $_postService;

    /**
     * Summary of _commentService
     * 
     * @var CommentService
     */
    private CommentService $_commentService;
    
    const URL = "posts";
    const POSTS_VIEW = 'posts.html.twig';
    const ONEPOST_VIEW = 'one-post.html.twig'; // a changer

    /**
     * Summary of __construct call an instance of TemplateInterface
     * 
     * @param TemplateInterface $template template engine
     */
    private function __construct(private readonly TemplateInterface $template)
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
    public static function getInstance(TemplateInterface $template): PostController
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
    public function showPosts(): void
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
    public function showPostDetails(int $postId): void
    {
        $message = null;
        if (isset($_POST["action"]) && $_POST["action"] === $this->_commentService::ACTION) {

            if ($this->isSubmitted($this->_commentService::ACTION) && $this->isValid($_POST)) {

                $username = $_POST["username"];            
                $postId = intval($_POST["postId"]);
                $content = $_POST["content"];

                $validateContent = $this->validCommentForm($content);
                $comment = $this->_commentService->manageComment($username, $postId, $validateContent);
                $message = $this->_commentService->createNewComment($comment);
            } else {
                $message = [
                    MessageService::ERROR => MessageService::GENERAL_ERROR
                ];
            }
        }

        $postDetails = $this->_postService->getPostDetails($postId);
        $comments = [];
        foreach ($postDetails->getComments() as $postCom) {
            $postCom["content"] = $this->toDisplay($postCom["content"]);
            $comments[] = $postCom;
        }
        $postDetails->setComments($comments);

        echo $this->template->render(
            self::ONEPOST_VIEW, [
                'id' => $postId,
                'postDetails' => $postDetails,
                'message' => $message
            ]
        );
    }

    /**
     * Summary of validCommentForm
     * 
     * @param string $content content
     * 
     * @return string
     */
    public function validCommentForm(string $content): string
    {
        $content = $this->sanitize($content);

        return $content; 
    }
}
