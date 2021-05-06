<?php
 session_start();

if(isset($_SESSION['username'])){
     include 'includes'.DIRECTORY_SEPARATOR.'header.php';

     $userRole = $_SESSION['roleName'];
?>

<!-- ================================================== MAIN CONTENT - BODY ======================================================== -->
   <!---------------------- Loading ----------------->
   <div class="loaderFrame" id="loader" style="display:none">
    <img class="img-loader" src="includes/ring-loader.gif" alt="loading">
    <label>Processing...</label>
  </div>
  <!---------------------- Loading ----------------->


    <!--=========================== VIEW ENCODED DELIVERY ITEMS MODAL ==========================-->
    <div class="modal fade" id="deliveredSuppliesMdl">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><label id="deliveredSuppliesLbl"></label></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal form-label-left input_mask">

            <div class="form-group col-sm-12">
                <div class="col-sm-2">
                    <label class="control-label">Date Delivery</label>
                    <input class="hidden" id="dlvrdSupIDModal">
                    <input class="hidden" id="supplierNameModal">
                    <input type="text" class="form-control" id="dateDelivered" placeholder="Date Delivered">
                </div>
                <div class="col-sm-10">
                    <label class="control-label">Remarks</label>
                    <input type="text" class="form-control" id="delRemarks" placeholder="Remarks">
                </div>
            </div>
            <table id="delItemsTbl" class="table table-bordered table-striped table-hover">
                <thead>
                <tr class="bg-gray">
                  <th style='display:none; width: 3%'></th>
                  <th style="width: 20%;">Brandame</th>
                  <th style="width: 20%;">Product Name</th>
                  <th style="width: 17%;">Description</th>
                  <th style="width: 10%;">Quantity</th>
                  <th style="width: 10%;">Unit</th>
                  <th style="width: 10%;">Amount</th>
                  <th style="width: 10%;">SubTotal</th>
                </tr>
                </thead>
                <tbody id="delItemsTbody">
                </tbody>
                <tfoot id="tfootTotal">
                  <tr>
                    <td colspan="6" style="text-align:right; font-weight:bold">Total: </td>
                    <td colspan="1" style="font-weight:bold" id="delTotal"></td>
                  </tr>
                </tfoot>
            </table>

          </form>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <?php if($_SESSION['warehouse_mngdel']=="true"){ ?>
            <div class="col-md-3"></div>
            <div class="col-md-4">
            <button type="button" id="approveDeliveryBtn" class="btn btn-success pull-right"><i class="fas fa-check"></i> &nbsp;&nbsp;Approve Delivery</button>
            </div>
          <?php } ?>
        </div> 
      </div>
    </div>
  </div>
  <!--=========================================================================================-->



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
              <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
              <li><a href="#history" data-toggle="tab" id="historyTab">History</a></li>
            </ul>

              <div class="tab-content">
                <!-- /.tab-pane -->
                <div class="active tab-pane" id="details">
                  <div class="box-body">
                    <div class="form-group col-sm-12">
                      <div class="col-sm-6">
                          <label class="control-label">Category</label>
                          <input type="text" class="form-control" id="category">
                      </div>
                      <!-- small space -->
                      <div class="col-sm-2">
                          <label class="control-label">Tag Number</label>
                          <input type="text" class="form-control" id="tagnum">
                      </div>
                      <!-- small space -->
                      <div class="col-sm-4">
                          <label class="control-label">Serial Number</label>
                          <input type="text" class="form-control" id="serialNum" placeholder="Serial Number">
                      </div>
                    </div>

                    <div class="form-group col-sm-12">
                      <div class="col-sm-6">
                          <label class="control-label">Brand-Model</label>
                          <input type="text" class="form-control" id="brandModel">
                      </div>
                      <!-- small space -->
                      <div class="col-sm-6">
                          <label class="control-label">Description</label>
                          <input type="text" class="form-control" id="description" placeholder="Description">
                      </div>
                    </div>

                    <div class="form-group col-sm-12">
                      <div class="col-sm-3">
                          <label class="control-label">Quantity</label>
                          <input type="text" class="form-control" id="quantity" placeholder="Quantity">
                      </div>
                       <!-- small space -->
                       <div class="col-sm-3">
                          <label class="control-label">Amount</label>
                          <input type="text" class="form-control" id="amount" placeholder="Amount">
                      </div>
                      <!-- small space -->
                      <div class="col-sm-2">
                          <label class="control-label">Purchased Date</label>
                          <input type="text" class="form-control" id="purchasedDate" placeholder="Purchased Date">
                      </div>
                       <!-- small space -->
                       <div class="col-sm-4">
                          <label class="control-label">Age from acquisition</label>
                          <input type="text" class="form-control" id="age" placeholder="Age">
                      </div>
                    </div>

                    <div class="form-group col-sm-12">
                      <div class="col-sm-12">
                          <label class="control-label">Supplier</label>
                          <input type="text" class="form-control" id="supplier" placeholder="Supplier">
                      </div>
                    </div>

                    <div class="form-group col-sm-12">
                      <div class="col-sm-6">
                          <label class="control-label">Location</label>
                          <input type="text" class="form-control" id="location">
                      </div>
                      <!-- small space -->
                      <div class="col-sm-6">
                          <label class="control-label">Person in charge</label>
                          <input type="text" class="form-control" id="personInCharge" placeholder="Person in charge">
                      </div>
                    </div>

                    <div class="form-group col-sm-12">
                      <div class="col-sm-12">
                          <label class="control-label">Remarks/ Notes</label>
                          <input type="text" class="form-control" id="remarks" placeholder="Remarks/ Notes">
                          <input type="text" class="form-control" id="itemID" style="display:none">
                      </div>
                    </div>
                    
                  </div>  <!-- /.box-body -->
                </div>

                <!-- /.tab-pane -->
                <div class="tab-pane" id="history">
                    <div class="form-group col-sm-12">
                      <div class="form-group col-sm-8" id="activityVld">
                          <label class="control-label">Activity *</label>
                          <input type="text" class="form-control" id="newActivity" placeholder="Activity">
                      </div>
                       <!-- small space -->
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
        
              </div> <!-- /.tab-content -->
          </div> <!-- /.nav-tabs-custom -->
        </div>
        <div class="clearfix"></div>
        
      </div>
    </div>
  </div>
<!--=========================================================================================-->


   <!--=========================== VIEW REQUESTED ITEMS MODAL ==========================-->
   <div class="modal fade" id="requestedItemsMdl">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><label id="requestedSuppliesLbl"></label></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal form-label-left input_mask">
            <input class="hidden" id="rqstSupID">
            <input type="hidden" id="dateNow" value="<?php echo date("m/d/Y");?>">
            <!-- <div class="form-group col-sm-12">
                <div class="col-sm-2">
                    <label class="control-label">Date Delivery</label>
                    
                    <input class="hidden" id="supplierNameModal">
                    <input type="text" class="form-control" id="dateDelivered" placeholder="Date Delivered">
                </div>
                <div class="col-sm-10">
                    <label class="control-label">Remarks</label>
                    <input type="text" class="form-control" id="delRemarks" placeholder="Remarks">
                </div>
            </div> -->
            <table id="requestedItemsTbl" class="table table-bordered table-striped table-hover">
                <thead>
                <tr class="bg-gray">
                  <th style='display:none; width: 1%'></th>
                  <th style="width: 44%;">Item</th>
                  <th style="width: 15%;">Quantity</th>
                  <th style="width: 15%;">Unit</th>
                  <th style="width: 25%;">Type</th>
                </tr>
                </thead>
                <tbody id="requestedItemsTbody">
                </tbody>
            </table>

          </form>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <div class="col-md-3"></div>
            <div class="col-md-4">
              <?php if($userRole!="User"){?>
                <button type="button" id="claimItemsBtn" class="btn btn-success pull-right"><i class="fas fa-check"></i> &nbsp;&nbsp;Claim Supplies</button>
              <?php }?>
            </div>
        </div>
      </div>
    </div>
  </div>
  <!--=========================================================================================-->





  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <!-- <div id="liveClock"><h5 class="pull-right" id="liveClockNow"></h5></div> -->
      <h3>Welcome <?php echo $_SESSION['currentUser']; ?>!</h3>
      <input type="hidden" id="userRole" value="<?php echo $userRole ?>">
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
      <div class="row" id="shortcutBox" style="display:none"> <!-- SHORTCUT INFO BOX -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3 id="assetCount"></h3>

              <p>Total Asset Count</p>
            </div>
            <div class="icon">
              <i class="fas fa-briefcase"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3 id="assetCost"></h3>

              <p>Total Asset Cost (PhP)</p>
            </div>
            <div class="icon">
              <i class="fas fa-money-bill-alt"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 id="deliveredSupplies"></h3>

              <p>Pending Delivered Supplies</p>
            </div>
            <div class="icon">
              <i class="fas fa-truck-loading"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 id="whLowStocks"></h3>

              <p>Lowering Supplies</p>
            </div>
            <div class="icon">
              <i class="fas fa-folder-open"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>



      <!-----=================== Quick Search Box ---===================-->
      <?php if($_SESSION['asset_addnew']=="true" || $_SESSION['asset_mngasset']=="true" || $_SESSION['asset_disposed']=="true"){ ?>
      <div class="box" id="quickSearchBox" >
          <div class="box-header with-border">
            <h3 class="box-title">Asset Quick Search</h3>
          </div>
          <div class="box-body">
            <form class="form-horizontal form-label-left">
                <div class="row" id="">
                  <div class="col-sm-4"></div>
                  <div class="col-sm-4" >
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fas fa-search"></i></span>
                      <input type="text" class="form-control" id="searchBar" placeholder="Search for..." maxlength="30">
                    </div>
                  </div>
                </div>
            </form>
          </div> <!-- /box body -->

          <div class="box-body" id="searchResultSection">
              <table id="srchResultTbl" class="table table-bordered table-striped table-hover" style="display:none">
                <thead>
                <tr>
                  <th>Tag Num</th>
                  <th>Category</th>
                  <th>Brand-Model</th>
                  <th>Description</th>
                  <th>Location</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody id="srchResultTbody">
                </tbody>
              </table>
          </div> <!-- /box body -->
      </div> <!-- /Quick Search box -->
      <?php } ?>


      <!-----=================== USER'S OWN REQUESTED SUPPLIES ---===================-->
      <div class="box" id="userReqSuppliesBox">
          <div class="box-header with-border">
            <h3 class="box-title">My Requested Supplies</h3>
          </div>
          <div class="box-body">
              <table id="userReqSuppliesTbl" class="table table-bordered table-striped table-hover">
                <thead>
                <tr class="bg-info">
                  <th style="display:none; width: 1%;"></th>
                  <th style="width: 8%;">Request ID</th>
                  <th style="width: 10%;">Date Requested</th>
                  <th style="width: 30%;">Requestor</th>
                  <th style="width: 32%;">Department</th>
                  <th style="width: 10%;">Status</th>
                  <th style="width: 9%;">Action</th>
                </tr>
                </thead>
                <tbody id="userReqSuppliesTbody">
                </tbody>
              </table>
          </div> 
      </div> <!---->


      <!-----=================== PENDING REQUESTED SUPPLIES ---===================-->
    <?php if($_SESSION['outlet_reqsup']=="true"){?>
      <div class="box" id="requestedSuppliesBox">
          <div class="box-header with-border">
            <h3 class="box-title">Pending Requested Supplies</h3>
            <!-- <input type="hidden" id="curRow"> -->
            <!-- <button type="button" id="showRecAddedBoxBtn" class='btn btn-default pull-right' title='Show Pending Encoded Delivery' style="display:none"><i class="fas fa-angle-double-down"></i></button>
            <button type="button" id="hideRecAddedBoxBtn" class='btn btn-default pull-right' title='Hide Pending Encoded Delivery'><i class="fas fa-angle-double-up"></i></button> -->
            <!-- For consumed table -->
            <input type="hidden" id="reqsDept">
            <input type="hidden" id="requestedSuppliesAmt">
            <input type="hidden" id="reqsMonth">
            <input type="hidden" id="reqsYear">
          </div>
          <div class="box-body">
              <table id="requestedSuppliesTbl" class="table table-bordered table-striped table-hover">
                <thead>
                <tr class="bg-info">
                  <th style="display:none; width: 1%;"></th>
                  <th style="width: 8%;">Request ID</th>
                  <th style="width: 10%;">Date Requested</th>
                  <th style="width: 30%;">Requestor</th>
                  <th style="width: 32%;">Department</th>
                  <th style="width: 10%;">Status</th>
                  <th style="width: 9%;">Action</th>
                </tr>
                </thead>
                <tbody id="requestedSuppliesTbody">
                </tbody>
              </table>
              
          </div>
      </div> <!---->

      <!-- For consumed table -->
      <input type="hidden" id="consrecordID">
      <input type="hidden" id="consDept">
      <input type="hidden" id="consTotalAmt">
      <input type="hidden" id="consMonth">
      <input type="hidden" id="consYear">

    <?php } ?>


      <!-----=================== PENDING ENCODED DELIVERY ---===================-->
    <?php if($userRole!="User"){?>
      <div class="box" id="encodedDeliveryBox">
          <div class="box-header with-border">
            <h3 class="box-title">Pending Encoded Delivery</h3>
            <input type="hidden" id="curRow">
            <!-- <button type="button" id="showRecAddedBoxBtn" class='btn btn-default pull-right' title='Show Pending Encoded Delivery' style="display:none"><i class="fas fa-angle-double-down"></i></button>
            <button type="button" id="hideRecAddedBoxBtn" class='btn btn-default pull-right' title='Hide Pending Encoded Delivery'><i class="fas fa-angle-double-up"></i></button> -->
          </div>
          <div class="box-body">
              <table id="encodedDeliveryTbl" class="table table-bordered table-striped table-hover">
                <thead>
                <tr class="bg-info">
                  <th style="width: 15%;">Date Delivered</th>
                  <th style="width: 35%;">Supplier</th>
                  <th style="width: 15%;">Invoice No.</th>
                  <th style="width: 10%;">Total Amount</th>
                  <th style="width: 15%;">Status</th>
                  <th style="width: 10%;">Action</th>
                </tr>
                </thead>
                <tbody id="encodedDeliveryTbody">
                </tbody>
              </table>
          </div> <!-- /box body -->
      </div> <!-- /PENDING ENCODED DELIVERY -->
    <?php } ?>

      <!-----=================== Recently Added Box ---===================-->
    <?php if($userRole!="User"){?>
      <div class="box" id="recentlyAddedBox" >
          <div class="box-header with-border">
            <h3 class="box-title">Recently Added Assets</h3>
            <button type="button" id="showRecAddedBoxBtn" class='btn btn-default pull-right' title='Show Recently Added Assets' style="display:none"><i class="fas fa-angle-double-down"></i></button>
            <button type="button" id="hideRecAddedBoxBtn" class='btn btn-default pull-right' title='Hide Recently Added Assets'><i class="fas fa-angle-double-up"></i></button>
          </div>
          <div class="box-body" id="rcntAddedBox">
              <table id="rcntAddedTbl" class="table table-bordered table-striped table-hover">
                <thead>
                <tr class="bg-gray">
                  <th>Tag Num</th>
                  <th>Category</th>
                  <th>Brand-Model</th>
                  <th>Description</th>
                  <th>Location</th>
                  <th>Date Added</th>
                </tr>
                </thead>
                <tbody id="rcntAddedTbody">
                </tbody>
              </table>
          </div> <!-- /box body -->
      </div> <!-- /Recently Added box -->
    <?php } ?>


    <!-----=================== Warehouse Stocks Info ---===================-->
    <?php if($_SESSION['allWarehouseAccess']){?>
      <div class="box" id="warehouseStockBox" style="display:none;">
        <div class="box-header with-border">
          <h3 class="box-title">Warehouse Stocks Info</h3>
        </div>
        <div class="box-body" id="whStockInfoBox">
            <table id="whStockInfoTbl" class="table table-bordered table-striped table-hover">
              <thead>
              <tr>
                <th>itemID</th>
                <th>productID</th>
                <th>stocksFull</th>
                <th>stocksLeft</th>
                <th>percentage</th>
              </tr>
              </thead>
              <tbody id="whStockInfoTbody">
              </tbody>
            </table>
        </div> <!-- /box body -->
      </div> <!-- /Recently Added box -->
    <?php } ?>


      <!--============ CHANGE PASSWORD ON FIRST LOGIN PANEL =============-->
      <div class="box" id="updateDefaultPass" style="display:none">
        <div class="box-header">
          <h3 class="box-title">Change Default Password</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form class="form-horizontal form-label-left input_mask">

                <div class="form-group" id="currentPassValidate">
                  <label for="currentPassword" class="col-sm-5 control-label">Current Password</label>
                  <div class="input-group col-sm-3">
                    <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Current Password" maxlength="30" required>
                  </div>
                </div>
                
                <div class="form-group" id="newPassValidate">
                  <label for="newPassword" class="col-sm-5 control-label">New Password</label>
                  <div class="input-group col-sm-3">
                    <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New Password" maxlength="25" required>
                  </div>
                </div>

                <div class="form-group" id="confPasswordValidate">
                  <label for="confPassword" class="col-sm-5 control-label">Re-type Password</label>
                  <div class="input-group col-sm-3">
                    <input type="password" class="form-control" id="confPassword" name="confPassword" placeholder="Re-type Password" maxlength="25" required>
                  </div>
                </div>
                

          </form>
        </div>
        <div class="clearfix"></div>
        <div class="box-footer">
          <center>
          <button type="button" class="btn btn-success align-self-center" id="saveNewPassword"><i class="fas fa-save"></i> Update Password</button>
          </center>
        </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
<!--============ END OF CHANGE PASSWORD ON FIRST LOGIN PANEL =============-->

      

    </section>
    <!-- /.content -->
  </div>

<?php
    include 'includes/footer.php';
?>
<!--=======================================-->
	<script src=includes/js/home.js></script>
  <script src=includes/js/user_UpdateDefaultPass.js></script>
<!--=======================================-->
<?php
  } else{
         header("Location: ../index");
  }
?>