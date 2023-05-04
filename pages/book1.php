<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beauty";

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

//include('includes/dbconnection.php');
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $service = $_POST["service"];
    $time = $_POST["time"];
    $stylist = $_POST["stylist"];

    // Check if selected stylist is available at the selected time
    $sql = "SELECT * FROM stylists WHERE StylistID = $stylist AND Availability LIKE '%$time%'";
    $result = $con->query($sql);
    if ($result->num_rows == 0) {
        echo "Sorry, the selected stylist is not available at the selected time. Please choose a different time or stylist.";
    } else {
        // Insert new appointment into database
        $sql = "INSERT INTO appointments (CustomerName, CustomerEmail, Service, AppointmentTime, StylistID) VALUES ('$name', '$email', '$service', '$time', $stylist)";
        if ($con->query($sql) === TRUE) {
            echo "Appointment booked successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
}

// Close connection
$con->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book a Beauty Service</title>
</head>
<body>
    <h1>Book a Beauty Service</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <!-- <form action="booking.php" method="post"> -->
  <label for="name">Name:</label>
  <input type="text" name="name" required>
  
  <label for="email">Email:</label>
  <input type="email" name="email" required>
  
  <label for="date">Date:</label>
  <input type="date" name="date" required>

  <label for="service">Select Service:</label>
  <select name="service" required>
    <option value="">--Select Service--</option>
    <option value="Haircut">Haircut</option>
    <option value="Manicure">Manicure</option>
    <option value="Pedicure">Pedicure</option>
    <option value="Facial">Facial</option>
    <option value="Massage">Massage</option>
  </select>

  <label for="stylist">Select Stylist:</label>
  <select name="stylist" id="stylist" required>
    <option value="">--Select Stylist--</option>
    <?php
      $sql = "SELECT * FROM stylist WHERE availability='Available'";
      $result = mysqli_query($con, $sql);
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
      }
    ?>
  </select>

  <label for="time">Select Time:</label>
  <select name="time" id="time" required>
    <option value="">--Select Time--</option>
    <?php
      if (isset($_POST['date']) && isset($_POST['stylist'])) {
        $date = $_POST['date'];
        $stylist = $_POST['stylist'];
        $sql = "SELECT * FROM availability WHERE stylist_id='$stylist' AND date='$date' AND availability='Available'";
        $result = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<option value='" . $row['time_slot'] . "'>" . $row['time_slot'] . "</option>";
        }
      }
    ?>
  </select>

  <button type="submit" name="submit">Book Now</button>
</form>

</body>
</html>
