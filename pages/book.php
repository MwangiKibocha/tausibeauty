<?php
// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beauty";

$con=mysqli_connect("localhost", "root", "", "beauty");
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get form values
  $first_name = $_POST["first_name"];
  $last_name = $_POST["last_name"];
  $email = $_POST["email"];
  $service = implode(", ", $_POST["service"]);
  $stylist_id = $_POST["stylist_id"];
  $date = $_POST["date"];
  $time = $_POST["time"];

  // Check if the selected stylist is available on the selected date and time
  $sql = "SELECT COUNT(*) as count FROM bookings WHERE stylist_id = $stylist_id AND date = '$date' AND time = '$time' AND status = 'booked'";
  $result = mysqli_query($con, $sql);
  $row = mysqli_fetch_assoc($result);
  $count = $row["count"];
  if ($count > 0) {
    echo "Sorry, the selected stylist is not available on the selected date and time.";
  } else {
    // Insert booking into database
    $sql = "INSERT INTO bookings (first_name, last_name, email, service, stylist_id, date, time) VALUES ('$first_name', '$last_name', '$email', '$service', $stylist_id, '$date', '$time')";
    if (mysqli_query($con, $sql)) {
      // Send confirmation email
      $to = $email;
      $subject = "Booking Confirmation";
      $message = "Dear $first_name,\n\nThank you for booking with us. Your appointment is confirmed for $date at $time with stylist #$stylist_id for the following service(s): $service.\n\nWe look forward to seeing you soon!";
      $headers = "From: salon@example.com";
      mail($to, $subject, $message, $headers);

      echo "Booking successful! Confirmation email sent to $email.";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
  }

  mysqli_close($conn);
}
?>

<form method="post">
  <label for="first_name">First Name:</label>
  <input type="text" name="first_name" required>

  <label for="last_name">Last Name:</label>
  <input type="text" name="last_name" required>

  <label for="email">Email:</label>
  <input type="email" name="email" required>

  <label for="service">Select Service(s):</label>
  <select name="service[]" multiple required>
    <option value="makeup">Makeup</option>
    <option value="facials">Facials</option>
    <option value="hair">Hair</option>
    <option value="manicure">Manicure</option>
    <option value="pedicure">Pedicure</option>
    <option value="face_scrubbing">Face Scrubbing</option>
  </select>
  
   <label for="stylist">Select Stylist:</label>
   <select id="stylist" name="stylist" required>
    <?php
    $sql = "SELECT * FROM stylist WHERE id NOT IN (SELECT stylist_id FROM bookings WHERE date = '$date' AND time = '$time')";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
      echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
    }
    ?>
  </select>

  <label for="date">Select Date:</label>
  <input type="date" id="date" name="date" value="<?php echo $date; ?>" min="<?php echo $date; ?>" required>

  <label for="time">Select Time:</label>
  <input type="time" id="time" name="time" value="<?php echo $time; ?>" min="09:00" max="17:00" step="1800" required>

  <input type="submit" value="Book">
</form>
