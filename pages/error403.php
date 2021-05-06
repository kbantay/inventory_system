<?php
 //session_start();

// if(isset($_SESSION['username'])){
//      include 'includes/header.php';
?>

<!-- ================================================== MAIN CONTENT - BODY ======================================================== -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>403 Error Page</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
      <center>
      <div class="error-page">
        <h1 class="headline text-yellow"> 403</h1>
        <br>
        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Access Denied!</h3>
          <p>You don't have the clearance to access this page or this resource.</p>
          <p>You may contact the system administrator for assistance or clearance.</p>
        </div>
        <!-- /.error-content -->
      </div>
      </center>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->
  </div>

<?php
  // include 'includes/footer.php';

  // } else{
  //       header("Location: ../index");
  //   }
?>