<?php 

include('dbconnection.php');
//include("header.php");

session_start();

//error_reporting(0);

if (isset($_SESSION['username'])) {
    //header("location: ../template");
}

if (isset($_POST['submit'])) {
	$stylist_name = $_POST['username'];
	$stylist_email =$_POST['email'];

  $_SESSION['uid'] = $stylist_name;

	$sql = "SELECT * FROM stylists WHERE stylist_name='$stylist_name' AND stylist_email='$stylist_email'";
	$result = mysqli_query($con, $sql);
	if ($result->num_rows > 0) {
		$row = mysqli_fetch_assoc($result);
		//$_SESSION['username'] = $row['username'];
		header("location: ../main/stylist.php");
	} else {
		echo "<script>alert('Woops! username or Password is Wrong.')</script>";
	}
}

if (isset($_POST['submit'])) {
	$username2 = $_POST['username'];
	$password2 = md5($_POST['psw']);

	$sql2 = "SELECT * FROM admin WHERE Username='$username2' AND Password='$password2'";
	$result2 = mysqli_query($con, $sql2);
	if ($result2->num_rows > 0) {
		$row2 = mysqli_fetch_assoc($result2);
		$_SESSION['username'] = $row2['username'];
		header("location: ../admin/dashboard.php");
	} else {
		echo "<script>alert('Woops! username or Password is Wrong.')</script>";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
  
<!--meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">

    <title>Klassy Cafe - Restaurant HTML Template</title>
<--
    
TemplateMo 558 Klassy Cafe

https://templatemo.com/tm-558-klassy-cafe

--
    -- Additional CSS Files --
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">

    <link rel="stylesheet" href="assets/css/templatemo-klassy-cafe.css">

    <link rel="stylesheet" href="assets/css/owl-carousel.css">

    <link rel="stylesheet" href="assets/css/lightbox.css">-->


<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tausi Beauty</title>

<style>
body {font-family: Arial, Helvetica, sans-serif;}
form {border: 3px solid #f1f1f1;}

input[type=text], input[type=password] {
  width: 50%;
  padding: 12px 20px;
  margin: 8px 0;
  display: flex;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color: #04AA6D;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 10%;
}

button:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

img.avatar {
  width: 40%;
  border-radius: 50%;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* Set a grey background color and center the text of the "sign in" section */
.signin {
  background-color: #f1f1f1;
  text-align: center;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}

</style>
</head>
<body>

<h2 >Login Form</h2>

<form action="" method="post">

  <div class="container" ><br><br>
    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Stylist Name" id="username" name="username" required>

    <label for="email"><b>Email Address</b></label>
<input type="email" placeholder="Enter Email Address" id="email" name="email" required><br><br>

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


</body>
</html>
