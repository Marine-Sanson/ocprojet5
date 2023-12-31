<?php
/**
 * AbstractController File Doc Comment
 *
 * PHP Version 8.1.10
 *
 * @category Controller
 * @package  App\controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\controller;
use App\model\PostModel;

/**
 * AbstractController Class Doc Comment
 *
 * @category Controller
 * @package  App\controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class AbstractController
{


    /**
     * Summary of isValid
     *
     * @param array $post = $_POST
     *
     * @return bool
     */
    public function isValid(array $post): bool
    {

        if (isset($post) === false) {
            return false;
        }

        foreach ($post as $value) {
            if (empty($value) === true) {
                return false;
            }
        }

        return true;

    }//end isValid()


    /**
     * Summary of sanitize
     * Strip whitespace from the beginning and end of a string
     * Un-quotes a quoted string
     * Convert special characters to HTML entities
     *
     * @param string $data recived by the form
     *
     * @return string
     */
    public function sanitize(string $data): string
    {

        return htmlspecialchars(htmlentities(stripslashes(trim($data))));

    }//end sanitize()


    /**
     * Summary of toDisplay
     *
     * @param string $data data
     *
     * @return string
     */
    public function toDisplay(string $data): string
    {

        return html_entity_decode(htmlspecialchars_decode($data));

    }//end toDisplay()


    /**
     * Summary of sanitizeLastPosts
     *
     * @param array<PostModel> $lastPosts array of PostModel
     *
     * @return array<PostModel>
     */
    public function sanitizeLastPosts(array $lastPosts): array
    {

        return array_map(
            function (PostModel $postModel) {
                $postModel->setTitle($this->toDisplay($postModel->getTitle()));
                $postModel->setSummary($this->toDisplay($postModel->getSummary()));
                return $postModel;
            },
            $lastPosts
        );

    }//end sanitizeLastPosts()


}//end class
