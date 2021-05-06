<?php
 session_start();

if(isset($_SESSION['username'])){
    include 'includes/header.php';
    if ($_SESSION['asset_addnew']=="true") {
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


  <!------------ ALERTS ------------->
  <div class="alert alert-danger alert-dismissible" id="alertBox" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-ban"></i> Item(s) on red box is/ are required and cannot be empty!
  </div>

  <div class="alert alert-danger alert-dismissible" id="alertBoxQty" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-ban"></i> Quantity should not be less than 1!
  </div>

  <div class="alert alert-danger alert-dismissible" id="alertBoxSaveError" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-ban"></i> An error occured upon saving this new asset!
  </div>

  <!----------------------------------->


  <!--=========================== NEWLY ADDED ASSET DETAILS MODAL ==========================-->
  <div class="modal fade" id="newAssetDetailsMdl">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" style="text-align:center"><label>A new asset has been added succesfully!</label></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal form-label-left input_mask">
            <div class="form-group">
              <label class="col-sm-4 control-label">Brand-Model</label>
              <div class="input-group col-sm-6">
                <input type="text" class="form-control" style="background-color:white" id="brandModelMdl" name="brandModelMdl" readonly>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 control-label">Description</label>
              <div class="input-group col-sm-6">
                <input type="text" class="form-control" style="background-color:white" id="descriptionMdl" name="descriptionMdl" readonly>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 control-label">Tag Number</label>
              <div class="input-group col-sm-6 bg-warning" style="border: 1px solid #d9d9d9">
                <!-- <input type="text" class="form-control" id="tagnumMdl" name="tagnumMdl" readonly> -->
                <h2 style="text-align:center"><label id="tagnumLblMdl"></label></h2>
              </div>
            </div>    
          </form>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <div class="col-md-3"></div>
            <div class="col-md-5">
            <button type="button" id="okMdlBtn" class="btn btn-success pull-right"><i class="far fa-thumbs-up"></i> &nbsp;&nbsp;Okay got it</button>
            </div>
        </div>
      </div>
    </div>
  </div>
<!--=========================================================================================-->





    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3><i class="fas fa-dolly-flatbed"></i>&nbsp;&nbsp; Add New Asset</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
      <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">All fields with * are required</h3>
          </div>

          <!-- form start -->
          <form method="POST" action="" data-parsley-validate class="form-horizontal form-label-left">
              <div class="box-body">

                <div class="form-group col-sm-10" id="dateAcquiredValidate">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                      <label>Date Acquired *</label>
                      <div class="input-group date">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        <input type="text" class="form-control pull-right" id="dateAcquired" placeholder="mm/dd/yyyy">
                      </div>
                    </div>
                </div>

                <div class="form-group col-sm-10">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-5" id="categoryValidate">
                        <label for="category" class="control-label">Category *</label>
                            <select class="form-control" id="categoryDdown">
                            </select>
                        <input type="hidden" id="assetAccess" value="<?=$_SESSION['assetaccess']?>">
                    </div>
                    <!-- small space -->
                    <div class="col-sm-4" id="subcategoryValidate">
                        <label for="subcategoryDdown" class="control-label">Subcategory *</label>
                            <select class="form-control" id="subcategoryDdown">
                              <option>Select Category First</option>
                            </select>
                    </div>
                </div>

                <div class="form-group col-sm-10">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9" id="brandModelValidate">
                        <label for="brandModel" class="control-label">Brand - Model *</label>
                        <input type="text" class="form-control" id="brandModel" placeholder="Brand - Model">
                    </div>
                </div>

                <div class="form-group col-sm-10">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9" id="descriptionValidate">
                        <label for="description" class="control-label">Description *</label>
                        <input type="text" class="form-control" id="description" placeholder="Color/ weight/ size/ shape/ texture/ material/ distinguishing feature">
                    </div>
                </div>

                <div class="form-group col-sm-10">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9" id="serialNumberValidate">
                        <label for="serialNumber" class="control-label">Serial Number</label>
                        <input type="text" class="form-control" id="serialNumber" placeholder="Serial Number">
                    </div>
                </div>

                <div class="form-group col-sm-10">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-5" id="quantityValidate">
                        <label for="quantity" class="control-label">Quantity *</label>
                        <input type="number" class="form-control" id="quantity" value="1" placeholder="Quantity">
                    </div>
                    <!-- small space -->
                    <div class="col-sm-4" id="unitCostValidate">
                        <label for="unitCost" class="control-label">Unit Cost *</label>
                        <input type="text" class="form-control" id="unitCost" placeholder="Amount in Php without comma (ex. 25930.50)">
                    </div>
                </div>

                <div class="form-group col-sm-10">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9" id="supplierValidate">
                        <label for="supplier" class="control-label">Supplier</label>
                            <select class="form-control" id="supplierDdown">
                            </select>
                    </div>
                </div>

                <div class="form-group col-sm-10">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9" id="referenceNumValidate">
                        <label for="referenceNum" class="control-label">Reference Number</label>
                        <input type="text" class="form-control" id="referenceNum" value="CV #" placeholder="Reference Number">
                    </div>
                </div>

                <div class="form-group col-sm-10">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-5" id="buildingValidate">
                        <label for="building" class="control-label">Location *</label>
                        <select class="form-control" id="buildingDdown">
                        </select>
                    </div>
                    <!-- small space -->
                    <div class="col-sm-4" id="roomValidate">
                        <label for="roomDdown" class="control-label" style="color: white">.</label>
                        <select class="form-control" id="roomDdown">
                          <option>Select Building First</option>
                        </select>
                    </div>
                </div>

                <div class="form-group col-sm-10">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-5" id="personInChargeValidate">
                        <label for="personInCharge" class="control-label">Person in charge *</label>
                        <input type="text" class="form-control" id="personInCharge" placeholder="Full name">
                        <div class="box-search-result" id="searchResultBox" style="display: none;">
                          <ul class="search-result" id="searchResult"></ul>
                        </div>
                    </div>
                    <!-- small space -->
                    <div class="col-sm-4" id="departmentValidate">
                        <label for="departmentDdown" class="control-label">Department *</label>
                        <select class="form-control" id="departmentDdown">
                        </select>
                    </div>
                </div>

                <div class="form-group col-sm-10">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9" id="remarksValidate">
                        <label for="remarks" class="control-label" >Notes/ Remarks</label>
                        <textarea class="form-control" id="remarks" placeholder="Notes/ remarks" rows="3"></textarea>
                    </div>
                </div>

              
              </div> <!-- box body -->

              <div class="box-footer">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                  <button type="reset"  id="resetBtn" class="btn btn-default" title="This will clear all the fields">Reset</button>
                  <button type="button" id="saveAssetBtn" class="btn btn-success pull-right">Save</button>
                  <!-- <button type="button" id="try" class="btn btn-danger pull-right">Try</button> -->
                  <label class="pull-right" title="Retain all information from your recently saved item">
                    <h6><input type="checkbox" class="" id="retainDataChk" title="Retain all information from your recently saved item"> Retain Data
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h6>
                  </label>
                </div>
              </div> <!-- /.box-footer -->
          </form>
      </div>    

      <!------------------------------------------------------------------------------------------------------------>

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
  <script src=includes/js/asset_add.js></script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>