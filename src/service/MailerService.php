<?php
/**
 * MailerService File Doc Comment
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
 * MailerService Class Doc Comment
 * 
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class MailerService
{
    /**
     * Summary of sendMail
     * 
     * @param string $to      mail adress to send the email
     * @param string $subject subjet of the mail
     * @param string $message name and adress of the sender, and message
     * 
     * @return bool
     */
    public function sendMail(string $to, string $subject, string $message) :bool
    {
        $headers = 'Content-Type: text/plain; charset=utf-8';
        $mail = mail($to, $subject, $message, $headers);

        return $mail;
    }
}
