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
use App\entity\UserEntity;
use App\model\UserConnectionModel;
use App\mapper\UserMapper;
use App\repository\UserRepository;
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
     * Summary of checkConnection
     * call the functions to verify if form datas aren't empty, get the
     * ConnectionModel, then verify password, connect the user, put the data
     * needed in the $_SESSION and finaly return the right template and datas
     * for the render function
     * 
     * @param string $username come from the connection form
     * @param string $password come from the connection form
     * 
     * @return array $result with template and datas
     */
    public function checkConnection(string $username, string $password) :array
    {
        $checkConnectionData = $this->checkData($username, $password);
        $data = [];

        if (!$checkConnectionData) {
            $template = "login.html.twig";
            $data = [
                "error" => "Veuillez rentrer vos informations de connexion ou 
                vous enregistrer."
            ];
        } else {
            $userEntity = $this->getUserEntity($username, $password);
            if ($userEntity) {
                $userMapper = new UserMapper;
                $connectionModel = $userMapper->transformToUserConnectionModel($userEntity);

                $result = $this->connect($password, $connectionModel);
                $template = $result["template"];
                $data = $result["data"];

            } else {
                $template = "login.html.twig";
                $data = [
                    "error" => "Problème d'identification."
                ];
            }
        }
        $result = [
            "template" => $template,
            "data" => $data
        ];
        return $result;
    }

    /**
     * Summary of connect
     * verify password connect the user and put the data needed in $_SESSION
     * 
     * @param string                         $password        come from form
     * @param \App\model\UserConnectionModel $userConnectionModel come from database
     * 
     * @return array
     */
    public function connect(
        string $password, 
        UserConnectionModel $userConnectionModel
    ) :array {
        $dbPassword = password_verify($password, $userConnectionModel->password);

        if ($dbPassword) {
            $_SESSION["connected"] = true;
            $_SESSION["button"] = "disconnect";
            $_SESSION["user"]= [
                "first_name" => $userConnectionModel->firstName,
                "role" => $userConnectionModel->role,
                "is_allowed" => $userConnectionModel->isAllowed
            ];

            $template = "home.html.twig";
            $data = [
                "message" => 
                "Bonjour " . $userConnectionModel->firstName . " vous êtes connecté.",
            ];

        } else {
            $template = "login.html.twig";
            $data = [
                "error" => "Problème d'identification."
            ];
        }
        $result = [
            "template" => $template,
            "data" => $data
        ];

        return $result;
    }

    /**
     * Summary of getUserEntity
     * 
     * @param string $username come from the connection form
     * @param string $password come from the connection form
     * 
     * @return \App\entity\UserEntity
     */
    public function getUserEntity(
        string $username, string $password
    ) :UserEntity {
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
        if ($username === "" || $password === "") return false;
            return true;
    }
}
