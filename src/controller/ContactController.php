<?php
/**
 * ContactController File Doc Comment
 * 
 * PHP Version 8.1.10
 * 
 * @category Controller
 * @package  App\controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\controller;

use App\entity\ContactEntity;
use App\repository\ContactRepository;
use App\service\ContactService;
use App\service\TemplateInterface;
use DateTime;

/**
 * ContactController Class Doc Comment
 * 
 * @category Controller
 * @package  App\controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class ContactController
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
     * @var ContactController
     */
    private static $_instance;

    const URL = "contact";

    /**
     * Summary of __construct call an instance of TemplateInterface
     * 
     * @param TemplateInterface $template template engine
     */
    public function __construct(TemplateInterface $template)
    {
        $this->template = $template;
    }

    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     * 
     * @param \App\service\TemplateInterface $template template engine
     * 
     * @return \App\controller\ContactController
     */
    public static function getInstance(TemplateInterface $template) :ContactController
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new ContactController($template);  
        }
    
        return self::$_instance;
    }

    // private function isSubmitted() : bool
    // {
    //     return $_POST["action"] === "contact";
    // }

    // private function isValid() : bool
    // {

    // }

    /**
     * Summary of manageContact
     * 
     * @return array with template and data
     */
    public function manageContact() :array
    {
        if ($_POST["action"] === "contact") {
            $name = $_POST["name"];
            $firstName = $_POST["firstName"];
            $email = $_POST["email"];
            $content = $_POST["content"];

            $contactService = ContactService::getInstance();
// $contactService->createContact() va appeller le repo créer le model enregistrement db
// $contactService->notify (privée) envoie le mail -- appelle $mailerService -> sendEmail
            $contactData = $contactService->checkContactForm($name, $firstName, $email, $content);  // remettre dans le controller

            $contactRepository = new ContactRepository;
            $currentDate = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
            $contactId = null;

            $newContact = new ContactEntity($contactId, $contactData["name"], $contactData["firstName"], $contactData["email"], $contactData["content"], $currentDate);
            $sendMail = $contactService->sendMail($newContact); // passer par service puis par MailerService
            if ($sendMail) {
                $contactRepository->insertContact($newContact); // appelle une fonction du service qui le fait // génere le message réussi ou non
    
                $template = "home.html.twig";
                $data = [
                    "message" => "votre message a bien été envoyé"
                ];
            } else {
                $template = "contact.html.twig";
                $data = [
                    "error" => "il y a eu un problème, merci de bien vouloir recommencer"
                ];
            }
        } else {
            $template = "contact.html.twig";
            $data = [
                "error" => "il y a eu un problème, merci de bien vouloir recommencer"
            ];
        }
        $result = [
            "template" => $template,
            "data" => $data
        ];

        return $result;
    }
}
