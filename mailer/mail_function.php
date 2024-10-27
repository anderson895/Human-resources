<?php
header('Access-Control-Allow-Origin: *');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpMailer/PHPMailer-master/src/Exception.php';
require 'phpMailer/PHPMailer-master/src/PHPMailer.php';
require 'phpMailer/PHPMailer-master/src/SMTP.php';
require 'phpMailer/crds.php';


function SendEmail($email_address,$password){
  
    $mail = new PHPMailer;

    // $mail->SMTPDebug = 4; 

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
        return $mail->ErrorInfo;
    } else {
        return "send";
    }
}

function SendEmailApplicant($email_address) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = EMAIL;
        $mail->Password   = PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom(EMAIL, 'CIFRA');
        $mail->addAddress($email_address, 'Applicant');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Application Received';
        $mail->Body    = "
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
                    <h2>Application Received</h2>
                </div>
                <div class='content'>
                    <p>Thank you for your application. We have received it successfully and will review it shortly.</p>
                    <p>Our HR team will get back to you soon.</p>
                </div>
                <div class='footer'>
                    <p>If you have any questions, please contact our <a href='mailto:".EMAIL."'>support team</a>.</p>
                </div>
            </div>
        </body>
        </html>
        ";

        $mail->send();
        return "send";
    } catch (Exception $e) {
        return "Mailer Error: " . $mail->ErrorInfo;
    }
}


function SendEmailPasswordChangeVerification($email_address, $verification_code) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = EMAIL;
        $mail->Password   = PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        // $mail->SMTPDebug  = 2; // Adjust debug level as needed

        // Recipients
        $mail->setFrom(EMAIL, 'CIFRA');
        $mail->addAddress($email_address, 'User');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Change Verification Code';
        $mail->Body    = "
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
                    background-color: #ff9800;
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
                .footer {
                    background-color: #f4f4f4;
                    color: #888888;
                    padding: 10px 0;
                    text-align: center;
                    border-bottom-left-radius: 8px;
                    border-bottom-right-radius: 8px;
                }
                .footer a {
                    color: #ff9800;
                    text-decoration: none;
                }
                .code {
                    font-size: 24px;
                    font-weight: bold;
                    margin-top: 20px;
                    color: #ff9800;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Password Change Verification</h2>
                </div>
                <div class='content'>
                    <p>To complete your password change, please use the following verification code:</p>
                    <p class='code'>".$verification_code."</p>
                    <p>If you did not request to change your password, please ignore this email or contact support.</p>
                </div>
                <div class='footer'>
                    <p>If you have any questions, please contact our <a href='mailto:".EMAIL."'>support team</a>.</p>
                </div>
            </div>
        </body>
        </html>
        ";

        $mail->send();
        return "send";
    } catch (Exception $e) {
        return "Mailer Error: " . $mail->ErrorInfo;
    }
}

