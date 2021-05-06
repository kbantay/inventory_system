<?php
 session_start();

if(isset($_SESSION['username'])){
  include 'includes/header.php';
  if ($_SESSION['user_manage']=="true") {
?>

 <!-- Main content -->
  <!-- Content Wrapper. Contains page content -->
    <!---------------------- Loading ----------------->
  <div class="loaderFrame" id="loader" style="display:none">
    <img class="img-loader" src="includes/ring-loader.gif" alt="loading">
    <label>Processing...</label>
  </div>
  <!---------------------- Loading ----------------->

  
  <div class="content-wrapper">

  <!--=========================== Change Password MODAL ==========================-->
  <div class="modal fade" id="changePassMdl">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <button type="button" class="close" id="closeSearchModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="changePassMdlTitle">Change Password</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal form-label-left input_mask">
                <input type="hidden" id="selectedUserId">      

                <div class="form-group" id="newPassValidate">
                  <label for="newPassword" class="col-sm-4 control-label">New Password</label>
                  <div class="input-group col-sm-6">
                    <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New Password" maxlength="25" required>
                  </div>
                </div>

                <div class="form-group" id="confPasswordValidate">
                  <label for="confPassword" class="col-sm-4 control-label">Re-type Password</label>
                  <div class="input-group col-sm-6">
                    <input type="password" class="form-control" id="confPassword" name="confPassword" placeholder="Re-type Password" maxlength="25" required>
                  </div>
                </div>

          </form>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success pull-right" id="saveNewPassword">Update Password</button>
        </div>
      </div>
    </div>
  </div>
<!--=========================================================================================-->


  <!------------ ALERTS ------------->
  <div class="alert alert-danger alert-dismissible" id="alertBox" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-ban"></i><span > Items in red are required. Please fill-in.</span>
  </div>

  <div class="alert alert-danger alert-dismissible" id="alertError" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-ban"></i><span > An error occured while saving!</span>
  </div>

   <div class="alert alert-success alert-dismissible" id="alertBoxDeleted" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i> A user has been deleted!
  </div>
  <!----------------------------------->



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
              <th>Employee Name</th>
              <th>Email Address</th>
              <th>Username</th>
              <th>Position</th>
              <?php //if ($_SESSION['user_manage']=='true') { ?>
              <th>Action</th>
              <?php //} ?>
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
  <!-- <input type="text" class="form-control" id="userId" style="display:none"> -->
  <input type="text" class="form-control" id="fullname" style="display:none">
  
<?php
  }
  else {
    include 'error403.php';
  }
  include 'includes/footer.php';
?>

<!--=======================================-->
	<script src=includes/js/user_manage.js></script>
<!--=======================================-->

<?php
  } else{
        header("Location: ../index");
    }
?>