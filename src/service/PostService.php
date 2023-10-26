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

use App\entity\PostEntity;
use App\mapper\DateTimeMapper;
use App\mapper\PostDetailsMapper;
use App\mapper\PostsMapper;
use App\model\NewPostModel;
use App\model\PostDetailsModel;
use App\model\PostModel;
use App\model\UpdatePostModel;
use App\repository\CommentRepository;
use App\repository\PostRepository;
use App\repository\UserRepository;
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
     * Summary of instance
     *
     * @var PostService
     */
    private static $instance;


    /**
     * Summary of __construct
     *
     * @param \App\mapper\DateTimeMapper        $_dateTimeMapper    DateTimeMapper
     * @param \App\mapper\PostsMapper           $_postsMapper       PostsMapper
     * @param \App\mapper\PostDetailsMapper     $_postDetailsMapper PostDetailsMapper
     * @param \App\repository\CommentRepository $_commentRepository CommentRepository
     * @param \App\repository\PostRepository    $_postRepository    PostRepository
     * @param \App\repository\UserRepository    $_userRepository    UserRepository
     * @param \App\service\CommentService       $_commentService    CommentService
     */
    private function __construct(
        private readonly DateTimeMapper $_dateTimeMapper,
        private readonly PostsMapper $_postsMapper,
        private readonly PostDetailsMapper $_postDetailsMapper,
        private readonly CommentRepository $_commentRepository,
        private readonly PostRepository $_postRepository,
        private readonly UserRepository $_userRepository,
        private readonly CommentService $_commentService
    ) {

    }//end __construct()


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
                DateTimeMapper::getInstance(),
                PostsMapper::getInstance(),
                PostDetailsMapper::getInstance(),
                CommentRepository::getInstance(),
                PostRepository::getInstance(),
                UserRepository::getInstance(),
                CommentService::getInstance()
            );
        }

        return self::$instance;

    }//end getInstance()


    /**
     * Summary of getPosts
     *
     * @return array<PostModel>
     */
    public function getPosts(): array
    {

        // $results = $this->_postRepository->getAllPostsWithAuthors();
        $postEntities = $this->_postRepository->getAllPosts();
        $postEntities = $this->getPostAuthor($postEntities);
        $postModels = $this->_postsMapper->transformToPostModels($postEntities);

        return $postModels;

    }//end getPosts()


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
        $username = $this->_userRepository->getUsername($post->getIdUser());
        $comments = $this->_commentService->getpostComments($postId);

        return $this->_postDetailsMapper->getPostDetailsModel($post, $username, $comments);

    }//end getPostDetails()


    /**
     * Summary of getPostData
     *
     * @param int $postId id of the post
     *
     * @return array
     */
    private function getPostData(int $postId): PostEntity
    {

        return $this->_postRepository->getOnePostData($postId);

    }//end getPostData()


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

        $currentDate = $this->_dateTimeMapper->getCurrentDate();

        $newPost = new NewPostModel($userId, $title, $summary, $content, $currentDate);

        $insertPost = $this->_postRepository->insertNewPost($newPost);

        if (isset($insertPost) === true) {
            return true;
        }

        return false;

    }//end createNewPost()


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

        $lastUpdateDate = $this->_dateTimeMapper->getCurrentDate();

        $updatePost = new UpdatePostModel($postId, $userId, $title, $summary, $content, $lastUpdateDate);
        $this->_postRepository->updatePost($updatePost);

    }//end updateAPost()


    /**
     * Summary of transformToPostModels
     *
     * @param array<PostEntity> $postEntities postEntities
     *
     * @return array<PostModel>
     */
    public function getPostAuthor(array $postEntities): array
    {

        return array_map(
            function (PostEntity $postEntity) {
                $username = $this->_userRepository->getUsername($postEntity->getIdUser());
                return $postEntity->setUsername($username);
            },
            $postEntities
        );

    }//end getPostAuthor()


}//end class
