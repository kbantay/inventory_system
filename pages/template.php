<?php
 session_start();

if(isset($_SESSION['username'])){
    include 'includes/header.php';
    if ($_SESSION['outlet_pendingrestock']=="true") {
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



      </div>
    </section>
    <!-- /.content -->
  </div>



<?php
    }
    else {
      include 'error403.php';
    }
    include 'includes/footer.php';
?>
<!--=======================================-->
	<script src="includes/js/template.js"></script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>