<?php
 session_start();

if(isset($_SESSION['username'])){
    include 'includes/header.php';
    if ($_SESSION['outlet_resitem']=="true") {
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

  
  <!--=========================== SPECIFY QUANTITY UPON SELECTION MODAL ==========================-->
  <div class="modal fade" id="selectedItemMdl">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><label id="selectedItemLbl"></label></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal form-label-left input_mask">

                <div class="form-group col-sm-12">
                  <div class="col-sm-6">
                      <label class="control-label">Brandname</label>
                      <input type="text" class="form-control" id="brandname" readonly>
                      <input type="hidden" id="productId">
                  </div>
                  <div class="col-sm-6">
                      <label class="control-label">Product Name</label>
                      <input type="text" class="form-control" id="productName" readonly>
                      <input type="hidden" id="productID">
                  </div>
                </div>

                <div class="form-group col-sm-12">
                  <div class="col-sm-6">
                      <label class="control-label">Description</label>
                      <input type="text" class="form-control" id="description" placeholder="Description" readonly>
                      <input type="hidden" id="itemType">
                  </div>
                  <div class="col-sm-3">
                      <label class="control-label">Unit Cost</label>
                      <input type="text" class="form-control" id="unitCost" placeholder="Unit Cost" readonly>
                  </div>
                  <div class="col-sm-3">
                      <label class="control-label">Current Stocks Left</label>
                      <input type="text" class="form-control" id="stocksLeft" placeholder="Stocks Left" readonly>
                      <input type="hidden" id="stocksFull">
                  </div>
                </div>

                <div class="form-group col-sm-12">
                  <div class="col-sm-6">
                      <label class="control-label">Quantity *</label>
                      <input type="number" class="form-control" id="quantity" placeholder="Enter Quantity" style="background-color:#fffded;">
                  </div>
                  <div class="col-sm-6">
                      <label class="control-label">Unit</label>
                      <input type="text" class="form-control" id="unit" placeholder="Unit" readonly>
                  </div>
                </div>

          </form>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <div class="col-md-3"></div>
            <div class="col-md-4">
            <button type="button" id="selectItemBtn" class="btn btn-success pull-right"><i class="fas fa-plus"></i> &nbsp;&nbsp;Add</button>
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

  <div class="alert alert-success alert-dismissible" id="alertBoxSuccess" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i> Requested consumable supplies has been saved successfully!
  </div>
  <!----------------------------------->


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3><i class="fas fa-boxes"></i>&nbsp;&nbsp; Request Restock of Supplies</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
      <div class="box">
          <!-- <div class="box-header with-border">
            <h3 class="box-title">Delivery Information</h3>
          </div> -->

          <!-- form start -->
          <form method="POST" action="" data-parsley-validate class="form-horizontal form-label-left">
              <div class="box-body">
                <div class="form-group col-sm-12">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-4" id="employeeValidate">
                        <label class="control-label">Employee *</label>
                        <input type="text" class="form-control" id="requestor" value="<?php echo $_SESSION['currentUser']; ?>" style="background-color: white;" readonly>
                    </div>
                    <!-- small space -->
                    <div class="col-sm-3" id="departmentValidate">
                        <label class="control-label">Department *</label>
                            <input type="text" class="form-control" id="department" value="Outlet Stocks - Reception" style="background-color: white;" readonly>
                    </div>
                    <!-- small space -->
                    <div class="col-sm-3" id="dateRequestedValidate">
                        <label class="control-label">Date Requested *</label>
                        <input type="text" class="form-control" id="dateRequested" value="<?php echo date("m/d/Y");?>" style="background-color: white;" readonly>
                        <!-- <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" class="form-control pull-right" id="dateRequested" placeholder="mm/dd/yyyy">
                      </div> -->
                    </div>
                </div>

                <div class="form-group col-sm-12">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10">
                        <label class="control-label">Remarks</label>
                        <input type="text" class="form-control" id="remarks" placeholder="remarks">
                    </div>
                </div>
              
              </div> <!-- box body -->
          </form>
      </div>    

      <!------------------------------------------------------------------------------------------------------------>
      <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Find an Item</h3>
            <button type="button" id="showFindItemBoxBtn" class='btn btn-default pull-right' title='Show "Find an Item" box' style="display:none"><i class="fas fa-angle-double-down"></i></button>
            <button type="button" id="hideFindItemBoxBtn" class='btn btn-default pull-right' title='Hide "Find an Item" box'><i class="fas fa-angle-double-up"></i></button>
          </div>

          <div class="box-body" id="findItemBox">
            <div class="row" >
                <div class="col-sm-4"></div>
                <div class="col-sm-4" >
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" id="itemSearch" placeholder="Search..." maxlength="30">
                </div>
                </div>
            </div>
            </br>
            <table id="itemsTbl" class="table table-bordered table-striped table-hover" style="display:none;">
              <thead>
              <tr class="bg-gray">
                <th style='display:none'></th>
                <th>Brandame</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody id="itemsTbody">
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
      </div>   


      <!------------------------------------------------------------------------------------------------------------>
      <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Requested Items</h3>
          </div>

          <div class="box-body">
            <table id="requestedTbl" class="table table-bordered table-striped table-hover" style="display:none;">
              <thead>
              <tr class="bg-info">
                <th style='display:none; width: 1%'></th>
                <th style="width: 20%;">Brandame</th>
                <th style="width: 20%;">Product Name</th>
                <th style="width: 27%;">Description</th>
                <th style="width: 10%;">Quantity</th>
                <th style="width: 10%;">Unit</th>
                <th style='display:none; width: 1%'></th>
                <th style='display:none; width: 1%'></th>
                <th style="width: 10%;">Action</th>
              </tr>
              </thead>
              <tbody id="requestedTbody">
              </tbody>
              <tfoot id="tfootTotal" style="display:none">
                <tr>
                  <td colspan="6" style="text-align:right; font-weight:bold">Total: </td>
                  <td colspan="2" style="font-weight:bold" id="delTotal"></td>
                </tr>
              </tfoot>
            </table>
            </br>
            <center><button type="button" id="submitRequestedBtn" class="btn btn-success" style="display: none;"><i class="fas fa-save"></i> &nbsp;&nbsp;Save </button></center>
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
  <script src=includes/js/outlet_restock.js></script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>