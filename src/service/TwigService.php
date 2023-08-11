<?php
declare(strict_types=1);

namespace App\service;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigService
{

     /**
     * Summary of _loader
     * 
     * @var FilesystemLoader
     */
    private static ?FilesystemLoader $_loader = null;
    
    /**
     * Summary of __construct
     */
    private function __construct()
    {
            $this->_loader = new FilesystemLoader('src/view');
    }

    public static function getInstance()
    { 
        if(is_null(self::$_loader)) {
          self::$_loader = new TwigService();  
        }
    
        return self::$_loader;
    }
    /**
     * Summary of twigLoader
     * 
     * @return \Twig\Environment
     */
    public function twigLoader()
    {
            $twig = new Environment(
                $this->getInstance(), [
                    'cache' => false, // __DIR__ . '/tmp'
                ]
            );

        return $twig;
    }
}
