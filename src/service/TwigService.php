<?php
declare(strict_types=1);

namespace App\service;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigService implements TemplateInterface
{

    /**
     * Summary of _instance
     * 
     * @var TwigService
     */
    private static $_instance;

    private Environment $_twig;
    
    /**
     * Summary of __construct
     */
    private function __construct() 
    {
        $loader = new FilesystemLoader('src/view');
        $this->_twig = new Environment(
            $loader, [
                'cache' => false, // __DIR__ . '/tmp'
            ]
        );
    }

    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't
     * exist and return it
     * 
     * @return \App\service\TwigService
     */
    public static function getInstance() :TwigService
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new TwigService();  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of render
     * 
     * @param string $templateName
     * @param array  $parameters
     * 
     * @return string
     */
    public function render(string $templateName, array $parameters = []) :string
    {
        return $this->_twig->render($templateName, $parameters);
    }
}
