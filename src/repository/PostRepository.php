<?php
/**
 * PostRepository File Doc Comment
 * 
 * PHP Version 8.1.10
 * 
 * @category Repository
 * @package  App\repository
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\repository;

use App\service\DatabaseService;

/**
 * PostRepository Class Doc Comment
 * 
 * @category Repository
 * @package  App\repository
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class PostRepository
{
    /**
     * Summary of _db
     * 
     * @var DatabaseService $_db connection between PHP and a database server
     */
    private DatabaseService $_db;
    
    /**
     * Summary of getAllPostsWithAuthors
     * 
     * @return array
     */
    public function getAllPostsWithAuthors()
    {
        $this->_db = DatabaseService::getInstance();
        $request = 'SELECT posts.*, username FROM posts JOIN users ON posts.id_user = users.id';

        $result = $this->_db->execute($request, null);

        return $result;
    }

    /**
     * Summary of getOnePostData
     * 
     * @param int $id id of the post
     * 
     * @return array
     */
    public function getOnePostData(int $id) :array
    {
        $this->_db = DatabaseService::getInstance();
        $request = 'SELECT posts.*, username FROM posts JOIN users ON posts.id_user = users.id WHERE posts.id = :id ';
        $parameters = [
            'id' => $id
        ];
        $result = $this->_db->execute($request, $parameters);

        return $result[0];
    }

    /**
     * Summary of getLastPosts
     * 
     * @return array
     */
    public function getLastPosts() :array
    {
        $this->_db = DatabaseService::getInstance();
        $request = 'SELECT posts.*, username FROM posts 
        JOIN users ON posts.id_user = users.id ORDER BY last_update_date DESC LIMIT 3';
        $parameters = [];
        $result = $this->_db->execute($request, $parameters);

        return $result;
    }
}
