<?php
 session_start();

if(isset($_SESSION['username'])){
    include 'includes/header.php';
    if ($_SESSION['outlet_pendingrestock']=="true") {
      $whResreq = $_SESSION['warehouse_resreq'];
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
    <div class="modal fade" id="outletRestkSuppliesMdl">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-warning">
          <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><label id="outletRestkSuppliesLbl"></label></h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal form-label-left input_mask">
            <input type="hidden" id="outletRstkID">

            <table id="outletReqsItemsTbl" class="table table-bordered table-striped table-hover">
                <thead>
                <tr class="bg-gray">
                  <th style="width: 1%; display:none"></th>
                  <th style="width: 20%;">Brandame</th>
                  <th style="width: 30%;">Product Name</th>
                  <th style="width: 20%;">Description</th>
                  <th style="width: 15%;">Quantity</th>
                  <th style="width: 15%;">Unit</th>
                </tr>
                </thead>
                <tbody id="outletReqsItemsTbody">
                </tbody>
            </table>

          </form>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
            <div class="col-md-3"></div>
            <?php if ($whResreq=="true") { ?>
                <div class="col-md-4" id="approveOutletRestockDiv" style="display: none;">
                    <button type="button" id="approveOutletRestockBtn" class="btn btn-success pull-right"><i class="fas fa-check"></i> &nbsp;&nbsp;Approve Restock</button>
                </div>
            <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <!--=========================================================================================-->


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3><i class="fas fa-truck-loading"></i>&nbsp;&nbsp; Pending Restock Request</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
      <div class="box">

        <div class="box-body">
            <table id="outletRestockTbl" class="table table-bordered table-striped table-hover">
                <thead>
                <tr class="bg-info">
                    <th style="width: 1%; display:none"></th>
                    <th style="width: 14%;">Date Requested</th>
                    <th style="width: 25%;">Requestor</th>
                    <th style="width: 15%;">Department</th>
                    <th style="width: 26%;">Remarks</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 8%;">Action</th>
                </tr>
                </thead>
                <tbody id="outletRestockTbody">
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
	<script src=includes/js/outlet_restock.js></script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>