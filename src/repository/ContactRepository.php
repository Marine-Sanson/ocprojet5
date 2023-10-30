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
     * @var DatabaseService $db connection between PHP and a database server
     */
    private readonly DatabaseService $db;


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

        $this->db = DatabaseService::getInstance();
        $request = 'INSERT INTO contacts (first_name, name, email, content, creation_date) 
                    VALUES (:first_name, :name, :email, :content, :creationDate)';
        $parameters = [
            'first_name'   => $newContact->getFirstName(),
            'name'         => $newContact->getName(),
            'email'        => $newContact->getEmail(),
            'content'      => $newContact->getContent(),
            'creationDate' => $newContact->getCreationDate()
        ];
        $this->db->execute($request, $parameters);
        $newReq = 'SELECT LAST_INSERT_ID()';
        $lastInsertId = $this->db->execute($newReq, null);
        return $lastInsertId[0]["LAST_INSERT_ID()"];

    }//end insertContact()


}//end class
