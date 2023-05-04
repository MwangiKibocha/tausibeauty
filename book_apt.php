<?php 

/*session_start();
if(!isset($_SESSION['username'])){
    header('location:includes/login.php');
}*/

/*include("includes/session.php");
session_start(); */

include('includes/dbconnection.php');
include("includes/header.php");



?>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!--<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&display=swap" rel="stylesheet">
      --
    <title>Malena Beauty Salon</title>
<!--
    
TemplateMo 558 Klassy Cafe

https://templatemo.com/tm-558-klassy-cafe

-->
    <!-- Additional CSS Files -->
    <!--<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
    <link rel="stylesheet" href="css/book.css">

    <link rel="stylesheet" href="assets/css/templatemo-klassy-cafe.css">

    <link rel="stylesheet" href="assets/css/owl-carousel.css">

    <link rel="stylesheet" href="assets/css/lightbox.css"> -->
    <link rel="stylesheet" href="css/book.css">
    </head>
     <br><br><br><br><br>

    <?php
      if(isset($_POST['submit']))
      {
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];
        $category=$_POST['category'];
        $service=$_POST['service'];
        $date=$_POST['date'];
        $time=$_POST['time'];
        $message=$_POST['message'];
        
        $time = $_POST['time']; // get the selected booking time from the form submission
        $timeHour = (int) substr($time, 0, 2); // extract the hour component of the booking time as an integer
        
        // check if the booking time falls within the available booking hours (7 am to 6 pm)
        if ($timeHour < 7 || $timeHour > 18) {
            // if the booking time is outside the available booking hours, show an error message to the user
            echo "Invalid booking time. Please select a time between 7 am and 6 pm.";
        } else {
            // if the booking time is valid, proceed with the booking process
            // ...
        }
        
        $sql = "SELECT * FROM stylists";
        $result = mysqli_query($con, $sql);
        
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
        $query=mysqli_query($con, "insert into appointment(FirstName,LastName,Email,PhoneNumber,Category,Service,AptDate,AptTime,Message) values('$fname','$lname','$email',$phone,'$category','$service','$date','$time','$message')")or die(mysqli_error($con));
        
        if ($query) {
          echo "<script>alert('Your appointment has been booked.');</script>"; 
          echo "<script>window.location.href = 'book_apt.php'</script>";   
          $msg="";
        }
        else
        {
          echo "<script>alert('Something Went Wrong. Please try again.');</script>";    
        }
      }
    
      
    //}
    ?>



    <div class="row justify-content-center">
    <div class="col-lg-6">
                    <div class="contact-form">
                        <form id="contact" action="" method="post">
                          <div class="row">
                            <div class="col-lg-12">
                                <h4>Book Appointment Here!</h4>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                              <fieldset>
                                <input name="fname" type="text" id="name" placeholder="First Name" required="">
                              </fieldset>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                              <fieldset>
                                <input name="lname" type="text" id="name" placeholder="Last Name" required="">
                              </fieldset>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                              <fieldset>
                              <input name="email" type="text" id="email" pattern="[^ @]*@[^ @]*" placeholder="Your Email Address" required="">
                            </fieldset>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                              <fieldset>
                                <input name="phone" type="text" id="phone" placeholder="Phone Number" required="">
                              </fieldset>
                            </div>
                            <!--<div class="col-md-6 col-sm-12">
                              <fieldset>
                                <select value="number-guests" class="form-select" name="person" id="number-guests">
                                    <option value="number-guests">Number Of Guests</option>
                                    <option name="1" id="1">1</option>
                                    <option name="2" id="2">2</option>
                                    <option name="3" id="3">3</option>
                                    <option name="4" id="4">4</option>
                                    <option name="5" id="5">5</option>
                                    <option name="6" id="6">6</option>
                                    <option name="7" id="7">7</option>
                                    <option name="8" id="8">8</option>
                                    <option name="9" id="9">9</option>
                                    <option name="10" id="10">10</option>
                                    <option name="11" id="11">11</option>
                                    <option name="12" id="12">12</option>
                                </select>
                              </fieldset>
                            </div>-->
                        
                            <!--<div class="col-md-6 col-sm-12">
                              <fieldset>
                                <select value="time" name="time" id="time">
                                    <option value="time">Time</option>
                                    <--<option name="Breakfast" id="Breakfast">Breakfast</option>
                                    <option name="Lunch" id="Lunch">Lunch</option>
                                    <option name="Dinner" id="Dinner">Dinner</option>--
                                </select>
                              </fieldset>
                            </div>-->
                            <div class="col-md-6 col-sm-12">
                                <fieldset>
                                  <select value="category" name="category" id="category" required="">
                                      <option value=""> Select Service</option>
                                      <option name="hair" value="hair" id="hair">Hair</option>
                                      <option name="skin" value="skin" id="skin">Skin</option>
                                      <option name="makeup" value="makeup" id="makeup">Makeup</option>
                                  </select>
                                </fieldset>
                              </div>
                              <fieldset>
                              <div class="col-lg-6">
                                <div id="filterDate2">    
                                <label for="time">Time:</label>
                                      <select id="time" name="time">
                                        <option value="">Select a time</option>
                                        <option value="07:00">07:00</option>
                                        <option value="08:00">08:00</option>
                                        <option value="09:00">09:00</option>
                                        <option value="10:00">10:00</option>
                                        <option value="11:00">11:00</option>
                                        <option value="12:00">12:00</option>
                                        <option value="13:00">13:00</option>
                                        <option value="14:00">14:00</option>
                                        <option value="15:00">15:00</option>
                                        <option value="16:00">16:00</option>
                                        <option value="17:00">17:00</option>
                                        <option value="18:00">18:00</option>
                                  </select>

                                    </div>
                                  </div>
                                </div>   
                            </div>
                            </fieldset>
                            <fieldset>
                              <div class="col-lg-6">
                                <div id="filterDate2">    
                                <div class="input-group date" data-date-format="dd/mm/yyyy">
    <input name="date" id="date" type="date" class="form-control" placeholder="dd/mm/yyyy" required min="<?php echo date('Y-m-d'); ?>">    
