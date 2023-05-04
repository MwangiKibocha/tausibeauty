<?php
// Initialize variables
$fname = "";
$lname = "";
$email = "";
$phone = "";
$date = "";
$time = "";
$services = array();
$stylist = "";
$total_cost = 0;
$total_time = 0;
$available_stylists = array("Stylist A", "Stylist B", "Stylist C"); // List of available stylists
$booked_stylists = array(); // Initialize an empty array for booked stylists

// Define service prices and times
$service_prices = array(
    "makeup" => array("price" => 400, "time" => 1),
    "facials" => array("price" => 250, "time" => 1),
    "hair" => array("price" => 300, "time" => 1.5),
    "manicure" => array("price" => 200, "time" => 1),
    "pedicure" => array("price" => 220, "time" => 1),
    "face_scrubbing" => array("price" => 150, "time" => 0.5)
);

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $fname = test_input($_POST["fname"]);
    $lname = test_input($_POST["lname"]);
    $email = test_input($_POST["email"]);
    $phone = test_input($_POST["phone"]);
    $date = test_input($_POST["date"]);
    $time = test_input($_POST["time"]);
    $services = $_POST["services"];
    $stylist = test_input($_POST["stylist"]);

    // Calculate total cost and time
    foreach ($services as $service) {
        $total_cost += $service_prices[$service]["price"];
        $total_time += $service_prices[$service]["time"];
    }

    // Check if stylist is available
    if (in_array($stylist, $available_stylists)) {
        // Book stylist
        array_push($booked_stylists, $stylist);

        // Send booking confirmation email to user
        $to = $email;
        $subject = "Booking Confirmation";
        $message = "Dear " . $fname . ",\n\nThank you for booking with us! Your appointment has been scheduled for " . $date . " at " . $time . " with " . $stylist . ".\n\nServices:\n";
        foreach ($services as $service) {
            $message .= "- " . ucfirst($service) . ": " . $service_prices[$service]["time"] . " hours\n";
        }
        $message .= "\nTotal cost: Ksh " . $total_cost . "\nTotal time: " . $total_time . " hours\n\nWe look forward to seeing you soon!\n\nBest regards,\nOur Team";
        $headers = "From: booking@example.com\r\n" . "Reply-To: booking@example.com\r\n" . "X-Mailer: PHP/" . phpversion();
        mail($to, $subject, $message, $headers);

        // Display success message
        echo "<p>Booking successful!</p>";
    } else {
        // Display error message
        echo "<p>The selected stylist is not available. Please select another stylist.</p>";
    }
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// define variables and set to empty values
$first_name = $last_name = $email = $phone_number = $booking_date = $booking_time = $services = $stylist = "";
$booking_time_hours = array("7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $first_name = test_input($_POST["first_name"]);
  $last_name = test_input($_POST["last_name"]);
  $email = test_input($_POST["email"]);
  $phone_number = test_input($_POST["phone_number"]);
  $booking_date = test_input($_POST["booking_date"]);
  $booking_time = test_input($_POST["booking_time"]);
  $services = test_input($_POST["services"]);
  $stylist = test_input($_POST["stylist"]);

  // validate the booking date
  if (strtotime($booking_date) < time()) {
    $booking_date_err = "You cannot select a date that has already passed";
  }

  // validate the booking time
  if (!in_array($booking_time, $booking_time_hours)) {
    $booking_time_err = "Please select a valid booking time";
  }

  // calculate the total cost and time of the selected services
  $total_cost = 0;
  $total_time = 0;
  $services_arr = explode(",", $services);
  foreach ($services_arr as $service) {
    switch ($service) {
      case "makeup":
        $total_cost += 400;
        $total_time += 60;
        break;
      case "facials":
        $total_cost += 250;
        $total_time += 60;
        break;
      case "hair":
        $total_cost += 350;
        $total_time += 90;
        break;
      case "manicure":
        $total_cost += 200;
        $total_time += 30;
        break;
      case "pedicure":
        $total_cost += 250;
        $total_time += 45;
        break;
      case "face_scrubbing":
        $total_cost += 150;
        $total_time += 30;
        break;
      default:
        // do nothing
        break;
    }
  }

  // send booking confirmation email
  $to = $email;
  $subject = "Booking Confirmation";
  $message = "Dear " . $first_name . ",\n\nThank you for booking an appointment with us. Your booking details are as follows:\n\nFirst Name: " . $first_name . "\nLast Name: " . $last_name . "\nEmail: " . $email . "\nPhone Number: " . $phone_number . "\nDate: " . $booking_date . "\nTime: " . $booking_time . "\nServices: " . $services . "\nStylist: " . $stylist . "\nTotal Cost: " . $total_cost . " Ksh" . "\nTotal Time: " . $total_time . " minutes";
  $headers = "From: booking@yourwebsite.com" . "\r\n" .
      "CC: someoneelse@yourwebsite.com";

  mail($to, $subject, $message, $headers);

  // display success message
 // display success message
 echo '<div class="success">Booking successful</div>';

// send email notification
$to = $email;
$subject = "Booking Confirmation";
$message = "Dear $first_name $last_name, <br><br>";
$message .= "Thank you for booking with us. Below are the details of your booking:<br><br>";
$message .= "Name: $first_name $last_name<br>";
$message .= "Email: $email<br>";
$message .= "Phone Number: $phone_number<br>";
$message .= "Date: $date<br>";
$message .= "Time: $time<br>";
$message .= "Services: $services<br>";
$message .= "Total Cost: Ksh. $total_cost<br>";
$message .= "Stylist: $stylist<br><br>";
$headers = "From: bookings@mysalon.com\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

mail($to, $subject, $message, $headers);

}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Booking Form</title>
	<style>
		form {
			margin: 20px;
			padding: 20px;
			border: 1px solid #ccc;
			border-radius: 5px;
			max-width: 500px;
		}
		label {
			display: block;
			margin-bottom: 10px;
			font-weight: bold;
		}
		input[type="text"], input[type="email"], select {
			display: block;
			margin-bottom: 20px;
			padding: 10px;
			border-radius: 5px;
			border: 1px solid #ccc;
			font-size: 16px;
			width: 100%;
		}
		select option {
			font-size: 16px;
		}
		input[type="submit"] {
			background-color: #4CAF50;
			color: white;
			border: none;
			border-radius: 5px;
			padding: 10px 20px;
			font-size: 16px;
			cursor: pointer;
			margin-top: 20px;
		}
		input[type="submit"]:hover {
			background-color: #3e8e41;
		}
		.success {
			background-color: #d4edda;
			color: #155724;
			padding: 10px;
			border-radius: 5px;
			margin-top: 20px;
		}
		.error {
			background-color: #f8d7da;
			color: #721c24;
			padding: 10px;
			border-radius: 5px;
			margin-top: 20px;
		}
	</style>
