<?php
/**
 * PostDetailsModel File Doc Comment
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
 * PostDetailsModel Class Doc Comment
 * 
 * @category Model
 * @package  App\model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class PostDetailsModel
{

    /**
     * Summary of __construct
     * 
     * @param int | null  $id             id
     * @param int         $idUser         idUser
     * @param string      $title          title
     * @param string      $summary        summary
     * @param string      $content        content
     * @param \DateTime   $lastUpdateDate lastUpdateDate
     * @param string      $username       username
     * @param array |null $comments       comments
     */
    public function __construct(
        private readonly ?int $id,
        private readonly int $idUser,
        private readonly string $title,
        private readonly string $summary,
        private readonly string $content,
        private readonly DateTime $lastUpdateDate,
        private readonly string $username,
        private ?array $comments
    ) {

    }

    /**
     * Summary of getId
     * 
     * @return int | null
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
     * Summary of getLastUpdateDate
     * 
     * @return DateTime
     */
    public function getLastUpdateDate(): DateTime
    {
        return $this->lastUpdateDate;
    }

    /**
     * Summary of getUsername
     * 
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Summary of getComments
     * 
     * @return array
     */
    public function getComments(): ?array
    {
        return $this->comments;
    }

    /**
     * Summary of setComments
     * 
     * @param array | null $comments comments
     * 
     * @return self
     */
    public function setComments(?array $comments): self
    {
        $this->comments = $comments;
        return $this;
    }
}
