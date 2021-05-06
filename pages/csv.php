<?php
 session_start();

if(isset($_SESSION['username'])){
    include 'includes/header.php';
    include 'includes/handlers/csvexport_handler.php';
    // if ($_SESSION['outlet_pendingrestock']=="true") {
      require 'includes/handlers/databaseConn_handler.php';

      $sql = $conn->query("SELECT productID FROM supplies_tbl");
      $numRows = $sql->num_rows; 
?>

<!-- ================================================== MAIN CONTENT - BODY ======================================================== -->
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
      <h3><i class="fas fa-tasks"></i>&nbsp;&nbsp; Manage Asset Record</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
      <div class="box">
        <form id="uploadForm" action="includes/handlers/csvimport_handler.php" class="form-horizontal form-label-left input_mask" method="post"  enctype="multipart/form-data">
            <div class="form-group">
              <label class="col-md-4 control-label" for="profilePhoto">Profile Photo</label>  
              <div class="col-md-5">
                <input type="file" id="csvdata" name="csvdata" class="form-control input-md" required="">
              </div>
            </div>

            <div class="form-group">
              <!-- <label class="col-md-4 control-label" for="upload"></label> -->
              <div class="col-md-9">
                <button type="submit" id="uploadBtn" name="upload" class="btn btn-success pull-right"><span class='fas fa-upload'>&nbsp;</span> Upload</button>
                <!-- <button type="submit" id="uploadBtn" name="submit" class="btn btn-success pull-right"><span class='fas fa-upload'>&nbsp;</span> Upload</button> -->
              </div>
              
            </div>
            <div class="form-group" style="padding-left: 80px;">
              <div class="col-md-12" > 
              <p>
                Reminder:
                <br>
                <i>* Only jpg, jpeg and png format are allowed.
                <br>
                * Attached image that is 1MB and below. Preferrably 300 x 300 pixels</i>
              </p>
              </div>
            </div>
          </form>


      </div>
    </section>

    <br>

    <section class="content">
      <div class="box">
          <div class="form-group">
            <!-- <label class="col-md-4 control-label" for="upload"></label> -->
            <div class="col-md-9">
              <input type="hidden" id="max" value="<?=$numRows?>">
              <p id="response">Please wait...</p>
              <br><br><br>
              <!-- <a href="<?php echo"";//$response?>" type="submit" download="supplies.csv" class="btn btn-warning pull-right"><span class='fas fa-upload'>&nbsp;</span> Download File</a> -->
            </div>
            
          </div>
      </div>
    </section>
    <!-- /.content -->
  </div>



<?php
    //}
    // else {
    //   include 'error403.php';
    // }
    include 'includes/footer.php';
?>
<!--=======================================-->
	<script src="includes/js/csvexport.js"></script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>