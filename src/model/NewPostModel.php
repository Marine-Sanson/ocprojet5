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
     * @param int       $userId       userId
     * @param string    $title        title
     * @param string    $summary      summary
     * @param string    $content      content
     * @param \DateTime $creationDate lastUpdateDate
     */
    public function __construct(
        private readonly int $userId,
        private readonly string $title,
        private readonly string $summary,
        private readonly string $content,
        private readonly DateTime $creationDate
    ) {

    }//end __construct()


    /**
     * Summary of getUserId
     *
     * @return int
     */
    public function getUserId(): int
    {

        return $this->userId;

    }//end getUserId()


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
     * Summary of getSummary
     *
     * @return string
     */
    public function getSummary(): string
    {

        return $this->summary;

    }//end getSummary()


    /**
     * Summary of getContent
     *
     * @return string
     */
    public function getContent(): string
    {

        return $this->content;

    }//end getContent()


    /**
     * Summary of getCreationDate
     *
     * @return DateTime
     */
    public function getCreationDate(): DateTime
    {

        return $this->creationDate;

    }//end getCreationDate()


}//end class
