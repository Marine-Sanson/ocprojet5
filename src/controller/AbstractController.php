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
            if (empty($value)) {
                return false;
            }
        }
        return true;

    }

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

    }

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

    }

}
