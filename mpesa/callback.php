<?php
// Get the JSON data sent in the request body
header("Content-Type: application/json");
date_default_timezone_set('Africa/Nairobi');
$data = file_get_contents("php://input");
$logFile = "Mpesastkresponse.json";
$log = fopen($logFile, "a");
//trial

// Retrieve the transaction details from the callback URL

//$transaction_id = $_POST['transaction_id'];
//$amount = $_POST['amount'];
//$phone_number = $_POST['phone_number'];

//
if (!$log) {
  // log an error message to a separate file if fopen() fails
  error_log("Failed to open $logFile for writing");
} else {
  // write data to log file and close the file pointer
  fwrite($log, $data);
  fclose($log);
}
// Convert the JSON data to an array
$data = json_decode($data, true);

// Check if the required data is set before accessing it
if(isset($data['Body']['stkCallback']['CheckoutRequestID'])){
    $transaction_id = $data['Body']['stkCallback']['CheckoutRequestID'];
} else {
    $transaction_id = '';
}
if(isset($data['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'])){
    $amount = $data['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
} else {
    $amount = '';
}
if(isset($data['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'])){
    $phone_number = $data['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
} else {
    $phone_number = '';
} 
if(isset($data['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'])){
    $status = $data['Body']['stkCallback']['ResultCode'];
} else{
    $status ='';
}

// Print the transaction details for testing purposes
echo "Transaction ID: " . $transaction_id . "<br>";
echo "Amount: " . $amount . "<br>";
echo "Phone Number: " . $phone_number . "<br>";
echo "Status: " . $status . "<br>";

// log an error message to a separate file if json_decode() fails
if (json_last_error() !== JSON_ERROR_NONE) {
  error_log("json_decode() failed: " . json_last_error_msg());
}

// Connect to the MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beauty";
$con = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Escape special characters in the data to prevent SQL injection attacks
$transaction_id = mysqli_real_escape_string($con, $transaction_id);
$amount = mysqli_real_escape_string($con, $amount);
$phone_number = mysqli_real_escape_string($con, $phone_number);
$status = mysqli_real_escape_string($con, $status);
$payment_date = date("Y-m-d H:i:s");

// Insert the transaction details into the database
$sql = "INSERT INTO payments (transaction_id, phone_number, amount, payment_date) VALUES ('$transaction_id', '$phone_number', '$amount', '$payment_date')";

if (mysqli_query($con, $sql)) {
    echo "New payment record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);
?>
