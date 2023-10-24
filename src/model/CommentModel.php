<?php
/**
 * CommentModel File Doc Comment
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
 * CommentModel Class Doc Comment
 *
 * @category Model
 * @package  App\model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class CommentModel
{


    /**
     * Summary of __construct
     *
     * @param int|null  $id             id of the comment
     * @param int       $idPost         id of the post
     * @param string    $author         user firstName and name
     * @param string    $content        content
     * @param \DateTime $lastUpdateDate last update date
     * @param bool      $isValidate     default 0
     */
    public function __construct(
        private ?int $id,
        private int $idPost,
        private string $author,
        private string $content,
        private DateTime $lastUpdateDate,
        private bool $isValidate
    ) {

    }//end __construct()


    /**
     * Summary of getId
     *
     * @return integer|null
     */
    public function getId(): ?int
    {

        return $this->id;

    }//end getId()


    /**
     * Summary of getIdPost
     *
     * @return int
     */
    public function getIdPost(): int
    {

        return $this->idPost;

    }//end getIdPost()


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
     * @return self
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
     * Summary of isCommentValidate
     *
     * @return bool
     */
    public function isCommentValidate(): bool
    {

        return $this->isValidate;

    }//end isCommentValidate()


}//end class
