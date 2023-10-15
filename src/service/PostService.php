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
use App\model\NewPostModel;
use App\model\PostDetailsModel;
use App\model\UpdatePostModel;
use App\repository\CommentRepository;
use App\repository\PostRepository;
use App\service\CommentService;
use DateTime;

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
     * Summary of _postsMapper
     * 
     * @var PostsMapper
     */
    private PostsMapper $_postsMapper;

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
     * Summary of _postDetailsMapper
     * 
     * @var PostDetailsMapper
     */
    private PostDetailsMapper $_postDetailsMapper;

    /**
     * Summary of _commentRepository
     * 
     * @var CommentRepository
     */
    private CommentRepository $_commentRepository;

    /**
     * Summary of _instance
     * 
     * @var PostService
     */
    private static $_instance;

    /**
     * Summary of __construct
     */
    private function __construct()
    {
        $this->_postsMapper = PostsMapper::getInstance();
        $this->_postRepository = PostRepository::getInstance();
        $this->_commentService = CommentService::getInstance();
        $this->_postDetailsMapper = PostDetailsMapper::getInstance();
        $this->_commentRepository = CommentRepository::getInstance();
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

        $posts = $this->_postsMapper->transformToListOfPostModel($results);

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
        $comments = $this->_commentService->getpostComments($postId);
 
        return $this->_postDetailsMapper->getPostDetailsModel($post, $comments);
    }

    /**
     * Summary of getPostData
     * 
     * @param int $postId id of the post
     * 
     * @return array
     */
    private function _getPostData(int $postId): array
    {
        return $this->_postRepository->getOnePostData($postId);
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
        $id = $this->_commentRepository->insertComment($newComment);

        if (!isset($id)) {
            return false;
        }
        return true;
    }

    /**
     * Summary of createNewPost
     * 
     * @param int    $userId  userId
     * @param string $title   title
     * @param string $summary summary
     * @param string $content content
     * 
     * @return bool
     */
    public function createNewPost(int $userId, string $title, string $summary, string $content): bool
    {
        $currentDate = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));

        $newPost = new NewPostModel($userId, $title, $summary, $content, $currentDate);

        $insertPost = $this->_postRepository->insertNewPost($newPost);

        if ($insertPost) {
            return true;
        }

        return false;
    }

    /**
     * Summary of updateAPost
     * 
     * @param int    $postId  postId
     * @param int    $userId  userId
     * @param string $title   title
     * @param string $summary summary
     * @param string $content content
     * 
     * @return void
     */
    public function updateAPost(int $postId, int $userId, string $title, string $summary, string $content)
    {
        $lastUpdateDate = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
        $updatePost = new UpdatePostModel($postId, $userId, $title, $summary, $content, $lastUpdateDate);
        $this->_postRepository->updatePost($updatePost);
    }
}
