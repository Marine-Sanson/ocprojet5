<?php
/**
 * CommentModel File Doc Comment
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
 * CommentModel Class Doc Comment
 *
 * @category Model
 * @package  App\model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class CommentModel
{

    /**
     * Summary of __construct
     * 
     * @param int | null $id             id of the comment
     * @param int        $id_post        id of the post
     * @param string     $author         user firstName and name
     * @param string     $content        content
     * @param \DateTime  $lastUpdateDate last update date
     * @param bool       $is_validate    default 0
     */
    public function __construct(
        public ?int $id,
        public int $id_post,
        public string $author,
        public string $content,
        public DateTime $lastUpdateDate,
        public bool $is_validate
    ) {

    }//end __construct()


}
