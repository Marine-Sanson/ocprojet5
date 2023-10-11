<?php
/**
 * RoleService File Doc Comment
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

/**
 * RoleService Class Doc Comment
 * 
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
enum RoleService: string
{
    case User = 'user';
    case Supadmin = 'supadmin';

    /**
     * Summary of getLabel
     * 
     * @return string
     */
    public function getLabel(): string
    {
        return match ($this) {
            static::User => 'user',
            static::Supadmin => 'supadmin',
        };
    }
}
