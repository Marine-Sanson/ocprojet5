<?php
/**
 * MessageService File Doc Comment
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
 * MessageService Class Doc Comment
 * 
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class MessageService
{
    const MESSAGE = "message";
    const ERROR = "error";
    const MAIL_VALID = "Votre message a bien été envoyé";
    const MAIL_ERROR = "Votre adresse mail n'est pas valide";
    const GENERAL_ERROR = "Il y a eu un problème, merci de bien vouloir recommencer";
    const LOGIN_PROBLEM = "Problème d'identification. Veuillez rentrer vos informations de connexion ou vous
    enregistrer.";
    const LOGIN_SUCCESS = " bonjour, vous êtes connecté.";
    const DISCONNECT = "Vous êtes déconnecté";
    const COMMENT_CREATED = "Votre commentaire à bien été enregistré, il apparaitra dès qu'il sera validé";
    const NOT_AVAILABE_USERNAME = "Ce nom d'utilisateur est déjà pris, merci d'en choisir un autre";
    const REGISTER_PASSWORD_ERROR = "Attention à bien entrer 2 fois le même mot de passe";
    const REGISTER_SUCCESS = "Bienvenue! Vous pourrez commenter des posts dès que vous y serez autorisé. Vous serez 
    averti par mail quand ça sera le cas.";
    const NEW_POST_SUCCESS = "Votre article a bien été pris en compte.";
    const UPDATE_SUCCES = "Vos modifications ont bien été prises en compte";
    const VALIDATE_SUCCESS = "Ce commentaire à bien été validé";
    const DELATE_SUCCESS = "Ce commentaire à bien été supprimé";
}
