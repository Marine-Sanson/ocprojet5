<?php
/**
 * SessionService File Doc Comment
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
use App\model\UserConnectionModel;

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
     * Summary of _session
     * 
     * @var array contain the data of $_SESSION
     */
    private ?array $_session = null;

    const USER_KEY = "user";

    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     * 
     * @return \App\service\SessionService
     */
    public static function getInstance(): SessionService
    { 
        if (is_null(self::$_instance)) {
            self::$_instance = new SessionService();  
        }
    
        return self::$_instance;
    }

    /**
     * Summary of start
     * start the session and assign $_session by reference at $_SESSION
     * 
     * @return void
     */
    public function start():  void
    {
        session_start();
        $this->_session = &$_SESSION;
    }

    /**
     * Summary of setUser
     * put user's data in the $_session
     * 
     * @param \App\model\UserConnectionModel $user user's data
     * 
     * @return void
     */
    public function setUser(UserConnectionModel $user):  void
    {
        $this->_session[self::USER_KEY] = $user;
    }

    /**
     * Summary of getUser
     * 
     * @return UserConnectionModel
     */
    public function getUser(): UserConnectionModel
    {
        return $this->_session[self::USER_KEY];
    }

    /**
     * Summary of isUserConnected
     * check if there is a user connected or not
     * 
     * @return bool
     */
    public function isUserConnected():  bool 
    {
        return !empty($this->_session[self::USER_KEY]);
    }

    /**
     * Summary of getSession
     *
     * @return array $_session
     */
    public function getSession():  array
    {
        return $this->_session;
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
            return $this->_session[$key];
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
        $this->_session[$key] = $value;
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
            unset($this->_session[$key]);
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
        return array_key_exists($key, $this->_session);
    }

    /**
     * Summary of cleanSession
     * 
     * @return void
     */
    public function cleanSession(): void
    {
        $this->clear();
        $this->destroy();
    }
}
