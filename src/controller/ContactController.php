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
     * Summary of _instance
     *
     * @var ContactController
     */
    private static $instance;

    const URL = "contact";
    const ACTION = "contact";

    
    /**
     * Summary of __construct
     * Call an instance of TemplateInterface
     *
     * @param \App\service\TemplateInterface $template        TemplateInterface
     * @param \App\service\ContactService    $_contactService ContactService
     */
    private function __construct(
        private readonly TemplateInterface $_template,
        private readonly ContactService $_contactService
    )
    {

    }//end of __construct()
    

    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     *
     * @param \App\service\TemplateInterface $template template engine
     *
     * @return \App\controller\ContactController
     */
    public static function getInstance(TemplateInterface $template, ContactService $contactService): ContactController
    {

        if (self::$instance === null) {
            self::$instance = new ContactController($template, $contactService);
        }
    
        return self::$instance;

    }

    /**
     * Summary of displayContactPage
     *
     * @return void
     */
    public function displayContactPage(): void
    {

        $this->_template->display(RouteMapper::ContactView->getTemplate(), []);

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
    public function manageContact(array $post): void
    {

        if ($this->isValid($post) === false) {
            $template = RouteMapper::ContactView->getTemplate();
            $data = [
                MessageMapper::Error->getMessageLabel() => MessageMapper::GeneralError->getMessage()
            ];
        }

        if (isset($data[MessageMapper::Error->getMessageLabel()]) === false) {
            $currentDate = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
            $contact = new ContactModel($post["name"], $post["firstName"], $post["email"], $post["content"], $currentDate);
            $this->validContactForm($contact);
            $sendMail = false;
            $isContactCreated = $this->_contactService->createContact($contact);

            if ($isContactCreated === true) {
                $contact->setContent(htmlspecialchars_decode($contact->getContent()));
                $sendMail = $this->_contactService->notify($contact);
            }

            if ($sendMail === false) {
                $template = RouteMapper::ContactView->getTemplate();
                $data = [
                    MessageMapper::Error->getMessageLabel() => MessageMapper::GeneralError->getMessage()
                ];
            }

            if (isset($data[MessageMapper::Error->getMessageLabel()]) === false) {
                $template = RouteMapper::HomeView->getTemplate();
                $data = [
                    MessageMapper::Message->getMessageLabel() => MessageMapper::MailValid->getMessage()
                ];
            }
        }//end if

        $this->_template->display($template, $data);

    }

    /**
     * Summary of validContactForm
     *
     * @param \App\model\ContactModel $contact contact from the form
     *
     * @return \App\model\ContactModel
     */
    public function validContactForm(ContactModel $contact): void
    {

        $contact->setName($this->sanitize($contact->getName()));
        $contact->setFirstName($this->sanitize($contact->getFirstName()));
        $contact->setEmail($this->sanitize($contact->getEmail()));
        $contact->setContent($this->sanitize($contact->getContent()));

    }

}
