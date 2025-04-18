<?php

// Use DIRECTORY_SEPARATOR to handle path separators
require PHPMAILERROOT . DIRECTORY_SEPARATOR . 'PHPMailer.php';
require PHPMAILERROOT . DIRECTORY_SEPARATOR . 'Exception.php';
require PHPMAILERROOT . DIRECTORY_SEPARATOR . 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

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
        $template = file_get_contents(TEMPLATEROOT . DIRECTORY_SEPARATOR . 'emails' . DIRECTORY_SEPARATOR . 'verification_email_comp.html');
        //create link
        $link = URLROOT . '/register/verifyCompEmail?token=' . $token;

        //replace placeholders
        $template = str_replace('{{verification_link}}', $link, $template);
        $template = str_replace('{{year}}', date('Y'), $template);

        $subject = "Verify Your Email";

        return self::sendEmail($toEmail, '', $subject, $template);
    }

    //send email with token to verify student email
    public static function sendEmailWithTokenStudent($toEmail, $token, $controller)
    {
        //load template
        $template = file_get_contents(TEMPLATEROOT . DIRECTORY_SEPARATOR . 'emails' . DIRECTORY_SEPARATOR . 'verification_email_stu.html');
        //create link
        $link = URLROOT . '/' . $controller . '/verifyStuEmail?token=' . $token;

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
        $template = file_get_contents(TEMPLATEROOT . DIRECTORY_SEPARATOR . 'emails' . DIRECTORY_SEPARATOR . 'reset_password.html');
        //create link
        $link = URLROOT . '/user/reset_password?token=' . $token;

        //replace placeholders
        $template = str_replace('{{reset_link}}', $link, $template);
        $template = str_replace('{{year}}', date('Y'), $template);

        $subject = "Reset Your Password";

        return self::sendEmail($toEmail, '', $subject, $template);
    }

    //send email to notify student that their account has been approved with link to login
    public static function sendEmailStuAccountApproved($toEmail, $toName)
    {
        //load template
        $template = file_get_contents(TEMPLATEROOT . DIRECTORY_SEPARATOR . 'emails' . DIRECTORY_SEPARATOR . 'stu_account_approved.html');
        //create link
        $link = URLROOT . '/login';

        //replace placeholders
        $template = str_replace('{{login_link}}', $link, $template);
        $template = str_replace('{{name}}', $toName, $template);
        $template = str_replace('{{year}}', date('Y'), $template);

        $subject = "Account Approved";

        return self::sendEmail($toEmail, $toName, $subject, $template);
    }

    //send email to notify company that their account has been approved with link to login
    public static function sendEmailCompAccountApproved($toEmail, $toName)
    {
        //load template
        $template = file_get_contents(TEMPLATEROOT . DIRECTORY_SEPARATOR .'emails' . DIRECTORY_SEPARATOR . 'comp_account_approved.html');
        //create link
        $link = URLROOT . '/login';

        //replace placeholders
        $template = str_replace('{{login_link}}', $link, $template);
        $template = str_replace('{{company_name}}', $toName, $template);
        $template = str_replace('{{year}}', date('Y'), $template);

        $subject = "Account Approved";

        return self::sendEmail($toEmail, $toName, $subject, $template);
    }

    //send email to notify student that their account has been rejected with reason
    public static function sendEmailAccountRejected($toEmail, $toName, $reason)
    {
        //load template
        $template = file_get_contents(TEMPLATEROOT . DIRECTORY_SEPARATOR . 'emails' . DIRECTORY_SEPARATOR . 'account_rejected.html');
        //create link
        $contactLink = URLROOT . '/contact';//TODO: change to contact admin page
        $regLink = URLROOT . '/register';//TODO: change to resubmit registration page

        //replace placeholders
        $template = str_replace('{{name}}', $toName, $template);
        $template = str_replace('{{rejection_reason}}', $reason, $template);
        $template = str_replace('{{year}}', date('Y'), $template);
        $template = str_replace('{{contact_admin_link}}', $contactLink, $template);
        $template = str_replace('{{resubmit_link}}', $regLink, $template);

        $subject = "Account Rejected";

        return self::sendEmail($toEmail, $toName, $subject, $template);
    }

    //send email to notify student that their account has been deactivated
    public static function sendEmailAccountDeactivated($toEmail, $toName)
    {
        //load template
        $template = file_get_contents(TEMPLATEROOT . DIRECTORY_SEPARATOR . 'emails' . DIRECTORY_SEPARATOR . 'acc_deactivate.html');
        //create link
        $reactivateLink = URLROOT . '/login';

        //replace placeholders
        $template = str_replace('{{name}}', $toName, $template);
        $template = str_replace('{{reactivate_link}}', $reactivateLink, $template);
        $template = str_replace('{{year}}', date('Y'), $template);

        $subject = "Account Deactivated";

        return self::sendEmail($toEmail, $toName, $subject, $template);
    }

    //send email to notify student that their account has been reactivated
    public static function sendEmailAccountReactivated($toEmail, $toName)
    {
        //load template
        $template = file_get_contents(TEMPLATEROOT . DIRECTORY_SEPARATOR . 'emails' . DIRECTORY_SEPARATOR . 'acc_reactivation.html');
        //create link
        $loginLink = URLROOT . '/login';

        //replace placeholders
        $template = str_replace('{{name}}', $toName, $template);
        $template = str_replace('{{year}}', date('Y'), $template);

        $subject = "Account Reactivated";

        return self::sendEmail($toEmail, $toName, $subject, $template);
    }

    //send email to notify student that their account has been deactivated by admin
    public static function sendEmailAccountDeactivatedByAdmin($toEmail, $reason)
    {
        //load template
        $template = file_get_contents(TEMPLATEROOT . DIRECTORY_SEPARATOR . 'emails' . DIRECTORY_SEPARATOR . 'acc_deactivate_admin.html');
        //create link
        $contactLink = URLROOT . '/contact';//TODO: change to contact admin page

        //replace placeholders
        $template = str_replace('{{deactivation_reason}}', $reason, $template);
        $template = str_replace('{{year}}', date('Y'), $template);
        $template = str_replace('{{contact_admin_link}}', $contactLink, $template);

        $subject = "Account Deactivated";

        return self::sendEmail($toEmail, '', $subject, $template);
    }

    //send email to notify student that their account has been reactivated by admin
    public static function sendEmailAccountReactivatedByAdmin($toEmail, $reason)
    {
        //load template
        $template = file_get_contents(TEMPLATEROOT . DIRECTORY_SEPARATOR . 'emails' . DIRECTORY_SEPARATOR . 'acc_reactivate_admin.html');

        //replace placeholders
        $template = str_replace('{{year}}', date('Y'), $template);
        $template = str_replace('{{reactivation_reason}}', $reason, $template);

        $subject = "Account Reactivated";

        return self::sendEmail($toEmail, '', $subject, $template);
    }

    //send email to notify company that their job post has been approved
    public static function sendEmailJobApproved($toEmail, $toName, $title, $publishDate)
    {
        //load template
        $template = file_get_contents(TEMPLATEROOT . DIRECTORY_SEPARATOR .'emails' . DIRECTORY_SEPARATOR . 'job_approved.html');
        //create link
        $link = URLROOT . '/';//TODO: change to company dashboard page

        //replace placeholders
        $template = str_replace('{{dashboard_link}}', $link, $template);
        $template = str_replace('{{company_name}}', $toName, $template);
        $template = str_replace('{{year}}', date('Y'), $template);
        $template = str_replace('{{publish_date}}', $publishDate, $template);
        $template = str_replace('{{job_title}}', $title, $template); 

        $subject = "Job Post Approved";

        return self::sendEmail($toEmail, $toName, $subject, $template);
    }

    //send email to notify student that their job post has been rejected with reason
    public static function sendEmailJobRejected($toEmail, $toName, $title, $reason)
    {
        //load template
        $template = file_get_contents(TEMPLATEROOT . DIRECTORY_SEPARATOR . 'emails' . DIRECTORY_SEPARATOR . 'job_rejected.html');
        //create link
        $contactLink = URLROOT . '/contact';//TODO: change to contact admin page
        $editLink = URLROOT . '/register';//TODO: change to resubmit registration page

        //replace placeholders
        $template = str_replace('{{company_name}}', $toName, $template);
        $template = str_replace('{{rejection_reason}}', $reason, $template);
        $template = str_replace('{{year}}', date('Y'), $template);
        $template = str_replace('{{contact_admin_link}}', $contactLink, $template);
        $template = str_replace('{{edit_link}}', $editLink, $template);
        $template = str_replace('{{job_title}}', $title, $template);

        $subject = "Job Post Rejected";

        return self::sendEmail($toEmail, $toName, $subject, $template);
    }
}
