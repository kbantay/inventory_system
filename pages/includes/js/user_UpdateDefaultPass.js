$('#saveNewPassword').click(function(){
  $('#loader').removeAttr('style');
  var userID = $('#userid').val();
  var currentPass = $('#currentPassword').val();
  var newPassword = $('#newPassword').val();
  var confPassword = $('#confPassword').val();
  var min = 8;
  var passwordLen = $("#newPassword").val().length;

  if (currentPass=="" || newPassword=="" || confPassword=="") {

    if (currentPass=="") {
      $('#currentPassValidate').addClass("has-error");
    }
    if (newPassword=="") {
      $('#newPassValidate').addClass("has-error");
    }
    if (confPassword=="") {
      $('#confPasswordValidate').addClass("has-error");
    }  
  }
  else if (passwordLen < min) {
    alert("Password should be at least eight(8) characters");
  }
  else if (newPassword!=confPassword) {
    alert("New password and re-typed password did not match!");
  }
  else if (newPassword==currentPass) {
    alert("New password cannot be the same as the current password!");
  }
  else {
    // //--------- update user's default password ---------
    var activity = "Changed the user default password";
    $.ajax({
      type: 'POST',
      url: 'includes/handlers/profile_checkPass_handler',
      data: {"userID":userID, "currentPass":currentPass, "newPassword":newPassword, "activity":activity},
      success: function(result){
        $('#loader').hide();
        if (result=="success") {
          //--- also change the is_passchanged value to 1
          $.ajax({
            type: "POST",
            url: "includes/handlers/user_updateIsPassChanged_handler",
            data: {"userID":userID},
            success: function(result){
              console.log(result);
              $('#dashboardMain').show();
              $('#shortcutBox').show();
              $('#updateDefaultPass').attr("style", "display:none");
              
            }
          });
          alert("Default password has been changed!");
        } 
        else {
          alert(result);
        }
      }
    });
  }
});


$('#newPassword').keypress(function(e){
    var key = e.which;
    if (key == 13) {
      $('#saveNewPassword').click();
      return false;
    }
});
$('#confPassword').keypress(function(e){
    var key = e.which;
    if (key == 13) {
      $('#saveNewPassword').click();
      return false;
    }
});



$('#currentPassword').keypress(function(){
  $('#currentPassValidate').removeClass("has-error");
});


$('#newPassword').keypress(function(){
  $('#newPassValidate').removeClass("has-error");
});


$('#confPassword').keypress(function(){
  $('#confPasswordValidate').removeClass("has-error");
});