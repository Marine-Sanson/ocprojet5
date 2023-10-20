<?php
/**
 * UpdatePostModel File Doc Comment
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
 * UpdatePostModel Class Doc Comment
 *
 * @category Model
 * @package  App\model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class UpdatePostModel
{


    /**
     * Summary of __construct
     *
     * @param int       $id             postId
     * @param int       $userId         userId
     * @param string    $title          title
     * @param string    $summary        summary
     * @param string    $content        content
     * @param \DateTime $lastUpdateDate lastUpdateDate
     */
    public function __construct(
        private readonly int $id,
        private readonly int $userId,
        private readonly string $title,
        private string $summary,
        private string $content,
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

    }


    /**
     * Summary of getUserId
     *
     * @return int
     */
    public function getUserId(): int
    {

        return $this->userId;

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
     * Summary of setSummary
     *
     * @param string $summary summary
     *
     * @return \App\model\UpdatePostModel
     */
    public function setSummary(string $summary): self
    {

        $this->summary = $summary;
        return $this;

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
     * Summary of setContent
     *
     * @param string $content content
     *
     * @return \App\model\UpdatePostModel
     */
    public function setContent(string $content): self
    {

        $this->content = $content;
        return $this;

    }


    /**
     * Summary of getCreationDate
     *
     * @return DateTime
     */
    public function getLastUpdateDate(): DateTime
    {

        return $this->lastUpdateDate;

    }


}//end class
