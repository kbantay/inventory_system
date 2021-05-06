<?php
  //if(isset($_SESSION['username'])){
?>
  
<!--========================================== FOOTER SECTION GOES BEYOND HERE ===============================
	<input type="text" class="form-control" id="eid" style="display:none" value="<//?php echo $_SESSION['employeeID'];?>">-->
  <input type="text" class="form-control" id="userid" style="display:none" value="<?php echo $_SESSION['userID'];?>"> <!-- ID of the user being edited -->
  <input type="text" class="form-control" id="curUserID" style="display:none" value="<?php echo $_SESSION['userID'];?>"> <!-- ID of the current-loggedin user -->

</div> 
  <footer class="main-footer">
    <div class="text-right"><small>Published &copy; 2021 &nbsp;&nbsp;|&nbsp;&nbsp;</strong> IGSL Supplies and Asset Management System   |   Designed and Developed by IGSL ICT team</small></div>
  </footer>

  <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
  <!-- <div class="control-sidebar-bg"></div> -->
<!-- </div> -->
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!--Load dataTable JS-->
<!-- <script src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script> -->
<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- DataTable Buttons -->
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<!-- DataTable PDF make -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<!-- Sidebar Validation Changed Password -->
<script src="includes/js/sidebarChangedPassValidation.js"></script>

<!-- Sparkline -->
<script src="../bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

<!-- jQuery Knob Chart -->
<script src="../bower_components/jquery-knob/dist/jquery.knob.min.js"></script>

<!-- daterangepicker -->
<script src="../bower_components/moment/min/moment.min.js"></script>
<!-- <script src="../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script> -->

<!-- datepicker -->
<script src="../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="includes/js/datepicker.js"></script>

<!-- Select2 -->
<!-- <script src="../bower_components/select2/dist/css/select2.min.css"></script> -->

<!-- Bootstrap WYSIHTML5 -->
<script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<!-- Slimscroll -->
<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

<!-- FastClick -->
<script src="../bower_components/fastclick/lib/fastclick.js"></script>

<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="../dist/js/pages/dashboard.js"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>

<!-- User Logout -->
<script src="includes/js/logout.js"></script>




</body>
</html>


<?php
  // } else{
  //       header("Location: ../index");
  //   }
?>