<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  
  require 'vendor/autoload.php';

// get the email and verification code from the AJAX request
$email = $_POST['email'];
$code = $_POST['code'];

// send the verification code to the email using PHPMailer
$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->SMTPDebug = 0;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'vinmwangi39@gmail.com';                     // SMTP username
    $mail->Password   = 'ziqyevifolwxpllz';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('vinmwangi39@gmail.com', 'Your Name');
    $mail->addAddress($email);     // Add a recipient

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Verification Code';
    $mail->Body    = 'Tausi Beauty. Your verification code is: ' . $code  ;

    $mail->send();
    echo 'Verification code sent successfully';
} catch (Exception $e) {
    echo "Verification code could not be sent. Error message: {$mail->ErrorInfo}";
}
?>
