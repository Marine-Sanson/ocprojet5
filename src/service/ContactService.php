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
     * @param string $firstName firstName
     * @param string $name      name
     * @param string $email     email
     * @param string $content   content
     * 
     * @return array with the same data securized
     */
    public function checkContactForm(string $firstName, string $name, string $email, string $content) :array
    {

        // doit sécuriser le formulaire -> htmlspecialchars()?

        $contactData = [
            "firstName" => $firstName,
            "name" => $name, 
            "email" => $email, 
            "content" => $content
        ];

        return $contactData;
    }

}
