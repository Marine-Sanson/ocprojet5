<?php
/**
 * RoleMapper File Doc Comment
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

namespace App\mapper;

/**
 * RoleMapper Class Doc Comment
 *
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
enum RoleMapper: string
{
    case User = 'user';
    case Supadmin = 'supadmin';

    /**
     * Summary of getRole
     *
     * @return string
     */
    public function getRole(): string
    {

        return match ($this) {
            static::User => 'user',
            static::Supadmin => 'supadmin',
        };

    }//end getRole()

}
