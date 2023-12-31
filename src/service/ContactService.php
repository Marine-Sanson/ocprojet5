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
use App\mapper\DateTimeMapper;
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
     * Summary of instance
     *
     * @var ContactService
     */
    private static $instance;


    /**
     * Summary of __construct
     *
     * @param \App\mapper\DateTimeMapper $_dateTimeMapper DateTimeMapper
     */
    private function __construct(private readonly DateTimeMapper $_dateTimeMapper)
    {

    }//end __construct()


     /**
      * Summary of getInstance
      * That method create the unique instance of the class, if it doesn't exist and return it
      *
      * @return \App\service\ContactService
      */
    public static function getInstance(): ContactService
    {

        if (self::$instance === null) {
            self::$instance = new ContactService(DateTimeMapper::getInstance());
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
            $this->_dateTimeMapper->toString($contactModel->getCreationDate())
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
     * @param \App\model\ContactModel $newContact call the MailerService to send the contact message by email
     *
     * @return bool
     */
    public function notify(ContactModel $newContact): bool
    {

        $message = sprintf(
            " De: %s %s Email: %s Le %s Message:  %s",
            $newContact->getFirstName(),
            $newContact->getName(),
            $newContact->getEmail(),
            $this->_dateTimeMapper->toString($newContact->getCreationDate()),
            $newContact->getContent()
        );

        $subject = "contact depuis le blog";

        $mailerService = new MailerService;
        return $mailerService->sendMail($_ENV['SMTP_USERNAME'], $subject, $message);

    }//end notify()


}//end class
