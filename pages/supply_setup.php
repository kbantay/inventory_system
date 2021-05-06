<?php
 session_start();

if(isset($_SESSION['username'])){
    include 'includes/header.php';
    if ($_SESSION['warehouse_setupitem']=="true") {
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
  <div class="modal fade" id="editItemInfoMdl">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><label id="editItemModalLbl"></label></h4>
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
                  <div class="col-sm-3">
                      <label class="control-label">Unit Cost</label>
                      <input type="text" class="form-control" id="unitCost" placeholder="Unit Cost">
                  </div>
                  <div class="col-sm-3">
                      <label class="control-label">Stocks in Full</label>
                      <input type="number" class="form-control" id="stocksFull" placeholder="Stocks in full">
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
            <button type="button" id="updateSupplyBtn" class="btn btn-success pull-right"><i class="fas fa-save"></i> &nbsp;&nbsp;Update</button>
            </div>
        </div>
      </div>
    </div>
  </div>
<!--=========================================================================================-->


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3><i class="fas fa-tasks"></i>&nbsp;&nbsp; Supplies Info Setup</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
      <div class="box">

        <div class="box-body">
          <table id="suppliesTbl" class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
              <th style="display: none;"></th>
              <th>Brandname</th>
              <th>Product Name</th>
              <th>Description</th>
              <th>Type</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody id="suppliesTbody">
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
	<script src=includes/js/supply_setup.js></script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>