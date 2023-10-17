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

    const URL = "enregistrement";
    const ACTION = "register";

    /**
     * Summary of __construct
     * Call an instance of TemplateInterface
     * 
     * @param \App\service\TemplateInterface   $template             TemplateInterface
     * @param \App\service\UserService         $_userService         UserService
     * @param \App\service\SessionService      $_sessionService      SessionService
     * @param \App\service\UserRegisterService $_userRegisterService UserRegisterService
     */
    private function __construct(TemplateInterface $template, private UserService $_userService, private SessionService $_sessionService, private UserRegisterService $_userRegisterService)
    {
        $this->_template = $template;
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
            self::$_instance = new UserRegisterController($template, UserService::getInstance(), SessionService::getInstance(), UserRegisterService::getInstance());  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of displayUserRegisterPage
     * 
     * @return void
     */
    public function displayUserRegisterPage(): void
    {
        $template = RouteMapper::UserRegisterView->getTemplate();

        echo $this->_template->display($template, []);
    }


    /**
     * Summary of manageUserRegister
     * 
     * @param string $firstName      firstName
     * @param string $name           name
     * @param string $username       username
     * @param string $email          email
     * @param string $password       password
     * @param string $passwordVerify passwordVerify
     * 
     * @return void
     */
    public function manageUserRegister(
        string $firstName,
        string $name,
        string $username,
        string $email,
        string $password,
        string $passwordVerify
    ): void {
        $template = RouteMapper::UserRegisterView->getTemplate();
        $data = [];
        if (!$this->isValid($_POST)) {

            $template = RouteMapper::UserRegisterView->getTemplate();
            $data = [
                MessageMapper::Error->getMessageLabel() => MessageMapper::GeneralError->getMessage()
            ];
        }

        if (!isset($data[MessageMapper::Error->getMessageLabel()])) {

            $firstName = ucwords(strtolower($firstName));
            $name = ucwords(strtolower($name));
            $username = ucwords(strtolower($username));
            $isUsernameAvailable = $this->_userRegisterService->verifyUsername($username);
            if ($isUsernameAvailable) {
                $data = [
                    MessageMapper::Error->getMessageLabel() => MessageMapper::UsernameUnavailable->getMessage()
                ];
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $data = [
                    MessageMapper::Error->getMessageLabel() => MessageMapper::MailError->getMessage()
                ];
            }

            if ($password !== $passwordVerify) {
                $data = [
                    MessageMapper::Error->getMessageLabel() => MessageMapper::PasswordError->getMessage()
                ];
            }

            if (!isset($data[MessageMapper::Error->getMessageLabel()])) {
                $register = $this->_userRegisterService->transformToUserRegisterModel(
                    $firstName,
                    $name,
                    $username,
                    $email,
                    $password
                );

                $register = $this->_sanitizeRegisterData($register);

                $register = $this->_hashPassword($register);

                $isSaved = $this->_userRegisterService->saveUserRegisterData($register);

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
        echo $this->_template->display($template, $data);
    }

    /**
     * Summary of _sanitizeRegisterData
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
