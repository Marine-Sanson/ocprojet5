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
     * Summary of instance
     *
     * @var SessionService
     */
    private static $instance;

    /**
     * Summary of session
     *
     * @var array contain the data of $session
     */
    private ?array $session = null;

    const USER_KEY = "user";


    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     *
     * @return \App\service\SessionService
     */
    public static function getInstance(): SessionService
    {

        if (self::$instance === null) {
            self::$instance = new SessionService();
        }

        return self::$instance;

    }//end getInstance()


    /**
     * Summary of start
     * start the session and assign $session by reference at $session
     *
     * @return void
     */
    public function start(): void
    {

        session_start();
        $this->session = &$_SESSION;

    }//end start()


    /**
     * Summary of setUser
     * put user's data in the $session
     *
     * @param \App\model\UserConnectionModel $user user's data
     *
     * @return void
     */
    public function setUser(UserConnectionModel $user): void
    {

        $this->session[self::USER_KEY] = $user;

    }//end setUser()


    /**
     * Summary of getUser
     *
     * @return UserConnectionModel
     */
    public function getUser(): UserConnectionModel
    {

        return $this->session[self::USER_KEY];

    }//end getUser()


    /**
     * Summary of isUserConnected
     * check if there is a user connected or not
     *
     * @return bool
     */
    public function isUserConnected(): bool
    {

        return !empty($this->session[self::USER_KEY]);

    }//end isUserConnected()


    /**
     * Summary of getSession
     *
     * @return array $session
     */
    public function getSession(): array
    {

        return $this->session;

    }//end getSession()


    /**
     * Summary of get
     *
     * @param string $key key
     *
     * @return array | null
     */
    public function get(string $key): ?array
    {

        if ($this->has($key) === true) {
            return $this->session[$key];
        }

        return null;

    }//end get()


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

        $this->session[$key] = $value;
        return $this;

    }//end set()


    /**
     * Summary of remove
     *
     * @param string $key key
     *
     * @return void
     */
    public function remove(string $key): void
    {

        if ($this->has($key) === true) {
            unset($this->session[$key]);
        }

    }//end remove()


    /**
     * Summary of clear
     *
     * @return void
     */
    public function clear(): void
    {

        session_unset();

    }//end clear()


    /**
     * Summary of destroy
     *
     * @return void
     */
    public function destroy(): void
    {

        session_destroy();

    }//end destroy()


    /**
     * Summary of has
     *
     * @param string $key key
     *
     * @return void
     */
    public function has(string $key): bool
    {

        return array_key_exists($key, $this->session);

    }//end has()


    /**
     * Summary of cleanSession
     *
     * @return void
     */
    public function cleanSession(): void
    {

        $this->clear();
        $this->destroy();

    }//end cleanSession()


}//end class
