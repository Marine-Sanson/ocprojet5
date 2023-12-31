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
        private string $title,
        private string $summary,
        private string $content,
        private readonly DateTime $lastUpdateDate,
        private readonly string $username,
        private ?array $comments
    ) {

    }//end __construct()


    /**
     * Summary of getId
     *
     * @return int | null
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
     * Summary of setTitle
     *
     * @param string $title title
     *
     * @return \App\model\PostDetailsModel
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
     * @return \App\model\PostDetailsModel
     */
    public function setSummary(string $summary): self
    {

        $this->summary = $summary;
        return $this;

    }//end setSummary()


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
     * Summary of setContent
     *
     * @param string $content content
     *
     * @return \App\model\PostDetailsModel
     */
    public function setContent(string $content): self
    {

        $this->content = $content;
        return $this;

    }//end setContent()


    /**
     * Summary of getLastUpdateDate
     *
     * @return DateTime
     */
    public function getLastUpdateDate(): DateTime
    {

        return $this->lastUpdateDate;

    }//end getLastUpdateDate()


    /**
     * Summary of getUsername
     *
     * @return string
     */
    public function getUsername(): string
    {

        return $this->username;

    }//end getUsername()


    /**
     * Summary of getComments
     *
     * @return array
     */
    public function getComments(): ?array
    {

        return $this->comments;

    }//end getComments()


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

    }//end setComments()


}//end class
