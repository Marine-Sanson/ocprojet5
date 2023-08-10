<?php
declare(strict_types=1);
namespace App\service;

class TwigService
{
    /**
     * Summary of loader
     * 
     * @var 
     */
    private static $_loader;
    /**
     * Summary of twig
     * 
     * @var 
     */
    private static $_twig;


    /**
     * Summary of twigLoader
     * 
     * @return \Twig\Environment
     */
    public static function twigLoader()
    {
        if (is_null(self::$_loader)) {
                $_loader = new \Twig\Loader\FilesystemLoader('src/view');
        }

        if (is_null(self::$_twig)) {
            $_twig = new \Twig\Environment(
                $_loader, [
                    'cache' => false, // __DIR__ . '/tmp'
                ]
            );
        }

        return $_twig;
    }
}
