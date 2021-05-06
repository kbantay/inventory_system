<?php
 session_start();

if(isset($_SESSION['username'])){
    include 'includes/header.php';
    if ($_SESSION['warehouse_regitem']=="true") {
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
  <div class="alert alert-danger alert-dismissible" id="alertBoxFailed" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-ban"></i> Item(s) on red box is required and cannot be empty!
  </div>
  
  <div class="alert alert-success alert-dismissible" id="alertBoxSuccess" style="display:none">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <i class="icon fa fa-check"></i> Success! A new item has been registered!
  </div>
  <!----------------------------------->


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h3><i class="fas fa-newspaper"></i>&nbsp;&nbsp; Register New Item</h3>
    </section>

    <!----------------------------- Main content ---------------------->
    <section class="content">
      <div class="box">

        <div class="box-header with-border">
            <h3 class="box-title">All fields with * are required</h3>
        </div>
            
        <form method="POST" action="" data-parsley-validate class="form-horizontal form-label-left">
            <div class="box-body">

            <div class="form-group" id="brandNameValidate">
                <label class="col-sm-4 control-label">Brandname *</label>
                <div class="input-group col-sm-4">
                <input type="text" class="form-control" id="brandname" placeholder="Brandname" maxlength="30" required>
                </div>
            </div>

            <div class="form-group" id="productNameValidate">
                <label class="col-sm-4 control-label">Product Name *</label>
                <div class="input-group col-sm-4">
                <input type="text" class="form-control" id="productName" placeholder="Product Name" maxlength="50">
                </div>
            </div>

            <div class="form-group" id="descriptionValidate">
                <label class="col-sm-4 control-label">Description</label>
                <div class="input-group col-sm-4">
                <input type="text" class="form-control" id="description" placeholder="Description" maxlength="50">
                </div>
            </div>

            <div class="form-group" id="amountValidate">
                <label class="col-sm-4 control-label">Unit Cost (in PhP)*</label>
                <div class="input-group col-sm-4">
                <input type="text" class="form-control" id="amount" placeholder="Disregard comma - Example: 1580.75">
                </div>
            </div>

            <div class="form-group" id="unitValidate">
                <label class="col-sm-4 control-label">Unit *</label>
                <div class="input-group col-sm-4">
                <select class="form-control" id="unitDdown" placeholder="Select Unit">
                    <option value="Bottle">Bottle</option>
                    <option value="Box">Box</option>
                    <option value="Gallon">Gallon</option>
                    <option value="Pack">Pack</option>
                    <option value="Piece" selected>Piece</option>
                    <option value="Ream">Ream</option>
                    <option value="Roll">Roll</option>
                    <option value="Sack">Sack</option>
                    <option value="Set">Set</option>
                </select>
                </div>
            </div>

            <div class="form-group" id="stocksFullValidate">
                <label class="col-sm-4 control-label">Stocks in Full *</label>
                <div class="input-group col-sm-4">
                <input type="number" class="form-control" id="stocksFull" placeholder="Stocks in Full" maxlength="6">
                </div>
            </div>

            <div class="form-group" id="typeValidate">
                <label class="col-sm-4 control-label">Type *</label>
                <div class="input-group col-sm-4">
                <select class="form-control" id="typeDdown" placeholder="Select Type">
                    <option value="Office Supply" selected>Office Supply</option>
                    <option value="Janitorial Supply">Janitorial Supply</option>
                    <option value="Electrical">Electrical Supply</option>
                    <option value="Plumbing Supply">Plumbing Supply</option>
                    <option value="Others">Others</option>
                </select>
                </div>
            </div>

            

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
            <div class="col-md-4"></div>
            <div class="col-md-4">
            <button type="reset"  id="resetBtn" class="btn btn-warning" title="This will clear all the fields">Reset</button>
            <button type="button" id="addItemBtn" class="btn btn-success pull-right">Submit</button></div>
            </div>
            <!-- /.box-footer -->
        </form>

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
	<script src=includes/js/supply_register.js></script>
<!--=======================================-->
<?php
  } else{
        header("Location: ../index");
    }
?>