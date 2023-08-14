<?php
declare(strict_types=1);

namespace App\controller;

use App\service\TemplateInterface;
use App\service\TwigService;

class HomeController
{
    /**
     * Summary of _templateEngine
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
     * Summary of __construct
     * call an instance of TwigService
     * 
     * @param \App\service\TemplateInterface $template
     */
    private function __construct(TemplateInterface $template)
    {
        $this->_template = $template;
    }

    /**
     * Summary of getInstance
     * That methode create the unique instance of the class, if it doesn't
     * exist and return it
     * 
     * @return \App\controller\HomeController
     */
    public static function getInstance(TemplateInterface $templateEngine) :HomeController
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new HomeController($templateEngine);  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of index
     * the content of this function is temporary, just to test
     *
     * @param int|null $id
     * 
     * @return void
     */
    public function index(?int $id) :void
    {
        echo $this->_template->render('home.phtml');
    }
}
