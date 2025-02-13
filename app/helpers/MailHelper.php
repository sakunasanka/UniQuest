<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Ensure PHPMailer is loaded
require_once __DIR__ . '/../../vendor/autoload.php';

class MailHelper
{
    public static function sendEmail($toEmail, $toName, $subject, $body)
    {
        $mail = new PHPMailer(true);
        // SMTP_SETTINGS = require 'app/config/config.php'; // Load SMTP settings

        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host       = SMTP_SETTINGS['smtp_host'];
            $mail->SMTPAuth   = SMTP_SETTINGS['smtp_auth'];
            $mail->Username   = SMTP_SETTINGS['smtp_username'];
            $mail->Password   = SMTP_SETTINGS['smtp_password'];
            $mail->SMTPSecure = SMTP_SETTINGS['smtp_secure'] === 'tls' ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = SMTP_SETTINGS['smtp_port'];

            // Sender and Recipient
            $mail->setFrom(SMTP_SETTINGS['from_email'], SMTP_SETTINGS['from_name']);
            $mail->addAddress($toEmail, $toName);

            // Email Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            // Debugging
            // $mail->SMTPDebug = 2; // Debug mode (set to 0 after testing)
            // $mail->Debugoutput = 'html'; // Show output in a readable format

            if ($mail->send()) {
                return true;
            } else {
                return "Mailer Error: " . $mail->ErrorInfo; // Show error message
            }
        } catch (Exception $e) {
            return "Exception: " . $e->getMessage(); // Show exception message
        }
    }

    //send email with token to verify company email
    public static function sendEmailWithTokenCompany($toEmail, $token)
    {
        //load template
        $template = file_get_contents(TEMPLATEROOT . '\emails\verification_email_comp.html');
        //create link
        $link = URLROOT . '/register/verifyCompEmail?token=' . $token;

        //replace placeholders
        $template = str_replace('{{verification_link}}', $link, $template);
        $template = str_replace('{{year}}', date('Y'), $template);

        $subject = "Verify Your Email";

        return self::sendEmail($toEmail, '', $subject, $template);
    }

    //send email with token to verify student email
    public static function sendEmailWithTokenStudent($toEmail, $token)
    {
        //load template
        $template = file_get_contents(TEMPLATEROOT . '\emails\verification_email_stu.html');
        //create link
        $link = URLROOT . '/register/verifyStuEmail?token=' . $token;

        //replace placeholders
        $template = str_replace('{{verification_link}}', $link, $template);
        $template = str_replace('{{year}}', date('Y'), $template);

        $subject = "Verify Your Email";

        return self::sendEmail($toEmail, '', $subject, $template);
    }

    //send email with token to reset password
    public static function sendEmailWithTokenResetPassword($toEmail, $token)
    {
        //load template
        $template = file_get_contents(TEMPLATEROOT . '\emails\reset_password.html');
        //create link
        $link = URLROOT . '/user/reset_password?token=' . $token;

        //replace placeholders
        $template = str_replace('{{reset_link}}', $link, $template);
        $template = str_replace('{{year}}', date('Y'), $template);

        $subject = "Reset Your Password";

        return self::sendEmail($toEmail, '', $subject, $template);
    }
}
