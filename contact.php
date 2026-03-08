<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlspecialchars(strip_tags(trim($_POST['name'])));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(strip_tags(trim($_POST['subject'])));
    $message = htmlspecialchars(strip_tags(trim($_POST['message'])));

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        die("Please fill out all fields.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Please enter a valid email address.");
    }

    $mail = new PHPMailer(true);

    try {

        // SMTP SETTINGS
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'surgedigitalhq@gmail.com';
        $mail->Password   = 'zheycxxmbtqolgha'; // Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // SEND TO YOU
        $mail->setFrom('surgedigitalhq@gmail.com', 'SURGE Website');
        $mail->addAddress('surge.official.001@gmail.com', 'SURGE Team');
        $mail->addReplyTo($email, $name);

        $mail->isHTML(true);
        $mail->Subject = 'New Website Inquiry: ' . $subject;

        $mailBody = "
        <h3>New Contact Request from SURGE Website</h3>

        <p><strong>Name:</strong> {$name}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Subject:</strong> {$subject}</p>

        <p><strong>Message:</strong><br>{$message}</p>
        ";

        $mail->Body = $mailBody;
        $mail->AltBody = strip_tags($mailBody);

        $mail->send();


        // THANK YOU EMAIL TO CLIENT
        $thankMail = new PHPMailer(true);

        $thankMail->isSMTP();
        $thankMail->Host = 'smtp.gmail.com';
        $thankMail->SMTPAuth = true;
        $thankMail->Username = 'surgedigitalhq@gmail.com';
        $thankMail->Password = 'zheycxxmbtqolgha';
        $thankMail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $thankMail->Port = 587;

        $thankMail->setFrom('surgedigitalhq@gmail.com', 'SURGE Team');
        $thankMail->addAddress($email, $name);

        $thankMail->isHTML(true);
        $thankMail->Subject = "Thank You for Contacting SURGE";

        $thankBody = "

        <h2>Hi {$name},</h2>

        <p>Thank you for reaching out to <strong>SURGE</strong>.</p>

        <p>We received your message and our team will get back to you shortly.</p>

        <p>Best Regards,<br>SURGE Team</p>

        ";

        $thankMail->Body = $thankBody;
        $thankMail->AltBody = strip_tags($thankBody);

        $thankMail->send();


        header("Location: index.html?status=success#contact");
        exit();

    } catch (Exception $e) {

        echo "Mailer Error: {$mail->ErrorInfo}";
    }

} else {

    header("Location: index.html");
    exit();
}