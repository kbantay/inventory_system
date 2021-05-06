<?php
 session_start();

if(isset($_SESSION['username'])){
    include 'includes/header.php';
    if ($_SESSION['settings_supplier']=="true") {
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

  
<!--=========================== EDIT SUPPLIERS DETAILS MODAL ==========================-->
  <div class="modal fade" id="editSupplierDetailsMdl">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><label id="editSupplierModalLbl"></label></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal form-label-left input_mask">

                <div class="form-group col-sm-11">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10" id="supplierNameMdlValidate">
                        <label for="supplierName" class="control-label">Supplier's Name *</label>
                        <input type="text" class="form-control" id="supplierNameMdl" placeholder="Supplier's Name" required>
                        <input type="text" class="form-control" id="supplierIdMdl" placeholder="" style="display:none">
                    </div>
                </div>

                <div class="form-group col-sm-11">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10" id="supAddressMdlValidate">
                        <label for="supAddress" class="control-label" >Address *</label>
                        <textarea class="form-control" id="supAddressMdl" placeholder="Address" rows="3"></textarea>
                    </div>
                </div>

                <div class="form-group col-sm-11">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-5" id="supContactNumMdlValidate">
                        <label for="supContactNum" class="control-label">Contact Number *</label>
                        <input type="number" class="form-control" id="supContactNumMdl" placeholder="Contact Number" required>
                    </div>
                    <!-- small space -->
                    <div class="col-sm-5" id="supTypeMdlValidate">
                        <label for="salesCategory" class="control-label">Type *</label>
                            <select class="form-control" id="supTypeMdlDdown">
                                <option disabled>Select Type</option>
                                <option selected value="Asset">Asset</option>
                                <option value="Supplies">Supplies</option>
                            </select>
                    </div>
                </div>

          </form>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <div class="col-md-3"></div>
            <div class="col-md-4">
            <button type="button" id="updateSupplierBtn" class="btn btn-success pull-right"><i class="fas fa-save"></i> &nbsp;&nbsp;Update</button>
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
    <i class="icon fa fa-ban"></i> Error on updating supplier's info!
  </div>

  <div class="alert alert-success alert-dismissible" id="alertBoxSuccess" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i> Success! A new supplier has been added!
  </div>

  <div class="alert alert-success alert-dismissible" id="alertBoxSuccessDelRoom" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i> A supplier has been deleted!
  </div>

  <div class="alert alert-success alert-dismissible" id="alertBoxUpdateSuccess" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i> Supplier's info has been updated successfully!
  </div>
  <!----------------------------------->


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3><i class="fas fa-store"></i>&nbsp;&nbsp; Manage Suppliers</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
      <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Add New Supplier</h3>
          </div>

          <!-- form start -->
          <form method="POST" action="" data-parsley-validate class="form-horizontal form-label-left">
              <div class="box-body">

                <div class="form-group col-sm-11">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10" id="supplierNameValidate">
                        <label for="supplierName" class="control-label">Supplier's Name *</label>
                        <input type="text" class="form-control" id="supplierName" placeholder="Supplier's Name" pattern="[^:]*$" required>
                    </div>
                </div>

                <div class="form-group col-sm-11">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10" id="supAddressValidate">
                        <label for="supAddress" class="control-label" >Address *</label>
                        <textarea class="form-control" id="supAddress" placeholder="Address" rows="3"></textarea>
                    </div>
                </div>

                <div class="form-group col-sm-11">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-5" id="supContactNumValidate">
                        <label for="supContactNum" class="control-label">Contact Number *</label>
                        <input type="text" class="form-control" id="supContactNum" placeholder="Contact Number" required>
                    </div>
                    <!-- small space -->
                    <div class="col-sm-5" id="supTypeValidate">
                        <label for="salesCategory" class="control-label">Type *</label>
                            <select class="form-control" id="supTypeDdown">
                                <option disabled>Select Type</option>
                                <option selected value="Asset">Asset</option>
                                <option value="Supplies">Supplies</option>
                            </select>
                    </div>
                </div>
              
              </div> <!-- box body -->

              <div class="box-footer">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                <button type="reset"  id="resetBtn" class="btn btn-default" title="This will clear all the fields">Reset</button>
                <button type="button" id="saveSupplierBtn" class="btn btn-success pull-right">Save</button></div>
              </div> <!-- /.box-footer -->
          </form>
      </div>    

      <!------------------------------------------------------------------------------------------------------------>

      <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Suppliers</h3>
          </div> <!-- /box-header-->

          <div class="box-body">
            <table id="supplierTbl" class="table table-bordered table-striped table-hover">
              <thead>
              <tr>
                <th style='display:none'></th>
                <th>Supplier Name</th>
                <th>Address</th>
                <th>Contact Number</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody id="supplierTbody">
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
  <script src=includes/js/supplier_manage.js></script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>