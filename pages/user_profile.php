<?php
 session_start();

if(isset($_SESSION['username'])){
     include 'includes/header.php';
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
    <i class="icon fa fa-ban"></i> Item(s) on red box is required!
  </div>

   <div class="alert alert-success alert-dismissible" id="alertBoxSuccess" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i> Profile information has been updated successfully!.
  </div>
  <!----------------------------------->


  <!--=========================== Change Password MODAL ==========================-->
  <div class="modal fade" id="changePassMdl">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="closeSearchModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Change Password</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal form-label-left input_mask">

                <div class="form-group" id="currentPassValidate">
                  <label for="currentPassword" class="col-sm-4 control-label">Current Password</label>
                  <div class="input-group col-sm-6">
                    <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Current Password" maxlength="30" required>
                  </div>
                </div>
                
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


  <!--=========================== UPLOAD PHOTO MODAL ==========================-->
  <div class="modal fade" id="uploadPhotoMdl">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <button type="button" class="close" id="closeSearchModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Upload Profile Photo</h4>
        </div>
        <div class="modal-body">
          <form id="uploadForm" class="form-horizontal form-label-left input_mask" method="post"  enctype="multipart/form-data">
            <div class="form-group">
              <label class="col-md-4 control-label" for="profilePhoto">Profile Photo</label>  
              <div class="col-md-5">
                <input type="file" id="file" name="file" class="form-control input-md" required="">
              </div>
            </div>

            <div class="form-group">
              <!-- <label class="col-md-4 control-label" for="upload"></label> -->
              <div class="col-md-9">
                <button type="button" id="uploadBtn" name="upload" class="btn btn-success pull-right"><span class='fas fa-upload'>&nbsp;</span> Upload</button>
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
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
<!--=========================================================================================-->



    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3><i class="far fa-id-card"></i>&nbsp;&nbsp; User Profile</h3>
      <input type="hidden" id="sysuserID" value="<?=$_SESSION['userID']?>">
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
      

      <div class="row">
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">

              <img class="profile-user-img img-responsive img-circle" id="profileImg" src="../dist/img/user.jpg" alt="User profile picture">
              <input type="hidden" id="imgPath" value="<?=$_SESSION['profilePic'];?>">
              
              <h3 class="profile-username text-center" id="boxFullname"></h3>
              <input type="hidden" id="user_manage" value="<?=$_SESSION['user_manage']?>">
              <input type="hidden" id="user_updateInfo" value="<?=$_SESSION['user_updateInfo']?>">
              <input type="hidden" id="selectedUserID" value="">
              <input type="hidden" id="roleID" value="">

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item text-center">
                  <b id="boxUsername"></b>
                </li>
              <?php if($_SESSION['user_manage']=="true"){?>
                <li class="list-group-item text-center">  
                  <div class="form-group" id="roleValidate">
                    <select class="form-control" id="userRoleDdown">
                    </select>
                  </div>
                </li>
              <?php } ?>
              </ul>

              <button class="btn btn-primary btn-block" id="changePassBtn"><b><span class='fas fa-sync-alt'>&nbsp;</span> Change Password</b></button>
              <button class="btn btn-info btn-block" id="openUploadBtn"><b><span class='fas fa-upload'>&nbsp;</span> Change Profile Photo</b></button>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->


        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-body box-profile">
            <form class="form-horizontal form-label-left input_mask">

              <div class="form-group col-sm-12">
                <div class="col-sm-6">
                  <label for="fullName" class="control-label">Full Name</label>
                  <input type="text" class="form-control" id="fullName" placeholder="Full Name">
                </div>
                <!-- small space -->
                <div class="col-sm-6">
                  <label for="designation" class="control-label">Designation</label>
                  <input type="text" class="form-control" id="designation" placeholder="Designation">
                </div>
              </div>

              <div class="form-group col-sm-12">
                <div class="col-sm-3">
                  <label for="" class="control-label">Username</label>
                  <input type="text" class="form-control" id="userName" placeholder="userName" style="background-color: #fffdf5;">
                </div>
                <div class="col-sm-3">
                  <label for="email" class="control-label">Email Address</label>
                  <input type="text" class="form-control" id="email" placeholder="Email Address">
                </div>
                <!-- small space -->
                <div class="col-sm-6" id="deptValidate">
                  <label for="department" class="control-label">Department</label>
                    <input type="text" class="form-control" id="departmentTxt" placeholder="Department" style="background-color: white;" readonly>
                    <select class="form-control" id="departmentDdown" style="display:none">
                    </select>
                </div>
              </div>

              <div class="form-group col-sm-12">
                <div class="col-sm-12">
                  <label for="secquestion" class="control-label">Security Question</label>
                  <input type="text" class="form-control" id="secquestion" placeholder="Security Question" style="background-color: #fffdf5;">
                </div>
              </div>

              <div class="form-group col-sm-12">
                <div class="col-sm-12">
                  <label for="secanswer" class="control-label">Security Answer</label>
                  <input type="text" class="form-control" id="secanswer" placeholder="Security Answer" style="background-color: #fffdf5;">
                </div>
              </div>

            </form>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success pull-right" id="saveUserInfoBtn">Save changes</button>
            </div>
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->


    </section>
    <!-- /.content -->
  </div>

<?php
    include 'includes/footer.php';
?>
<!--=======================================-->
  <script src=includes/js/user_profile.js></script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>