<?php
/**
 * SessionInterface File Doc Comment
 *
 * PHP Version 8.1.10
 *
 * @category Interface
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\service;

use App\model\UserConnectionModel;

/**
 * SessionInterface Class Doc Comment
 *
 * @category Interface
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
interface SessionInterface
{
    /**
     * Summary of start
     * start the session and assign $_session by reference at $_SESSION
     *
     * @return void
     */
    public function start(): void;

    /**
     * Summary of setUser
     * put user's data in the $_session
     *
     * @param \App\model\UserConnectionModel $user user's data
     *
     * @return void
     */
    public function setUser(UserConnectionModel $user): void;

    /**
     * Summary of isUserConnected
     * check if there is a user connected or not
     *
     * @return bool
     */
    public function isUserConnected(): bool;

    /**
     * Summary of getSession
     *
     * @return array $_session
     */
    public function getSession(): array;

    /**
     * Summary of get
     *
     * @param string $key key
     *
     * @return mixed
     */
    public function get(string $key);

    /**
     * Summary of set
     *
     * @param string $key   key
     * @param mixed  $value value
     *
     * @return SessionInterface
     */
    public function set(string $key, $value): self;

    /**
     * Summary of remove
     *
     * @param string $key key
     *
     * @return void
     */
    public function remove(string $key): void;


    /**
     * Summary of clear
     *
     * @return void
     */
    public function clear(): void;

    /**
     * Summary of destroy
     *
     * @return void
     */
    public function destroy(): void;

    /**
     * Summary of has
     *
     * @param string $key key
     *
     * @return void
     */
    public function has(string $key): bool;

}
