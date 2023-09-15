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
        public string $name,
        public string $firstName, 
        public string $email, 
        public string $content,
        public DateTime $creationDate
    ) {

    }
}
