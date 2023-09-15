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

use App\service\config;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/phpmailer/phpmailer/src/Exception.php';
require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php';

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
     * Create an instance of phpmailer, configure it, send the mail and verify if the sending is true
     * Use the constant of local config.php
     * 
     * @param string $contactName  full name of the sender
     * @param string $contactEmail mail adress to send the email
     * @param string $subject      subjet of the mail
     * @param string $message      name and adress of the sender, and message
     * 
     * @return bool
     */
    public function sendMail(string $contactName, string $contactEmail, string $subject, string $message) :bool
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->SMTPAuth = true;

        $mail->Host = config::SMTP_HOST;
        $mail->Port = config::SMTP_PORT;
        $mail->Username = config::SMTP_USERNAME;
        $mail->Password = config::SMTP_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->From = config::SMTP_USERNAME;

        $mail->Sender = $contactEmail;
        $mail->addAddress(config::SMTP_USERNAME, config::SMTP_NAME);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = $message;

        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        $test = $mail->send();

        if (!$test) {
            echo $mail->ErrorInfo;
            $mailSend = false;
        } else {
            $mailSend = true;
        }
        return $mailSend;
    }
}
