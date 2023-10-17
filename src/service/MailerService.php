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

use PHPMailer\PHPMailer\PHPMailer;

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
    public function sendMail(string $contactEmail, string $subject, string $message): bool
    {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->SMTPAuth = true;

        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->Port = $_ENV['SMTP_PORT'];
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->From = $_ENV['SMTP_USERNAME'];

        $mail->Sender = $contactEmail;
        $mail->addAddress($_ENV['SMTP_USERNAME'], $_ENV['SMTP_NAME']);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = $message;

        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        $test = $mail->send();

        if (!$test) {
            $mailSend = false;
        } else {
            $mailSend = true;
        }
        return $mailSend;
    }
}
