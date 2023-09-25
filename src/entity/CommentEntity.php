<?php
/**
 * CommentEntity File Doc Comment
 * 
 * PHP Version 8.1.10
 * 
 * @category Entity
 * @package  App\entity
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\entity;
use DateTime;

/**
 * CommentEntity Class Doc Comment
 * 
 * @category Entity
 * @package  App\entity
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class CommentEntity
{

    /**
     * Summary of __construct
     * @param mixed     $id             id of the comment
     * @param int       $id_post        id of the post
     * @param string    $id_user        id of the user
     * @param string    $content        content
     * @param \DateTime $creationDate   creation date
     * @param \DateTime $lastUpdateDate last update date
     * @param bool      $is_validate    default 0
     */
    public function __construct(
        public ?int $id,
        public int $id_post,
        public string $id_user,
        public string $content,
        public DateTime $creationDate,
        public DateTime $lastUpdateDate,
        public bool $is_validate
    ) {

    }
}
