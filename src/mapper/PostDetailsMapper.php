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
use App\mapper\DateTimeMapper;
use App\model\PostDetailsModel;


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
     * Summary of instance
     *
     * @var PostDetailsMapper
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
     * @return \App\mapper\PostDetailsMapper
     */
    public static function getInstance(): PostDetailsMapper
    {

        if (self::$instance === null) {
            self::$instance = new PostDetailsMapper(DateTimeMapper::getInstance());
        }

        return self::$instance;

    }//end getInstance()


    /**
     * Summary of getPostDetailsModel
     *
     * @param PostEntity $post     post
     * @param string     $username username
     * @param array|null $comments comments
     *
     * @return \App\model\PostDetailsModel
     */
    public function getPostDetailsModel(PostEntity $post, string $username, ?array $comments): PostDetailsModel
    {

        $lastUpdateDate = $this->_dateTimeMapper->toDateTime($post->getLastUpdateDate());
        $postDetails = new PostDetailsModel(
            $post->getId(),
            $post->getIdUser(),
            $post->getTitle(),
            $post->getSummary(),
            $post->getContent(),
            $lastUpdateDate,
            $username,
            $comments
        );

        return $postDetails;

    }//end getPostDetailsModel()


}//end class