function SendEmailApplicantStatus($email_address, $status, $password, $message = null) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = EMAIL;
        $mail->Password   = PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom(EMAIL, 'CIFRA');
        $mail->addAddress($email_address, 'Applicant');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Application Status Update';

        // Define status messages and colors
        $statusDetails = [
            'for review' => [
                'subject' => 'Application Status: For Review',
                'color'   => '#FFA500', // Orange
                'body'    => "<p>Your application is currently under review. We will get back to you once our team has had a chance to evaluate it.</p>"
            ],
            'for interview' => [
                'subject' => 'Application Status: For Interview',
                'color'   => '#4CAF50', // Green
                'body'    => "<p>Congratulations! Your application has been shortlisted for an interview. Our team will contact you shortly to schedule a convenient time.</p>"
            ],
            'for requirements' => [
                'subject' => 'Application Status: For Requirements',
                'color'   => '#FFC107', // Amber
                'body'    => "<p>We need additional information to proceed with your application. Please provide the requested documents as soon as possible.</p>"
            ],
            'for processing' => [
                'subject' => 'Application Status: For Processing',
                'color'   => '#2196F3', // Blue
                'body'    => "<p>Your application is currently being processed. We will update you with the next steps soon.</p>"
            ],
            'hired' => [
                'subject' => 'Application Status: Hired',
                'color'   => '#8BC34A', // Light Green
                'body'    => "
                <p>Congratulations!</p>
                <p>We are thrilled to inform you that you have been hired. Our HR team will reach out to you with further instructions shortly.</p>
                <p>In the meantime, you can log in to your account using the credentials provided below:</p>
                <p><strong>Temporary Password:</strong> {$password}</p>
                <p>Please note: For security reasons, do not share this password with anyone. You will be prompted to change it upon your first login.</p>
                <p>If you have any questions or need assistance, feel free to contact our support team.</p>
                <p>Welcome aboard!</p>
                "
            ],
            'declined' => [
                'subject' => 'Application Status: Declined',
                'color'   => '#F44336', // Red
                'body'    => "<p>We regret to inform you that your application has been declined. We appreciate your interest in our company and wish you the best in your job search.</p>"
            ]
        ];

        // Set the email body based on status
        if (array_key_exists($status, $statusDetails)) {
            $details = $statusDetails[$status];
            $optionalMessage = $message ? "<p>Note: {$message}</p>" : "";
            $mail->Body = "
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
                        background-color: {$details['color']};
                        color: #ffffff;
                        padding: 15px 0;
                        text-align: center;
                        border-top-left-radius: 8px;
                        border-top-right-radius: 8px;
                        font-size: 24px;
                        font-weight: bold;
                    }
                    .content {
                        padding: 30px;
                        text-align: left;
                        line-height: 1.6;
                    }
                    .content p {
                        margin-bottom: 15px;
                    }
                    .footer {
                        background-color: #f4f4f4;
                        color: #888888;
                        padding: 20px;
                        text-align: center;
                        border-bottom-left-radius: 8px;
                        border-bottom-right-radius: 8px;
                    }
                    .footer a {
                        color: {$details['color']};
                        text-decoration: none;
                        font-weight: bold;
                    }
                    .button {
                        display: inline-block;
                        padding: 10px 20px;
                        margin-top: 20px;
                        background-color: {$details['color']};
                        color: #ffffff;
                        text-decoration: none;
                        border-radius: 5px;
                        font-weight: bold;
                        text-align: center;
                    }
                    .button:hover {
                        background-color: darken({$details['color']}, 10%);
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        {$details['subject']}
                    </div>
                    <div class='content'>
                        {$details['body']}
                        {$optionalMessage}
                    </div>
                    <div class='footer'>
                        <p>If you have any questions, please contact our <a href='mailto:" . EMAIL . "'>support team</a>.</p>
                    </div>
                </div>
            </body>
            </html>
            ";
        } else {
            // Handle unexpected status
            $mail->Body = "<p>Invalid application status.</p>";
        }

        $mail->send();
        return "send";
    } catch (Exception $e) {
        return "Mailer Error: " . $mail->ErrorInfo;
    }
}






function SendEmailLeaveRequestStatus($email_address, $status, $leaveDetails) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = EMAIL;
        $mail->Password   = PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom(EMAIL, 'CIFRA');
        $mail->addAddress($email_address, 'Employee');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Leave Request Status Update';

        // Define leave request status messages and colors
        $statusDetails = [
            'accepted' => [
                'subject' => 'Leave Request Status: Approved',
                'color'   => '#4CAF50', // Green
                'body'    => "<p>Congratulations! Your leave request has been approved. Enjoy your time off!</p>"
            ],
            'rejected' => [
                'subject' => 'Leave Request Status: Rejected',
                'color'   => '#F44336', // Red
                'body'    => "<p>We regret to inform you that your leave request has been rejected. If you have any questions, please contact HR.</p>"
            ],
        ];

        // Set the email body based on status
        if (array_key_exists($status, $statusDetails)) {
            $details = $statusDetails[$status];
            $mail->Body = "
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
                        background-color: {$details['color']};
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
                    .footer {
                        background-color: #f4f4f4;
                        color: #888888;
                        padding: 10px 0;
                        text-align: center;
                        border-bottom-left-radius: 8px;
                        border-bottom-right-radius: 8px;
                    }
                    .footer a {
                        color: {$details['color']};
                        text-decoration: none;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>{$details['subject']}</h2>
                    </div>
                    <div class='content'>
                        {$details['body']}
                    </div>
                    <div class='footer'>
                        <p>If you have any questions, please contact our <a href='mailto:".EMAIL."'>HR team</a>.</p>
                    </div>
                </div>
            </body>
            </html>
            ";
        } else {
            // Handle unexpected status
            $mail->Body = "<p>Invalid leave request status.</p>";
        }

        $mail->send();
        return "send";
    } catch (Exception $e) {
        return "Mailer Error: " . $mail->ErrorInfo;
    }
}
