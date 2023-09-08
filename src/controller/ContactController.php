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

    public function checkContactForm() :array
    {
        var_dump("<pre>");
        var_dump($_POST);
        var_dump("</pre>");
        
        $firstName = $_POST["firstName"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $message = $_POST["message"];
        $contactService = ContactService::getInstance();
        $result = $contactService->checkContactForm($firstName, $name, $email, $message);

        var_dump("<pre>");
        var_dump($result);
        var_dump("</pre>");

        return $result;
      //  if ($_POST["action"] === "contact") {

        //}
    }
    
}
