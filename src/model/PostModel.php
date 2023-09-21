<?php
/**
 * PostModel File Doc Comment
 * 
 * PHP Version 8.1.10
 * 
 * @category Model
 * @package  App\model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\model;
use DateTime;

/**
 * PostModel Class Doc Comment
 * 
 * @category Model
 * @package  App\model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class PostModel
{
    /**
     * Summary of __construct
     * 
     * @param mixed     $id             id of the post
     * @param string    $author         user firstName and name
     * @param string    $title          title
     * @param string    $summary        summary
     * @param \DateTime $lastUpdateDate last update date
     */
    public function __construct(
        public ?int $id,
        public string $author,
        public string $title,
        public string $summary,
        public DateTime $lastUpdateDate
    ) {

    }
}
