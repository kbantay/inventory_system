//================================================================================================================
$('#sysUsersTbl').on('click', '.resetPass', function() {
    var row = $(this).closest('tr');
    var userid = row.find("span.userid").text();
    var fullname = row.find("span.fullname").text();
    //console.log(empId);
    //$('#userId').val(empId);
    $('#fullname').val(fullname);
    $('#changePassMdl').modal('show');
});


$('#saveNewPassword').click(function() {
    var userid = $('#userid').val();
    var fullname = $('#fullname').val();
    var newPassword = $('#newPassword').val();
    var confPassword = $('#confPassword').val();
    var min = 8;
    var passwordLen = $("#newPassword").val().length;

    if (newPassword == "" || confPassword == "") {

        if (newPassword == "") {
            $('#newPassValidate').addClass("has-error");
        }
        if (confPassword == "") {
            $('#confPasswordValidate').addClass("has-error");
        }
    } else if (passwordLen < min) {
        alert("Password should be at least eight(8) characters");
    } else if (newPassword != confPassword) {
        alert("New password and re-typed password did not match!");
    } else {
        //--------- load user's current password ---------
        $.ajax({
            type: 'POST',
            url: 'includes/handlers/user_resetPassword_handler',
            data: { "userid": userid, "newPassword": newPassword, "fullname": fullname },
            success: function(result) {
                if (result == "success") {
                    alert("Password has been changed!");
                    $('#changePassMdl').modal('hide');
                } else {
                    console.error(result);
                }
            }
        });
    }
});

$('#newPassword').keypress(function(e) {
    var key = e.which;
    if (key == 13) {
        $('#saveNewPassword').click();
        return false;
    }
});
$('#confPassword').keypress(function(e) {
    var key = e.which;
    if (key == 13) {
        $('#saveNewPassword').click();
        return false;
    }
});

// $('#currentPassword').keypress(function(){
//   $('#currentPassValidate').removeClass("has-error");
// });

$('#newPassword').keypress(function() {
    $('#newPassValidate').removeClass("has-error");
});


$('#confPassword').keypress(function() {
    $('#confPasswordValidate').removeClass("has-error");
});