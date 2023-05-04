<?php
session_start();
include('connn.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if user is already logged in
if (isset($_SESSION['username'])) {
  // header("location: ../template");
}



// Check if cookies exist and log user in automatically
if (isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
  $username = $_COOKIE['username'];
  $password = $_COOKIE['password'];

  // Check if the username and password match
  $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = mysqli_query($con, $sql);

  if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['username'] = $row['username'];
    header("location: ../main/index.php");
  }
}


// Check if the form was submitted
if (isset($_POST['login'])) {
  // Get the submitted values
  $username = $_POST['username'];
  $password = md5($_POST['password']);
  $email = $_POST['email'];
  $verification_code = $_POST['verification_code'];

  $_SESSION['uid'] = $email;
  // Get the submitted password value
  $password = md5($_POST['password']);

  // Check if the password meets the requirements
  if (strlen($password) < 8 || !preg_match("#[0-9]+#", $password) || !preg_match("#[A-Z]+#", $password)) {
    echo "<script>alert('Password must be at least 8 characters long and contain at least 1 number and 1 uppercase letter.')</script>";
  } else {
    // Proceed with the login process
  }


  // Check if the verification code is correct
  if ($_SESSION['verification_code'] != $verification_code) {
    echo "<script>alert('Verification code is incorrect.')</script>";
  } else {
    // Check if the username and password match
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($con, $sql);
    if ($result->num_rows > 0) {
      $row = mysqli_fetch_assoc($result);
      $_SESSION['username'] = $row['username'];
      if (isset($_POST['remember_me'])) {
        // Set cookie to remember user
        setcookie('username', $row['username'], time() + (30 * 24 * 60 * 60)); // Expires in 30 days
        setcookie('password', $row['password'], time() + (30 * 24 * 60 * 60)); // Expires in 30 days
      }
      header("location: ../main/index.php");
    } else {
      echo "<script>alert('Woops! username or Password is Wrong.')</script>";
    }
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Login Page</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
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
      margin-bottom: 10px;
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
  top: 50%;
  right: 5px;
  transform: translateY(-50%);
  cursor: pointer;
}
.error {
  position: absolute;
  top: 0%;
  right: 5px;
  transform: translateY(-50%);
  color: red;
  font-size: 12px;
}

  </style>

  <h1>Login Page</h1>
  <form action="" method="post">
    <label>Username:</label>
    <input type="text" name="username" required>
    <br>
    <div class="password-input-container">
      <input type="password" id="password" name="password" required>
      <span id="password-error" class="error"></span>
      <i class="fa fa-eye password-toggle-icon" onclick="togglePassword()" aria-hidden="true"></i>
    </div>

    <br>
    <label>Email:</label>
    <input type="email" name="email" id="email" required>
    <button type="button" onclick="sendVerificationCode()">Send Verification Code</button>
    <br>
    <label>Verification Code:</label>
    <input type="text" name="verification_code" id="verification_code" required>
    <br>
    <label>
      <input type="checkbox" name="remember_me">
      Remember Me
    </label>

    <button type="submit" name="login" value="Login"> Login </button>
    <div class="mt-3">
      <a href="forgot.html">Forgot password?</a>
    </div>
    <p>New Here? Sign up <a href="reg.php">Register</a>.</p>
    <p>Admin? Login in Here <a href="../admin_login/admin_login.php">Admin login</a>.</p>
  </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    function sendVerificationCode() {
      var email = $('#email').val();
      if (email.trim() === '') {
        alert('Please enter your email address.');
        return;
      }
      $.ajax({
        url: 'send_verification_email.php',
        method: 'POST',
        data: {
          email: email
        },
        success: function(response) {
          alert('Verification code sent to your email. Please check your inbox and enter the code.');
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('Error sending verification code: ' + errorThrown);
        }
      });
    }

    function togglePassword() {
      var passwordInput = document.getElementById("password");
      var passwordToggleIcon = document.querySelector(".password-toggle-icon");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        passwordToggleIcon.classList.remove("fa-eye");
        passwordToggleIcon.classList.add("fa-eye-slash");
      } else {
        passwordInput.type = "password";
        passwordToggleIcon.classList.remove("fa-eye-slash");
        passwordToggleIcon.classList.add("fa-eye");
      }
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
</body>

</html>