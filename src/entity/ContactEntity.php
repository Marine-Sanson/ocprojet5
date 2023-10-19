<?php
/**
 * ContactEntity File Doc Comment
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
 * ContactEntity Class Doc Comment
 *
 * @category Entity
 * @package  App\entity
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class ContactEntity
{

    /**
     * Summary of __construct ContactEntity
     *
     * @param int|null $id           id - autoincrement in the DB
     * @param string   $name         name of the contact
     * @param string   $firstName    first name of the contact
     * @param string   $email        email of the contact
     * @param string   $content      message send by the contact
     * @param DateTime $creationDate creation date in the db
     */
    public function __construct(
        private readonly ?int $id,
        private readonly string $name,
        private readonly string $firstName,
        private readonly string $email,
        private readonly string $content,
        private readonly DateTime $creationDate
    ) {

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
     * Summary of getName
     *
     * @return string
     */
    public function getName(): string
    {

        return $this->name;

    }//end getName()


    /**
     * Summary of getFirstName
     *
     * @return string
     */
    public function getFirstName(): string
    {

        return $this->firstName;

    }//end getFirstName()


    /**
     * Summary of getEmail
     *
     * @return string
     */
    public function getEmail(): string
    {

        return $this->email;

    }//end getEmail()


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
    public function getCreationDate(): DateTime
    {

        return $this->creationDate;

    }//end getCreationDate()


}
