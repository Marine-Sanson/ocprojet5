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

    public function manageContact() :array
    {
        if ($_POST["action"] === "contact") {
            $firstName = $_POST["firstName"];
            $name = $_POST["name"];
            $email = $_POST["email"];
            $content = $_POST["content"];
            $contactService = ContactService::getInstance();
            $contactData = $contactService->checkContactForm($firstName, $name, $email, $content);

            $contactRepository = new ContactRepository;
            $currentDate = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));
            $contactRepository->insertContact($contactData["firstName"], $contactData["name"], $contactData["email"], $contactData["content"], $currentDate);
            $template = "home.html.twig";
            $data = [
                "message" => "votre message a bien été pris en compte"
            ];
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
        var_dump("<pre>");
        var_dump($result);
        var_dump("</pre>");

        return $result;
    }
}
