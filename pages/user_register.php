<?php
 session_start();
  // //include_once  'dbconn_handler.php';

if(isset($_SESSION['username'])){
  include 'includes/header.php';
  if ($_SESSION['user_add']=="true") {
?>

<!-- ================================================ MAIN CONTENT - BODY ====================================================== -->
  <!---------------------- Loading ----------------->
  <div class="loaderFrame" id="loader" style="display:none">
    <img class="img-loader" src="includes/ring-loader.gif" alt="loading">
    <label>Processing...</label>
  </div>
  <!---------------------- Loading ----------------->
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

  <!------------ ALERTS ------------->
  <div class="alert alert-danger alert-dismissible" id="alertBox" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-ban"></i> Item(s) on red box is required and cannot be empty!
  </div>
  
  <div class="alert alert-danger alert-dismissible" id="alertUnmatchPass" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-ban"></i> Password did not matched the Re-type Password!
  </div>

  <div class="alert alert-danger alert-dismissible" id="alertUserMin" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-ban"></i> Username/ Password should be at least eight (8) characters.
  </div>

  <div class="alert alert-danger alert-dismissible" id="alertEmailTaken" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-ban"></i><span > Username has already been taken. Try another.</span>
  </div>

   <div class="alert alert-success alert-dismissible" id="alertBoxSuccess" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i> Success! A new user has been added!
  </div>
  <!----------------------------------->

<!--=========================== SEARCH EMPLOYEE MODAL ==========================-->
  <div class="modal fade" id="searchEmployeeMdl">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="closeSearchModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Select an employee</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal form-label-left input_mask">
            
            <div class="form-group col-md-12">
              <div class="col-sm-1"></div>
              <div class="input-group col-sm-10">
                <input type="text" class="form-control" id="searchEmployeeTxt" placeholder="Search..." required>
                <span class="input-group-btn">
                  <button type="button" id="searchBtn" class="btn btn-info" title="Search"><span class="fas fa-fw fa-search"></span></button>
                </span>
              </div>
            </div>


            <div class="box-body">
              <table id="employeeTbl" class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                  <th style="display:none"></th>
                  <th>Employee Name</th>
                  <th>Designation</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody id="employeeTbody">
                </tbody>
              </table>
            </div>


          </form>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
<!--=========================================================================================-->


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3><i class="fas fa-user-plus"></i>&nbsp;&nbsp; Register New User</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
        <div class="row col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">All fields with * are required</h3>
            </div>
            <!-- form start -->
            <form method="POST" action="includes/handlers/user_registration_handler.php" data-parsley-validate class="form-horizontal form-label-left">
              <div class="box-body">

                <div class="form-group" id="fullnameValidate">
                  <label for="fullname" class="col-sm-4 control-label">Fullname *</label>
                  <div class="input-group col-sm-4">
                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Fullname" maxlength="30" required>
                  </div>
                </div>

                <div class="form-group" id="designationValidate">
                  <label for="designation" class="col-sm-4 control-label">Designation *</label>
                  <div class="input-group col-sm-4">
                    <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation" required>
                  </div>
                </div>

                <div class="form-group" id="departmentValidate">
                  <label for="department" class="col-sm-4 control-label">Department *</label>
                  <div class="input-group col-sm-4">
                    <!-- <input type="text" class="form-control" id="department" name="department" placeholder="Department" required> -->
                    <select class="form-control" id="departmentDdown">
                            </select>
                  </div>
                </div>

                <div class="form-group" id="emailValidate">
                  <label for="email" class="col-sm-4 control-label">Email *</label>
                  <div class="input-group col-sm-4">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                  </div>
                </div>

                <div class="form-group" id="usernameValidate">
                  <label for="username" class="col-sm-4 control-label">Username *</label>
                  <div class="input-group col-sm-4">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" maxlength="30" required>
                  </div>
                </div>
                
                <div class="form-group" id="passwordValidate">
                  <label for="password" class="col-sm-4 control-label">Password *</label>
                  <div class="input-group col-sm-4">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" maxlength="25" required>
                  </div>
                </div>

                <div class="form-group" id="confPasswordValidate">
                  <label for="confPassword" class="col-sm-4 control-label">Confirm Password *</label>
                  <div class="input-group col-sm-4">
                    <input type="password" class="form-control" id="confPassword" name="confPassword" placeholder="Re-type Password" maxlength="25" required>
                  </div>
                </div>

                <div class="form-group" id="accessLevelValidate">
                  <label for="accessLevelDdown" class="col-sm-4 control-label">Access Level *</label>
                  <div class="input-group col-sm-4">
                    <select class="form-control" id="accessLevelDdown" placeholder="Select Role">
                    </select>
                  </div>
                </div>

                <div class="form-group" id="assetAccessValidate">
                  <label for="assetAccessDdown" class="col-sm-4 control-label">Asset Access</label>
                  <div class="input-group col-sm-4">
                    <select class="form-control" id="categoryDdown" placeholder="Select Classification">
                    </select>
                  </div>
                </div>

                <div class="form-group" id="secquestionValidate">
                  <label for="seqQuestionDdown" class="col-sm-4 control-label">Security Question</label>
                  <div class="input-group col-sm-4">
                    <select class="form-control" id="seqQuestionDdown" name="seqQuestionDdown" placeholder="Select Role" required>
                        <option selected disabled> Select Question </option>
                        <option value="Who referred you here at IGSL?">Who referred you here at IGSL?</option>
                        <option value="What is the date you were hired here?">What is the date you were hired here?</option>
                        <option value="What is your favorite IGSL event?">What is your favorite IGSL event?</option>
                    </select>
                  </div>
                </div>

                <div class="form-group" id="secAnsValidate">
                  <label for="secAns" class="col-sm-4 control-label">Security Answer</label>
                  <div class="input-group col-sm-4">
                    <input type="text" class="form-control" id="secAns" name="secAns" placeholder="Security Answer" required>
                  </div>
                </div>

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                <button type="reset"  id="resetBtn" class="btn btn-default" title="This will clear all the fields">Reset</button>
                <button type="button" id="addUserBtn" class="btn btn-success pull-right">Submit</button></div>
              </div>
              <!-- /.box-footer -->
            </form>
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
  <script src=includes/js/user_register.js></script>
<!--=======================================-->

<?php
} 
else {
  header("Location: ../index");
}
?>