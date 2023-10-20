<?php
/**
 * ContactModel File Doc Comment
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
 * ContactModel Class Doc Comment
 *
 * @category Model
 * @package  App\model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class ContactModel
{


    /**
     * Summary of __construct ContactModel
     *
     * @param string   $name         name of the sender
     * @param string   $firstName    first name of the sender
     * @param string   $email        email of the sender
     * @param string   $content      message from the sender
     * @param DateTime $creationDate date of the message
     */
    public function __construct(
        private string $name,
        private string $firstName,
        private string $email,
        private string $content,
        private DateTime $creationDate
    ) {

    }//end __construct()


    /**
     * Summary of getName
     *
     * @return string
     */
    public function getName(): string
    {

        return $this->name;

    }


    /**
     * Summary of setName
     *
     * @param string $name name
     *
     * @return \App\model\ContactModel
     */
    public function setName(string $name): self
    {

        $this->name = $name;
        return $this;

    }


    /**
     * Summary of getFirstName
     *
     * @return string
     */
    public function getFirstName(): string
    {

        return $this->firstName;

    }


    /**
     * Summary of setFirstName
     *
     * @param string $firstName firstName
     *
     * @return \App\model\ContactModel
     */
    public function setFirstName(string $firstName): self
    {

        $this->firstName = $firstName;
        return $this;

    }


    /**
     * Summary of getEmail
     *
     * @return string
     */
    public function getEmail(): string
    {

        return $this->email;

    }


    /**
     * Summary of setEmail
     *
     * @param string $email email
     *
     * @return \App\model\ContactModel
     */
    public function setEmail(string $email): self
    {

        $this->email = $email;
        return $this;

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
     * Summary of setContent
     *
     * @param string $content content
     *
     * @return \App\model\ContactModel
     */
    public function setContent(string $content): self
    {

        $this->content = $content;
        return $this;

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
     * Summary of setCreationDate
     *
     * @param \DateTime $creationDate DateTime
     *
     * @return \App\model\ContactModel
     */
    public function setCreationDate(DateTime $creationDate): self
    {

        $this->creationDate = $creationDate;
        return $this;

    }


}//end class
