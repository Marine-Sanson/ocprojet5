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
use DateTimeInterface;

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

    public readonly ?int $id;
    private readonly int $idUser;
    private readonly string $title;
    private readonly string $summary;
    private readonly string $content;
    private readonly string $creationDate;
    private readonly string $lastUpdateDate;

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

    ) {

        // $this->creationDate = new DateTime($this->creationDate->format("Y-m-d H:i:s"));

    }//end __construct()


    /**
     * Summary of getId
     *
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }//end getId()


    /**
     * Summary of getIdUser
     *
     * @return int
     */
    public function getIdUser(): int
    {

        return $this->idUser;

    }//end getIdUser()


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
     * @return \DateTime
     */
    public function getCreationDate(): DateTimeInterface
    {

        return DateTime::createFromFormat("Y-m-d H:i:s", date($this->creationDate));


    }//end getCreationDate()


    /**
     * Summary of getLastUpdateDate
     *
     * @return \DateTime
     */
    public function getLastUpdateDate(): DateTime
    {

        return DateTime::createFromFormat("Y-m-d H:i:s", date($this->lastUpdateDate));

    }//end getLastUpdateDate()


}//end class
