<?php
/**
 * PostDetailsMapper File Doc Comment
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
use App\model\PostDetailsModel;
use App\model\PostModel;
use DateTime;

/**
 * PostDetailsMapper Class Doc Comment
 *
 * @category Mapper
 * @package  App\mapper
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class PostDetailsMapper
{

    /**
     * Summary of _instance
     *
     * @var PostDetailsMapper
     */
    private static $instance;


    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     *
     * @return \App\mapper\PostDetailsMapper
     */
    public static function getInstance(): PostDetailsMapper
    {

        if (self::$instance === null) {
            self::$instance = new PostDetailsMapper();
        }

        return self::$instance;

    }//end getInstance()


    /**
     * Summary of getPostDetailsModel
     *
     * @param array        $post     post
     * @param array | null $comments comments
     *
     * @return \App\model\PostDetailsModel
     */
    public function getPostDetailsModel(PostEntity $post, string $username, ?array $comments): PostDetailsModel
    {

        $postDetails = new PostDetailsModel(
            $post->getId(),
            $post->getIdUser(),
            $post->getTitle(),
            $post->getSummary(),
            $post->getContent(),
            $post->getLastUpdateDate(),
            $username,
            $comments
        );

        return $postDetails;

    }//end getPostDetailsModel()


}//end class
