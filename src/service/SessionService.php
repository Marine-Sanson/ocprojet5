<?php
/**
 * SessionService File Doc Comment
 * 
 * PHP Version 8.1.10
 * 
 * @category SessionService
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\service;

/**
 * SessionService Class Doc Comment
 * 
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */

class SessionService implements SessionInterface
{
    /**
     * Summary of _instance
     * 
     * @var SessionService
     */
    private static $_instance;

    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     * 
     * @return \App\service\SessionService
     */
    public static function getInstance() :SessionService
    { 
        if (is_null(self::$_instance)) {
            session_start();
            self::$_instance = new SessionService();  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of get
     * 
     * @param string $key key
     * 
     * @return mixed
     */
    public function get(string $key)
    {
        if ($this->has($key)) {
            return $_SESSION[$key];
        }

        return null;
    }

    /**
     * Summary of set
     * 
     * @param string                $key   key
     * @param string | array | bool $value value
     * 
     * @return SessionInterface
     */
    public function set(string $key, $value): SessionInterface
    {
        $_SESSION[$key] = $value;
        return $this;
    }

    /**
     * Summary of remove
     * 
     * @param string $key key
     * 
     * @return void
     */
    public function remove(string $key): void
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Summary of clear
     *
     * @return void
     */
    public function clear(): void
    {
        session_unset();
    }

    /**
     * Summary of destroy
     *
     * @return void
     */
    public function destroy(): void
    {
        session_destroy();
    }

    /**
     * Summary of has
     *
     * @param string $key key
     * 
     * @return void
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }
}
