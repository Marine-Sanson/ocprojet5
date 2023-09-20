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
    /**
     * Summary of _instance
     * 
     * @var MessageService
     */
    private static $_instance;

    const MESSAGE = "message";
    const ERROR = "error";
    const MAIL_VALID = "votre message a bien été envoyé";
    const MAIL_ERROR = "il y a eu un problème, merci de bien vouloir recommencer";
    const CONNECTION_ERROR = "Veuillez rentrer vos informations de connexion ou vous enregistrer.";
    const LOGIN_PROBLEM = "Problème d'identification.";
    const LOGIN_SUCCESS = " bonjour, vous êtes connecté.";
    const LOGIN_ERROR = "Problème d'identification.";
    const DISCONNECT = "Vous êtes déconnecté";
}
