<?php
/**
 * RouteService File Doc Comment
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
 * RouteService Class Doc Comment
 * 
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
enum RouteService: string
{
    case ContactView = 'contact.html.twig';
    case HomeView = 'home.html.twig';
    case PostsView = 'posts.html.twig';
    case OnePostView = 'one-post.html.twig';
    case RegisterView = "register.html.twig";
    case LoginView = "login.html.twig";
    case PromotingView = "promoting.html.twig";

    public function getLabel(): string
    {
        return match($this) {
            static::ContactView => 'contact.html.twig',
            static::HomeView => 'home.html.twig',
            static::PostsView => 'posts.html.twig',
            static::OnePostView => 'one-post.html.twig',
            static::RegisterView => "register.html.twig",
            static::LoginView => "login.html.twig",
            static::PromotingView => "promoting.html.twig",
        };
    }
}
