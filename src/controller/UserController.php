<?php
/**
 * UserController File Doc Comment
 * 
 * PHP Version 8.1.10
 * 
 * @category Controller
 * @package  App\controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_type=1);

namespace App\controller;

use App\service\TemplateInterface;

/**
 * UserController Class Doc Comment
 * 
 * @category Controller
 * @package  App\controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class UserController
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
     * @var UserController
     */
    private static $_instance;

    const URL = "login";

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
     * Summary of index
     * 
     * @return void
     */
    public function index() :void
    {
        echo $this->_template->render('login.html.twig', []);
    }
}
