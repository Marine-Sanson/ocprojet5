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

use App\controller\AbstractController;
use App\mapper\MessageMapper;
use App\mapper\RouteMapper;
use App\model\ContactModel;
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

    const URL = "contact";
    const ACTION = "contact";

    /**
     * Summary of __construct
     * Call an instance of TemplateInterface
     * 
     * @param \App\service\TemplateInterface $template        TemplateInterface
     * @param \App\service\ContactService    $_contactService ContactService
     */
    private function __construct(TemplateInterface $template, private ContactService $_contactService)
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
    public static function getInstance(TemplateInterface $template): ContactController
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new ContactController($template, ContactService::getInstance());  
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
        echo $this->template->render(RouteMapper::ContactView->getTemplate(), []);
    }

    /**
     * Summary of manageContact
     * 
     * @param string $name      name
     * @param string $firstName firstName
     * @param string $email     email
     * @param string $content   content
     * 
     * @return void
     */
    public function manageContact(string $name, string $firstName, string $email, string $content): void
    {
        if (!$this->isSubmitted(self::ACTION) || !$this->isValid($_POST)) {
            $template = RouteMapper::ContactView->getTemplate();
            $data = [
                MessageMapper::Error->getMessageLabel() => MessageMapper::GeneralError->getMessage()
            ];
        }

        if (!isset($data[MessageMapper::Error->getMessageLabel()])) {
            $currentDate = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
            $contact = new ContactModel($name, $firstName, $email, $content, $currentDate);
            $validateContact = $this->validContactForm($contact);
            $contactCreated = $this->_contactService->createContact($validateContact);

            if ($contactCreated) {
                $validateContact->setContent(htmlspecialchars_decode($validateContact->getContent()));
                $sendMail = $this->_contactService->notify($validateContact);
            }

            if (!$sendMail) {
                $template = RouteMapper::ContactView->getTemplate();
                $data = [
                    MessageMapper::Error->getMessageLabel() => MessageMapper::GeneralError->getMessage()
                ];
            }

            if (!isset($data[MessageMapper::Error->getMessageLabel()])) {
                $template = RouteMapper::HomeView->getTemplate();
                $data = [
                    MessageMapper::Message->getMessageLabel() => MessageMapper::MailValid->getMessage()
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
        $contact->setName($this->sanitize($contact->getName()));
        $contact->setFirstName($this->sanitize($contact->getFirstName()));
        $contact->setEmail($this->sanitize($contact->getEmail()));
        $contact->setContent($this->sanitize($contact->getContent()));

        return $contact; 
    }
}
