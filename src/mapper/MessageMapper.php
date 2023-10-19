<?php
/**
 * MessageMapper File Doc Comment
 *
 * PHP Version 8.1.10
 *
 * @category Mapper
 * @package  App\mapper
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\mapper;

/**
 * MessageMapper Class Doc Comment
 *
 * @category Mapper
 * @package  App\mapper
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */

enum MessageMapper: string
{
    case Message = 'message';
    case Error = 'error';

    case MailValid = 'mailValid';
    case MailError = 'mailError';
    case GeneralError = 'generalError';
    case LoginProblem = 'loginProblem';
    case LoginSuccess = 'loginSuccess';
    case Disconnect = 'disconnect';
    case CommentCreated = 'commentCreated';
    case UsernameUnavailable = 'usernameUnavailable';
    case PasswordError = 'passwordError';
    case UserRegisterSuccess = 'userRegisterSuccess';
    case NewPostSuccess = 'newPostSuccess';
    case UpdateSuccess = 'updateSuccess';
    case CommentValidationSuccess = 'commentValidationSuccess';
    case CommentDeleteSuccess = 'commentDeleteSuccess';

    /**
     * Summary of getMessageLabel
     *
     * @return string
     */
    public function getMessageLabel(): string
    {

        return match ($this) {
            static::Message => "message",
            static::Error => "error"
        };

    }//end getMessageLabel()


    /**
     * Summary of getMessage
     *
     * @return string
     */
    public function getMessage(): string
    {

        return match ($this) {
            static::MailValid => "Votre message a bien été envoyé",
            static::MailError => "Votre adresse mail n'est pas valide",
            static::GeneralError => "Il y a eu un problème, merci de bien vouloir recommencer",
            static::LoginProblem => "Problème d'identification. Veuillez rentrer vos informations de connexion ou vous
            enregistrer.",
            static::LoginSuccess => " bonjour, vous êtes connecté.",
            static::Disconnect => "Vous êtes déconnecté",
            static::CommentCreated => "Votre commentaire à bien été enregistré, il apparaitra dès qu'il sera validé",
            static::UsernameUnavailable => "Ce nom d'utilisateur est déjà pris, merci d'en choisir un autre",
            static::PasswordError => "Attention à bien entrer 2 fois le même mot de passe",
            static::UserRegisterSuccess => "Bienvenue! Vous pourrez commenter des posts dès que vous y serez autorisé.
            Vous serez averti par mail quand ça sera le cas.",
            static::NewPostSuccess => "Votre article a bien été pris en compte.",
            static::UpdateSuccess => "Vos modifications ont bien été prises en compte",
            static::CommentValidationSuccess => "Ce commentaire à bien été validé",
            static::CommentDeleteSuccess => "Ce commentaire à bien été supprimé",
        };

    }//end getMessage()

}
