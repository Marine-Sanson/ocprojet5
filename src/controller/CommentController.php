<?php
/**
 * CommentController File Doc Comment
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

use App\controller\AbstractController;
use App\repository\CommentRepository;

/**
 * CommentController Class Doc Comment
 * 
 * @category Controller
 * @package  App\controller
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class CommentController extends AbstractController
{

    /**
     * Summary of _instance
     * 
     * @var CommentController
     */
    private static $_instance;

    /**
     * Summary of __construct
     */
    public function __construct()
    {

    }

    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     * 
     * @return \App\controller\CommentController
     */
    public static function getInstance() :CommentController
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new CommentController();  
        }
    
        return self::$_instance;
    }

    public function getOnePostComments(int $id) :array
    {
        $commentRepository = new CommentRepository();
        $comments = $commentRepository->getOnePostComments($id);

        return $comments;
    }

}
