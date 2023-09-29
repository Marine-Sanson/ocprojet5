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

use App\model\PostDetailsModel;
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
    private static $_instance;

    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     * 
     * @return \App\mapper\PostDetailsMapper
     */
    public static function getInstance(): PostDetailsMapper
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new PostDetailsMapper();  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of getPostDetailsModel
     * 
     * @param array        $post     post
     * @param array | null $comments comments
     * 
     * @return \App\model\PostDetailsModel
     */
    public function getPostDetailsModel(array $post, ?array $comments): PostDetailsModel
    {
        $date = $post["last_update_date"];
        $date = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));

        $postDetails = new PostDetailsModel(
            $post["id"],
            $post["id_user"], 
            $post["title"], 
            $post["summary"], 
            $post["content"], 
            $date, 
            $post["username"], 
            $comments
        );

        return $postDetails;
    }
}
