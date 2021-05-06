<?php
 session_start();

if(isset($_SESSION['username'])){
    include 'includes/header.php';
    if ($_SESSION['settings_assetsubcat']=="true") {
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
    <div class="modal fade" id="editSubcatDetailsMdl">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><label id="editSubcatModalLbl"></label></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal form-label-left input_mask">

            <div class="form-group" id="categoryNameMdlValidate">
              <label for="categoryNameMdlDdown" class="col-sm-4 control-label">Category *</label>
              <div class="input-group col-sm-4">
                  <select class="form-control" id="categoryMdlDdown" placeholder="Select Category">
                  </select>
              </div>
            </div>

            <div class="form-group" id="subcategoryMdlValidate">
              <label class="col-sm-4 control-label">Subcategory *</label>
              <div class="input-group col-sm-4">
                <input type="text" class="form-control" id="subcategoryMdl" name="subcategoryMdl" placeholder="Subcategory" maxlength="30" required>
                <input type="text" class="form-control" id="subcategoryID" name="subcategoryID" placeholder="ID" style="display:none">
              </div>
            </div>

            <div class="form-group" id="subcatNotesMdlValidate">
              <label class="col-sm-4 control-label">Notes</label>
              <div class="input-group col-sm-4">
                <input type="text" class="form-control" id="subcatNotesMdl" name="subcatNotesMdl" placeholder="Notes" required>
              </div>
            </div>

          </form>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <div class="col-md-3"></div>
            <div class="col-md-4">
            <button type="button" id="updateSubcatBtn" class="btn btn-success pull-right"><i class="fas fa-save"></i> &nbsp;&nbsp;Update</button>
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
    <i class="icon fa fa-ban"></i> Error on updating subcategory info!
  </div>

  <div class="alert alert-success alert-dismissible" id="alertBoxSuccess" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i> Success! A new subcategory has been added!
  </div>

  <div class="alert alert-success alert-dismissible" id="alertBoxSuccessDelRoom" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i> A subcategory has been deleted!
  </div>

  <div class="alert alert-success alert-dismissible" id="alertBoxUpdateSuccess" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i> Subcategory info has been updated successfully!
  </div>
  <!----------------------------------->


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3><i class="fas fa-th"></i>&nbsp;&nbsp; Manage Subcategories</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
      <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Add New Subcategory</h3>
          </div>

          <!-- form start -->
          <form method="POST" action="" data-parsley-validate class="form-horizontal form-label-left">
              <div class="box-body">

                <div class="form-group" id="categoryNameValidate">
                    <label for="categoryNameDdown" class="col-sm-4 control-label">Category Name *</label>
                    <div class="input-group col-sm-4">
                        <select class="form-control" id="categoryNameDdown" placeholder="Select Building">
                        </select>
                    </div>
                </div>

                <div class="form-group" id="subcategoryNameValidate">
                  <label class="col-sm-4 control-label">Subcategory Name *</label>
                  <div class="input-group col-sm-4">
                    <input type="text" class="form-control" id="subcategoryName" name="subcategoryName" placeholder="Subcategory Name" maxlength="40" required>
                  </div>
                </div>

                <div class="form-group" id="subcategoryNotesValidate">
                  <label class="col-sm-4 control-label">Notes</label>
                  <div class="input-group col-sm-4">
                    <input type="text" class="form-control" id="subcategoryNotes" name="subcategoryNotes" placeholder="Notes" required>
                  </div>
                </div>
              
              </div> <!-- box body -->

              <div class="box-footer">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                <button type="reset"  id="resetBtn" class="btn btn-default" title="This will clear all the fields">Reset</button>
                <button type="button" id="saveSubcatBtn" class="btn btn-success pull-right">Save</button></div>
              </div> <!-- /.box-footer -->
          </form>
      </div>    

      <!------------------------------------------------------------------------------------------------------------>

      <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Subcategories</h3>
          </div> <!-- /box-header-->

          <div class="box-body">
            <table id="subcatTbl" class="table table-bordered table-striped table-hover">
              <thead>
              <tr>
                <th style='display:none'></th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Notes</th>
                <?php //if ($_SESSION['user_manage']=='true') { ?>
                <th>Action</th>
                <?php //} ?>
              </tr>
              </thead>
              <tbody id="subcatTbody">
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
  <script src=includes/js/subcategory_manage.js></script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>