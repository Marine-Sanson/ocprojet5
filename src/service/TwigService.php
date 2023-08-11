<?php
declare(strict_types=1);
namespace App\service;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigService
{
    /**
     * Summary of loader
     * 
     * @var 
     */
    private FilesystemLoader $_loader;
    /**
     * Summary of twig
     * 
     * @var 
     */
    private Environment $_twig;


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
