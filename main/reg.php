<?php 
session_start();
include('../main/connn.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if user is already logged in
if (isset($_SESSION['username'])) {
    //header("location: ../template");
}

if (isset($_SESSION['submit'])) {
    //header("location: login.php");
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $verification_code = $_POST['verification_code'];
    
     // Check if the verification code is correct
     if (!isset($_SESSION['verification_code'])) {
        echo "<script>alert('Verification code is not set.')</script>";
    } else if ($_SESSION['verification_code'] != $verification_code) {
        echo "<script>alert('Verification code is incorrect.')</script>";
     } else {
        // Validate password
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);

        if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
            echo "<script>alert('Password should be at least 8 characters in length and should include at least one upper case letter and one number.')</script>";
        } else if ($password != $cpassword) {
            echo "<script>alert('Password and Confirm Password do not match.')</script>";
        } else {
            $password = md5($password);
            $cpassword = md5($cpassword);

            $sql = "SELECT * FROM users WHERE email='$email'";
            $result = mysqli_query($con, $sql);

            if (!mysqli_num_rows($result) > 0) {
                $sql1 = "INSERT INTO users (username, email, password, cpassword)
                        VALUES ('$username', '$email', '$password','$cpassword')";
                $result = mysqli_query($con, $sql1)or die("Can't Insert".mysqli_error($con));
                if ($result) {
                    echo "<script>alert('Wow! User Registration Completed.')</script>";
                    header("location: ./signin.php");
                    $username = "";
                    $email = "";
                    $_POST['password'] = "";
                    $_POST['cpassword'] = "";
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
        $mail->Subject = 'Welcome to Tausi Beauty';
        $mail->Body = 'Hi '.$first_name.',<br><br>
        Thank you for registering with us. Sign in and let us style you. We look forward to working with you.<br><br>
        If you have any questions or concerns, please don\'t hesitate to reach out to us.<br><br>
        Best regards,<br>
        Tausi Beauty';
         $mail->send();
        echo 'Register Success sent to '.$email;
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
                } else {
                    echo "<script>alert('Woops! Something Wrong Went.')</script>";
                }
            } else {
                echo "<script>alert('Woops! Email Already Exists.')</script>";
            }
        }
    }
}
?>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
 <style>
    body {
    background-color: rgb(253, 229, 255);
        font-family: Arial, sans-serif;
        margin-top: 0%;
    }
    h1 {
        text-align: center;
        color: #333;
        margin-top: 0px;
    }
    form {
        background-color: #fff;
        width: 400px;
        margin: 0 auto;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px #ccc;
    }
    label {
        display: block;
        margin-bottom: 05px;
        color: #333;
    }
    input[type="text"],
    input[type="password"],
    input[type="email"],
    input[type="submit"],
    button {
        display: block;
        width: 100%;
        margin-bottom: 20px;
        padding: 10px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
    }
    input[type="text"],
    input[type="password"],
    input[type="email"],
    input[type="submit"] {
        background-color: #f2f2f2;
        color: #333;
    }
    button {
        background-color: #3b5998;
        color: #fff;
        cursor: pointer;
    }
    input[type="text"]:focus,
    input[type="password"]:focus,
    input[type="email"]:focus,
    button:focus {
        outline: none;
    }
.password-input-container {
  position: relative;
}

.password-toggle-icon {
  position:absolute;
  top: 70%;
  right: 5px;
  transform: translateY(-50%);
  cursor: pointer;
}
.error {
  position: absolute;
  top: 50%;
  right: 5px;
  transform: translateY(-50%);
  color: red;
  font-size: 12px;
}


  </style>
<form action="" method="post">
    <div class="container">
        <h1>Register</h1>
        <p>Please fill in this form to create an account.</p>
        <hr>

        <label for="username"><b>Username</b></label><br>
        <input type="text" placeholder="Enter Username" name="username" id="username" required>

        <label for="email"><b>Email</b></label><br>
    <input type="email" placeholder="Enter Email" name="email" id="email" required>
    <button type="button" onclick="sendVerificationCode()">Send Verification Code</button>
    <br>
    <label for="verification_code"><b>Verification Code</b></label><br>
    <input type="text" placeholder="Enter Verification Code" name="verification_code" id="verification_code" required>
    <br>

    <div class="password-input-container">
  <label for="password"><b>Password</b></label><br>
  <input type="password" placeholder="Enter Password" name="password" id="password" required>
  <span id="password-error" class="error"></span>
  <i class="fa fa-eye password-toggle-icon toggle-password" aria-hidden="true" toggle="#password"></i>
</div>
<div class="password-input-container">
  <label for="cpassword"><b>Confirm Password</b></label><br>
  <input type="password" placeholder="Confirm Password" name="cpassword" id="cpassword" required minlength="8" pattern="^(?=.*[A-Z])(?=.*[0-9]).{8,}$">
  <i class="fa fa-eye password-toggle-icon toggle-password" aria-hidden="true" toggle="#cpassword"></i>
  <span id="divCheckPasswordMatch" class="error"></span>
</div>


    <button type="submit" name="submit" class="registerbtn" id="submit">Register</button>
    <div class="container signin">
      <p>Already have an account? <a href="signin.php">Sign in</a>.</p>
    </div>
  </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  // Function to toggle password visibility
  $(document).on('click', '.toggle-password', function() {
    $(this).toggleClass('eye-slash');
    var input = $($(this).attr('toggle'));
    if (input.attr('type') == 'password') {
      input.attr('type', 'text');
    } else {
      input.attr('type', 'password');
    }
  });

  // Function to check if password and confirm password match
  function checkPasswordMatch() {
    var password = $("#password").val();
    var confirmPassword = $("#cpassword").val();
    if (password != confirmPassword) {
  $("#divCheckPasswordMatch").html("Passwords do not match!");
  $("#submit").attr("disabled", true);
  $("#submit").css("background-color", "gray");
  $("#submit").val("Cancel");
} else {
  $("#divCheckPasswordMatch").html("");
  $("#submit").attr("disabled", false);
  $("#submit").css("background-color", ""); // reset to default color
  $("#submit").val("Submit"); // reset to default text
}
  }

  $(document).ready(function() {
    $("#cpassword").keyup(checkPasswordMatch);
  });

  function sendVerificationCode() {
    var email = $('#email').val();
    if (email.trim() === '') {
        alert('Please enter your email address.');
        return;
    }
    $.ajax({
        url: '../main/send_verification_email.php',
        method: 'POST',
        data: {email: email},
        success: function(response) {
            alert('Verification code sent to your email. Please check your inbox and enter the code.');
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error sending verification code: ' + errorThrown);
        }
    });
}
const passwordInput = document.getElementById("password");
const passwordError = document.getElementById("password-error");
passwordInput.addEventListener("input", () => {
  const passwordValue = passwordInput.value;

  if (passwordValue.length < 8) {
    passwordError.textContent = "Password must be at least 8 characters long";
  } else if (!/\d/.test(passwordValue)) {
    passwordError.textContent = "Password must contain at least one number";
  } else if (!/[A-Z]/.test(passwordValue)) {
    passwordError.textContent = "Password must contain at least one uppercase letter";
  } else {
    passwordError.textContent = "";
  }
});
</script>

