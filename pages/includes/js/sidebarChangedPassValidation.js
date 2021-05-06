$(document).ready(function(){
  var empID = $('#eid').val();
  //--------- check is_password_changed? --------
  $.ajax({
    type: 'POST',
    url: 'includes/handlers/user_checkIsPassChanged_handler',
    data: {"employeeID":empID},
    success: function(result){
      //console.log(result)
      if (result=="1") {
        $('#dashboardMain').removeAttr('style');
      }
    }
  });
});

$.widget.bridge('uibutton', $.ui.button);