<?php
/**
 * PostEntity File Doc Comment
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
 * PostEntity Class Doc Comment
 * 
 * @category Entity
 * @package  App\entity
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class PostEntity
{

    /**
     * Summary of __construct
     * 
     * @param int | null $id             id of the post  - autoincrement in the DB
     * @param int        $idUser         id of the post author
     * @param string     $title          title of the post
     * @param string     $summary        summary of the post
     * @param string     $content        content of the post
     * @param \DateTime  $creationDate   creation date in the db
     * @param \DateTime  $lastUpdateDate last update date dat in the db
     */
    public function __construct(
        public ?int $id,
        public int $idUser,
        public string $title,
        public string $summary,
        public string $content,
        public DateTime $creationDate,
        public DateTime $lastUpdateDate
    ) {

    }
}
