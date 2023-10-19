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
     * Summary of _instance
     *
     * @var PostService
     */
    private static $instance;


    /**
     * Summary of __construct
     *
     * @param \App\mapper\PostsMapper           $_postsMapper       PostsMapper
     * @param \App\mapper\PostDetailsMapper     $_postDetailsMapper PostDetailsMapper
     * @param \App\repository\CommentRepository $_commentRepository CommentRepository
     * @param \App\repository\PostRepository    $_postRepository    PostRepository
     * @param \App\service\CommentService       $_commentService    CommentService
     */
    private function __construct(
        private readonly PostsMapper $_postsMapper,
        private readonly PostDetailsMapper $_postDetailsMapper,
        private readonly CommentRepository $_commentRepository,
        private readonly PostRepository $_postRepository,
        private readonly CommentService $_commentService
    )
    {

    }//end of __construct()


    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     *
     * @return \App\service\PostService
     */
    public static function getInstance(): PostService
    {

        if (self::$instance === null) {
            self::$instance = new PostService(
                PostsMapper::getInstance(),
                PostDetailsMapper::getInstance(),
                CommentRepository::getInstance(),
                PostRepository::getInstance(),
                CommentService::getInstance()
            );
        }

        return self::$instance;
        
    }

    /**
     * Summary of getPosts
     *
     * @return array
     */
    public function getPosts(): array
    {

        $results = $this->_postRepository->getAllPostsWithAuthors();

        return $this->_postsMapper->transformToListOfPostModel($results);

    }

    /**
     * Summary of getPostDetails
     *
     * @param int $postId id of the post
     *
     * @return PostDetailsModel
     */
    public function getPostDetails(int $postId): PostDetailsModel
    {

        $post = $this->getPostData($postId);
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
    private function getPostData(int $postId): array
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

        if (isset($id) === false) {
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

        if ($insertPost === true) {
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
    public function updateAPost(int $postId, int $userId, string $title, string $summary, string $content): void
    {
        
        $lastUpdateDate = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
        $updatePost = new UpdatePostModel($postId, $userId, $title, $summary, $content, $lastUpdateDate);
        $this->_postRepository->updatePost($updatePost);

    }

}
