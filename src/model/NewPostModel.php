<?php
/**
 * NewPostModel File Doc Comment
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
 * NewPostModel Class Doc Comment
 *
 * @category Model
 * @package  App\model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class NewPostModel
{
    /**
     * Summary of __construct
     *
     * @param int       $idUser       idUser
     * @param string    $title        title
     * @param string    $summary      summary
     * @param string    $content      content
     * @param \DateTime $creationDate lastUpdateDate
     */
    public function __construct(
        private readonly int      $idUser,
        private readonly string   $title,
        private readonly string   $summary,
        private readonly string   $content,
        private readonly DateTime $creationDate
        )
        {

        }//end of __construct()


    /**
     * Summary of getFirstName
     *
     * @return int
     */
    public function getIdUser(): int
    {

        return $this->idUser;

    }

    /**
     * Summary of getTitle
     *
     * @return string
     */
    public function getTitle(): string
    {

        return $this->title;

    }

    /**
     * Summary of getSummary
     *
     * @return string
     */
    public function getSummary(): string
    {

        return $this->summary;

    }

    /**
     * Summary of getContent
     *
     * @return string
     */
    public function getContent(): string
    {

        return $this->content;

    }

    /**
     * Summary of getCreationDate
     *
     * @return DateTime
     */
    public function getCreationDate(): DateTime
    {

        return $this->creationDate;

    }

}