</head>
<body>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label for="first_name">First Name:</label>
		<input type="text" id="first_name" name="first_name" required>

		<label for="last_name">Last Name:</label>
		<input type="text" id="last_name" name="last_name" required>

		<label for="email">Email:</label>
		<input type="email" id="email" name="email" required>

		<label for="phone">Phone Number:</label>
		<input type="text" id="phone" name="phone" required>

		<label for="date">Date:</label>
		<input type="date" id="date" name="date" min="<?php echo date('Y-m-d'); ?>" required>

		<label for="time">Time:</label>
		<select id="time" name="time" required>
			<option value="" selected disabled>Select a time</option>
			<?php
				$start_time = strtotime('7:00AM');
				$end_time = strtotime('6:00PM');
				while($start_time <= $end_time) {
					echo '<option value="'.date('H:i:s', $start_time).'">'.date('h:i A', $start_time).'</option>';
					$start_time = strtotime('+1 hour', $start_time);
				}
			?>
		</select>

		<div class="form-group">
  <label for="services">Select Service(s):</label>
  <select name="services[]" id="services" multiple required>
    <option value="makeup-400">Makeup - Ksh. 400/hr</option>
    <option value="facials-250">Facials - Ksh. 250/hr</option>
    <option value="hair-300">Hair - Ksh. 300/hr</option>
    <option value="manicure-200">Manicure - Ksh. 200/hr</option>
    <option value="pedicure-250">Pedicure - Ksh. 250/hr</option>
  </select>
</div>

<div class="form-group">
  <label for="stylist">Select Stylist:</label>
  <select name="stylist" id="stylist" required>
    <?php
      $stylists = array("Jane Doe", "John Doe", "Mary Jane");
      // loop through stylists and check if they are available at selected date and time
      foreach ($stylists as $stylist) {
        if (is_available($date, $time, $stylist)) {
          echo "<option value='$stylist'>$stylist</option>";
        }
      }
    ?>
  </select>
</div>

<div class="form-group">
  <button type="submit" name="submit">Submit</button>
</div>
</form>
