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
     * Summary of _instance
     *
     * @var HomeService
     */
    private static $instance;


    /**
     * Summary of __construct
     *
     * @param \App\repository\PostRepository $_postRepository PostRepository
     * @param \App\mapper\DateTimeMapper     $_dateTimeMapper DateTimeMapper
     * @param \App\mapper\PostsMapper        $_postsMapper    PostsMapper
     */
    private function __construct(
        private readonly PostRepository $_postRepository,
        private readonly UserRepository $_userRepository,
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
            self::$instance = new HomeService(PostRepository::getInstance(), UserRepository::getInstance(), PostsMapper::getInstance());
        }

        return self::$instance;

    }//end getInstance()


    /**
     * Summary of getLastPosts
     *
     * @return array
     */
    public function getLastPosts(): array
    {

        $results = $this->_postRepository->getListOfPosts();

        $postModels = [];

        foreach ($results as $entity) {
            $username = $this->_userRepository->getUsername($entity->getIdUser());
            $postModel = $this->_postsMapper->transformToPostModel($entity, $username);

            $postModels[] = $postModel;
        }

        return $postModels;

    }//end getLastPosts()


}//end class
