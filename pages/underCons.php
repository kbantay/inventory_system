
<?php
 session_start();

if(isset($_SESSION['username'])){
    include 'includes/header.php';
?>

<!-- ================================================== MAIN CONTENT - BODY ======================================================== -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3>Sorry! This page is still under construction.</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
        <div class="box box-warning">
            <img src="../dist/img/construction.png" alt="Construction Image">

        </div>
    </section>
    <!-- /.content -->
  </div>

<?php
    include 'includes/footer.php';
?>
<!--=======================================-->
	<script type="text/javascript">
    // need to add on JS file --> $('#dashboardMain').removeAttr('style');
    $(document).ready(function(){
        $('#dashboardMain').removeAttr('style');
    });
	</script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>


