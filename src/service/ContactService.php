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
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// require 'path/to/PHPMailer/src/Exception.php';
// require 'path/to/PHPMailer/src/PHPMailer.php';
// require 'path/to/PHPMailer/src/SMTP.php';

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
     * Summary of template
     * 
     * @var TemplateInterface
     */
    public TemplateInterface $template;

    /**
     * Summary of _instance
     * 
     * @var ContactService
     */
    private static $_instance;

     /**
      * Summary of getInstance
      * That method create the unique instance of the class, if it doesn't exist and return it
      * 
      * @return \App\service\ContactService
      */
    public static function getInstance() :ContactService
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new ContactService();  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of checkContactForm
     * check the data received by the contact form
     * 
     * @param string $name      name
     * @param string $firstName firstName
     * @param string $email     email
     * @param string $content   content
     * 
     * @return array with the same data securized
     */
    public function checkContactForm(string $name, string $firstName, string $email, string $content) :array
    {
// a déplacer controller

        // doit sécuriser le formulaire -> htmlspecialchars()?
        // vérifie si champs sont pas vides -> isset

        $contactData = [
            "name" => $name, 
            "firstName" => $firstName,
            "email" => $email, 
            "content" => $content
        ];

        return $contactData; // return ContactModel
    }

    /**
     * Summary of sendMail
     * 
     * @param \App\entity\ContactEntity $newContact send the contact message by email
     * 
     * @return bool
     */
    public function sendMail(ContactEntity $newContact) :bool
    {
        $to = "marine_sanson@yahoo.fr";
        $subject = "contact depuis le blog";
        $message = "De : " . $newContact->firstName . " " . $newContact->name . " Email : " . $newContact->email . " Le " . $newContact->creationDate . " Message : " . $newContact->content;

        $mail = mail($to, $subject, $message);
        if ($mail) {
            return true;
        } else {
            return false;
        }
    }

}