</div>

                                    <div class="input-group-addon" >
                                      <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                  </div>
                                </div>   
                            </div>
                            </fieldset>
                              <div class="col-md-6 col-sm-12">
                                <fieldset>
                                <select value="category" name="category" id="category" required="">
                                      <option value=""> Select Stylist</option>
                                      <option name="joe" value="joe" id="joe">Joe</option>
                                      <option name="jane" value="jane" id="jane">Jane</option>
                                      <option name="Nellie" value="nellie" id="Nellie">Nellie</option>
                                      <option name="kelly" value="kelly" id="kelly">Kelly</option>
                                </fieldset>
                              </div>
                              
                            
                            <!--<div class="col-lg-12">
                              <fieldset>
                                <textarea name="message" rows="6" id="message" placeholder="Message" required=""></textarea>
                              </fieldset>
                            </div> -->
                            <div class="col-lg-12">
                              <fieldset>
                                <button type="submit" name="submit" id="form-submit" class="main-button-icon">Book Appointment</button>
                              </fieldset>
                            </div>
                          </div>
                        </form>
                    </div>
                </div>
                </div>
    

























    



    <!-- jQuery -->
    <script src="assets/js/jquery-2.1.0.min.js"></script>

    <!-- Bootstrap -->
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Plugins -->
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/accordions.js"></script>
    <script src="assets/js/datepicker.js"></script>
    <script src="assets/js/scrollreveal.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/imgfix.min.js"></script> 
    <script src="assets/js/slick.js"></script> 
    <script src="assets/js/lightbox.js"></script> 
    <script src="assets/js/isotope.js"></script> 
    
    <!-- Global Init -->
    <script src="assets/js/custom.js"></script>
    <script>

        $(function() {
            var selectedClass = "";
            $("p").click(function(){
            selectedClass = $(this).attr("data-rel");
            $("#portfolio").fadeTo(50, 0.1);
                $("#portfolio div").not("."+selectedClass).fadeOut();
            setTimeout(function() {
              $("."+selectedClass).fadeIn();
              $("#portfolio").fadeTo(50, 1);
            }, 500);
                
            });
        });

    </script>
    </html>
    <?php
        include("includes/footer.php"); 
    ?>