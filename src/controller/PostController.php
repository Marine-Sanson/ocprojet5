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
use App\controller\CommentController;
use App\mapper\PostsMapper;
use App\repository\PostRepository;
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
     * Summary of template
     * 
     * @var TemplateInterface
     */
    // private TemplateInterface $_template;

    /**
     * Summary of _instance
     * 
     * @var PostController
     */
    private static $_instance;

    const URL = "posts";
    const URL_ONE_POST = "post";
    const POSTS_VIEW = 'posts.html.twig';
    const ONEPOST_VIEW = 'one-post.html.twig'; // a changer

    /**
     * Summary of __construct call an instance of TemplateInterface
     * 
     * @param TemplateInterface $template template engine
     */
    public function __construct(public TemplateInterface $template)
    {
        // $this->postService = PostService::getInstance();
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
     * Summary of getPosts
     * 
     * @return array
     */
    public function getPosts() :array
    {
        $postRepository = new PostRepository();
        $results= $postRepository->getAllPostsWithAuthors();

        $postmapper = new PostsMapper();
        $posts = $postmapper->transformToListOfPostModel($results);

        return $posts;
    }

    public function showPostDetails(int $id) :void
    {
        $post = $this->getPostData($id);
        $comments = $this->getPostComments($id);
        // $this->postService->getPostDetails($postId);
        echo $this->template->render(
            $this::ONEPOST_VIEW, [
                'id' => $id,
                'post' => $post,
                'comments' => $comments
            ]);
    }

    /**
     * Summary of getPostData
     * 
     * @param int $id id of the post
     * 
     * @return array
     */
    private function getPostData(int $id) :array // dans le postService
    {
        $postRepository = new PostRepository();
        $post = $postRepository->getOnePostData($id);

        return $post;
    }

    private function getPostComments(int $id) :array // déplacer dans un postService ou commentService
    {
        $commentController = CommentController::getInstance();
        $comments = $commentController->getOnePostComments($id);

        return $comments;
    }
}
