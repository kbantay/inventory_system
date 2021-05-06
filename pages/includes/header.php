<?php
  //if(isset($_SESSION['username'])){
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>IGSL SAMS</title>
  <!-- -Titlebar icon -->
  <link rel="icon" href="../favicon.ico">
  <!-- Loader GIF/ Icon -->
  <link rel="stylesheet" href="../dist/css/loader.css">
  <!-- Search Result List -->
  <link rel="stylesheet" href="../dist/css/listresult.css">

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <script src="https://kit.fontawesome.com/2ca9bfa0f4.js" crossorigin="anonymous"></script>
  <!-- Ionicons -->
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- <link rel="stylesheet" href="../dist/css/AdminLTE.css"> -->
  <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- load DataTable and DataTable Buttons -->
  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css"> -->
  <link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css"></link>
  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css"></link> -->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>


<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper" style="background-color:#ecf0f5">

  <header class="main-header">
    <a href="home" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><i class="fas fa-cubes"></i></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><i class="fas fa-cubes"></i><small> <b>IGSL </b>SAMS</small></span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <!-- ========================== RIGHT NAVBAR MENU ANS LINK ======================= -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-------------------- Username Dropdown Menu ------------------->

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img id="bannerImg" src="<?=$_SESSION['profilePic']?>" class="user-image" alt="User Image">
              <span class="hidden-xs" id="currentUser"><?php echo $_SESSION['currentUser']; ?></span>
              <input type="hidden" id="curUser" value="<?php echo $_SESSION['currentUser']; ?>">
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img id="dropdownImg" src="<?=$_SESSION['profilePic']?>" class="img-circle" alt="User Image">
                <p>
                  <?php echo $_SESSION['currentUser']; ?>
                  <small><?php echo $_SESSION['userPosition']; ?></small>
                </p>
              </li>

              <li class="user-footer">
                <div class="pull-left">
                  <a href="user_profile?id=<?php echo $_SESSION['userID']; ?>" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat" id="logoutBtn">Logout</a>
                </div>
              </li>
            </ul>
          </li>

          <!-------------------- UI Theme Settings Menu ------------------->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fas fa-sliders-h"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-------------============== Control Sidebar: UI Settings ===================------------>
  <aside class="control-sidebar control-sidebar-dark" style="display:none;">
    <div class="tab-content">
      <div class="tab-pane" id="control-sidebar-home-tab"></div>
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Left side column. contains the logo and sidebar -->


  <!-- ========================== DASHBOARD: LEFT TAB NAVIGATION LINKS TO ALL PAGES ======================= -->
  <aside class="main-sidebar" >
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" id="dashboardMain" style="display:none;">
      <!-- DASHBOARD sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="active treeview">
          <a><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
        </li>
        <!---------------------------------------------------------------->
        <li>
          <a href="supply_request">
            <i class="fas fa-inbox"></i>&nbsp;&nbsp;<span> Request Supplies</span>   
          </a>
        </li>
        <!---------------------------------------------------------------->
        <?php if ($_SESSION['allOutletAccess']) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fas fa-fw fa-store-alt"></i>&nbsp;&nbsp;<span> Outlet</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
          <ul class="treeview-menu">
            <li><a href="outlet_stocks">&nbsp;&nbsp;&nbsp; Supplies List</a></li>
            <li><a href="supply_pendingrequest">&nbsp;&nbsp;&nbsp; Requested Supplies</a></li>
            <li><a href="outlet_restock">&nbsp;&nbsp;&nbsp; Restock Item</a></li>
            <li><a href="outlet_pendingrestock">&nbsp;&nbsp;&nbsp; Pending Restock</a></li>
          </ul>
        </li>
        <?php } ?>
        <!---------------------------------------------------------------->
        <?php if ($_SESSION['allWarehouseAccess']) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fas fa-warehouse"></i>&nbsp;&nbsp;<span> Warehouse </span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
          <ul class="treeview-menu">
            <li><a href="supply_register">&nbsp;&nbsp;&nbsp; Register Item</a></li>
            <li><a href="supply_setup">&nbsp;&nbsp;&nbsp; Setup Item</a></li>
            <li><a href="supply_inventory">&nbsp;&nbsp;&nbsp; Supplies Inventory</a></li>
            <li><a href="consumed_supplies">&nbsp;&nbsp;&nbsp; Encode Requested Supplies</a></li>
            <li><a href="delivery_encode">&nbsp;&nbsp;&nbsp; Encode Delivery</a></li>
            <li><a href="delivery_pending">&nbsp;&nbsp;&nbsp; Pending Delivery</a></li>
            <li><a href="outlet_pendingrestock">&nbsp;&nbsp;&nbsp; Pending Outlet Restock</a></li>
            <!-- <li><a href="underCons">&nbsp;&nbsp;&nbsp; Restock Request</a></li> -->
          </ul>
        </li>
        <?php } ?>
        <!---------------------------------------------------------------->
        <?php if ($_SESSION['allAssetAccess']) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fas fa-fw fa-cubes"></i>&nbsp;&nbsp;<span> Asset </span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
          <ul class="treeview-menu">
            <li><a href="asset_add">&nbsp;&nbsp;&nbsp; Add New</a></li>
            <li><a href="asset_manage">&nbsp;&nbsp;&nbsp; Manage</a></li>
            <li><a href="asset_disposed">&nbsp;&nbsp;&nbsp; Disposed</a></li>
          </ul>
        </li>
        <?php } ?>
        <!---------------------------------------------------------------->
        <?php if ($_SESSION['allReportsAccess']) { ?>
        <li>
          <a href="reports">
            <i class="fas fa-fw fa-file-alt"></i>&nbsp;&nbsp;<span> Reports </span>
          </a>
        </li>
        <?php } ?>
        <!---------------------------------------------------------------->
        <?php if ($_SESSION['allUsersAccess']) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fas fa-user-alt"></i>&nbsp;&nbsp;<span> Users</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
          <ul class="treeview-menu">
            <li><a href="user_register">&nbsp;&nbsp;&nbsp; Add New</a></li>
            <li><a href="user_view">&nbsp;&nbsp;&nbsp; List</a></li>
            <li><a href="user_manage">&nbsp;&nbsp;&nbsp; Manage</a></li>
            <li class="treeview">
              <a href="#">&nbsp;&nbsp;&nbsp; Role <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
              <ul class="treeview-menu">
                <li><a href="role_addNew">&nbsp;&nbsp;&nbsp;Add New</a></li>
                <li><a href="role_manage">&nbsp;&nbsp;&nbsp;Manage</a></li>
              </ul>
            </li>
            <li><a href="user_logs">&nbsp;&nbsp;&nbsp; Logs</a></li>
          </ul>
        </li>
        <?php } ?>
        <!---------------------------------------------------------------->
        <?php if ($_SESSION['allSettingsAccess']) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fas fa-cogs"></i>&nbsp;&nbsp;<span> Data Setup </span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview">
              <a href="#">&nbsp;&nbsp;&nbsp; Asset Categories <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
              <ul class="treeview-menu">
                <li><a href="category_manage">&nbsp;&nbsp;&nbsp; Category</a></li>
                <li><a href="subcategory_manage">&nbsp;&nbsp;&nbsp; Subcategory</a></li>
              </ul>
            </li>

            <li><a href="department_manage">&nbsp;&nbsp;&nbsp; Department</a></li>

            <li class="treeview">
              <a href="#">&nbsp;&nbsp;&nbsp; Email <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
              <ul class="treeview-menu">
                <li><a href="email_outletAdmin">&nbsp;&nbsp;&nbsp; Outlet Admin</a></li>
                <li><a href="email_warehouseAdmin">&nbsp;&nbsp;&nbsp; Warehouse Admin</a></li>
                <li><a href="email_supervisor">&nbsp;&nbsp;&nbsp; Warehouse Supervisor</a></li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#">&nbsp;&nbsp;&nbsp; Location <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
              <ul class="treeview-menu">
                <li><a href="building_manage">&nbsp;&nbsp;&nbsp; Building</a></li>
                <li><a href="room_manage">&nbsp;&nbsp;&nbsp; Room</a></li>
              </ul>
            </li>
            
            <li><a href="supplier_manage">&nbsp;&nbsp;&nbsp; Supplier</a></li>
          </ul>
        </li>
        <?php } ?>
        <!---------------------------------------------------------------->

    </section>
    <!-- /.sidebar -->
  </aside>


<!-- END OF HEADER FILE -->