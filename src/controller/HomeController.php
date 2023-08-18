<?php
/**
 * HomeController File Doc Comment
 * 
 * PHP Version 8.1.10
 * 
 * @category Controller
 * @package  App\controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\controller;

use App\service\TemplateInterface;
use App\service\TwigService;

/**
 * HomeController Class Doc Comment
 * 
 * @category Controller
 * @package  App\controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class HomeController
{


    /**
     * Summary of _template
     * 
     * @var TemplateInterface
     */
    private TemplateInterface $_template;

    /**
     * Summary of _instance
     * 
     * @var HomeController
     */
    private static $_instance;

    /**
     * Summary of URL
     * 
     * @var string
     */
    const URL = "home";

    /**
     * Summary of __construct call an instance of TemplateInterface
     * 
     * @param TemplateInterface $template template engine
     */
    private function __construct(TemplateInterface $template)
    {
        $this->_template = $template;
    }


    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't
     * exist and return it
     * 
     * @param \App\service\TemplateInterface $template template engine
     * 
     * @return \App\controller\HomeController
     */
    public static function getInstance(TemplateInterface $template) :HomeController
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new HomeController($template);  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of index
     * The content of this function is temporary, just to test
     *
     * @param int|null $id id of the post
     * 
     * @return void
     */
    public function index(?int $id) :void
    {
        echo $this->_template->render('home.html.twig', []);
    }
}
