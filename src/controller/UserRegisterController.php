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
     * Summary of _instance
     *
     * @var UserRegisterController
     */
    private static $instance;

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
    private function __construct(
        private readonly TemplateInterface $_template,
        private readonly UserService $_userService,
        private readonly SessionService $_sessionService,
        private readonly UserRegisterService $_userRegisterService
    ) { }
    // End of __construct()


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

        if (self::$instance === null) {
            self::$instance = new UserRegisterController(
                $template, UserService::getInstance(),
                SessionService::getInstance(),
                UserRegisterService::getInstance()
            );
        }
    
        return self::$instance;

    }

    /**
     * Summary of displayUserRegisterPage
     *
     * @return void
     */
    public function displayUserRegisterPage(): void
    {

        $template = RouteMapper::UserRegisterView->getTemplate();

        $this->_template->display($template, []);

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
    public function manageUserRegister(array $post): void {

        $template = RouteMapper::UserRegisterView->getTemplate();

        $email = $post["email"];
        $password  = $post["password"];

        $data = [];
        if (!$this->isValid($post)) {
            $template = RouteMapper::UserRegisterView->getTemplate();
            $data = [
                     MessageMapper::Error->getMessageLabel() => MessageMapper::GeneralError->getMessage()
                    ];
        }

        if (isset($data[MessageMapper::Error->getMessageLabel()]) === false) {

            $firstName = ucwords(strtolower($post["firstName"]));
            $name = ucwords(strtolower($post["name"]));
            $username = ucwords(strtolower($post["username"]));
            $isUnavailable = $this->_userRegisterService->verifyUsername($username);

            if ($isUnavailable === true) {
                $data = [
                         MessageMapper::Error->getMessageLabel() => MessageMapper::UsernameUnavailable->getMessage()
                        ];
            }

            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $data = [
                         MessageMapper::Error->getMessageLabel() => MessageMapper::MailError->getMessage()
                        ];
            }

            if ($password !== $post["passwordVerify"]) {
                $data = [
                         MessageMapper::Error->getMessageLabel() => MessageMapper::PasswordError->getMessage()
                        ];
            }

            if (isset($data[MessageMapper::Error->getMessageLabel()]) === false) {
                $register = $this->_userRegisterService->transformToUserRegisterModel(
                    $firstName,
                    $name,
                    $username,
                    $email,
                    $password
                );

                $this->sanitizeRegisterData($register);

                $isSaved = $this->_userRegisterService->saveUserRegisterData($register);

                if ($isSaved === false) {
                    $data = [
                             MessageMapper::Error->getMessageLabel() => MessageMapper::GeneralError->getMessage()
                            ];

                }

                if (isset($data[MessageMapper::Error->getMessageLabel()]) === false) {
                    $data = [
                             MessageMapper::Message->getMessageLabel() => MessageMapper::UserRegisterSuccess->getMessage()
                            ];
                }
            }
            // End if
        }
        $this->_template->display($template, $data);

    }

    /**
     * Summary of sanitizeRegisterData
     *
     * @param \App\model\UserRegisterModel $userRegister UserRegisterModel
     *
     * @return \App\model\UserRegisterModel
     */
    private function sanitizeRegisterData(UserRegisterModel $userRegister): void
    {

        $userRegister->setFirstName($this->sanitize($userRegister->getFirstName()));
        $userRegister->setName($this->sanitize($userRegister->getName()));
        $userRegister->setUsername($this->sanitize($userRegister->getUsername()));

    }

}
