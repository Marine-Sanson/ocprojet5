<?php
/**
 * UserMapper File Doc Comment
 *
 * PHP Version 8.1.10
 *
 * @category Mapper
 * @package  App\mapper
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\mapper;

use App\entity\UserEntity;
use App\model\UserConnectionModel;

/**
 * UserMapper Class Doc Comment
 *
 * @category Mapper
 * @package  App\mapper
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class UserMapper
{

    /**
     * Summary of instance
     *
     * @var UserMapper
     */
    private static $instance;


    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     *
     * @return \App\mapper\UserMapper
     */
    public static function getInstance(): UserMapper
    {

        if (self::$instance === null) {
            self::$instance = new UserMapper();
        }

        return self::$instance;

    }//end getInstance()


    /**
     * Summary of transformToUserConnectionModel
     *
     * @param \App\entity\UserEntity $user Entity UserEntity
     *
     * @return \App\model\UserConnectionModel UserConnectionModel
     */
    public function transformToUserConnectionModel(UserEntity $user): UserConnectionModel
    {

        return new UserConnectionModel(
            $user->getId(),
            $user->getFirstName(),
            $user->getUsername(),
            $user->getPassword(),
            $user->getRole(),
            $user->isUserAllowed()
        );

    }//end transformToUserConnectionModel()


}//end class
