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
        public ?int $id, 
        public string $name, 
        public string $firstName, 
        public string $email, 
        public string   $content,
        public DateTime $creationDate, 
    ) {

    }
}
