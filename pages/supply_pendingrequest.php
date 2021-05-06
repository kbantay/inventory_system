<?php
 session_start();

if(isset($_SESSION['username'])){
    include 'includes/header.php';
    if ($_SESSION['outlet_reqsup']=="true") {
      $userRole = $_SESSION['roleName'];
?>

<!-- ================================================== MAIN CONTENT - BODY ======================================================== -->
  <!---------------------- Loading ----------------->
  <div class="loaderFrame" id="loader" style="display:none">
    <img class="img-loader" src="includes/ring-loader.gif" alt="loading">
    <label>Processing...</label>
  </div>
  <!---------------------- Loading ----------------->
  

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
      <h3><i class="fas fa-inbox"></i>&nbsp;&nbsp; Manage Requested Supplies</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
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
	<script src=includes/js/supply_managerequest.js></script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>