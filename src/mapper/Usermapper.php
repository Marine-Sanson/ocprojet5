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
     * Summary of changeUserToConnection
     * 
     * @param \App\entity\UserEntity $user Entity UserEntity
     * 
     * @return \App\model\UserConnectionModel UserConnectionModel
     */
    public function transformToUserConnectionModel(UserEntity $user): UserConnectionModel
    {
        return new UserConnectionModel(
            $user->firstName, 
            $user->username, 
            $user->password, 
            $user->role, 
            $user->isAllowed
        );
    }
}
