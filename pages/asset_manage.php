<?php
 session_start();

if(isset($_SESSION['username'])){
    include 'includes/header.php';
    if ($_SESSION['asset_mngasset']=="true") {
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

  <div class="alert alert-success alert-dismissible" id="alertBoxSuccess" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i> An asset has been disposed!
  </div>
  <!----------------------------------->


 
 
  <!--=========================== ASSETS PER LOCATION MODAL ==========================-->
  <div class="modal fade" id="assetLocationMdl">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        
        <div class="modal-header bg-info">
          <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" style="text-align:center"><label id="assetLocationMdlLbl"></label></h4>
        </div>

        <div class="modal-body">
            <table id="locAssetTbl" class="table table-bordered table-hover">
              <thead>
              <tr class="bg-gray">
                <th style="display:none">ID</th>
                <th>Tag No.</th>
                <th>Category</th>
                <th>Brand-Model</th>
                <th>Description</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody id="locAssetTbody">
              </tbody>
            </table>
        </div>

        <div class="clearfix"></div>
        
      </div>
    </div>
  </div>
 
 
 
 
  <!--=========================== ASSET MORE DETAILS MODAL ==========================-->
    <div class="modal fade" id="assetDetailsMdl">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" style="text-align:center"><label id="assetDetailsMdlLbl"></label></h4>
        </div>
        <div class="modal-body">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#details" data-toggle="tab" id="detailsTab">Details</a></li>
              <li><a href="#history" data-toggle="tab" id="historyTab">History</a></li>
            </ul>

              <div class="tab-content">
                <div class="active tab-pane" id="details">
                <div class="clearfix"></div>
                  <div class="">
                    <div class="form-group col-sm-12">
                      <br>
                      <div class="col-sm-6">
                          <label class="control-label">Category</label>
                          <!-- <input type="hidden" class="form-control readonly" id="itemIDmdl" readonly> -->
                          <input type="text" class="form-control readonly" id="category" readonly>
                          <select class="form-control" id="categoryDdownMdl" style="display: none;">
                          </select>

                          <select class="form-control" id="subcategoryDdownMdl" style="display: none;">
                              <option>Select Category First</option>
                            </select>
                      </div>
                      
                      <div class="col-sm-2">
                          <label class="control-label">Tag Number</label>
                          <input type="text" class="form-control readonly" id="tagnum" readonly>
                      </div>
                      
                      <div class="col-sm-4">
                          <label class="control-label">Serial Number</label>
                          <input type="text" class="form-control  readonly" id="serialNum" placeholder="Serial Number" readonly>
                          <input type="hidden" id="serialNumMdl">
                      </div>
                    </div>

                    <div class="form-group col-sm-12">
                      <div class="col-sm-6">
                          <label class="control-label">Brand-Model</label>
                          <input type="text" class="form-control  readonly" id="brandModel" readonly>
                          <input type="hidden" id="brandModelMdl">
                      </div>
                      
                      <div class="col-sm-6">
                          <label class="control-label">Description</label>
                          <input type="text" class="form-control  readonly" id="description" placeholder="Description" readonly>
                          <input type="hidden" id="descriptionMdl">
                      </div>
                    </div>

                    <div class="form-group col-sm-12">
                      <div class="col-sm-3">
                          <label class="control-label">Quantity</label>
                          <input type="number" class="form-control  readonly" id="quantity" placeholder="Quantity" readonly>
                          <input type="hidden" id="quantityMdl">
                      </div>
                       
                       <div class="col-sm-3">
                          <label class="control-label">Amount</label>
                          <input type="text" class="form-control  readonly" id="amount" placeholder="Amount" readonly>
                          <input type="hidden" id="amountMdl">
                      </div>
                      
                      <div class="col-sm-2">
                          <label class="control-label">Purchased Date</label>
                          <input type="text" class="form-control  readonly" id="purchasedDate" placeholder="Purchased Date" readonly>
                          <div class="input-group date" id="dateAcqBox" style="display: none;">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" class="form-control pull-right" id="dateAcquired" placeholder="mm/dd/yyyy">
                          </div>
                      </div>
                       
                       <div class="col-sm-4">
                          <label class="control-label">Age from acquisition</label>
                          <input type="text" class="form-control  readonly" id="age" placeholder="Age" readonly>
                      </div>
                    </div>

                    <div class="form-group col-sm-12">
                      <div class="col-sm-12">
                          <label class="control-label">Supplier</label>
                          <input type="text" class="form-control  readonly" id="supplier" placeholder="Supplier" readonly>
                          <select class="form-control" id="supplierDdown" style="display: none;">
                            </select>
                      </div>
                    </div>

                    <div class="form-group col-sm-12">
                      <div class="col-sm-6">
                          <label class="control-label">Location</label>
                          <input type="text" class="form-control  readonly" id="location" readonly>
                          <div id="locationDdowns" style="display:none;">
                              <div class="col-sm-7" id="buildingValidate">
                                <select class="form-control" id="buildingDdown">
                                </select>
                              </div>
                              <!-- small space -->
                              <div class="col-sm-5" id="roomValidate">
                                <select class="form-control" id="roomDdown">
                                  <option>Select Bldg First</option>
                                </select>
                              </div>
                          </div>
                      </div>
                      
                      <div class="col-sm-6">
                          <label class="control-label">Person in charge</label>
                          <input type="text" class="form-control  readonly" id="personInCharge" placeholder="Person in charge" readonly>
                          <input type="hidden" id="personInChargeMdl">
                          <div class="box-search-result" id="searchResultBox" style="display: none;">
                            <ul class="search-result" id="searchResult"></ul>
                          </div>
                      </div>
                    </div>

                    <div class="form-group col-sm-12">
                      <div class="col-sm-12">
                          <label class="control-label">Remarks/ Notes</label>
                          <input type="text" class="form-control  readonly" id="remarks" placeholder="Remarks/ Notes" readonly>
                          <input type="text" class="form-control" id="itemID" style="display:none">
                      </div>
                    </div>
                    
                  </div>
                </div>

                
                
                <div class="tab-pane" id="history">
                    <div class="form-group col-sm-12">
                      <div class="form-group col-sm-8" id="activityVld">
                          <label class="control-label">Activity *</label>
                          <input type="text" class="form-control" id="newActivity" placeholder="Activity">
                      </div>
                      <div class="form-group col-sm-4" id="activityDateVld">
                        <label>Date (of activity) *</label>
                        <div class="input-group date">
                          <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                          <input type="text" class="form-control pull-right" id="activityDate" placeholder="mm/dd/yyyy">
                        </div>
                      </div>
                    </div>

                    <div class="form-group col-sm-12">
                      <div class="col-sm-12">
                        <button type="button" id="updateHistoryBtn" class="btn btn-success pull-right"><i class="fas fa-edit"></i>&nbsp; Update</button>
                      </div>
                    </div>
                    
                    </br>
                    <table id="historyTbl" class="table table-bordered table-striped table-hover">
                      <thead>
                      <tr>
                        <th style="display:none">ID</th>
                        <th>Activity</th>
                        <th>Date</th>
                        <th>Updated By</th>
                        <th>Date Updated</th>
                      </tr>
                      </thead>
                      <tbody id="historyTbody">
                      </tbody>
                    </table>
                </div>
        
              </div> 
          </div> 

        </div>
        <div class="clearfix"></div>
        <div class="modal-footer" id="assetDetailsUpdateBtns">
            <button type="button" class="btn btn-info pull-left" id="editAssetDetailsBtn">Edit Details</button>
            <button type="button" class="btn btn-warning pull-left" id="cancelEditingBtn" style="display: none;">Cancel</button>
            <button type="button" class="btn btn-success pull-right" id="updateAssetDetailsBtn" style="display: none;">Update Changes</button>
        </div>
      </div>
    </div>
  </div>
<!--=========================================================================================-->



<!--=========================== DELETE ASSET MODAL ==========================-->
  <div class="modal  fade" id="disposeAssetMdl">
    <div class="modal-dialog modal-md">
      <div class="modal-content ">
        <div class="modal-header bg-danger">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Specify reason of disposal</h4>
        </div>
        <div class="modal-body">
          <div class="box-body">
            <div class="form-group col-sm-12">
              <div class="col-sm-4">
                  <label class="control-label">Tag Number</label>
                  <input type="text" class="form-control" id="tagnumDelMdl">
                  <input type="hidden" id="itemIDMdl">
              </div>
              <!-- small space -->
              <div class="col-sm-8">
                  <label class="control-label">Brand-Model</label>
                  <input type="text" class="form-control" id="brandDelMdl">
              </div>
            </div>

            <div class="col-sm-12">
              <div class="form-group col-sm-4" id="disposeTypeVld">
                  <label for="salesCategory" class="control-label">Type *</label>
                  <select class="form-control" id="delTypeDdownMdl">
                      <option disabled selected>Select Type</option>
                      <option value="Junked">Junked</option>
                      <option value="Sold">Sold</option>
                  </select>
              </div>
              <!-- small space -->
              <div class="form-group col-sm-8" id="dateDisposedVld">
                <label>Date disposed *</label>
                <div class="input-group date">
                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                  <input type="text" class="form-control pull-right" id="disposedDateMdl" placeholder="mm/dd/yyyy">
                </div>
              </div>
            </div>

            <div class="form-group col-sm-12" id="disposeReasonVld">
              <div class="col-sm-12">
                  <label class="control-label">Reason/ Remarks/ Notes *</label>
                  <textarea class="form-control" id="delReasonMdl" name="description" placeholder="Reason/ Remarks/ Notes" required ></textarea>
              </div>
            </div>

          </div><!--/box body--> 
        </div>
        <div class="modal-footer bg-danger" style="text-align: center">
            <button type="button" class="btn btn-danger" id="disposeBtn"><span class='fas fa-trash-alt'></span>&nbsp;&nbsp;&nbsp;Dispose</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div> 
<!--=========================== DELETE ASSET MODAL ==========================-->





    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3><i class="fas fa-tasks"></i>&nbsp;&nbsp; Manage Asset Record</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
      <div class="box">
    
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#allAsset" data-toggle="tab">Assets</a></li>
              <!--li><a href="#perClass" data-toggle="tab">Per Classification</a></li-->
              <li><a href="#perLocation" data-toggle="tab" id="perLocTab">Per Location</a></li>
            </ul>

              <div class="tab-content">
                <!-- /.tab-pane -->
                <div class="active tab-pane" id="allAsset">
                  <div class="box-body">
                    <div class="form-group" class="col-sm-8" id="" style="padding-left: 35%;">
                      <label for="" class="col-sm-2 control-label">Classification:</label>
                      <div class="input-group col-sm-2">
                          <select class="form-control" id="categoryDdown">
                          </select>
                      </div>
                      <input type="hidden" name="astAccess" id="astAccess" value="<?php echo $_SESSION['assetaccess'];?>">
                      <input type="hidden" name="itemClass" id="itemClass">
                    </div>

                    <table id="allAssetTbl" class="table table-bordered table-striped table-hover">
                      <thead>
                      <tr class="bg-gray">
                        <th style="display:none">ID</th>
                        <th>Tag No.</th>
                        <th>Category</th>
                        <th>Brand-Model</th>
                        <th>Description</th>
                        <th>Location</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody id="allAssetTbody">
                      </tbody>
                    </table>
                  </div>  <!-- /.box-body -->
                </div>

                <!-- /.tab-pane -->
                <div class="tab-pane" id="perClass">

                </div>
                
                <!-- /.tab-pane -->
                <div class="tab-pane" id="perLocation">
                  <?php
                    $role = $_SESSION['roleID'];
                    if($role==1){
                  ?>
                      <button type="button" id="updateData" title="Update number of items per location (per current num of entries in this table)"><i class="fas fa-sync-alt"></i></button>
                  <?php
                    }
                  ?>    
                      <div class="box-body">
                        <table id="perLocationTbl" class="table table-bordered table-striped table-hover">
                          <thead>
                          <tr class="bg-gray">
                            <th style="display:none">ID</th>
                            <th>Location</th>
                            <th>Number of Items</th>
                            <th>Last Updated</th>
                            <th>Action</th>
                          </tr>
                          </thead>
                          <tbody id="perLocationTbody">
                          </tbody>
                        </table>
                      </div>  <!-- /.box-body -->
                </div>
                
              </div> <!-- /.tab-content -->
            
          </div> <!-- /.nav-tabs-custom -->
          
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
  <script src=includes/js/asset_manage.js></script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>