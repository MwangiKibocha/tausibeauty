<?php

include('connn.php');
session_start();
/*if (strlen($_SESSION['sid']==0)) {
  //header('location:logout.php');
}*/

// get the appointment ID from the URL parameter
$id = $_GET['id'];

// check the current status of the appointment
$status_query = "SELECT Status FROM bookings WHERE id=" . $id;
$status_result = mysqli_query($con, $status_query);
$status_row = mysqli_fetch_assoc($status_result);
$current_status = $status_row['Status'];

// update the appointment status in the database
if ($current_status == 'scheduled') {
    $query = "UPDATE bookings SET status='cancelled' WHERE id=" . $id;
} elseif ($current_status == 'cancelled') {
    $query = "UPDATE bookings SET status='scheduled' WHERE id=" . $id;
}
mysqli_query($con, $query);

// redirect back to the appointments page
header("Location: view_bookings.php");
exit();
?>
