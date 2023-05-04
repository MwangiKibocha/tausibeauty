<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include('connn.php');

// Check if the email was submitted
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    
    // Generate a random verification code
    $verification_code = rand(100000, 999999);
    
    // Store the verification code in a session variable
    $_SESSION['verification_code'] = $verification_code;
    
    // Send the verification code to the user's email address
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = 'vinmwangi39@gmail.com';
        $mail->Password = 'ziqyevifolwxpllz';
        $mail->setFrom('vinmwangi39@gmail.com', 'Tausi Beauty');
        $mail->addAddress($email);
        $mail->Subject = 'Verification Code';
        $mail->Body = 'Your verification code is: ' . $verification_code;
        $mail->send();
        echo 'Verification code sent to '.$email;
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
}
mysqli_close($con);
?>