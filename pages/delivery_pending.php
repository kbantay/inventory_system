<?php
 session_start();

if(isset($_SESSION['username'])){
    include 'includes/header.php';
    if ($_SESSION['warehouse_mngdel']=="true") {
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
        <!-- <div class="modal-footer">

        </div> -->
      </div>
    </div>
  </div>
  <!--=========================================================================================-->


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3><i class="fas fa-truck-loading"></i>&nbsp;&nbsp; Pending Encoded Delivery</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
      <div class="box">

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
	<script src=includes/js/delivery_pending.js></script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>