<?php
/**
 * UserRegisterModel File Doc Comment
 *
 * PHP Version 8.1.10
 *
 * @category Model
 * @package  App\model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\model;

/**
 * UserRegisterModel Class Doc Comment
 *
 * @category Model
 * @package  App\model
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class UserRegisterModel
{


    /**
     * Summary of __construct UserRegisterModel
     *
     * @param string $firstName first name of the user
     * @param string $name      name of the user
     * @param string $username  username must be unique, used to login
     * @param string $email     email of the user
     * @param string $password  password - will be saved encrypt in the DB
     */
    public function __construct(
        private string $firstName,
        private string $name,
        private string $username,
        private string $email,
        private string $password
    ) {

    }//end __construct()


    /**
     * Summary of getFirstName
     *
     * @return string
     */
    public function getFirstName(): string
    {

        return $this->firstName;

    }//end getFirstName()


    /**
     * Summary of setFirstName
     *
     * @param string $firstName firstName
     *
     * @return \App\model\UserRegisterModel
     */
    public function setFirstName(string $firstName): self
    {

        $this->firstName = $firstName;
        return $this;

    }//end setFirstName()


    /**
     * Summary of getName
     *
     * @return string
     */
    public function getName(): string
    {

        return $this->name;

    }//end getName()


    /**
     * Summary of setName
     *
     * @param string $name name
     *
     * @return \App\model\UserRegisterModel
     */
    public function setName(string $name): self
    {

        $this->name = $name;
        return $this;

    }//end setName()


    /**
     * Summary of getUsername
     *
     * @return string
     */
    public function getUsername(): string
    {

        return $this->username;

    }//end getUsername()


    /**
     * Summary of setUsername
     *
     * @param string $username username
     *
     * @return \App\model\UserRegisterModel
     */
    public function setUsername(string $username): self
    {

        $this->username = $username;
        return $this;

    }//end setUsername()


    /**
     * Summary of getEmail
     *
     * @return string
     */
    public function getEmail(): string
    {

        return $this->email;

    }//end getEmail()


    /**
     * Summary of setEmail
     *
     * @param string $email email
     *
     * @return \App\model\UserRegisterModel
     */
    public function setEmail(string $email): self
    {

        $this->email = $email;
        return $this;

    }//end setEmail()


    /**
     * Summary of getPassword
     *
     * @return string
     */
    public function getPassword(): string
    {

        return $this->password;

    }//end getPassword()


    /**
     * Summary of setPassword
     *
     * @param string $password password
     *
     * @return \App\model\UserRegisterModel
     */
    public function setPassword(string $password): self
    {

        $this->password = $password;
        return $this;

    }//end setPassword()


    /**
     * Summary of toArray
     *
     * @return array
     */
    public function toArray() :array
    {

        return [
            "firstName" => $this->firstName,
            "name"      => $this->name,
            "username"  => $this->username,
            "email"     => $this->email,
            "password"  => $this->password
        ];

    }//end toArray()


}//end class
