<?php
 session_start();

if(isset($_SESSION['username'])){
  include 'includes/header.php';
  if ($_SESSION['user_view']=="true") {
?>

 <!-- Main content -->
   <!---------------------- Loading ----------------->
  <div class="loaderFrame" id="loader" style="display:none">
    <img class="img-loader" src="includes/ring-loader.gif" alt="loading">
    <label>Processing...</label>
  </div>
  <!---------------------- Loading ----------------->
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


	  <!-- Content Header (Page header) -->
    <div class="content-header">
		  <h3><i class="fas fa-user-alt"></i>&nbsp;&nbsp; Manage Users</h3>
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">System Users</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="sysUsersTbl" class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
              <th style='display:none'></th>
              <th>Full Name</th>
              <th>Email Address</th>
              <th>Username</th>
              <th>Designation</th>
            </tr>
            </thead>
            <tbody id="sysUsersTbody">
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </section>

  </div>
  
<?php
  }
  else {
    include 'error403.php';
  }
  include 'includes/footer.php';
?>

<!--=======================================-->
	<script src=includes/js/user_view.js></script>
<!--=======================================-->

<?php
  } else{
        header("Location: ../index");
    }
?>