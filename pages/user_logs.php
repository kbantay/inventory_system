<?php
 session_start();

if(isset($_SESSION['username'])){
    include 'includes/header.php';
    if ($_SESSION['user_logs']=="true") {
?>

<!-- ============================================= MAIN CONTENT - BODY ===================================================== -->
  

  <!---------------------- Loading ----------------->
  <div class="loaderFrame" id="loader" style="display:none">
      <img class="img-loader" src="includes/ring-loader.gif" alt="loading">
      <label>Processing...</label>
  </div>
  <!---------------------- Loading ----------------->



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3><i class="far fa-address-card"></i>&nbsp;&nbsp; User Log Entry</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
      <div class="box">
        <!-- <div class="box-header">
          <h3 class="box-title">System Users</h3>
        </div> --> <!-- /.box-header -->
        <div class="box-body">
          <table id="userLogsTbl" class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
              <th>Log ID</th>
              <th>Fullname</th>
              <th>Username</th>
              <th>Activity</th>
              <th>Date-Time</th>
            </tr>
            </thead>
            <tbody id="userLogsTbody">
            </tbody>
          </table>
        </div>  <!-- /.box-body -->
        
      </div> <!-- /.box -->

    </section><!-- /.content -->
  </div>

<?php
    }
    else {
      include 'error403.php';
    }
  include 'includes/footer.php';
?>
<!--=======================================-->
  <script src=includes/js/user_logs.js></script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>