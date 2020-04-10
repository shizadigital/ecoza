<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PhpMailer {

    public function __construct() {
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load() {
        require_once('phpmailer/PHPMailerAutoload.php');

        $mail = new PHPMailer;
        return $mail;
    }
}
