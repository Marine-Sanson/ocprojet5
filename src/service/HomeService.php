<?php
/**
 * HomeService File Doc Comment
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

use App\mapper\PostsMapper;
use App\repository\PostRepository;

/**
 * HomeService Class Doc Comment
 * 
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class HomeService
{
    /**
     * Summary of template
     * 
     * @var TemplateInterface
     */
    public TemplateInterface $template;

    /**
     * Summary of _instance
     * 
     * @var HomeService
     */
    private static $_instance;

    /**
     * Summary of _postRepository
     * 
     * @var PostRepository
     */
    private PostRepository $_postRepository;

    /**
     * Summary of _postsMapper
     * 
     * @var PostsMapper
     */
    private PostsMapper $_postsMapper;

     /**
      * Summary of getInstance
      * That method create the unique instance of the class, if it doesn't exist and return it
      * 
      * @return \App\service\HomeService
      */
    public static function getInstance(): HomeService
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new HomeService();  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of __construct
     */
    private function __construct()
    {
        $this->_postRepository = PostRepository::getInstance();
        $this->_postsMapper = PostsMapper::getInstance();
    }

    /**
     * Summary of getLastPosts
     * 
     * @return array
     */
    public function getLastPosts(): array
    {
        $results = $this->_postRepository->getListOfPosts();

        return $this->_postsMapper->transformToListOfPostModel($results);
    }
}
