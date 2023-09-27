<?php
/**
 * UserService File Doc Comment
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

use App\controller\HomeController;
use App\controller\UserController;
use App\entity\UserEntity;
use App\model\UserConnectionModel;
use App\repository\UserRepository;
use App\service\SessionInterface;
use App\service\SessionService;
use DateTime;

/**
 * UserService Class Doc Comment
 * 
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class UserService
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
     * @var UserService
     */
    private static $_instance;

    /**
     * Summary of session
     * 
     * @var SessionInterface
     */
    private SessionInterface $_session;
    /**
     * Summary of _userRepository
     * 
     * @var UserRepository
     */
    private UserRepository $_userRepository;

    /**
     * Summary of __construct
     */
    private function __construct()
    {
        $this->_session = SessionService::getInstance();
        $this->_userRepository = new UserRepository();

    }
     /**
      * Summary of getInstance
      * That method create the unique instance of the class, if it doesn't exist and return it
      * 
      * @return \App\service\UserService
      */
    public static function getInstance() :UserService
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new UserService();
        }
    
        return self::$_instance;
    }

    /**
     * Summary of checkConnection
     * call the functions to verify if form datas aren't empty, get the ConnectionModel, then verify password, connect
     * the user, put the data needed in the session and finaly return the right template and datas for the render
     * function
     * 
     * @param string $username come from the connection form
     * @param string $password come from the connection form
     * 
     * @return array $result with template and datas
     */

    /**
     * Summary of connect
     * verify password connect the user and put the data needed in the session
     * 
     * @param string                         $password            come from form
     * @param \App\model\UserConnectionModel $userConnectionModel come from database
     * 
     * @return array
     */
    public function connect(string $password, UserConnectionModel $userConnectionModel) :array
    {
        $dbPassword = password_verify($password, $userConnectionModel->password);

        if ($dbPassword) {
            $this->_session->setUser($userConnectionModel);

            $template = HomeController::HOME_VIEW;
            $data = [
                MessageService::MESSAGE => ucfirst($userConnectionModel->firstName) . MessageService::LOGIN_SUCCESS
            ];

        } else {
            $template = UserController::LOGIN_VIEW;
            $data = [
                MessageService::ERROR => MessageService::LOGIN_ERROR
            ];
        }
        $result = [
            "template" => $template,
            "data" => $data
        ];

        return $result;
    }

    /**
     * Summary of getUser
     * 
     * @param string $username come from the connection form
     * @param string $password come from the connection form
     * 
     * @return \App\entity\UserEntity | null
     */
    public function getUser(string $username, string $password) :?UserEntity
    {
        $result = $this->_userRepository->getUser($username);

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

            $user = new UserEntity(
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
        } else {
            $user = null;
        }
        return $user;
    }

    /**
     * Summary of checkData
     * verify the data entered by the user and verify if they are empty
     * 
     * @param string $username come from the connection form
     * @param string $password come from the connection form
     * 
     * @return bool
     */
    public function checkData(string $username, string $password)
    {
        if ($username === "" || $password === "") {
            return false;
        }
        
        return true;
    }

    /**
     * Summary of getUserId
     * 
     * @param string $username username
     * 
     * @return int
     */
    public function getUserId(string $username) :int
    {
        $userId = $this->_userRepository->getUserId($username);

        return $userId;
    }
}
