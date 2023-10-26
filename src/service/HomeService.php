<?php
/**
 * HomeService File Doc Comment
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

use App\mapper\PostsMapper;
use App\model\PostModel;
use App\repository\PostRepository;
use App\repository\UserRepository;

/**
 * HomeService Class Doc Comment
 *
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class HomeService
{

    /**
     * Summary of instance
     *
     * @var HomeService
     */
    private static $instance;


    /**
     * Summary of __construct
     *
     * @param \App\repository\PostRepository $_postRepository PostRepository
     * @param \App\repository\UserRepository $_userRepository PostRepository
     * @param \App\service\PostService       $_postService    PostService
     * @param \App\mapper\PostsMapper        $_postsMapper    PostsMapper
     */
    private function __construct(
        private readonly PostRepository $_postRepository,
        private readonly UserRepository $_userRepository,
        private readonly PostService $_postService,
        private readonly PostsMapper $_postsMapper
    ) {

    }//end __construct()


    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     *
     * @return \App\service\HomeService
     */
    public static function getInstance(): HomeService
    {

        if (self::$instance === null) {
            self::$instance = new HomeService(
                PostRepository::getInstance(),
                UserRepository::getInstance(),
                PostService::getInstance(),
                PostsMapper::getInstance()
            );
        }

        return self::$instance;

    }//end getInstance()


    /**
     * Summary of getLastPosts
     *
     * @return array<PostModel>
     */
    public function getLastPosts(): array
    {

        $postEntities = $this->_postRepository->getListOfPosts();
        $postEntities = $this->_postService->getPostAuthor($postEntities);
        $postModels = $this->_postsMapper->transformToPostModels($postEntities);

        return $postModels;

    }//end getLastPosts()


}//end class
