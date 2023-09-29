<?php
/**
 * PostService File Doc Comment
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
use App\mapper\PostDetailsMapper;
use App\mapper\PostsMapper;
use App\model\PostDetailsModel;
use App\repository\CommentRepository;
use App\repository\PostRepository;
use App\service\CommentService;

/**
 * PostService Class Doc Comment
 * 
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class PostService
{
    /**
     * Summary of template
     * 
     * @var TemplateInterface
     */
    public TemplateInterface $template;

    /**
     * Summary of _postRepository
     * 
     * @var PostRepository
     */
    private PostRepository $_postRepository;

    /**
     * Summary of _postService
     * 
     * @var CommentService $_commentService
     */
    private CommentService $_commentService;

    /**
     * Summary of _instance
     * 
     * @var PostService
     */
    private static $_instance;

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->_postRepository = new PostRepository();
        $this->_commentService = CommentService::getInstance();
    }

    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     * 
     * @return \App\service\PostService
     */
    public static function getInstance(): PostService
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new PostService();  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of getPosts
     * 
     * @return array
     */
    public function getPosts(): array
    {
        $results= $this->_postRepository->getAllPostsWithAuthors();

        $postmapper = new PostsMapper();
        $posts = $postmapper->transformToListOfPostModel($results);

        return $posts;
    }

    /**
     * Summary of getPostDetails
     * 
     * @param int $postId id of the post
     * 
     * @return array
     */
    public function getPostDetails(int $postId): PostDetailsModel
    {
        $post = $this->_getPostData($postId);
        $comments = $this->_getPostComments($postId);
        $postDetailsMapper = PostDetailsMapper::getInstance();
        $postDetails = $postDetailsMapper->getPostDetailsModel($post, $comments);

        return $postDetails;
    }

    /**
     * Summary of getPostData
     * 
     * @param int $postId id of the post
     * 
     * @return array
     */
    private function _getPostData(int $postId): array // dans le postService
    {
        $post = $this->_postRepository->getOnePostData($postId);

        return $post;
    }

    /**
     * Summary of getPostComments
     * 
     * @param int $postId id of the post
     * 
     * @return array
     */
    private function _getPostComments(int $postId): array
    {
        $comments = $this->_commentService->getComments($postId);

        return $comments;
    }

    /**
     * Summary of createNewComment
     * 
     * @param \App\entity\CommentEntity $newComment new comment
     * 
     * @return bool
     */
    public function createNewComment(CommentEntity $newComment): bool
    {
        $commentRepository = new CommentRepository();
        $id = $commentRepository->insertComment($newComment);

        if (isset($id)) {
            return true;
        } else {
            return false;
        }
    }
}
