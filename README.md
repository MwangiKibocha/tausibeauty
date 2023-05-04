# housing-management
Rental management system web app
Enables search for vacant apartments.
Also enables landlords to manage their apartments.
Front end and back end.
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
    echo "<div
