<?php
require_once 'connn.php';
//require_once 'PHPMailer/PHPMailer.php';
//require_once 'PHPMailer/SMTP.php';
//require_once 'PHPMailer/Exception.php';

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(20));

    $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt = $con->prepare("UPDATE users SET token = ? WHERE email = ?");
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF; //Enable verbose debug output
            $mail->isSMTP(); //Send using SMTP
            $mail->Host       = 'smtp.gmail.com'; //Set the SMTP server to send through
            $mail->SMTPAuth   = true; //Enable SMTP authentication
            $mail->Username   = 'vinmwangi39@gmail.com'; //SMTP username
            $mail->Password   = 'ziqyevifolwxpllz'; //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587; //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('vinmwangi39@gmail.com', 'Tausi Beauty');
            $mail->addAddress($email); //Add a recipient
            $mail->addReplyTo('vinmwangi39@gmail.com', 'Tausi Beauty');

            //Content
            $mail->isHTML(true); //Set email format to HTML
            $mail->Subject = 'Reset Password';
            $mail->Body    = "Please click on this link to reset your password: <a href='http://localhost/tausi/main/reset_password.php?email=$email&token=$token'>http://localhost/tausi/main/reset_password.php?email=$email&token=$token</a>";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo '<script>alert("Check email for a password reset link"); window.location.href = "signin.php"</script>';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    } else {
        echo "<script>alert('Email not found.')</script>";
    }
}
?>
