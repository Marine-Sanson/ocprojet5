<?php
/**
 * CommentMapper File Doc Comment
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

use App\entity\CommentEntity;
use App\entity\PostEntity;
use App\mapper\DateTimeMapper;
use App\model\CommentModel;
use App\model\PostDetailsModel;


/**
 * CommentMapper Class Doc Comment
 *
 * @category Mapper
 * @package  App\mapper
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class CommentMapper
{

    /**
     * Summary of _instance
     *
     * @var CommentMapper
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
     * @return \App\mapper\CommentMapper
     */
    public static function getInstance(): CommentMapper
    {

        if (self::$instance === null) {
            self::$instance = new CommentMapper(DateTimeMapper::getInstance());
        }

        return self::$instance;

    }//end getInstance()


    /**
     * Summary of getCommentModel
     *
     * @param CommentEntity $comment  comment
     * @param string        $username username
     *
     * @return \App\model\PostDetailsModel
     */
    public function getCommentModel(CommentEntity $comment, string $username): CommentModel
    {

        $lastUpdateDate = $this->_dateTimeMapper->toDateTime($comment->getLastUpdateDate());
        $commentDetails = new CommentModel(
            $comment->getId(),
            $comment->getPostId(),
            $username,
            $comment->getContent(),
            $lastUpdateDate,
            $comment->isCommentValidate()
        );

        return $commentDetails;

    }//end getCommentModel()


}//end class
