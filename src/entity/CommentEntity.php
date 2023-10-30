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
     * Summary of id
     *
     * @var integer|null
     */
    private readonly ?int $id;

    /**
     * Summary of postId
     *
     * @var integer
     */
    private readonly int $postId;

    /**
     * Summary of userId
     *
     * @var integer
     */
    private readonly int $userId;

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
     * Summary of isValidate
     *
     * @var boolean
     */
    private readonly bool $isValidate;


    /**
     * Summary of __construct
     */
    public function __construct()
    {

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
     * Summary of setId
     *
     * @param $id Summary of id
     *
     * @return self
     */
    public function setId(?int $id): self
    {

        $this->id = $id;
        return $this;

    }//end setId()


    /**
     * Summary of getPostId
     *
     * @return int
     */
    public function getPostId(): int
    {

        return $this->postId;

    }//end getPostId()


    /**
     * Summary of setPostId
     *
     * @param int $postId Summary of postId
     *
     * @return self
     */
    public function setPostId(int $postId): self
    {

        $this->postId = $postId;
        return $this;

    }//end setPostId()


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
     * Summary of setUserId
     *
     * @param int $userId Summary of userId
     *
     * @return self
     */
    public function setUserId(int $userId): self
    {

        $this->userId = $userId;
        return $this;

    }//end setUserId()


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
     * @param string $content Summary of content
     *
     * @return self
     */
    public function setContent(string $content): self
    {

        $this->content = $content;
        return $this;

    }//end setContent()


    /**
     * Summary of getCreationDate
     *
     * @return string
     */
    public function getCreationDate(): string
    {

        return $this->creationDate;

    }//end getCreationDate()


    /**
     * Summary of setCreationDate
     *
     * @param string $creationDate Summary of creationDate
     *
     * @return self
     */
    public function setCreationDate(string $creationDate): self
    {

        $this->creationDate = $creationDate;
        return $this;

    }//end setCreationDate()


    /**
     * Summary of isCommentValidate
     *
     * @return bool
     */
    public function isCommentValidate(): bool
    {

        return $this->isValidate;

    }//end isCommentValidate()


    /**
     * Summary of setIsValidate
     *
     * @param bool $isValidate Summary of isValidate
     *
     * @return self
     */
    public function setIsValidate(bool $isValidate): self
    {

        $this->isValidate = $isValidate;
        return $this;

    }//end setIsValidate()


}//end class
