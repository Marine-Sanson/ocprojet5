<?php
/**
 * TwigService File Doc Comment
 * Implements TemplateInterface
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

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

 /**
  * TwigService Class Doc Comment
  * This interface load Twig and create a Twig environment
  * 
  * @category Service
  * @package  App\service
  * @author   Marine Sanson <marine_sanson@yahoo.fr>
  * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
  * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
  */
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
        $twig = new Environment(
            $loader, [
                'cache' => false, // __DIR__ . '/tmp'
                'debug' => true
            ]
        );
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $twig->addGlobal("session", $_SESSION);
        $this->_twig = $twig;
    }

    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
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
     * @param string $templateName Name of the template
     * @param array  $parameters   Parameters
     * 
     * @return string template to display
     */
    public function render(string $templateName, array $parameters = []) :string
    {
        return $this->_twig->render($templateName, $parameters);
    }
}
