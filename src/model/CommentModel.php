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
     * @param int|null    $id             id of the comment
     * @param int         $idPost         id of the post
     * @param int         $idUser         id of the author
     * @param string|null $author         username
     * @param string|null $postTitle      post title
     * @param string      $content        content
     * @param \DateTime   $lastUpdateDate last update date
     * @param bool        $isValidate     default 0
     */
    public function __construct(
        private ?int $id,
        private int $idPost,
        private int $idUser,
        private ?string $author,
        private ?string $postTitle,
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
     * Summary of setId
     *
     * @param integer $id Id
     *
     * @return self
     */
    public function setId(int $id): self
    {

        $this->id = $id;
        return $this;

    }//end setId()


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
     * Summary of setIdPost
     *
     * @param integer $idPost IdPost
     *
     * @return self
     */
    public function setIdPost(int $idPost): self
    {

        $this->idPost = $idPost;
        return $this;

    }//end setIdPost()


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
     * Summary of setIdUser
     *
     * @param integer $idUser IdUser
     *
     * @return self
     */
    public function setIdUser(int $idUser): self
    {

        $this->idUser = $idUser;
        return $this;

    }//end setIdUser()


    /**
     * Summary of getAuthor
     *
     * @return string|null
     */
    public function getAuthor(): ?string
    {

        return $this->author;

    }//end getAuthor()


    /**
     * Summary of setAuthor
     *
     * @param string $author author
     *
     * @return self
     */
    public function setAuthor(string $author): self
    {

        $this->author = $author;
        return $this;

    }//end setAuthor()


    /**
     * Summary of getPostTitle
     *
     * @return string|null
     */
    public function getPostTitle(): ?string
    {

        return $this->postTitle;

    }//end getPostTitle()


    /**
     * Summary of setPostTitle
     *
     * @param string $postTitle postTitle
     *
     * @return self
     */
    public function setPostTitle(string $postTitle): self
    {

        $this->postTitle = $postTitle;
        return $this;

    }//end setPostTitle()


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
     * Summary of setLastUpdateDate
     *
     * @param string $lastUpdateDate lastUpdateDate
     *
     * @return self
     */
    public function setLastUpdateDate(string $lastUpdateDate): self
    {

        $this->lastUpdateDate = $lastUpdateDate;
        return $this;

    }//end setLastUpdateDate()


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
     * @param integer $isValidate IsValidate
     *
     * @return self
     */
    public function setIsValidate(int $isValidate): self
    {

        $this->isValidate = $isValidate;
        return $this;

    }//end setIsValidate()



}//end class
