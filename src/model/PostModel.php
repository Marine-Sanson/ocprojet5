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
     * @param int | null $id             id of the post
     * @param string     $author         user firstName and name
     * @param string     $title          title
     * @param string     $summary        summary
     * @param \DateTime  $lastUpdateDate last update date
     */
    public function __construct(
        private readonly ?int $id,
        private readonly string $author,
        private string $title,
        private string $summary,
        private readonly DateTime $lastUpdateDate
    ) {

    }//end __construct()


    /**
     * Summary of getId
     *
     * @return int
     */
    public function getId(): int
    {

        return $this->id;

    }//end getId()


    /**
     * Summary of getAuthor
     *
     * @return string
     */
    public function getAuthor(): string
    {

        return $this->author;

    }//end getAuthor()


    /**
     * Summary of getTitle
     *
     * @return string
     */
    public function getTitle(): string
    {

        return $this->title;

    }//end getTitle()


    /**
     * Summary of setTitle
     *
     * @param string $title title
     *
     * @return \App\model\PostModel
     */
    public function setTitle(string $title): self
    {

        $this->title = $title;
        return $this;

    }//end setTitle()


    /**
     * Summary of getSummary
     *
     * @return string
     */
    public function getSummary(): string
    {

        return $this->summary;

    }//end getSummary()


    /**
     * Summary of setSummary
     *
     * @param string $summary summary
     *
     * @return \App\model\PostModel
     */
    public function setSummary(string $summary): self
    {

        $this->summary = $summary;
        return $this;

    }//end setSummary()


    /**
     * Summary of getLastUpdateDate
     *
     * @return DateTime
     */
    public function getLastUpdateDate(): DateTime
    {

        return $this->lastUpdateDate;

    }//end getLastUpdateDate()


}//end class
