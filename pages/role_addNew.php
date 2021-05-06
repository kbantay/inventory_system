<?php
 session_start();
  // //include_once  'dbconn_handler.php';

if(isset($_SESSION['username'])){
  include 'includes/header.php';
  if ($_SESSION['user_role']=="true") {
?>

<!-- ============================================ MAIN CONTENT - BODY ============================================== -->
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
    <i class="icon fa fa-ban"></i><span > Items in red are required. Please fill-in.</span>
  </div>

  <div class="alert alert-danger alert-dismissible" id="alertError" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-ban"></i><span > An error occured while saving!</span>
  </div>

   <div class="alert alert-success alert-dismissible" id="alertBoxSuccess" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i> Success! A new user role has been added!
  </div>
  <!----------------------------------->


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3><i class="fas fa-user-alt"></i>&nbsp;&nbsp; Add New Role</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
        <div class="row col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Role per user with permission</h3>
            </div>
            <!-- form start -->
            <form method="POST" action="" data-parsley-validate class="form-horizontal form-label-left">
              <div class="box-body">

                <div class="form-group" id="roleNameValidate">
                  <label for="roleName" class="col-sm-4 control-label">Role</label>
                  <div class="input-group col-sm-4">
                    <input type="text" class="form-control" id="roleName" name="roleName" placeholder="Role Name" maxlength="50" required>
                  </div>
                </div>

                <div class="form-group" id="roleDescValidate">
                  <label for="description" class="col-sm-4 control-label">Description</label>
                  <div class="input-group col-sm-4">
                    <textarea class="form-control" id="roleDesc" name="description" placeholder="Role Description" row="6" required style="height: 100px"></textarea>
                  </div>
                </div>

                <label class="col-sm-12 control-label" style="display:block; text-align:center; border-top: 1px solid #c2c2c2">PERMISSIONS</label>
               
                <!--------------------------------------------------------------------------------------------------------------------->
                <div class="form-group col-sm-12"></div>
                <label class="col-sm-12 control-label" style="display:block; text-align:center; border-top: 1px solid #c2c2c2">User Module</label>
                <div class="form-group col-sm-12">
                  <div class="row col-sm-2"></div>
                  <div class="checkbox col-sm-3">
                    <label for="userAddChk" class="control-label"><input type="checkbox" id="userAddChk">Add New User</label>
                  </div>
                  <!-- small space -->
                  <div class="checkbox col-sm-3">
                    <label for="userViewChk" class="control-label"><input type="checkbox" id="userViewChk">View Users List</label>
                  </div>
                  <!-- small space -->
                  <div class="checkbox col-sm-3">
                    <label for="userEditChk" class="control-label"><input type="checkbox" id="userEditChk">Edit User Permission</label>
                  </div>

                  <div class="row col-sm-2"></div>
                  <div class="checkbox col-sm-3">
                    <label for="userLogs" class="control-label"><input type="checkbox" id="userLogs">View User Logs</label>
                  </div>
                  <!-- small space -->
                  <div class="checkbox col-sm-3">
                    <label for="userRole" class="control-label"><input type="checkbox" id="userRole">Manage User Role</label>
                  </div>
                  <!-- small space -->
                  <div class="checkbox col-sm-3">
                    <label for="userUpdateInfo" class="control-label"><input type="checkbox" id="userUpdateInfo">Update User Info</label>
                  </div>
                </div>

                <!--------------------------------------------------------------------------------------------------------------------->
                <div class="form-group col-sm-12"></div>
                <label class="col-sm-12 control-label" style="display:block; text-align:center; border-top: 1px solid #c2c2c2">Outlet Module</label>
                <div class="form-group col-sm-12">
                  <div class="row col-sm-2"></div>
                  <div class="checkbox col-sm-3">
                    <label for="outletSupListChk" class="control-label"><input type="checkbox" id="outletSupListChk">Supplies List</label>
                  </div>
                  <!-- small space -->
                  <div class="checkbox col-sm-3">
                    <label for="outletReqSupChk" class="control-label"><input type="checkbox" id="outletReqSupChk">Manage Requested Supplies</label>
                  </div>
                  <!-- small space -->
                  <div class="checkbox col-sm-3">
                    <label for="outletResItemChk" class="control-label"><input type="checkbox" id="outletResItemChk">Restock Item</label>
                  </div>
                  
                  <div class="row col-sm-2"></div>
                  <div class="checkbox col-sm-3">
                    <label for="outletSupListChk" class="control-label"><input type="checkbox" id="outletPendingRestockChk">Pending Restock</label>
                  </div>
                </div>

                <!--------------------------------------------------------------------------------------------------------------------->
                <div class="form-group col-sm-12"></div>
                <label class="col-sm-12 control-label" style="display:block; text-align:center; border-top: 1px solid #c2c2c2">Warehouse Module</label>
                <div class="form-group col-sm-12">
                  <div class="row col-sm-2"></div>
                  <div class="checkbox col-sm-3">
                    <label for="whRegItemChk" class="control-label"><input type="checkbox" id="whRegItemChk">Register Item</label>
                  </div>
                  <!-- small space -->
                  <div class="checkbox col-sm-3">
                    <label for="whSetupItemChk" class="control-label"><input type="checkbox" id="whSetupItemChk">Setup Item</label>
                  </div>
                  <!-- small space -->
                  <div class="checkbox col-sm-3">
                    <label for="whSupListChk" class="control-label"><input type="checkbox" id="whSupListChk">Supplies List</label>
                  </div>
                  <div class="row col-sm-2"></div>
                  <div class="checkbox col-sm-3">
                    <label for="whEncReqSupChk" class="control-label"><input type="checkbox" id="whEncReqSupChk">Encode Requested Supplies</label>
                  </div>
                  <div class="checkbox col-sm-3">
                    <label for="whEncDelChk" class="control-label"><input type="checkbox" id="whEncDelChk">Encode Delivery</label>
                  </div>
                  <div class="checkbox col-sm-3">
                    <label for="whMngDelChk" class="control-label"><input type="checkbox" id="whMngDelChk">Manage Delivery</label>
                  </div>
                  <!-- small space -->
                  <div class="row col-sm-2"></div>
                  <div class="checkbox col-sm-3">
                    <label for="whResReqChk" class="control-label"><input type="checkbox" id="whResReqChk">Restock Resquest</label>
                  </div>
                </div>

                <!--------------------------------------------------------------------------------------------------------------------->
                <div class="form-group col-sm-12"></div>
                <label class="col-sm-12 control-label" style="display:block; text-align:center; border-top: 1px solid #c2c2c2">Asset Module</label>
                <div class="form-group col-sm-12">
                  <div class="row col-sm-2"></div>
                  <div class="checkbox col-sm-3">
                    <label for="astAddNewChk" class="control-label"><input type="checkbox" id="astAddNewChk">Add New Asset</label>
                  </div>
                  <!-- small space -->
                  <div class="checkbox col-sm-3">
                    <label for="astMngAssetChk" class="control-label"><input type="checkbox" id="astMngAssetChk">Manage Asset</label>
                  </div>
                  <!-- small space -->
                  <div class="checkbox col-sm-3">
                    <label for="astDispItemAssetChk" class="control-label"><input type="checkbox" id="astDispItemAssetChk">Disposed Item</label>
                  </div>
                </div>

                <!-------------------------------------------------------------------------------------------------------------------->
                <div class="form-group col-sm-12"></div>
                <label class="col-sm-12 control-label" style="display:block; text-align:center; border-top: 1px solid #c2c2c2">Reports</label>
                <div class="form-group col-sm-12">
                  <div class="row col-sm-2"></div>
                  <div class="checkbox col-sm-3">
                    <label for="assetsChk" class="control-label"><input type="checkbox" id="assetsChk">Assets</label>
                  </div>
                  <div class="checkbox col-sm-3">
                    <label for="repConsChk" class="control-label"><input type="checkbox" id="repConsChk">Consumed Supplies</label>
                  </div>
                  <div class="checkbox col-sm-3">
                    <label for="delSuppliesChk" class="control-label"><input type="checkbox" id="delSuppliesChk">Delivered Supplies</label>
                  </div>
                  <!-- small space -->
                  <div class="row col-sm-2"></div>
                  <div class="checkbox col-sm-3">
                    <label for="repDisposedChk" class="control-label"><input type="checkbox" id="repDisposedChk">Disposed Item</label>
                  </div>
                  <div class="checkbox col-sm-3">
                    <label for="userlogsChk" class="control-label"><input type="checkbox" id="userlogsChk">User Logs</label>
                  </div>
                </div>

                <!--------------------------------------------------------------------------------------------------------------------->
                <div class="form-group col-sm-12"></div>
                <label class="col-sm-12 control-label" style="display:block; text-align:center; border-top: 1px solid #c2c2c2">Settings Module</label>
                <div class="form-group col-sm-12">
                  <div class="row col-sm-2"></div>
                  <div class="checkbox col-sm-3">
                    <label for="setAssetSubChk" class="control-label"><input type="checkbox" id="setAssetSubChk">Asset Category</label>
                  </div>
                  <!-- small space -->
                  <div class="checkbox col-sm-3">
                    <label for="setOutletEmailNotChk" class="control-label"><input type="checkbox" id="setOutletEmailNotChk">Outlet Email Notification</label>
                  </div>
                  <!-- small space -->
                  <div class="checkbox col-sm-3">
                    <label for="setWhEmailNotChk" class="control-label"><input type="checkbox" id="setWhEmailNotChk">Warehouse Email Notification</label>
                  </div>
                  <div class="row col-sm-2"></div>
                  <div class="checkbox col-sm-3">
                    <label for="setSupplierChk" class="control-label"><input type="checkbox" id="setSupplierChk">Supplier</label>
                  </div>
                  <div class="checkbox col-sm-3">
                    <label for="setDeptChk" class="control-label"><input type="checkbox" id="setDeptChk">Deparment</label>
                  </div>
                  <div class="checkbox col-sm-3">
                    <label for="setLocationChk" class="control-label"><input type="checkbox" id="setLocationChk">Location</label>
                  </div>
                </div>

                <!--------------------------------------------------------------------------------------------------------------------->

                <div class="form-group col-sm-12"></div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                <button type="reset"  id="resetBtn" class="btn btn-default" title="This will clear all the fields">Reset</button>
                <button type="button" name="regsubmit" id="saveRoleBtn" class="btn btn-success pull-right">Save</button></div>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <input type="text" id="userID" value="<?php echo $_SESSION['userID']; ?>" readonly>

<?php
      }
  else {
    include 'error403.php';
  }
  include 'includes/footer.php';
?>

<!--=======================================-->
  <script src=includes/js/role_saveNew.js></script>
<!--=======================================-->

<?php
  } else{
        header("Location: ../index");
    }
?>