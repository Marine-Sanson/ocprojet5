<?php
/**
 * PostsMapper File Doc Comment
 *
 * PHP Version 8.1.10
 *
 * @category Mapper
 * @package  App\mapper
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\mapper;

use App\entity\PostEntity;
use App\model\PostModel;

/**
 * PostsMapper Class Doc Comment
 *
 * @category Mapper
 * @package  App\mapper
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class PostsMapper
{

    /**
     * Summary of _instance
     *
     * @var PostsMapper
     */
    private static $instance;


    /**
     * Summary of __construct
     *
     * @param \App\mapper\DateTimeMapper $_dateTimeMapper DateTimeMapper
     */
    private function __construct(private readonly DateTimeMapper $_dateTimeMapper)
    {

    }//end __construct()


    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     *
     * @return \App\service\PostService
     */
    public static function getInstance(): PostsMapper
    {

        if (self::$instance === null) {
            self::$instance = new PostsMapper(DateTimeMapper::getInstance());
        }

        return self::$instance;

    }//end getInstance()


    /**
     * Summary of transformToListOfPostModel
     *
     * @param array $posts posts datas
     *
     * @return array
     */
    public function transformToListOfPostModel(array $posts): array
    {

        $listOfPosts = [];
        foreach ($posts as $post) {
            $date = $this->_dateTimeMapper->toDateTime($post->getLastUpdateDate());
            $post = new PostModel($post["id"], $post["username"], $post["title"], $post["summary"], $date);
            $listOfPosts[] = $post;
        }

        return $listOfPosts;

    }//end transformToListOfPostModel()


    /**
     * Summary of transformToPostModel
     *
     * @param \App\entity\PostEntity $postEntity PostEntity
     *
     * @return PostModel
     */
    public function transformToPostModel(PostEntity $postEntity): PostModel
    {

        return new PostModel(
            $postEntity->getId(),
            $postEntity->getUsername(),
            $postEntity->getTitle(),
            $postEntity->getSummary(),
            $this->_dateTimeMapper->toDateTime($postEntity->getLastUpdateDate())
        );

    }//end transformToPostModel()


    /**
     * Summary of transformToPostModels
     *
     * @param array<PostEntity> $posts 
     *
     * @return array<PostModel>
     */
    public function transformToPostModels(array $postEntities): array
    {
        return array_map(
            function (PostEntity $postEntity)
            {
                return $this->transformToPostModel($postEntity);
            },
            $postEntities);

    }//end transformToPostModels()


}//end class
