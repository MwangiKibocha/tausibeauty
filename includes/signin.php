<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include('dbconnection.php');
//include("header.php");

session_start();

//error_reporting(0);

if (isset($_SESSION['username'])) {
    //header("location: ../template");
}

if (isset($_POST['submit'])) {
    $username = $_POST['uname'];
    $password = md5($_POST['psw']);
    $email = $_POST['email'];
    $verification_code = $_POST['code'];

    // Verify the verification code
    if ($verification_code !== $_SESSION['verification_code']) {
        echo "<script>alert('Woops! Verification code is wrong.')</script>";
    } else {
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($con, $sql);
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $row['username'];
            header("location: ../main/index.php");
        } else {
            echo "<script>alert('Woops! Username or password is wrong.')</script>";
        }
    }
}

if (isset($_POST['generate_code'])) {
    $email = $_POST['email'];
    $verification_code = rand(100000, 999999);

     // Send email
     $mail = new PHPMailer(true);
     try {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'vinmwangi39@gmail.com';
        $mail->Password = 'ziqyevifolwxpllz';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('vinmwangi39@gmail.com', 'Tausi beauty');
        $mail->addAddress($email, ); // Add a recipient
        $mail->addReplyTo('vinmwangi39l@gmail.com', 'Reply Address');
     
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Verification Code';
        $mail->Body    = 'Hi '.$email.',<br><br>
        Enter this Verification code <strong> $verification_code to login </strong>
        Tausi Beauty';
        $mail->AltBody = 'This is the plain text version of the email content.';
     
        $mail->send();
        echo ' email sent to '.$email;
     } catch (Exception $e) {
        echo 'Message could not be sent. Error: ', $mail->ErrorInfo;
     }
     
    $_SESSION['verification_code'] = $verification_code;
}

?>

<body>

<h2 align="center">Login Form</h2>

<form action="" method="post">

  <div class="container" align="center"><br><br>
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" id="uname" name="uname" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" id="psw" name="psw" required><br><br>
    <label for="email"><b>Email Address</b></label>
    <input type="email" placeholder="Enter Email" id="email" name="email" required>

    <button type="submit" name="generate_code">Generate Code</button><br><br>

    <label for="code"><b>Verification Code</b></label>
    <input type="text" placeholder="Enter Code" id="code" name="code" required><br><br>

    <button type="submit" name="submit">Login</button>
    <br><br>
    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
  </div>

  <div class="container signin">
    <p>Don't have an account? <a href="register.php">Sign up</a>.</p>
    <p>Admin? Login in Here <a href="../admin_login/admin_login.php">Admin login</a>.</p>
  </div>

</form>
