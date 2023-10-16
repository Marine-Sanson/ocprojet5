<?php
/**
 * ContactRepository File Doc Comment
 * 
 * PHP Version 8.1.10
 * 
 * @category Repository
 * @package  App\repository
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\repository;

use App\entity\ContactEntity;
use App\service\DatabaseService;

/**
 * ContactRepository Class Doc Comment
 * 
 * @category Repository
 * @package  App\repository
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class ContactRepository
{
    /**
     * Summary of _db
     * 
     * @var DatabaseService $_db connection between PHP and a database server
     */
    private DatabaseService $_db;

    /**
     * Summary of insertContact
     * prepare and execute the request to save the contact data in the db
     * 
     * @param ContactEntity $newContact ContactEntity
     * 
     * @return int
     */
    public function insertContact(ContactEntity $newContact): int
    {
        $firstName = $newContact->getFirstName();
        $name = $newContact->getName();
        $email = $newContact->getEmail();
        $content = $newContact->getContent();
        $creationDate = $newContact->getCreationDate();

        $this->_db = DatabaseService::getInstance();
        $request = 'INSERT INTO contacts (first_name, name, email, content, creation_date) 
                    VALUES (:first_name, :name, :email, :content, :creationDate)';
        $parameters = [
            'first_name' => $firstName,
            'name' => $name,
            'email' => $email,
            'content' => $content,
            'creationDate' => $creationDate->format('Y-m-d H:i:s')
        ];
        $this->_db->execute($request, $parameters);
        $newReq = 'SELECT LAST_INSERT_ID()';
        $lastInsertId = $this->_db->execute($newReq, null);
        return $lastInsertId[0]["LAST_INSERT_ID()"];
    }
}
