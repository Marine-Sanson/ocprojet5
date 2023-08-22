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

use App\model\User;
use App\repository\UserRepository;
use App\service\TemplateInterface;
use DateTime;

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
     * @return array $data $template
     */
    public function checkConnection()
    {
        $_SESSION["connected"] = false;
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

            $result = $userRepository->getUser($username);

            if ($result !== []) {
                $creationDate = $result[0]["creation_date"];
                $creationDate = DateTime::createFromFormat(
                    "Y-m-d H:i:s", 
                    date("Y-m-d H:i:s")
                );
    
                $updateDate = $result[0]["last_update_date"];
                $updateDate = DateTime::createFromFormat(
                    "Y-m-d H:i:s", 
                    date("Y-m-d H:i:s")
                );
    
                $allowed = boolval($result[0]["is_allowed"]);
    
                $user = new User(
                    $result[0]["id"], 
                    $result[0]["name"], 
                    $result[0]["first_name"], 
                    $result[0]["username"], 
                    $result[0]["email"], 
                    $result[0]["password"], 
                    $result[0]["role"], 
                    $creationDate, 
                    $updateDate,
                    $allowed
                );

                $dbPassword = password_verify($password, $user->password);

                if ($dbPassword) {
                    $_SESSION["connected"] = true;
                    $_SESSION["user"]= [
                        "first_name" => $user->firstName,
                        "role" => $user->role,
                        "is_allowed" => $user->is_allowed
                    ];

                    $template = "home.html.twig";
                    $data = [
                        "message" => 
                        "Bonjour " . $user->firstName . " vous êtes connecté."
                    ];

                } else {
                    $template = "login.html.twig";
                    $data = [
                        "error" => "Problème d'identification."
                    ];
                }
    
            } else {
                $template = "login.html.twig";
                $data = [
                    "error" => "Problème d'identification."
                ];
            }
        }

        $result = [
            "data" => $data,
            "template" => $template
        ];
        
        var_dump($_SESSION);
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
