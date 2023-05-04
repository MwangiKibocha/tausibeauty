
<?php
$con=mysqli_connect("localhost", "root", "", "beauty");
if(mysqli_connect_errno()){
echo "Connection Fail".mysqli_connect_error();
}
$result = mysqli_query($con, "SELECT * FROM users");
if (!$result) {
  printf("Error: %s\n", mysqli_error($con));
  exit();
}

?>
