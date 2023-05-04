<?php
//session_start();
//error_reporting(0);
include('connn.php');
    session_start();
/*if (strlen($_SESSION['sid']==0)) {
  //header('location:logout.php');
}*/ 
$loggedInStylist = $_SESSION['uid'];
?>
<!DOCTYPE html>
<html>
<?php @include("includes/head.php"); ?>
<style>
    .table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 1rem;
  background-color: #fff;
  color: #000;
}

.table th,
.table td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: 1px solid #dee2e6;
}

.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #dee2e6;
}

.table tbody + tbody {
  border-top: 2px solid #dee2e6;
}

.table-bordered {
  border: 1px solid #dee2e6;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #dee2e6;
}

.table-hover tbody tr:hover {
  background-color: rgba(0, 0, 0, 0.075);
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: rgba(0, 0, 0, 0.05);
}

</style>
<body>
    <div class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <?php @include("includes/header.php"); ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php @include("includes/sidebar.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Appointments</h1>
            </div>
            <div class="col-sm-6">
                <li class="breadcrumb-item active">View Bookings</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">DataTable with All Appointment</h3>
                </div>
        
                      <div class="modal-header">
                        <h5 class="modal-title">View Appointment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body" id="info_update">
                        <!--?php @include("view_appointment.php");?>-->
                      </div>
                      <div class="modal-footer ">
                         <table id="example1" class="table table-bordered table-hover">
                         <label for="booking_date">View bookings for:</label>
<input type="date" id="booking_date" name="booking_date">
<button type="submit" name="filter-btn">Filter</button>

                    <thead> 
                      <tr> 
                        <th>#</th> 
                        <th>Bookings ID</th> 
                        <th>FirstName</th> 
                        <th>LastName</th>
                        <th>Email</th> 
                        <th>PhoneNumber</th>
                        <th>Booked Date</th>
                        <th>Booked Time</th>
                        <th>Booked service</th>
                        <th>Booked Stylist</th>
                        <th>Booking Status</th>
                      </tr> 
                    </thead> 
                    <tbody>
<?php
if(isset($_POST['filter-btn']) && !empty($_POST['booking_date'])){
  $filterDate = date('Y-m-d', strtotime($_POST['booking_date']));
  $ret=mysqli_query($con,"SELECT * FROM bookings WHERE stylists ='$loggedInStylist' AND booking_date='$filterDate' ORDER BY booking_date ASC");
} else {
  $ret=mysqli_query($con,"SELECT * FROM bookings WHERE stylists ='$loggedInStylist' ORDER BY booking_date ASC");
}

$cnt=1;
while ($row=mysqli_fetch_array($ret)) {
?>
  <tr> 
    <th scope="row"><?php echo $cnt;?></th> 
    <td><?php  echo $row['id']; ?></td>
    <td><?php  echo $row['first_name'];?></td> 
    <td><?php  echo $row['last_name'];?></td>
    <td><?php  echo $row['email'];?></td>
    <td><?php  echo $row['phone_number'];?></td>
    <td><?php  echo $row['booking_date'];?></td>
    <td><?php  echo $row['booking_time'];?></td>
    <td><?php  echo $row['services'];?></td> 
    <td><?php  echo $row['stylists'];?></td>
    <td><?php  echo $row['Status'];?></td>  
    <!-- <td><a href="./view-appointment.php" class=" edit_data" id="?php echo  $row['ID']; ?>" title="click for edit">View</a></td> -->
    <!-- <td><a href="./cancel.php?id=<?php echo $row['id']; ?>">Cancel</a></td> -->
  </tr>   
<?php 
  $cnt++;
}
?>


                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php @include("includes/footer.php"); ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>

  <!-- ./wrapper -->
  <?php @include("includes/foot.php"); ?>
  <script type="text/javascript">
    $(document).ready(function(){
      $(document).on('click','.edit_data',function(){
        var edit_id=$(this).attr('id');
        $.ajax({
          url:"",
          type:"post",
          data:{edit_id:edit_id},
          success:function(data){
            $("#info_update").html(data);
            $("#editData").modal('show');
          }
        });
      });
    });
  </script>
    </div>
</body>
</html>
