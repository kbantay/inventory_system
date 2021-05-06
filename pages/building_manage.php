<?php
 session_start();

if(isset($_SESSION['username'])){
    include 'includes/header.php';
    include 'includes/loader.class.php';
    if ($_SESSION['settings_location']=="true") {
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


    <!--=========================== EDIT BLDG DETAILS MODAL ==========================-->
    <div class="modal fade" id="editBldgDetailsMdl">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><label id="editBldgModalLbl"></label></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal form-label-left input_mask">
            <div class="form-group" id="bldgNameMdlValidate">
              <label class="col-sm-4 control-label">Building Name *</label>
              <div class="input-group col-sm-6">
                <input type="text" class="form-control" id="bldgID" name="bldgID" placeholder="ID" style="display:none">
                <input type="text" class="form-control" id="bldgNameMdl" name="bldgNameMdl" placeholder="Building Name" maxlength="30" required>
              </div>
            </div>

            <div class="form-group" id="bldgShortNameMdlValidate">
              <label class="col-sm-4 control-label">Short Name *</label>
              <div class="input-group col-sm-6">
                <input type="text" class="form-control" id="bldgShortNameMdl" name="bldgShortNameMdl" placeholder="Building Short Name" required>
              </div>
            </div>

            <div class="form-group" id="bldgNotesMdlValidate">
              <label class="col-sm-4 control-label">Notes</label>
              <div class="input-group col-sm-6">
                <input type="text" class="form-control" id="bldgNotesMdl" name="bldgNotesMdl" placeholder="Notes" required>
              </div>
            </div>    
          </form>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <div class="col-md-3"></div>
            <div class="col-md-4">
            <button type="button" id="updateBldgBtn" class="btn btn-success pull-right" title="Update Building Info"><i class="fas fa-save"></i> &nbsp;&nbsp;Update</button>
            </div>
        </div>
      </div>
    </div>
  </div>
<!--=========================================================================================-->


  <!------------ ALERTS ------------->
    <div class="alert alert-danger alert-dismissible" id="alertBox" style="display:none">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <i class="icon fa fa-ban"></i> Item(s) on red box is/ are required and cannot be empty!
    </div>

    <div class="alert alert-danger alert-dismissible" id="alertBoxUpdateError" style="display:none">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <i class="icon fa fa-ban"></i> Error on updating building info!
    </div>

    <div class="alert alert-success alert-dismissible" id="alertBoxSuccess" style="display:none">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <i class="icon fa fa-check"></i> Success! A new user has been added!
    </div>

    <div class="alert alert-success alert-dismissible" id="alertBoxUpdateSuccess" style="display:none">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <i class="icon fa fa-check"></i> Building info has been updated successfully!
    </div>
  <!----------------------------------->


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3><i class="fas fa-building"></i>&nbsp;&nbsp; Manage Building</h3>
    </section>
    <!----------------------------- Main content ---------------------->
    <section class="content">
      <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Add New Building</h3>
          </div>

          <!-- form start -->
          <form data-parsley-validate class="form-horizontal form-label-left">
              <div class="box-body">

                <div class="form-group" id="bldgNameValidate">
                  <label class="col-sm-4 control-label">Building Name *</label>
                  <div class="input-group col-sm-4">
                    <input type="text" class="form-control" id="bldgName" name="bldgName" placeholder="Building Name" maxlength="30" required>
                  </div>
                </div>

                <div class="form-group" id="bldgShortNameValidate">
                  <label class="col-sm-4 control-label">Short Name *</label>
                  <div class="input-group col-sm-4">
                    <input type="text" class="form-control" id="bldgShortName" name="bldgShortName" placeholder="Building Short Name" required>
                  </div>
                </div>

                <div class="form-group" id="bldgNotesValidate">
                  <label class="col-sm-4 control-label">Notes</label>
                  <div class="input-group col-sm-4">
                    <input type="text" class="form-control" id="bldgNotes" name="bldgNotes" placeholder="Notes" required>
                  </div>
                </div>
              
              </div> <!-- box body -->

              <div class="box-footer">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                <button type="reset"  id="resetBtn" class="btn btn-default" title="This will clear all the fields">Reset</button>
                <button type="button" id="saveBldgBtn" class="btn btn-success pull-right">Save</button></div>
              </div> <!-- /.box-footer -->
          </form>
      </div>    

      <!------------------------------------------------------------------------------------------------------------>

      <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Buildings</h3>
          </div> <!-- /box-header-->

          <div class="box-body">
            <table id="buildingTbl" class="table table-bordered table-striped table-hover">
              <thead>
              <tr>
                <th style='display:none'></th>
                <th>Building Name</th>
                <th>Short Name</th>
                <th>Notes</th>
                <?php //if ($_SESSION['user_manage']=='true') { ?>
                <th>Action</th>
                <?php //} ?>
              </tr>
              </thead>
              <tbody id="buildingTbody">
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
          
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
  <script src=includes/js/building_manage.js></script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>