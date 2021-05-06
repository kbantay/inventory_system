<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IGSL SAMS</title>
  <!-- -Titlebar icon -->
  <link rel="icon" href="../favicon.ico">
  <link rel="stylesheet" href="../dist/css/loader.css">
  <link rel="stylesheet" href="../dist/css/listresult.css">
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <script src="https://kit.fontawesome.com/2ca9bfa0f4.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>


<body class="">
<div style="height: 50px; background-color:#3c8dbc"></div>
<!-- <div class="wrapper" style="background-color:#ecf0f5"> -->

  
  <!------------ JS ALERTS ------------->
  <div class="alert alert-danger alert-dismissible" id="alertErrorNoUser" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-ban"></i> Please enter your username.
  </div>

  <div class="alert alert-danger alert-dismissible" id="alertErrorNoAnswer" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-ban"></i> Please enter your answer.
  </div>

  <div class="alert alert-danger alert-dismissible" id="alertErrorInvalidUser" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-ban"></i> Invalid username. Please try again or contact the system administrator.
  </div>

  <div class="alert alert-danger alert-dismissible" id="alertErrorNoQuestion" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-ban"></i> Security question has not been set. You cannot reset password in this page. Please contact the system administrator.
  </div>

  <div class="alert alert-danger alert-dismissible" id="alertErrorNoAnswerFound" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-ban"></i> No answer found in the database.
  </div>

  <div class="alert alert-danger alert-dismissible" id="alertErrorInvalidAnswer" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-ban"></i> Invalid answer. Please take not that the answer is case sensitive. Please try again or contact the system administrator.
  </div>


  <div class="alert alert-success alert-dismissible" id="alertSuccessPasswordReset" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i> Password has been successfully reset.
  </div>
  <!----------------------------------->
  
  
 <!--=========================== Change Password MODAL ==========================-->
 <div class="modal fade" id="changePassMdl">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <button type="button" class="close" id="closeSearchModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="changePassMdlTitle">Reset Password</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal form-label-left input_mask"> 

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
          <button type="button" class="btn btn-success pull-right" id="saveNewPassword">Reset Password</button>
        </div>
      </div>
    </div>
  </div>
<!--=========================================================================================-->



    <!-- ======================================= MAIN CONTENT - BODY ========================================= -->
  <!---------------------- Loading ----------------->
  <div class="loaderFrame" id="loader" style="display:none">
    <img class="img-loader" src="includes/ring-loader.gif" alt="loading">
    <label>Processing...</label>
  </div>
  <!---------------------- Loading ----------------->
  
  <!-- Content Wrapper. Contains page content -->
  <div class="box" style="padding-left: 200px; padding-right: 200px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3><i class="fas fa-unlock-alt"></i>&nbsp;&nbsp; Forgot Password</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
      
      <div class="box" >
          <div class="col-sm-3"></div>
          <div class="form-group col-sm-8">
            <h5 style="text-align: right;"><a href="../index">Back to login</a></h5>
            <center>
            <br>
              

              <div id="usernameBox" class="col-md-10">
                <label class="col-sm-1 control-label">Username:</label>
                <div class="input-group col-sm-8">
                  <input type="text" class="form-control" id="username" placeholder="Username">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-info" id="verifyUserBtn">Submit</button>
                    </span>
                </div>
              </div>

              <div id="questionBox" class="col-md-10" style="display: none;">
                <label class="col-sm-0 control-label" id="secQuestion">Question?</label>
                
                <div class="input-group col-sm-8">
                  <input type="text" class="form-control" id="answer" placeholder="Answer">
                    <span class="input-group-btn">
                      <button type="button" class="btn btn-info" id="submitAnswerBtn">Submit</button>
                    </span>
                </div>
              </div>  

              <!-- <div class="col-sm-3"></div> -->

            </center>  
          </div>
      </div>
      
    </section>
    <!-- /.content -->
  </div>
  <input type="hidden" id="selectedUserID">
  <input type="hidden" id="fullname">
  <!-- </div> -->

  <!--=======================================-->
	<script src=includes/js/forgotpassword.js></script>

  
  <!--========================================== FOOTER SECTION GOES BEYOND HERE ===============================-->
  <!-- <footer class="main-footer">
    <div class="text-right"><small>Copyright &copy; 2020 &nbsp;&nbsp;|&nbsp;&nbsp;</strong> IGSL Supplies and Asset Management System   |   Designed and Developed by IGSL ICT team</small></div>
  </footer> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script src="../bower_components/jquery-ui/jquery-ui.min.js"></script>
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="includes/js/sidebarChangedPassValidation.js"></script>
<script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="../bower_components/fastclick/lib/fastclick.js"></script>
<script src="../dist/js/adminlte.min.js"></script>

</body>
</html>