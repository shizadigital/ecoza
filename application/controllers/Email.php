<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function test() {
        $mail = new PHPMailer(); // create a new object
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail ssl:465 tls:587
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587 or 465
        $mail->IsHTML(true);
        $mail->Username = $_ENV['MAIL_EMAIL'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SetFrom($_ENV['MAIL_EMAIL']);
        $mail->Subject = "Test";
        $mail->Body = "hello";
        $mail->AddAddress($_ENV['MAIL_EMAIL']);

        
        if(!$mail->Send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message has been sent";
        }
    }
}