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
        private readonly ?int $id,
        private readonly int $idUser,
        private readonly string $title,
        private readonly string $summary,
        private readonly string $content,
        private readonly DateTime $creationDate,
        private readonly DateTime $lastUpdateDate
    ) { }
    //end __construct()


    /**
     * Summary of getId
     *
     * @return int|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }

    /**
     * Summary of getIdUser
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
     * @return \DateTime
     */
    public function getCreationDate(): DateTime
    {

        return $this->creationDate;

    }

    /**
     * Summary of getLastUpdateDate
     *
     * @return \DateTime
     */
    public function getLastUpdateDate(): DateTime
    {

        return $this->lastUpdateDate;

    }
    
}
