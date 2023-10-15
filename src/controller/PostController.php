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
use App\mapper\MessageMapper;
use App\mapper\RouteMapper;
use App\service\CommentService;
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
    const ACTION = "addPost";
    const MODIFY = "modifyPost";


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
        $result = $this->postsToDisplay($result);
        
        echo $this->template->render(RouteMapper::PostsView->getTemplate(), ['posts' => $result]);
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
        $postDetails = $this->_postService->getPostDetails($postId);
        $postDetails->setSummary($this->toDisplay($postDetails->getSummary()));
        $postDetails->setContent($this->toDisplay($postDetails->getContent()));

        $comments = [];
        foreach ($postDetails->getComments() as $postCom) {
            $postCom["content"] = $this->toDisplay($postCom["content"]);
            $comments[] = $postCom;
        }
        $postDetails->setComments($comments);

        echo $this->template->render(
            RouteMapper::OnePostView->getTemplate(), [
                'id' => $postId,
                'postDetails' => $postDetails,
                'message' => $message
            ]
        );
    }

    /**
     * Summary of addComment
     * 
     * @param int $postId id of the post
     * 
     * @return void
     */
    public function addComment(int $postId): void
    {
        $postDetails = $this->_postService->getPostDetails($postId);
        if ($this->isSubmitted($this->_commentService::ACTION) && $this->isValid($_POST)) {
            $username = $_POST["username"];            
            $postId = intval($_POST["postId"]);
            $content = $this->sanitize($_POST["content"]);

            $comment = $this->_commentService->manageComment($username, $postId, $content);
            $message = $this->_commentService->createNewComment($comment);
        } else {
            $message = [
                MessageMapper::Error->getMessageLabel() => MessageMapper::GeneralError->getMessage()
            ];
        }
        echo $this->template->render(
            RouteMapper::OnePostView->getTemplate(), [
                'id' => $postId,
                'postDetails' => $postDetails,
                'message' => $message
            ]
        );
    }

    /**
     * Summary of addPost
     * 
     * @return void
     */
    public function addPost()
    {
        if ($this->isSubmitted(self::ACTION) && $this->isValid($_POST)) {

            $userId = intval($_POST["userId"]);
            $title = $this->sanitize($_POST["title"]);
            $summary = $this->sanitize($_POST["summary"]);
            $content = $this->sanitize($_POST["content"]);

            $isPostCreated = $this->_postService->createNewPost($userId, $title, $summary, $content);
            if (!$isPostCreated) {
                $data = [
                    MessageMapper::Error->getMessageLabel() => MessageMapper::GeneralError->getMessage()
                ];
            }

            if (!isset($data[MessageMapper::Error->getMessageLabel()])) {
                $data = [
                    MessageMapper::Message->getMessageLabel() => MessageMapper::NewPostSuccess->getMessage()
                ];
            }
        }
        $posts = $this->_postService->getPosts();
        $data["posts"] = $this->postsToDisplay($posts);

        echo $this->template->render(RouteMapper::PostsView->getTemplate(), $data);
    }

    /**
     * Summary of modifyPost
     * 
     * @param int    $routeParam routeParam
     * @param string $action     action
     * @param int    $userId     userId
     * @param string $username   username
     * @param int    $postId     postId
     * @param string $title      title
     * @param string $summary    summary
     * @param string $content    content
     * 
     * @return void
     */
    public function modifyPost(int $routeParam, string $action, int $userId, string $username, int $postId, string $title, string $summary, string $content): void
    {
        $message = null;

        if (!$this->isSubmitted(self::MODIFY) || !$this->isValid($_POST)) {
            $message = [
                MessageMapper::Error->getMessageLabel() => MessageMapper::GeneralError->getMessage()
            ];
        }
        if (!isset($data[MessageMapper::Error->getMessageLabel()])) {
            if ($routeParam !== $postId) {
                $message = [
                    MessageMapper::Error->getMessageLabel() => MessageMapper::GeneralError->getMessage()
                ];
            }
        }
        if (!isset($data[MessageMapper::Error->getMessageLabel()])) {
            $title = $this->sanitize($title);
            $summary = $this->sanitize($summary);
            $content = $this->sanitize($content);

            $this->_postService->updateAPost($postId, $userId, $title, $summary, $content);
            $message = [
                MessageMapper::Message->getMessageLabel() => MessageMapper::UpdateSuccess->getMessage()
            ];
        }

        $postDetails = $this->_postService->getPostDetails($routeParam);
        $postDetails->setSummary($this->toDisplay($postDetails->getSummary()));
        $postDetails->setContent($this->toDisplay($postDetails->getContent()));
        $comments = [];
        foreach ($postDetails->getComments() as $postCom) {
            $postCom["content"] = $this->toDisplay($postCom["content"]);
            $comments[] = $postCom;
        }
        $postDetails->setComments($comments);

        echo $this->template->render(
            RouteMapper::OnePostView->getTemplate(), [
                'id' => $routeParam,
                'postDetails' => $postDetails,
                'message' => $message
            ]
        );

    }

    /**
     * Summary of postsToDisplay
     * 
     * @param array $posts list of PostModels
     * 
     * @return array
     */
    public function postsToDisplay(array $posts)
    {
        $postsToDisplay = [];
        foreach ($posts as $post) {
            $post->setTitle($this->toDisplay($post->getTitle()));
            $post->setSummary($this->toDisplay($post->getSummary()));
            $postsToDisplay[] = $post;
        }
        return $postsToDisplay;
    }
}
