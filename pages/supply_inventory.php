<?php
 session_start();

if(isset($_SESSION['username'])){
    include 'includes/header.php';
    if ($_SESSION['warehouse_suplist']=="true") {
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
  <div class="modal fade" id="viewStockInfoMdl">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><label id="viewStockModalLbl"></label></h4>
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
                  </div>
                </div>

                <div class="form-group col-sm-12">
                  <div class="col-sm-6">
                      <label class="control-label">Description</label>
                      <input type="text" class="form-control" id="description" placeholder="Description" readonly>
                  </div>
                  <div class="col-sm-6">
                      <label class="control-label">Type</label>
                      <input type="text" class="form-control" id="type" readonly>
                  </div>
                </div>

                <div class="form-group col-sm-12">
                  <div class="col-sm-6">
                      <label class="control-label">Stocks Left</label>
                      <input type="text" class="form-control" id="stocksLeft" placeholder="Unit Cost" readonly>
                  </div>
                  <div class="col-sm-6">
                      <label class="control-label">Unit</label>
                      <input type="text" class="form-control" id="unit" placeholder="Unit" readonly>
                  </div>
                </div>

                <div class="form-group col-sm-12">
                  <div class="col-sm-6">
                  <label class="control-label">Stocks in Full</label>
                      <input type="text" class="form-control" id="stocksFull" placeholder="Stocks in full" readonly>
                  </div>
                  <div class="col-sm-6">
                      <label class="control-label">Unit Cost</label>
                      <input type="text" class="form-control" id="unitCost" placeholder="Unit Cost" readonly>
                  </div>
                </div>

          </form>
        </div>
        <div class="clearfix"></div>
         <div class="modal-footer">
        </div> 
      </div>
    </div>
  </div>
  <!--=========================================================================================-->


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3><i class="fas fa-boxes"></i>&nbsp;&nbsp; Warehouse Supplies Inventory</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <button type="button" id="allStocksBtn" class='btn btn-default btn-sm pull-right' title='Show all stocks'><i class="fas fa-th-large"></i></button>
          <button type="button" id="lowStocksBtn" class='btn btn-default btn-sm pull-right' title='Show lowering stocks' style="margin-right: 5px;"><i class="fas fa-sort-amount-down"></i></button>
        </div>

        <div class="box-body">
          <table id="stocksTbl" class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
              <th style="display: none;"></th>
              <th>Brandname</th>
              <th>Product Name</th>
              <th>Description</th>
              <th>Stocks Left</th>
              <th>Unit</th>
              <th>Type</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody id="stocksTbody">
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
	<script src=includes/js/supply_inventory.js></script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>