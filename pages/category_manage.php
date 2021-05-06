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


    <!--=========================== EDIT CATEGORY DETAILS MODAL ==========================-->
    <div class="modal fade" id="editCategoryDetailsMdl">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><label id="editCategoryModalLbl"></label></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal form-label-left input_mask">
            <div class="form-group" id="categoryNameMdlValidate">
              <label class="col-sm-4 control-label">Category Name *</label>
              <div class="input-group col-sm-6">
                <input type="text" class="form-control" id="categoryID" name="categoryID" placeholder="ID" style="display:none">
                <input type="text" class="form-control" id="categoryNameMdl" name="categoryNameMdl" placeholder="Category Name" maxlength="70" required>
              </div>
            </div>

            <div class="form-group" id="categoryNotesMdlValidate">
              <label class="col-sm-4 control-label">Notes</label>
              <div class="input-group col-sm-6">
                <input type="text" class="form-control" id="categoryNotesMdl" name="categoryNotesMdl" placeholder="Notes" required>
              </div>
            </div>    
          </form>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <div class="col-md-3"></div>
            <div class="col-md-4">
            <button type="button" id="updateCatBtn" class="btn btn-success pull-right" title="Update Category Info"><i class="fas fa-save"></i> &nbsp;&nbsp;Update</button>
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
    <i class="icon fa fa-ban"></i> Error on updating category info!
  </div>

  <div class="alert alert-success alert-dismissible" id="alertBoxSuccess" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i> A new category has been added successfully!
  </div>

  <div class="alert alert-success alert-dismissible" id="alertBoxUpdateSuccess" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i> Category info has been updated successfully!
  </div>
  <!----------------------------------->


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3><i class="fas fa-th-large"></i>&nbsp;&nbsp; Manage Categories</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
      <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Add New Category</h3>
          </div>

          <!-- form start -->
          <form method="POST" action="" data-parsley-validate class="form-horizontal form-label-left">
              <div class="box-body">

                <div class="form-group" id="categoryNameValidate">
                  <label class="col-sm-4 control-label">Category Name *</label>
                  <div class="input-group col-sm-4">
                    <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="Category Name" maxlength="70" required>
                  </div>
                </div>

                <div class="form-group" id="categoryNotesValidate">
                  <label class="col-sm-4 control-label">Notes</label>
                  <div class="input-group col-sm-4">
                    <input type="text" class="form-control" id="categoryNotes" name="categoryNotes" placeholder="Notes" required>
                  </div>
                </div>
              
              </div> <!-- box body -->

              <div class="box-footer">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                <button type="reset"  id="resetBtn" class="btn btn-default" title="This will clear all the fields">Reset</button>
                <button type="button" id="saveCatBtn" class="btn btn-success pull-right">Save</button></div>
              </div> <!-- /.box-footer -->
          </form>
      </div>    

      <!------------------------------------------------------------------------------------------------------------>

      <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Categories</h3>
          </div> <!-- /box-header-->

          <div class="box-body">
            <table id="categoryTbl" class="table table-bordered table-striped table-hover">
              <thead>
              <tr>
                <th style='display:none'></th>
                <th>Category Name</th>
                <th>Notes</th>
                <?php //if ($_SESSION['user_manage']=='true') { ?>
                <th>Action</th>
                <?php //} ?>
              </tr>
              </thead>
              <tbody id="categoryTbody">
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
  <script src=includes/js/category_manage.js></script>
<!--=======================================-->
<?php
  } else{
        header("Locategoryion: ../index");
    }
?>