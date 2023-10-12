<?php
/**
 * UserRegisterController File Doc Comment
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

use App\mapper\MessageMapper;
use App\mapper\RouteMapper;
use App\model\UserRegisterModel;
use App\service\SessionService;
use App\service\TemplateInterface;
use App\service\UserRegisterService;
use App\service\UserService;

/**
 * UserRegisterController Class Doc Comment
 * 
 * @category Controller
 * @package  App\controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class UserRegisterController extends AbstractController
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
     * @var UserRegisterController
     */
    private static $_instance;

    /**
     * Summary of _userService
     * 
     * @var UserService
     */
    private UserService $_userService;

    /**
     * Summary of _userRegisterService
     * 
     * @var UserRegisterService
     */
    private UserRegisterService $_userRegisterService;

    /**
     * Summary of _sessionService
     * 
     * @var SessionService
     */
    private SessionService $_sessionService;

    const URL = "enregistrement";
    const ACTION = "register";

    /**
     * Summary of __construct
     * call an instance of TemplateInterface
     * 
     * @param TemplateInterface $template template engine
     */
    private function __construct(TemplateInterface $template)
    {
        $this->_template = $template;
        $this->_userService = UserService::getInstance();
        $this->_sessionService = SessionService::getInstance();
        $this->_userRegisterService = UserRegisterService::getInstance();
    }

     /**
      * Summary of getInstance
      * That method create the unique instance of the class, if it doesn't exist and return it
      * 
      * @param \App\service\TemplateInterface $template template engine
      * 
      * @return \App\controller\UserRegisterController
      */
    public static function getInstance(TemplateInterface $template): UserRegisterController
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new UserRegisterController($template);  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of displayLoginPage
     * 
     * @return void
     */
    public function displayUserRegisterPage(): void
    {
        $template = RouteMapper::UserRegisterView->getTemplate();

        echo $this->_template->render($template, []);
    }

    /**
     * Summary of checkAction
     * 
     * @return void
     */
    public function manageUserRegister(): void
    {
        $template = RouteMapper::UserRegisterView->getTemplate();
        $data = [];
        if (!$this->isSubmitted(self::ACTION) || !$this->isValid($_POST)) {

            $template = RouteMapper::UserRegisterView->getTemplate();
            $data = [
                MessageMapper::Error->getMessageLabel() => MessageMapper::GeneralError->getMessage()
            ];
        }

        if (!isset($data[MessageMapper::Error->getMessageLabel()])) {

            // vérifie si le username n'est pas déja pris || message erreur
            $isUsernameAvailable = $this->_userRegisterService->verifyUsername($_POST["username"]);
            if ($isUsernameAvailable) {
                $data = [
                    MessageMapper::Error->getMessageLabel() => MessageMapper::UsernameUnavailable->getMessage()
                ];
            }
            // vérifie si l'adresse mail est valide
            if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                $data = [
                    MessageMapper::Error->getMessageLabel() => MessageMapper::MailError->getMessage()
                ];
            }
            // vérifie si le mdp est bien 2 fois le meme || message erreur
            if ($_POST["password"] !== $_POST["passwordVerify"]) {
                $data = [
                    MessageMapper::Error->getMessageLabel() => MessageMapper::PasswordError->getMessage()
                ];
            }
            if (!isset($data[MessageMapper::Error->getMessageLabel()])) {
                // renvoie un UserRegisterModel
                $register = $this->_userRegisterService->transformToUserRegisterModel(
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
                $isSaved = $this->_userRegisterService->saveUserRegisterData($register);

                // redirige vers la page de connexion
                if ($isSaved) {
                    $data = [
                        MessageMapper::Message->getMessageLabel() => MessageMapper::UserRegisterSuccess->getMessage()
                    ];
                } else {
                    $data = [
                        MessageMapper::Error->getMessageLabel() => MessageMapper::GeneralError->getMessage()
                    ];
                }
            }
        }

        echo $this->_template->render($template, $data);
    }

    /**
     * Summary of _cleanRegisterData
     * 
     * @param \App\model\UserRegisterModel $userRegister UserRegisterModel
     * 
     * @return \App\model\UserRegisterModel
     */
    private function _sanitizeRegisterData(UserRegisterModel $userRegister): UserRegisterModel
    {
        $userRegister->setFirstName($this->sanitize($userRegister->getFirstName()));
        $userRegister->setName($this->sanitize($userRegister->getName()));
        $userRegister->setUsername($this->sanitize($userRegister->getUsername()));

        return $userRegister;
    }

    /**
     * Summary of hashPassword - hash the user password before insert it to the db
     * 
     * @param \App\model\UserRegisterModel $register UserRegisterModel
     * 
     * @return \App\model\UserRegisterModel
     */
    private function _hashPassword(UserRegisterModel $register): UserRegisterModel
    {
        $register->setPassword(password_hash($register->getPassword(), PASSWORD_DEFAULT, ["cost" => "14"]));

        return $register;
    }

}
