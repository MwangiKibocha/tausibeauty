<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  
  require 'vendor/autoload.php';

    include('connn.php');
    session_start();

    $first_name = ($_POST["first_name"]);
    $last_name = ($_POST["last_name"]);
    $email = ($_POST["email"]);
    $phone_number = ($_POST["phone_number"]);
    $booking_date = ($_POST["booking_date"]);
    $booking_time = ($_POST["booking_time"]);
    $services = ($_POST["services"]);
    $stylists = ($_POST["stylists"]);
  


// Connect to MySQL database

// Check if form submitted
if (isset($_POST['submit'])) {
    // Sanitize input data

    $booking_time = mysqli_real_escape_string($con, $_POST['booking_time']);
    $stylists = mysqli_real_escape_string($con, $_POST['stylists']);
    $booking_date = mysqli_real_escape_string($con, $_POST['booking_date']);

    // Check if record already exists
    $sql = "SELECT * FROM bookings WHERE booking_time='$booking_time' AND booking_date='$booking_date' AND stylists='$stylists'";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
      echo '<script>alert("STYLIST IS ALREADY BOOKED SELECT OTHER TIME SLOT OR OTHER STYLIST");</script>';

        
    } else {
  
        $sql = "INSERT INTO bookings (first_name, last_name, email, phone_number, booking_date, booking_time, services, stylists, status) VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$booking_date', '$booking_time', '$services', '$stylists', 'scheduled')";
        $query=mysqli_query($con,$sql);
    
        // Redirect to success page
        echo '<script>alert("BOOKING SUCCESSFUL. Check email for details"); window.location.href = "index.php"</script>';
        
    }
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
   $mail->addAddress($email, $first_name.' '.$last_name); // Add a recipient
   $mail->addReplyTo('vinmwangi39l@gmail.com', 'Reply Address');

   //Content
   $mail->isHTML(true);                                  // Set email format to HTML
   $mail->Subject = 'Booking Confirmation';
   $mail->Body    = 'Hi '.$first_name.',<br><br>
   Thank you for booking an appointment with us. Below are the details of your booking:<br><br>
   <strong>Booking Date:</strong> '.$booking_date.'<br>
   <strong>Booking Time:</strong> '.$booking_time.'<br>
   <strong>Services:</strong> '.$services.'<br>
   <strong>Stylist:</strong> '.$stylists.'<br><br>
   If you have any questions or concerns, please don\'t hesitate to reach out to us.<br><br>
   Best regards,<br>
   Tausi Beauty';
   $mail->AltBody = 'This is the plain text version of the email content.';

   $mail->send();
   echo 'Booking confirmation email sent to '.$email;
} catch (Exception $e) {
   echo 'Message could not be sent. Error: ', $mail->ErrorInfo;
}


}
mysqli_close($con);
?>
