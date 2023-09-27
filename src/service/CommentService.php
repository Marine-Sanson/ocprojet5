<?php
/**
 * CommentService File Doc Comment
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
use App\controller\CommentController;
use App\controller\PostController;
use App\controller\UserController;
use App\entity\CommentEntity;
use App\mapper\PostsMapper;
use App\repository\CommentRepository;
use App\repository\PostRepository;
use App\service\UserService;
use DateTime;

/**
 * CommentService Class Doc Comment
 * 
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class CommentService
{
    /**
     * Summary of template
     * 
     * @var TemplateInterface
     */
    public TemplateInterface $template;

    /**
     * Summary of _postService
     * 
     * @var CommentRepository
     */
    private $_commentRepository;

    /**
     * Summary of _instance
     * 
     * @var CommentService
     */
    private static $_instance;
    const ACTION = "addComment";

    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->_postService = PostService::getInstance();
        $this->_commentRepository = new CommentRepository();
    }

    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     * 
     * @return \App\service\CommentService
     */
    public static function getInstance() :CommentService
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new CommentService();  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of manageComment
     * 
     * @return \App\entity\CommentEntity
     */
    public function manageComment() :CommentEntity
    {
            $currentDate = DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));

            $userService = UserService::getInstance();
            $id_user = $userService->getUserId($_POST["username"]);
            
            $postId = intval($_POST["postId"]);
            $comment = new CommentEntity(null, $postId, $id_user, $_POST["content"], $currentDate, $currentDate, false);

            return $comment;
    }

    /**
     * Summary of createNewComment
     * 
     * @param \App\entity\CommentEntity $validateComment CommentEntity after validation
     * 
     * @return array
     */
    public function createNewComment(CommentEntity $validateComment)
    {
        $createNewComment = $this->_commentRepository->insertComment($validateComment);
        if ($createNewComment) {
            $data = [
                MessageService::MESSAGE => MessageService::COMMENT_CREATED
            ];
        } else {
            $data = [
                MessageService::ERROR => MessageService::GENERAL_ERROR
            ];
        }
    
        return $data;
    }
}
