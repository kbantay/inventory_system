<?php
 session_start();

if(isset($_SESSION['username'])){
    include 'includes/header.php';
    if ($_SESSION['settings_whemail']=="true") {
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


   <!-------------- JS ALERTS ------------->
   <div class="alert alert-danger alert-dismissible" id="alertBoxError" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-ban"></i> An error occured upon updating the current email notification receiver!
  </div>

  <div class="alert alert-success alert-dismissible" id="alertBoxSuccess" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i> Current email notification receiver has been updated!
  </div>
  <!----------------------------------->


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3><i class="far fa-envelope"></i>&nbsp;&nbsp; Warehouse Admin Email Notification Setup</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
      <div class="box">

        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">System Users</h3>
                </div>
                <div class="box-body">
                    <table id="sysUsersTbl" class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Employee Name</th>
                            <th>Email Address</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="sysUsersTbody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Current Warehouse Admin</h3>
                    <input type="hidden" id="page" value="warehouse">
                </div>
                <div class="box-body">
                    <div class="form-group col-sm-12">
                        <label class="control-label">Full Name</label>
                        <input type="text" class="form-control" id="fullName" placeholder="Full Name" style="background-color: white;" readonly>
                    </div>

                    <div class="form-group col-sm-12">
                        <label class="control-label">Email Address</label>
                        <input type="text" class="form-control" id="emailAddress" placeholder="Email Address" style="background-color: white;" readonly>
                        </br>
                        <button type="button" class="btn btn-success pull-right" id="updateEmailReceiver">Update</button>
                    </div>

                    
                </div>
            </div>
        </div>


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
	<script src="includes/js/email_receiver.js"></script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>