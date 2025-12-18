<?php

require_once 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendors/PHPMailer/src/Exception.php';
require 'vendors/PHPMailer/src/PHPMailer.php';
require 'vendors/PHPMailer/src/SMTP.php';


function sendEmail($to, $subject, $message, $is_html = true)
{
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    $success = true;

    try {
        //Server settings
        $mail->SMTPDebug = false;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = SMTP_HOST;                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = SMTP_USERNAME;                     //SMTP username
        $mail->Password = SMTP_PASS;                               //SMTP password
        $mail->Port = SMTP_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->Mailer = 'smtp';
        //        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        //Recipients
        $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        $mail->addAddress($to);
//        $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
//        $mail->addAddress('ellen@example.com');               //Name is optional
//        $mail->addReplyTo('info@example.com', 'Information');
//        $mail->addCC('cc@example.com');
//        $mail->addBCC('bcc@example.com');

        //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML($is_html);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $message;
//        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        $response = 'Message has been sent';
    } catch (Exception $e) {
        $response = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        $success = false;

    }

    return ['success'=>$success,'response'=> $response];
}