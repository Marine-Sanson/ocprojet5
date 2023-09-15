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
    // same as PostEntity for now but that will change
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
