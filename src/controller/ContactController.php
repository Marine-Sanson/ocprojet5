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
use App\model\ContactModel;
use App\repository\ContactRepository;
use App\service\ContactService;
use App\service\GlobalService;
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
     * Summary of global
     * 
     * @var GlobalService
     */
    public GlobalService $globalService;

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
        $this->globalService = GlobalService::getInstance();
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

    /**
     * Summary of manageContact
     * 
     * @return array with template and data
     */
    public function manageContact() :array
    {
        $action = "contact";
        $isSubmitted = $this->globalService->isSubmitted($action);
        $isValid = $this->globalService->isValid($_POST);

        if ($isSubmitted && $isValid) {

            $currentDate = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
            $contact = new ContactModel($_POST["name"], $_POST["firstName"], $_POST["email"], $_POST["content"], $currentDate);

            $validateContact = $this->validContactForm($contact);

            $contactService = ContactService::getInstance();
            $contactCreated = $contactService->createContact($validateContact);

            if ($contactCreated) {
                $sendMail = $contactService->notify($validateContact); // passer par service puis par MailerService
            }

            if ($sendMail) {    
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

    /**
     * Summary of validContactForm
     * 
     * @param \App\model\ContactModel $contact contact from the form
     * 
     * @return \App\model\ContactModel
     */
    public function validContactForm(ContactModel $contact) :ContactModel
    {
        $contact->name = $this->globalService->cleanInput($contact->name);
        $contact->firstName = $this->globalService->cleanInput($contact->firstName);
        $contact->email = $this->globalService->cleanInput($contact->email);
        $contact->content = $this->globalService->cleanInput($contact->content);

        return $contact; 
    }

}
