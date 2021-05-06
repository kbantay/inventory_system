<?php
 session_start();

if(isset($_SESSION['username'])){
    include 'includes/header.php';
?>

<!-- ================================================== MAIN CONTENT - BODY ======================================================== -->
  <!---------------------- Loading ----------------->
  <div class="loaderFrame" id="loader" style="display:none">
    <img class="img-loader" src="includes/ring-loader.gif" alt="loading">
    <label>Processing...</label>
  </div>
  <!---------------------- Loading ----------------->


    <!--=========================== MAIN MODAL FOR REPORTS ==========================-->
    <div class="modal fade" id="reportModalMain">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-header bg-info">
            <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" style="text-align:center"><label id="reportModalLbl"></label></h4>
            </div>

            <div class="modal-body">
                <div class="form-group" class="" id="filterClassDiv" style="display:none">
                        <label for="" class="col-sm-3 control-label">Filter Classification:</label>
                        <div class="input-group col-sm-3">
                            <select class="form-control col-sm-3" id="categoryDdown">
                            </select>
                        </div>
                    <input type="hidden" name="astAccess" id="astAccess" value="<?php echo $_SESSION['assetaccess'];?>">
                    <input type="hidden" name="itemClass" id="itemClass">
                </div>
                
                <div class="form-group col-sm-10" id="locationDiv" style="display:none">
                    <div class="col-sm-2"><label for="building" class="control-label">Location:</label></div>
                    <div class="col-sm-5" id="buildingValidate">
                        <select class="form-control" id="buildingDdown">
                        </select>
                    </div>
                    <div class="col-sm-4" id="roomValidate">
                        <select class="form-control" id="roomDdown">
                          <option>Select Building First</option>
                        </select>
                    </div>
                </div>

                <div class="input-group" id="searchItemDiv" style="display:none">
                    <span class="input-group-addon">
                        <i class="fas fa-search"></i>
                    </span>
                  <div class="input-group col-sm-7">
                    <input type="text" class="form-control" id="searchedItem" placeholder="Find Item">
                  </div>
                </div>
                </br>

                <div class="form-group col-sm-10" id="deptMonthDiv" style="display:none">
                    <div class="col-sm-3"><!--label for="building" class="control-label">Location:</label--></div>
                    <div class="col-sm-5">
                        <select class="form-control" id="deptDdown">
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control" id="monthDdown">
                            <option selected>All Months</option>
                            <option>January</option>
                            <option>February</option>
                            <option>March</option>
                            <option>April</option>
                            <option>May</option>
                            <option>June</option>
                            <option>July</option>
                            <option>August</option>
                            <option>September</option>
                            <option>October</option>
                            <option>November</option>
                            <option>December</option>
                        </select>
                    </div>
                </div>


                <table id="allAssetTbl" class="table table-bordered table-hover" style="display:none;">
                    <thead>
                    <tr class="bg-gray">
                        <th></th>
                        <th>Tag No.</th>
                        <th>Category</th>
                        <th>Brand-Model</th>
                        <th>Description</th>
                        <th>Location</th>
                    </tr>
                    </thead>
                    <tbody id="allAssetTbody">
                    </tbody>
                </table>

                <table id="assetOnLocationTbl" class="table table-bordered table-hover" style="display:none;">
                    <thead>
                    <tr class="bg-gray">
                        <th></th>
                        <th>Location</th>
                        <th>Number of Items</th>
                        <th>Last Updated</th>
                    </tr>
                    </thead>
                    <tbody id="assetOnLocationTbody">
                    </tbody>
                </table>

                <table id="searchedItemTbl" class="table table-bordered table-hover" style="display:none;">
                    <thead>
                    <tr>
                        <th style='display:none'></th>
                        <th style="width: 8%;">Tag No.</th>
                        <th>Brand-Model</th>
                        <th>Description</th>
                        <th>Location</th>
                        <th style="width: 5%;"></th>
                    </tr>
                    </thead>
                    <tbody id="searchedItemTbody">
                    </tbody>
                </table>

                <table id="assetHistoryTbl" class="table table-bordered table-hover" style="display:none;">
                    <thead>
                    <tr class="bg-gray">
                        <th>Activity</th>
                        <th>Date</th>
                        <th>Updated By</th>
                        <th>Date Updated</th>
                    </tr>
                    </thead>
                    <tbody id="assetHistoryTbody">
                    </tbody>
                </table>

                <table id="consumedSuppliesTbl" class="table table-bordered table-hover" style="display:none;">
                    <thead>
                    <tr class="bg-gray">
                        <th>Department</th>
                        <th>Total Amount</th>
                        <th>Month</th>
                        <th>Year</th>
                    </tr>
                    </thead>
                    <tbody id="consumedSuppliesTbody">
                    </tbody>
                    <tfoot>
                        
                    </tfoot>
                </table>

                <table id="deliveriesTbl" class="table table-bordered table-hover" style="display:none;">
                    <thead>
                    <tr class="bg-gray">
                        <th style="display: none;"></th>
                        <th>Date Delivered</th>
                        <th>Supplier</th>
                        <th>Invoice Num</th>
                        <th>Total Amount</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="deliveriesTbody">
                    </tbody>
                </table>

                <table id="deliveredItemsTbl" class="table table-bordered table-hover" style="display:none;">
                    <thead>
                    <tr class="bg-gray">
                        <th>Brandname</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Amount</th>
                        <th>SubTotal</th>
                    </tr>
                    </thead>
                    <tbody id="deliveredItemsTbody">
                    </tbody>
                    <tfoot id="tfootTotal">
                        <tr>
                            <td colspan="6" style="text-align:right; font-weight:bold">Total: </td>
                            <td colspan="1" style="font-weight:bold" id="delTotal"></td>
                        </tr>
                    </tfoot>
                </table>

                <table id="disposedAssetTbl" class="table table-bordered table-hover" style="display:none;">
                    <thead>
                    <tr class="bg-gray">
                        <th></th>
                        <th>Tag No.</th>
                        <th>Brand-Model</th>
                        <th>Description</th>
                        <th>Remarks</th>
                        <th>Type</th>
                        <th>Date Disposed</th>
                    </tr>
                    </thead>
                    <tbody id="disposedAssetTbody">
                    </tbody>
                </table>

                <table id="userLogTbl" class="table table-bordered table-hover" style="display:none;">
                    <thead>
                    <tr class="bg-gray">
                        <th>Log ID</th>
                        <th>Fullname</th>
                        <th>Username</th>
                        <th>Activity</th>
                        <th>Date & Time</th>
                    </tr>
                    </thead>
                    <tbody id="userLogTbody">
                    </tbody>
                </table>
            </div>

            <div class="clearfix"></div>
            
        </div>
        </div>
    </div>




<!----------------------------------------------------------------------------------------------------->
<!--======================================= PAGE'S MAIN BODY ========================================-->
<!----------------------------------------------------------------------------------------------------->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <h3><i class="fas fa-fw fa-file-alt"></i>&nbsp;&nbsp; Generate Reports</h3>
    </div>
    <!-- /.content-header -->

    <!----------------------------- Main content ---------------------->
    <section class="content">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body" style="padding-left:20%">
                <table id="reportingTbl" class="table table-bordered table-striped table-hover" style="width: 70%">
                    <thead>
                        <tr class="bg-gray">
                        <th width="30%">File</th>
                        <th width="50%">Description</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="reportingTbody">
                    <?php if ($_SESSION['report_assets']=="true") { ?>
                        <tr id="allAssets">
                            <td > All assets</td>
                            <td>List of all assets</td>
                        </tr>
                        <tr id="assetsPerLoc">
                            <td> All assets in a room</td>
                            <td>List of all items in a specified location</td>
                        </tr>
                        <tr id="assetsNumPerLoc">
                            <td> Assets per location</td>
                            <td>Number of items in each location</td>
                        </tr>
                        <tr id="assetHistory">
                            <td> Asset History</td>
                            <td>Activities and movement history of an item</td>
                        </tr>
                    <?php } ?>
                    <?php if ($_SESSION['report_cons']=="true") { ?>
                        <tr id="consumedSupplies">
                            <td> Consumed Supplies</td>
                            <td>Consumed supplies per department and month</td>
                        </tr>
                    <?php } ?>
                    <?php if ($_SESSION['report_delsupplies']=="true") { ?>
                        <tr id="deliveredItems">
                            <td> Delivered Items</td>
                            <td>Deliveries of Consumable Supplies</td>
                        </tr>
                    <?php } ?>
                    <?php if ($_SESSION['report_delhistory']=="true") { ?>
                        <tr id="disposedAsset">
                            <td> Disposed Assets</td>
                            <td>Items that no longer in use; either junked, sold or gave away</td>
                        </tr>
                    <?php } ?>
                    <?php if ($_SESSION['report_userlogs']=="true") { ?>
                        <tr id="userLog">
                            <td> User Log</td>
                            <td>Activites of users inside the system</td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                </br>
            </div>
        </div>
    </section>
    <!-- /.content -->
  </div>

<?php
    include 'includes/footer.php';
?>
<!--=======================================-->
    <script src=includes/js/reports.js></script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>