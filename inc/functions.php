<?php
//php mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//simpleimage
require_once('lib/simpleImage.php');
// php mailer 
function sendEmail($email, $name = '', $title, $message, $message_alt, $email_reply = '', $name_reply = '', $file = '') {
        require 'lib/PHPMailer/src/Exception.php';
        require 'lib/PHPMailer/src/PHPMailer.php';
        require 'lib/PHPMailer/src/SMTP.php';
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            // Send using SMTP
            $mail->CharSet = 'utf-8';
            $mail->isSMTP();
            $mail->Host       = 'smtp.mail.ru';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'hov97hov@bk.ru';                     // SMTP username
            $mail->Password   = '095647576..';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('hov97hov@bk.ru', 'Login');
            $mail->addAddress($email, $name);     // Add a recipient
            // Reply
            if ($email_reply != '' && $name_reply != '') {
               $mail->addReplyTo($email_reply, $name_reply);
            }
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            // Attachments
            if(!empty($file)) {
               if(isset($file['tmp_name'])) {
                   $mail->AddAttachment($file['tmp_name'], $file['name']);
               } else {
                   $mail->AddStringAttachment($file["body"], $file["name"], 'base64', 'application/octet-stream');
               }
            }

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $title;
            $mail->Body    = $message;
            $mail->AltBody = $message_alt;

            return $mail->send();
        } catch (Exception $e) {
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

// secure post/get data
function checkVariable($value) {
    if(is_array($value)) {
        return array_map(function($item) {
            return checkVariable($item);
        }, $value);
    } else {
        $item = trim($value);
        $item = htmlspecialchars($item, ENT_QUOTES, 'UTF-8');
        return $item;
    }
}

// password generator
function passwordGenerator($count) {
   $mixer = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%*_-+=";
   $pwd = substr(str_shuffle($mixer), 0, $count);
   return $pwd;
}
?>