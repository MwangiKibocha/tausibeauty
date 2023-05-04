<?php

session_start();
//error_reporting(0);
include('includes/dbconnection.php');
/*if (strlen($_SESSION['sid']==0)) {
  //header('location:logout.php');
}*/ 

// get the appointment ID from the URL parameter
$id = $_GET['id'];

// update the appointment status in the database
$query = "UPDATE bookings SET status='cancelled' WHERE id=" . $id;
mysqli_query($con, $query);

// redirect back to the appointments page
header("Location: all_appointments.php");
exit();
?>
