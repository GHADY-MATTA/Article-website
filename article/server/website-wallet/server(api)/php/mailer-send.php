<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

function sendWelcomeEmail($username, $email)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'empty6266@gmail.com';
        $mail->Password = 'bokrtvmjfzfajqar'; // Use an App Password here
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Email Settings
        $mail->setFrom('empty6266@gmail.com');
        $mail->addAddress($email);
        $mail->isHTML(true);

        // Email content
        $mail->Subject = "Welcome, $username!";
        $mail->Body = "Hi $username,<br><br>Thanks for signing up! We're excited to have you on board.";

        // Send email
        $mail->send();
    } catch (Exception $e) {
        error_log("Email failed: {$mail->ErrorInfo}");
    }
}
