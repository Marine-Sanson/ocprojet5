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

use App\mapper\RouteMapper;
use App\service\HomeService;
use App\service\TemplateInterface;

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
     * Summary of __construct
     * Call an instance of TemplateInterface
     * 
     * @param \App\service\TemplateInterface $template     TemplateInterface
     * @param \App\service\HomeService       $_homeService HomeService
     */
    private function __construct(TemplateInterface $template, private HomeService $_homeService)
    {
        $this->_template = $template;
    }

    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     * 
     * @param \App\service\TemplateInterface $template template engine
     * 
     * @return \App\controller\HomeController
     */
    public static function getInstance(TemplateInterface $template): HomeController
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new HomeController($template, HomeService::getInstance());  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of displayHome
     *
     * @return void
     */
    public function displayHome(): void
    {
        $lastPosts = $this->_homeService->getLastPosts();

        $this->_template->display(
            RouteMapper::HomeView->getTemplate(), [
                "lastPosts" => $lastPosts
            ]
        );
    }
}
