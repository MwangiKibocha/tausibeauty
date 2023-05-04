<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // get form inputs
  $first_name = test_input($_POST["first_name"]);
  $last_name = test_input($_POST["last_name"]);
  $email = test_input($_POST["email"]);
  $phone_number = test_input($_POST["phone_number"]);
  $date = test_input($_POST["date"]);
  $time = test_input($_POST["time"]);
  $services = $_POST["services"];
  $stylist = test_input($_POST["stylist"]);

  // check if selected date is not in the past
  $today = date("Y-m-d");
  if ($date < $today) {
    echo "<div class='error'>Selected date is in the past.</div>";
    exit();
  }

  // calculate total cost and time
  $total_cost = 0;
  $total_time = 0;
  foreach ($services as $service) {
    $service_arr = explode("-", $service);
    $service_name = $service_arr[0];
    $service_price = $service_arr[1];
    $total_cost += $service_price;
    // assuming each service takes one hour
    $total_time += 1;
  }

  // check if stylist is available at selected date and time
  if (!is_available($date, $time, $stylist)) {
    echo "<div class='error'>The stylist is already booked at the selected time. Please choose another time or stylist.</div>";
  } else {
    // calculate total cost and time
    $services_total_cost = 0;
    $services_total_time = 0;
    foreach ($services as $service) {
      list($service_name, $service_time, $service_cost) = explode('-', $service);
      $services_total_cost += $service_cost;
      $services_total_time += $service_time;
    }
    $total_time = $time + $services_total_time;
    $total_cost = $services_total_cost;
}
    // display success message
    echo "<div class='success'>Booking successful</div>";
  
    $to = $email;
    $subject = "Booking Confirmation";
    $message = "Dear $first_name $last_name, <br><br>";
    $message .= "Thank you for booking with us. Below are the details of your booking:<br><br>";
    $message .= "Name: $first_name $last_name<br>";
    $message .= "Email: $email<br>";
    $message .= "Phone Number: $phone_number<br>";
    $message .= "Booking Date: $date<br>";
    $message .= "Booking Time: ".date('h:i A', $time)." - ".date('h:i A', $total_time)."<br>";
    $message .= "Services: ".implode(", ", $services)."<br>";
    $message .= "Total Cost: Ksh. $total_cost<br>";
    $message .= "Stylist: $stylist<br><br>";
    $message .= "We look forward to seeing you at our salon. Thank you!<br><br>";
    $message .= "Best regards,<br>";
    $message .= "The Salon Team";
  
    // send email
    $headers = "From: salon@example.com\r\n";
    $headers .= "Reply-To: salon@example.com\r\n";
    $headers .= "Content-type: text/html\r\n";
    mail($to, $subject, $message, $headers);
  }
  ?>