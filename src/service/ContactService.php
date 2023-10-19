<?php
/**
 * ContactService File Doc Comment
 *
 * PHP Version 8.1.10
 *
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\service;

use App\entity\ContactEntity;
use App\model\ContactModel;
use App\repository\ContactRepository;
use App\service\MailerService;

/**
 * ContactService Class Doc Comment
 *
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class ContactService
{

    /**
     * Summary of _instance
     *
     * @var ContactService
     */
    private static $instance;


     /**
      * Summary of getInstance
      * That method create the unique instance of the class, if it doesn't exist and return it
      *
      * @return \App\service\ContactService
      */
    public static function getInstance(): ContactService
    {

        if (self::$instance === null) {
            self::$instance = new ContactService();
        }
    
        return self::$instance;

    }//end getInstance()


    /**
     * Summary of createContact
     * Create a ContactEntity and insert it in the DB
     *
     * @param \App\model\ContactModel $contactModel ContactModel
     *
     * @return bool
     */
    public function createContact(ContactModel $contactModel): bool
    {

        $contactId = null;
        $newContact = new ContactEntity(
            $contactId, 
            $contactModel->getName(),
            $contactModel->getFirstName(),
            $contactModel->getEmail(),
            $contactModel->getContent(),
            $contactModel->getCreationDate()
        );

        $contactRepository = new ContactRepository;
        $id = $contactRepository->insertContact($newContact);

        if (isset($id) === true) {
            return true;
        }

        return false;

    }//end createContact()


    /**
     * Summary of notify
     *
     * @param \App\entity\ContactEntity $newContact call the MailerService to send the contact message by email
     *
     * @return bool
     */
    public function notify(ContactModel $newContact): bool
    {

        $content = $newContact->getContent();

        $contactName = $newContact->getFirstName()." ".$newContact->getName();
        $contactEmail = $newContact->getEmail();
        $subject = "contact depuis le blog";
        $message = " De:  ".$contactName." Email:  ".$newContact->getEmail()." Le ".$newContact->getCreationDate()->format('d-m-Y H:i:s')." Message:  ".$content;

        $mailerService = new MailerService;
        $mail = $mailerService->sendMail($contactEmail, $subject, $message);

        if ($mail === true) {
            return true;
        }

        return false;

    }//end notify()


}
