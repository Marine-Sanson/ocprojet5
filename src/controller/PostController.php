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
    private static $instance;

    const URL = "posts";
    const ACTION = "addPost";
    const MODIFY = "modifyPost";


    /**
     * Summary of __construct
     * Call an instance of TemplateInterface
     *
     * @param \App\service\TemplateInterface $_template       TemplateInterface
     * @param \App\service\PostService       $_postService    PostService
     * @param \App\service\CommentService    $_commentService CommentService
     */
    private function __construct(
        private readonly TemplateInterface $_template,
        private readonly PostService $_postService,
        private readonly CommentService $_commentService
    ) {

    }//end __construct()


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

        if (self::$instance === null) {
            self::$instance = new PostController($template, PostService::getInstance(), CommentService::getInstance());
        }

        return self::$instance;

    }//end getInstance()


    /**
     * Summary of showPosts
     *
     * @return void
     */
    public function showPosts(): void
    {

        $result = $this->_postService->getPosts();
        $result = $this->postsToDisplay($result);

        $this->_template->display(RouteMapper::PostsView->getTemplate(), ['posts' => $result]);

    }//end showPosts()


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
            $postCom->setContent($this->toDisplay($postCom->getContent()));
            $comments[] = $postCom;
        }

        $postDetails->setComments($comments);

        $this->_template->display(
            RouteMapper::OnePostView->getTemplate(), [
                'id'          => $postId,
                'postDetails' => $postDetails,
                'message'     => $message,
            ]
        );

    }//end showPostDetails()


    /**
     * Summary of addComment
     *
     * @param int   $routeParam routeParam
     * @param array $post       with postId, username and content
     *
     * @return void
     */
    public function addComment(int $routeParam, array $post): void
    {

        $message = [];
        $postId = (int) $post["postId"];

        if ($this->isValid($post) === false) {
            $message = [
                MessageMapper::Error->getMessageLabel() => MessageMapper::GeneralError->getMessage()
            ];
        }

        if ($postId !== $routeParam) {
            $message = [
                MessageMapper::Error->getMessageLabel() => MessageMapper::GeneralError->getMessage()
            ];
        }

        if (isset($message[MessageMapper::Error->getMessageLabel()]) === false) {
            $content = $this->sanitize($post["content"]);
            $comment = $this->_commentService->manageComment($post["username"], $postId, $content);
            $message = $this->_commentService->createNewComment($comment);
        }

        $postDetails = $this->_postService->getPostDetails($postId);
        $this->_template->display(
            RouteMapper::OnePostView->getTemplate(), [
                'id'          => $postId,
                'postDetails' => $postDetails,
                'message'     => $message,
            ]
        );

    }//end addComment()


    /**
     * Summary of addPost
     *
     * @param array $post with userId, title, summary and content
     *
     * @return void
     */
    public function addPost(array $post): void
    {

        $data = [];
        if ($this->isValid($post) === true) {
            $title = $this->sanitize(ucwords(strtolower($post["title"])));
            $summary = $this->sanitize($post["summary"]);
            $content = $this->sanitize($post["content"]);

            $isPostCreated = $this->_postService->createNewPost((int) $post["userId"], $title, $summary, $content);

            if ($isPostCreated === false) {
                $data = [
                    MessageMapper::Error->getMessageLabel() => MessageMapper::GeneralError->getMessage()
                ];
            }

            if (isset($data[MessageMapper::Error->getMessageLabel()]) === false) {
                $data = [
                    MessageMapper::Message->getMessageLabel() => MessageMapper::NewPostSuccess->getMessage()
                ];
            }
        }

        $posts = $this->_postService->getPosts();
        $data["posts"] = $this->postsToDisplay($posts);

        $this->_template->display(RouteMapper::PostsView->getTemplate(), $data);

    }//end addPost()


    /**
     * Summary of modifyPost
     *
     * @param int   $routeParam routeParam
     * @param array $post       with userId, username, postId, title, summary and content
     *
     * @return void
     */
    public function modifyPost(int $routeParam, array $post): void
    {

        $message = null;

        $userId = (int) $post["userId"];
        $postId = (int) $post["postId"];

        if ($this->isValid($post) === false) {
            $message = [
                MessageMapper::Error->getMessageLabel() => MessageMapper::GeneralError->getMessage()
            ];
        }

        if ($message === null) {
            if ($routeParam !== $postId) {
                $message = [
                    MessageMapper::Error->getMessageLabel() => MessageMapper::GeneralError->getMessage()
                ];
            }
        }

        if ($message === null) {
            $title = $this->sanitize($post["title"]);
            $summary = $this->sanitize($post["summary"]);
            $content = $this->sanitize($post["content"]);

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

        $this->_template->display(
            RouteMapper::OnePostView->getTemplate(), [
                'id'          => $routeParam,
                'postDetails' => $postDetails,
                'message'     => $message
            ]
        );

    }//end modifyPost()


    /**
     * Summary of postsToDisplay
     * Receive and return an array of PostModels after decode treatment on title and summary
     *
     * @param array $posts list of PostModels
     *
     * @return array
     */
    public function postsToDisplay(array $posts): array
    {

        $postsToDisplay = [];
        foreach ($posts as $post) {
            $post->setTitle($this->toDisplay($post->getTitle()));
            $post->setSummary($this->toDisplay($post->getSummary()));
            $postsToDisplay[] = $post;
        }

        return $postsToDisplay;

    }//end postsToDisplay()


}//end class
