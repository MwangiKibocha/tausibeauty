<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  
  require 'vendor/autoload.php';

include('connn.php');

    session_start();
    if (isset($_POST['submit'])) {
    $first_name = ($_POST["first_name"]);
    $last_name = ($_POST["last_name"]);
    $email = ($_POST["email"]);
    $phone_number = ($_POST["phone_number"]);
    $booking_date = ($_POST["booking_date"]);
    $booking_time = ($_POST["booking_time"]);
    $services = ($_POST["services"]);
    $stylists = ($_POST["stylists"]);
    $pay_number= ($_POST["pay_number"]);
    $payment_date = date('Y-m-d H:i:s');


    }


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
//INCLUDE THE ACCESS TOKEN FILE
// if (isset($_POST['submit'])) {
//   // retrieve form data
//   $pay_number = $_POST['pay_number'];
// }
include '../mpesa/accessToken.php';
date_default_timezone_set('Africa/Nairobi');
$processrequestUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
//$callbackurl = 'https://us-central1-tausi-beauty.cloudfunctions.net/callback';
$callbackurl = 'https://11ee-102-213-241-18.eu.ngrok.io/tausi/main/callback.php';
$passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
$BusinessShortCode = '174379';
$Timestamp = date('YmdHis');
// ENCRIPT  DATA TO GET PASSWORD
$Password = base64_encode($BusinessShortCode . $passkey . $Timestamp);
$phone = $pay_number;
$money = '1';
$PartyA = $pay_number;
$PartyB = $pay_number;
$AccountReference = 'Tausi Beauty';
$TransactionDesc = 'Booking Fee';
$Amount = $money;
$stkpushheader = ['Content-Type:application/json', 'Authorization:Bearer ' . $access_token];

//INITIATE CURL
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $processrequestUrl);
curl_setopt($curl, CURLOPT_HTTPHEADER, $stkpushheader); //setting custom header
$curl_post_data = array(
  //Fill in the request parameters with valid values
  'BusinessShortCode' => $BusinessShortCode,
  'Password' => $Password,
  'Timestamp' => $Timestamp,
  'TransactionType' => 'CustomerPayBillOnline',
  'Amount' => $Amount,
  'PartyA' => $PartyA,
  'PartyB' => $BusinessShortCode,
  'PhoneNumber' => $PartyA,
  'CallBackURL' => $callbackurl,
  'AccountReference' => $AccountReference,
  'TransactionDesc' => $TransactionDesc
);
$data_string = json_encode($curl_post_data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
$curl_response = curl_exec($curl);
//ECHO  RESPONSE
echo $curl_response;
// Parse the response
$response_data = json_decode($curl_response);
$merchant_request_id = $response_data->MerchantRequestID;
$checkout_request_id = $response_data->CheckoutRequestID;
$response_description = $response_data->ResponseDescription;

$response = file_get_contents('php://input');
$callbackData = json_decode($response);

// // Check if the payment was successful
// if(isset($data['Body']['stkCallback']['CheckoutRequestID'])){
//   $transaction_id = $data['Body']['stkCallback']['CheckoutRequestID'];
// } else {
//   $transaction_id = '';
// }
// if(isset($data['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'])){
//   $amount = $data['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
// } else {
//   $amount = '';
// }
// if(isset($data['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'])){
//   $phone_number = $data['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
// } else {
//   $phone_number = '';
// } 
// if(isset($data['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'])){
//   $status = $data['Body']['stkCallback']['ResultCode'];
// } else{
//   $status ='';
// }
// $transaction_id = mysqli_real_escape_string($con, $transaction_id);
// $amount = mysqli_real_escape_string($con, $amount);
// $phone_number = mysqli_real_escape_string($con, $phone_number);
// $status = mysqli_real_escape_string($con, $status);
// $payment_date = date("Y-m-d H:i:s");

// // Insert the transaction details into the database



// Return a response to the API
$response = [
    'ResultCode' => 0,
    'ResultDesc' => 'The service was accepted successfully',
];
echo json_encode($response);
// Prepare the insert statement
// $sql = "INSERT INTO payments (phone_number, amount, payment_date, merchant_request_id, checkout_request_id, response_description, first_name) 
//         VALUES ('$pay_number', '1', '$payment_date', '$merchant_request_id', '$checkout_request_id', '$response_description', '$first_name')";
        
// if (mysqli_query($con, $sql)) {
//     echo "Payment record added successfully";

// Echo the response
echo $curl_response;

      // if ($payment_successful) {
      //   if (mysqli_query($con, $sql)) {
      //     echo "New payment record created successfully";
      // // Print the transaction details for testing purposes
      // echo "Transaction ID: " . $transaction_id . "<br>";
      // echo "Amount: " . $amount . "<br>";
      // echo "Phone Number: " . $phone_number . "<br>";
      // echo "Status: " . $status . "<br>";
      $sql = "INSERT INTO payments (phone_number, amount, payment_date, merchant_request_id, checkout_request_id, response_description, first_name) 
      VALUES ('$pay_number', '1', '$payment_date', '$merchant_request_id', '$checkout_request_id', '$response_description', '$first_name')";
      $query=mysqli_query($con,$sql);
        // Insert booking details into database
        $sql = "INSERT INTO bookings (first_name, last_name, email, phone_number, booking_date, booking_time, services, stylists, status) VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$booking_date', '$booking_time', '$services', '$stylists', 'scheduled')";
        $query=mysqli_query($con,$sql);
    
        // Redirect to success page
        echo '<script>alert("BOOKING SUCCESSFUL. Check email for details"); window.location.href = "index.php"</script>';
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
       $mail->addReplyTo('vinmwangi39@gmail.com', 'Reply Address');
    
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
//   } else {
//     echo "Error adding payment record: " . mysqli_error($con);
// }
  // }else{
  //   echo "please complete payment";
  // }
  
    // log an error message to a separate file if json_decode() fails
    if (json_last_error() !== JSON_ERROR_NONE) {
      error_log("json_decode() failed: " . json_last_error_msg());
      }
//     } else {
//     $payment_successful = false;
//     echo '<script>alert("PAYMENT NOT SUCCESSFUL")window.location.href = "index.php"</script>';
// }
  }




}
mysqli_close($con);
?>
