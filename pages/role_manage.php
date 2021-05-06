<?php
 session_start();

if(isset($_SESSION['username'])){
  include 'includes/header.php';
  if ($_SESSION['user_role']=="true") {
?>

<!-- ========================================== MAIN CONTENT - BODY =========================================== -->
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
      <h3><i class="fas fa-user-alt"></i>&nbsp;&nbsp; Manage User Roles</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
      <div class="box">
          <!-- <div class="box-header">
            <h3 class="box-title">System Users</h3>
          </div> -->
        <!-- /.box-header -->
        <div class="box-body">
          <table id="roleTbl" class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
              <th style="display:none"></th>
              <th>Role Name</th>
              <th>Description</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody id="roleTbody">
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
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
  <script src=includes/js/role_manage.js></script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>