<?php
 session_start();

if(isset($_SESSION['username'])){
    include 'includes/header.php';
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


    <!--=========================== EDIT ROOM DETAILS MODAL ==========================-->
    <div class="modal fade" id="editRoomDetailsMdl">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><label id="editRoomModalLbl"></label></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal form-label-left input_mask">

            <div class="form-group" id="bldgNameMdlValidate">
              <label for="bldgNameDdown" class="col-sm-4 control-label">Building Name *</label>
              <div class="input-group col-sm-4">
                  <select class="form-control" id="bldgNameMdlDdown" placeholder="Select Building">
                  </select>
              </div>
            </div>

            <div class="form-group" id="roomNameMdlValidate">
              <label class="col-sm-4 control-label">Room Name *</label>
              <div class="input-group col-sm-4">
                <input type="text" class="form-control" id="roomNameMdl" name="roomNameMdl" placeholder="Room Name" maxlength="30" required>
                <input type="text" class="form-control" id="roomID" name="roomID" placeholder="ID" style="display:none">
              </div>
            </div>

            <div class="form-group" id="roomNotesMdlValidate">
              <label class="col-sm-4 control-label">Notes</label>
              <div class="input-group col-sm-4">
                <input type="text" class="form-control" id="roomNotesMdl" name="roomNotesMdl" placeholder="Notes" required>
              </div>
            </div>

          </form>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <div class="col-md-3"></div>
            <div class="col-md-4">
            <button type="button" id="updateRoomBtn" class="btn btn-success pull-right"><i class="fas fa-save"></i> &nbsp;&nbsp;Update</button>
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
    <i class="icon fa fa-ban"></i> Error on updating room info!
  </div>

  <div class="alert alert-success alert-dismissible" id="alertBoxSuccess" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i> Success! A new room has been added!
  </div>

  <div class="alert alert-success alert-dismissible" id="alertBoxSuccessDelRoom" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i> A room has been deleted!
  </div>

  <div class="alert alert-success alert-dismissible" id="alertBoxUpdateSuccess" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i> Room info has been updated successfully!
  </div>
  <!----------------------------------->


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3><i class="fas fa-door-open"></i>&nbsp;&nbsp; Manage Rooms</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
      <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Add New Room</h3>
          </div>

          <!-- form start -->
          <form method="POST" action="" data-parsley-validate class="form-horizontal form-label-left">
              <div class="box-body">

                <div class="form-group" id="bldgNameValidate">
                    <label for="bldgNameDdown" class="col-sm-4 control-label">Building Name *</label>
                    <div class="input-group col-sm-4">
                        <select class="form-control" id="bldgNameDdown" placeholder="Select Building">
                        </select>
                    </div>
                </div>

                <div class="form-group" id="roomNameValidate">
                  <label class="col-sm-4 control-label">Room Name *</label>
                  <div class="input-group col-sm-4">
                    <input type="text" class="form-control" id="roomName" name="roomName" placeholder="Room Name" maxlength="30" required>
                  </div>
                </div>

                <div class="form-group" id="roomNotesValidate">
                  <label class="col-sm-4 control-label">Notes</label>
                  <div class="input-group col-sm-4">
                    <input type="text" class="form-control" id="roomNotes" name="roomNotes" placeholder="Notes" required>
                  </div>
                </div>
              
              </div> <!-- box body -->

              <div class="box-footer">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                <button type="reset"  id="resetBtn" class="btn btn-default" title="This will clear all the fields">Reset</button>
                <button type="button" id="saveRoomBtn" class="btn btn-success pull-right">Save</button></div>
              </div> <!-- /.box-footer -->
          </form>
      </div>    

      <!------------------------------------------------------------------------------------------------------------>

      <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Rooms</h3>
          </div> <!-- /box-header-->

          <div class="box-body">
            <table id="roomsTbl" class="table table-bordered table-striped table-hover">
              <thead>
              <tr>
                <th style='display:none'></th>
                <th>Building Name</th>
                <th>Room Name</th>
                <th>Notes</th>
                <?php //if ($_SESSION['user_manage']=='true') { ?>
                <th>Action</th>
                <?php //} ?>
              </tr>
              </thead>
              <tbody id="roomsTbody">
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
  <script src=includes/js/room_manage.js></script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>