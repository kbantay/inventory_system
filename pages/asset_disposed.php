<?php
 session_start();

if(isset($_SESSION['username'])){
    include 'includes/header.php';
    if ($_SESSION['asset_disposed']=="true") {
?>

<!-- ================================================== MAIN CONTENT - BODY ======================================================== -->
  <!---------------------- Loading ----------------->
  <div class="loaderFrame" id="loader" style="display:none">
    <img class="img-loader" src="includes/ring-loader.gif" alt="loading">
    <label>Processing...</label>
  </div>
  <!---------------------- Loading ----------------->


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
                      </div>
                      
                      <div class="col-sm-2">
                          <label class="control-label">Tag Number</label>
                          <input type="text" class="form-control readonly" id="tagnum" readonly>
                      </div>
                      
                      <div class="col-sm-4">
                          <label class="control-label">Serial Number</label>
                          <input type="text" class="form-control  readonly" id="serialNum" placeholder="Serial Number" readonly>
                      </div>
                    </div>

                    <div class="form-group col-sm-12">
                      <div class="col-sm-6">
                          <label class="control-label">Brand-Model</label>
                          <input type="text" class="form-control  readonly" id="brandModel" readonly>
                      </div>
                      
                      <div class="col-sm-6">
                          <label class="control-label">Description</label>
                          <input type="text" class="form-control  readonly" id="description" placeholder="Description" readonly>
                      </div>
                    </div>

                    <div class="form-group col-sm-12">
                      <div class="col-sm-3">
                          <label class="control-label">Quantity</label>
                          <input type="text" class="form-control  readonly" id="quantity" placeholder="Quantity" readonly>
                      </div>
                       
                       <div class="col-sm-3">
                          <label class="control-label">Amount</label>
                          <input type="text" class="form-control  readonly" id="amount" placeholder="Amount" readonly>
                      </div>
                      
                      <div class="col-sm-2">
                          <label class="control-label">Purchased Date</label>
                          <input type="text" class="form-control  readonly" id="purchasedDate" placeholder="Purchased Date" readonly>
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
                      </div>
                    </div>

                    <div class="form-group col-sm-12">
                      <div class="col-sm-12">
                          <label class="control-label">Remarks/ Notes</label>
                          <input type="text" class="form-control  readonly" id="remarks" placeholder="Remarks/ Notes" readonly>
                          <input type="hidden" class="form-control" id="itemID">
                      </div>
                    </div>
                    
                  </div>
                </div>

                
                
                <div class="tab-pane" id="history">             
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
        </div>
      </div>
    </div>
  </div>
<!--=========================================================================================-->


  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3><i class="fas fa-trash-alt"></i>&nbsp;&nbsp; Disposed Asset Record</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
      <div class="box">
        <div class="box-body">
            <table id="disposedAssetTbl" class="table table-bordered table-hover">
              <thead>
              <tr class="bg-gray">
                  <th style="display:none"></th>
                  <th>Tag No.</th>
                  <th>Brand-Model</th>
                  <th>Description</th>
                  <th>Remarks</th>
                  <th>Type</th>
                  <th>Date Disposed</th>
                  <th>Action</th>
              </tr>
              </thead>
              <tbody id="disposedAssetTbody">
              </tbody>
          </table>
        </div>

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
	<script src=includes/js/asset_disposed.js></script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>