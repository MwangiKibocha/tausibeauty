<?php
// Include the database connection file
require_once 'connn.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Initialize the session
session_start();

// Check if the user is logged in, if yes then redirect him to home page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: home.php");
    exit;
}

// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate new password
    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "Please enter the new password.";
    } elseif (strlen(trim($_POST["new_password"])) < 8) {
        $new_password_err = "Password must have at least 8 characters.";
    } else {
        $new_password = trim($_POST["new_password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm the password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before updating the password in the database
    if (empty($new_password_err) && empty($confirm_password_err)) {
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";

        if ($stmt = $con->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("si", $param_password, $param_id);

            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();

                // Create a new PHPMailer instance
                $mail = new PHPMailer(true);

                try {
                    // Set up SMTP
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'vinmwangi39@gmail.com';
                    $mail->Password = 'ziqyevifolwxpllz';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    // Set up the email details
                    $mail->setFrom('vinmwangi39@gmail.com', 'Tausi Beauty');
                    $mail->addAddress($_SESSION["email"], $_SESSION["name"]);
                    $mail->Subject = 'Your password has been reset';
                    $mail->Body = "Hello " . $_SESSION["name"] . ",\n\nYour password has been reset successfully.";

                    // Send the email
                    $mail->send();

                    // Email sent successfully. Redirect to the login page with a success message
                    header("location: login.php?reset=success");
                    exit;
                } catch (Exception $e) {
                    // Email failed to send. Redirect to the login page with an error message
                    $email_err = "Email could not be sent. Please try again later.";
                }
            }
        }
    }
}
?>