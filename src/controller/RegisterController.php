<?php
/**
 * RegisterController File Doc Comment
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
use App\controller\UserController;
use App\model\RegisterModel;
use App\service\MessageService;
use App\service\RegisterService;
use App\service\SessionService;
use App\service\TemplateInterface;
use App\service\UserService;

/**
 * RegisterController Class Doc Comment
 * 
 * @category Controller
 * @package  App\controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class RegisterController extends AbstractController
{
    /**
     * Summary of template
     * 
     * @var TemplateInterface
     */
    private TemplateInterface $_template;

    /**
     * Summary of _instance
     * 
     * @var RegisterController
     */
    private static $_instance;

    /**
     * Summary of _userService
     * 
     * @var UserService
     */
    private UserService $_userService;

    private RegisterService $_registerService;

    /**
     * Summary of _sessionService
     * 
     * @var SessionService
     */
    private SessionService $_sessionService;

    const URL = "enregistrement";
    const REGISTER_VIEW = "register.html.twig";
    const ACTION = "register";

    /**
     * Summary of __construct
     * call an instance of TemplateInterface
     * 
     * @param TemplateInterface $template template engine
     */
    public function __construct(TemplateInterface $template)
    {
        $this->_template = $template;
        $this->_userService = UserService::getInstance();
        $this->_sessionService = SessionService::getInstance();
        $this->_registerService = RegisterService::getInstance();
    }

     /**
      * Summary of getInstance
      * That method create the unique instance of the class, if it doesn't exist and return it
      * 
      * @param \App\service\TemplateInterface $template template engine
      * 
      * @return \App\controller\RegisterController
      */
    public static function getInstance(TemplateInterface $template): RegisterController
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new RegisterController($template);  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of displayLoginPage
     * 
     * @return void
     */
    public function displayRegisterPage(): void
    {
        $template = self::REGISTER_VIEW;

        echo $this->_template->render($template, []);
    }

    /**
     * Summary of checkAction
     * 
     * @return void
     */
    public function manageRegister(): void
    {
        $template = self::REGISTER_VIEW;
        $data = [];
        if (!$this->isSubmitted(self::ACTION) || !$this->isValid($_POST)) {

            $template = self::REGISTER_VIEW;
            $data = [
                MessageService::ERROR => MessageService::GENERAL_ERROR
            ];
        }

        if (!isset($data[MessageService::ERROR])) {

            // vérifie si le username n'est pas déja pris || message erreur
            $isUsernameAvailable = $this->_registerService->verifyUsername($_POST["username"]);
            if ($isUsernameAvailable) {
                $data = [
                    MessageService::ERROR => MessageService::NOT_AVAILABE_USERNAME
                ];
            }
            // vérifie si l'adresse mail est valide
            if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                $data = [
                    MessageService::ERROR => MessageService::MAIL_ERROR
                ];
            }
            // vérifie si le mdp est bien 2 fois le meme || message erreur
            if ($_POST["password"] !== $_POST["passwordVerify"]) {
                $data = [
                    MessageService::ERROR => MessageService::REGISTER_PASSWORD_ERROR
                ];
            }
            if (!isset($data[MessageService::ERROR])) {
                // renvoie un RegisterModel
                $register = $this->_registerService->transformToRegister(
                    ucfirst(strtolower($_POST["firstName"])),
                    ucfirst(strtolower($_POST["name"])),
                    $_POST["username"],
                    $_POST["email"],
                    $_POST["password"]
                );
                // clean les données entrées
                $register = $this->_sanitizeRegisterData($register);

                // hash le mdp
                $register = $this->_hashPassword($register);

                // insère les donnéees dans la db
                $isSaved = $this->_registerService->saveRegisterData($register);

                // redirige vers la page de connexion
                if ($isSaved) {
                    $data = [
                        MessageService::MESSAGE => MessageService::REGISTER_SUCCESS
                    ];
                } else {
                    $data = [
                        MessageService::ERROR => MessageService::GENERAL_ERROR
                    ];
                }
            }
        }

        echo $this->_template->render($template, $data);
    }

    /**
     * Summary of _cleanRegisterData
     * 
     * @param \App\model\RegisterModel $register RegisterModel
     * 
     * @return \App\model\RegisterModel
     */
    private function _sanitizeRegisterData(RegisterModel $register): RegisterModel
    {
        $register->setFirstName($this->sanitize($register->getFirstName()));
        $register->setName($this->sanitize($register->getName()));
        $register->setUsername($this->sanitize($register->getUsername()));

        return $register;
    }

    /**
     * Summary of hashPassword - hash the user password before insert it to the db
     * 
     * @param \App\model\RegisterModel $register RegisterModel
     * 
     * @return \App\model\RegisterModel
     */
    private function _hashPassword(RegisterModel $register): RegisterModel
    {
        $register->setPassword(password_hash($register->getPassword(), PASSWORD_DEFAULT, ["cost" => "14"]));

        return $register;
    }

}
