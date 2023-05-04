<?php
include('../includes/dbconnection.php');

$first_name = $_POST['first-name'];
$last_name = $_POST['last-name'];
$email = $_POST['email'];
$services = implode(', ', $_POST['services']);
$stylist = $_POST['stylist'];
$date = $_POST['date'];
$time = $_POST['time'];

/*// Check if stylist is available
$query = "SELECT COUNT(*) AS count FROM bookings WHERE stylist = '$stylist' AND date = '$date' AND time = '$time'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$count = $row['count'];
//var_dump($stylists); */

    $sql = "SELECT * FROM stylists";
    $result = mysqli_query($conn, $sql);
    
    while($row = mysqli_fetch_assoc($result)) {
        $stylist_id = $row['id'];
        $stylist_name = $row['name'];
        
        // Check if stylist is available
        $sql_check = "SELECT * FROM bookings WHERE stylist_id = $stylist_id AND booking_time = '$booking_time'";
        $result_check = mysqli_query($con, $sql_check);
        $available = mysqli_num_rows($result_check) == 0;
        
        if ($available) {
            echo "<option value=\"$stylist_id\">$stylist_name</option>";
        }
    }



if ($count > 0) {
    // Stylist is not available
    echo "Sorry, the selected stylist is already booked for the selected date and time. Please select a different stylist or a different date and time.";
} else {
    // Stylist is available, insert booking into database
    $query = "INSERT INTO bookings (first_name, last_name, email, service, stylist, date, time) VALUES ('$first_name', '$last_name', '$email', '$services', '$stylist', '$date', '$time')";
    mysqli_query($con, $query);

    // Send notification email to customer
    $to = $email;
    $subject = "Booking Confirmation";
    $message = "Thank you for booking with us. Your appointment is scheduled for $date at $time with $stylist for $services. We look forward to seeing you!";
    $headers = "From: Tausi Beauty Center ";
    mail($to, $subject, $message, $headers);

    // Display success message to customer
    echo "Thank you for booking with us. We have sent a confirmation email to $email.";
}
?>
