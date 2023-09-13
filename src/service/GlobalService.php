<?php
/**
 * GlobalService File Doc Comment
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
 * GlobalService Class Doc Comment
 * 
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class GlobalService
{

     /**
      * Summary of _instance
      * 
      * @var GlobalService
      */
    private static $_instance;

    /**
     * Summary of __construct get a connection between PHP and a database server
     */
    private function __construct()
    {

    }

    /**
     * Summary of getInstance
     * 
     * @return GlobalService
     */
    public static function getInstance() :GlobalService
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new GlobalService();  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of isSubmitted
     * 
     * @param string $action name of the action
     * 
     * @return bool
     */
    public function isSubmitted(string $action) : bool
    {
        return $_POST["action"] === $action;
    }

    /**
     * Summary of isValid
     * 
     * @param array $post = $_POST
     * 
     * @return bool
     */
    public function isValid(array $post) : bool
    {
        $test = true;

        if ($post) {
            foreach ($post as $value) {
                if (empty($value)) {
                    $test = false;

                    return $test;
                }
            }
        }

        return $test;        
    }

    /**
     * Summary of cleanInput
     * Strip whitespace from the beginning and end of a string
     * Un-quotes a quoted string
     * Convert special characters to HTML entities
     * 
     * @param string $data recived by the form
     * 
     * @return string
     */
    public function cleanInput(string $data) :string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        return $data;
    }

}
