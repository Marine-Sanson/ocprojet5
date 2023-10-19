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
     * Summary of _instance
     *
     * @var HomeController
     */
    private static $instance;

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
    private function __construct(
        private readonly TemplateInterface $_template,
        private readonly HomeService $_homeService
        )
        {

        }//end of __construct()

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

        if (self::$instance === null) {
            self::$instance = new HomeController($template, HomeService::getInstance());
        }
    
        return self::$instance;

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
