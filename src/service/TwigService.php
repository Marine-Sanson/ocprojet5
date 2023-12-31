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
     * Summary of instance
     *
     * @var TwigService Twig
     */
    private static $instance;

    /**
     * Summary of twig
     *
     * @var Environment
     */
    private Environment $twigEnvironment;


    /**
     * Summary of __construct
     */
    private function __construct()
    {
        $loader = new FilesystemLoader('src/view');
        $twig = new Environment(
            $loader, [
                'cache' => false,
                'debug' => true
            ]
        );
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $twig->addGlobal("session", SessionService::getInstance()->getSession());
        $this->twigEnvironment = $twig;

    }//end __construct()


    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     *
     * @return \App\service\TwigService
     */
    public static function getInstance(): TwigService
    {

        if (self::$instance === null) {
            self::$instance = new TwigService();
        }

        return self::$instance;

    }//end getInstance()


    /**
     * Summary of display
     *
     * @param string $templateName name of the template
     * @param array  $parameters   parameters
     *
     * @return void
     */
    public function display(string $templateName, array $parameters=[]): void
    {

        $this->twigEnvironment->display($templateName, $parameters);

    }//end display()


}//end class
