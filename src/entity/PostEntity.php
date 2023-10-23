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

    /**
     * Summary of id
     *
     * @var integer|null
     */
    public readonly ?int $id;

    /**
     * Summary of idUser
     *
     * @var integer
     */
    private readonly int $idUser;

    /**
     * Summary of title
     *
     * @var string
     */
    private readonly string $title;

    /**
     * Summary of summary
     *
     * @var string
     */
    private readonly string $summary;

    /**
     * Summary of content
     *
     * @var string
     */
    private readonly string $content;

    /**
     * Summary of creationDate
     *
     * @var string
     */
    private readonly string $creationDate;

    /**
     * Summary of lastUpdateDate
     *
     * @var string
     */
    private readonly string $lastUpdateDate;


    /**
     * Summary of __construct
     */
    public function __construct()
    {

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
     * @return DateTime
     */
    public function getCreationDate(): DateTime
    {

        return DateTime::createFromFormat("Y-m-d H:i:s", date($this->creationDate));

    }//end getCreationDate()


    /**
     * Summary of getLastUpdateDate
     *
     * @return DateTime
     */
    public function getLastUpdateDate(): DateTime
    {

        return DateTime::createFromFormat("Y-m-d H:i:s", date($this->lastUpdateDate));

    }//end getLastUpdateDate()


}//end class
