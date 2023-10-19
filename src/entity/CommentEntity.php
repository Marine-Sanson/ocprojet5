<?php
/**
 * CommentEntity File Doc Comment
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
 * CommentEntity Class Doc Comment
 *
 * @category Entity
 * @package  App\entity
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class CommentEntity
{
    /**
     * Summary of __construct
     *
     * @param mixed     $id             id of the comment
     * @param int       $postId         id of the post
     * @param int       $userId         id of the user
     * @param string    $content        content
     * @param \DateTime $creationDate   creation date
     * @param \DateTime $lastUpdateDate last update date
     * @param bool      $isValidate     default 0
     */
    public function __construct(
        private readonly ?int $id,
        private readonly int $postId,
        private readonly int $userId,
        private readonly string $content,
        private readonly DateTime $creationDate,
        private readonly DateTime $lastUpdateDate,
        private readonly bool $isValidate
        )
        {

        }//end of __construct()
    

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
     * Summary of getPostId
     *
     * @return int
     */
    public function getPostId(): int
    {

        return $this->postId;

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


    /**
     * Summary of isCommentValidate
     *
     * @return bool
     */
    public function isCommentValidate(): bool
    {

        return $this->isValidate;

    }


}
