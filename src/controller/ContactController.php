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
use App\mapper\DateTimeMapper;
use App\mapper\MessageMapper;
use App\mapper\RouteMapper;
use App\model\ContactModel;
use App\service\ContactService;
use App\service\TemplateInterface;

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
     * Summary of instance
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
     * @param \App\service\TemplateInterface $_template       TemplateInterface
     * @param \App\mapper\DateTimeMapper     $_dateTimeMapper DateTimeMapper
     * @param \App\service\ContactService    $_contactService ContactService
     */
    private function __construct(
        private readonly TemplateInterface $_template,
        private readonly DateTimeMapper $_dateTimeMapper,
        private readonly ContactService $_contactService
    ) {

    }//end __construct()


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

        if (self::$instance === null) {
            self::$instance = new ContactController($template, DateTimeMapper::getInstance(), ContactService::getInstance());
        }

        return self::$instance;

    }//end getInstance()


    /**
     * Summary of displayContactPage
     *
     * @return void
     */
    public function displayContactPage(): void
    {

        $this->_template->display(RouteMapper::ContactView->getTemplate(), []);

    }//end displayContactPage()


    /**
     * Summary of manageContact
     *
     * @param array $post with name, firstName, email and content
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
            $currentDate = $this->_dateTimeMapper->getCurrentDate();
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

    }//end manageContact()


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

    }//end validContactForm()


}//end class
