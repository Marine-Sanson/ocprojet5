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

use App\model\ContactModel;
use App\controller\AbstractController;
use App\service\ContactService;
use App\service\MessageService;
use App\service\RouteService;
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
class ContactController extends AbstractController
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

    /**
     * Summary of _contactService
     * 
     * @var ContactService
     */
    private ContactService $_contactService;

    const URL = "contact";
    const ACTION = "contact";

    /**
     * Summary of __construct call an instance of TemplateInterface
     * 
     * @param TemplateInterface $template template engine
     */
    private function __construct(TemplateInterface $template)
    {
        $this->template = $template;
        $this->_contactService = ContactService::getInstance();
    }

    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     * 
     * @param \App\service\TemplateInterface $template template engine
     * 
     * @return \App\controller\ContactController
     */
    public static function getInstance(TemplateInterface $template): ContactController
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new ContactController($template);  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of displayContactPage
     * 
     * @return void
     */
    public function displayContactPage(): void
    {
        echo $this->template->render(RouteService::ContactView->getLabel(), []);
    }

    /**
     * Summary of manageContact
     * 
     * @return void
     */
    public function manageContact(): void
    {
        if (!$this->isSubmitted(self::ACTION) || !$this->isValid($_POST)) {
            $template = RouteService::ContactView->getLabel();

            $data = [
                MessageService::ERROR => MessageService::GENERAL_ERROR
            ];
        }

        if (!isset($data[MessageService::ERROR])) {
            $currentDate = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
            $contact = new ContactModel(
                $_POST["name"], 
                $_POST["firstName"], 
                $_POST["email"], 
                $_POST["content"], 
                $currentDate
            );

            $validateContact = $this->validContactForm($contact);
            $contactCreated = $this->_contactService->createContact($validateContact);

            if ($contactCreated) {
                $validateContact->content = htmlspecialchars_decode($validateContact->content);

                // $validateContact = htmlspecialchars_decode($validateContact);
                $sendMail = $this->_contactService->notify($validateContact);
            }

            if (!$sendMail) {
                $template = RouteService::ContactView->getLabel();
                $data = [
                    MessageService::ERROR => MessageService::GENERAL_ERROR
                ];
            }

            if (!isset($data[MessageService::ERROR])) {
                $template = RouteService::HomeView->getLabel();
                $data = [
                    MessageService::MESSAGE => MessageService::MAIL_VALID
                ];
            }
        }

        echo $this->template->render($template, $data);
    }

    /**
     * Summary of validContactForm
     * 
     * @param \App\model\ContactModel $contact contact from the form
     * 
     * @return \App\model\ContactModel
     */
    public function validContactForm(ContactModel $contact): ContactModel
    {
        $contact->name = $this->sanitize($contact->name);
        $contact->firstName = $this->sanitize($contact->firstName);
        $contact->email = $this->sanitize($contact->email);
        $contact->content = $this->sanitize($contact->content);

        return $contact; 
    }

}
