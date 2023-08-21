<?php
/**
 * UserController File Doc Comment
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

use App\repository\UserRepository;
use App\service\TemplateInterface;

/**
 * UserController Class Doc Comment
 * 
 * @category Controller
 * @package  App\controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class UserController
{

    /**
     * Summary of _template
     * 
     * @var TemplateInterface
     */
    private TemplateInterface $_template;

    /**
     * Summary of _instance
     * 
     * @var UserController
     */
    private static $_instance;

    const URL = "login";

    /**
     * Summary of __construct call an instance of TemplateInterface
     * 
     * @param TemplateInterface $template template engine
     */
    private function __construct(TemplateInterface $template)
    {
        $this->_template = $template;
    }

     /**
      * Summary of getInstance
      * That method create the unique instance of the class, if it doesn't
      * exist and return it
      * 
      * @param \App\service\TemplateInterface $template template engine
      * 
      * @return \App\controller\UserController
      */
    public static function getInstance(TemplateInterface $template) :UserController
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new UserController($template);  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of index
     * 
     * @return void
     */
    public function index() :void
    {
        if ($_POST === []) {
            echo $this->_template->render('login.html.twig', []);
        } else if ($_POST["action"] === "connection") {
            $result = $this->checkConnection();
            $template = $result["template"];
            $data = $result["data"];
            echo $this->_template->render($template, $data);
        }
    }

    /**
     * Summary of checkConnection
     * 
     * @return array
     */
    public function checkConnection()
    {
        $data = [];

        $username = $_POST["username"];
        $password = $_POST["password"];

        if ($username === "" || $password === "") {
            $template = "login.html.twig";
            $data = [
                "error" => "Veuillez rentrer vos informations de connexion ou 
                vous enregistrer."
            ];
        } else {
            $userRepository = new UserRepository;

            $result = $userRepository->getPassword($username);
     
            if ($result !== []) {
                $dbPassword = password_verify($password, $result[0]["password"]);
    
                if ($dbPassword) {
                    $template = "home.html.twig";
                    $data = [
                        "username" => $username,
                        "message" => "Bonjour " . $username . ", vous êtes connecté."
                    ];
                } else {
                    $template = "login.html.twig";
                    $data = [
                        "error" => "Problème d'identification - password."
                    ];
                }
    
            } else {
                $template = "login.html.twig";
                $data = [
                    "error" => "Problème d'identification - username."
                ];
            }
        }

        $result = [
            "data" => $data,
            "template" => $template
        ];

        return $result;
    }

    /**
     * Summary of hashPassword - will hash the user password before insert it 
     * to the db
     * 
     * @param string $password password entered by the user
     * 
     * @return string
     */
    public function hashPassword(string $password) :string
    {
        return password_hash($password, PASSWORD_DEFAULT, ["cost" => "14"]);
    }
}
