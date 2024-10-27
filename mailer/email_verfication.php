<?php
header('Access-Control-Allow-Origin: *');
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpMailer/PHPMailer-master/src/Exception.php';
require 'phpMailer/PHPMailer-master/src/PHPMailer.php';
require 'phpMailer/PHPMailer-master/src/SMTP.php';
require 'phpMailer/crds.php';

$mail = new PHPMailer;

$mail->SMTPDebug = 4; 

$mail->isSMTP();
$mail->SMTPSecure = 'tls';
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = EMAIL;
$mail->Password = PASS;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
$mail->Port = 465;
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
// if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    // $email_address = "mr.ephraiel@gmail.com";
    // $password = "123123123";

    $mail->setFrom(EMAIL, 'CIFRA');
    $mail->addAddress($email_address, 'Employee Credentials');

    $mail->isHTML(true);

    $mail->Subject = 'Employee Credentials';
    $message = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 600px;
                margin: 20px auto;
                background-color: #ffffff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .header {
                background-color: #4caf50;
                color: #ffffff;
                padding: 10px 0;
                text-align: center;
                border-top-left-radius: 8px;
                border-top-right-radius: 8px;
            }
            .content {
                padding: 20px;
                text-align: center;
            }
            .otp-code {
                font-size: 24px;
                font-weight: bold;
                color: #333333;
                margin: 20px 0;
            }
            .footer {
                background-color: #f4f4f4;
                color: #888888;
                padding: 10px 0;
                text-align: center;
                border-bottom-left-radius: 8px;
                border-bottom-right-radius: 8px;
            }
            .footer a {
                color: #4caf50;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>Temporary Password</h2>
            </div>
            <div class='content'>
                <p>DO NOT SHARE YOUR Temporary Password.</p>
                <p>Your Temporary Password is:</p>
                <div class='otp-code'>$password</div>
            </div>
            <div class='footer'>
                <p>If you have any questions, please contact our <a href='mailto:".EMAIL."'>support team</a>.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    $mail->Body    = $message;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if (!$mail->send()) {
        //echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo "send";
    }
// }
