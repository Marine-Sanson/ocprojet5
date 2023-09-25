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
use App\model\PostModel;
use DateTime;

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
     * Summary of transformToListOfPostModel
     * 
     * @param array $posts posts datas
     * 
     * @return array
     */
    public function transformToListOfPostModel(array $posts) :array
    {
        $listOfPosts = [];
        foreach ($posts as $key => $post) {
            $date = $post["last_update_date"];
            $date = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
            $post = new PostModel($post["id"], $post["username"], $post["title"], $post["summary"], $date);
            $listOfPosts[] = $post;
        }
        return $listOfPosts;
    }

}
