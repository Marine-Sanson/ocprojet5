<?php
/**
 * RouteMapper File Doc Comment
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

namespace App\mapper;

/**
 * RouteMapper Class Doc Comment
 *
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
enum RouteMapper: string
{
    case ContactView = 'contactView';
    case HomeView = 'homeView';
    case PostsView = 'postsView';
    case OnePostView = 'onePostView';
    case UserRegisterView = "userRegisterView";
    case LoginView = "loginView";
    case UserUpgradeView = "userUpgradeView";
    case ValidationComments = "validationView";
    case Page404 = "404";


    /**
     * Summary of getTemplate
     *
     * @return string
     */
    public function getTemplate(): string
    {

        return match ($this) {
            static::ContactView => 'contact.html.twig',
            static::HomeView => 'home.html.twig',
            static::PostsView => 'posts.html.twig',
            static::OnePostView => 'one-post.html.twig',
            static::UserRegisterView => "user-register.html.twig",
            static::LoginView => "login.html.twig",
            static::UserUpgradeView => "user-upgrade.html.twig",
            static::ValidationComments => 'validation.html.twig',
            static::Page404 => '404.html.twig',
        };

    }//end getTemplate()


}//end RouteMapper
