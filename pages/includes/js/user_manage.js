let url = "includes/handlers/user_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');

    loadAllUsers();
});


//========================================================================================================================
function loadAllUsers() {
    $('#loader').removeAttr('style');
    var request = "load";
    $.ajax({
        type: "POST",
        url: url,
        data: { "loadAllUsers": request },
        success: function(result) {
            //console.log(result);
            var html = '';
            if (result) {
                for (var i = 0; i < result.length; i++) {
                    html += "<tr id='userRow" + result[i].userid + "'>" +
                        "<td style='display:none'><span class='userid'>" + result[i].userid + "</span></td>" +
                        "<td><span class='fullname'>" + result[i].fullname + "</span></td>" +
                        "<td><span class='email'>" + result[i].email + "</span></td>" +
                        "<td><span class='username'>" + result[i].username + "</span></td>" +
                        "<td><span class='designation'>" + result[i].designation + "</span></td>" +
                        "<td><div class='btn-group btn-group-sm'> <a href='user_profile?id=" + result[i].userid + "' class='btn btn-success editProfile' title='Edit user profile'><span class='fas fa-user-edit'></span></a> <a href='user_editPermission?id=" + result[i].userid + "' class='btn btn-primary editPermission' title='Edit user permission'><span class='fas fa-edit'></span></a> <button class='btn btn-info resetPass' type='button' title='Reset user password'><span class='fas fa-sync-alt'></span></button> <button class='btn btn-danger deleteUser' type='button' title='Delete this user'><span class='fas fa-trash-alt'></span></button></td>" +
                        "</tr>";
                }
            }
            $("#sysUsersTbody").html(html); // table body
            $("#sysUsersTbl").DataTable();
            $('#loader').hide();
        }
    });
}



//======================================================== DELETING USER =========================================================
$('#sysUsersTbl').on('click', '.deleteUser', function() {
    if (confirm("Are you sure? Deleting this user is permanent, it cannot be undone!")) {
        var row = $(this).closest('tr');
        var userid = row.find("span.userid").text();
        var fullname = row.find("span.fullname").text();

        $.ajax({
            type: 'POST',
            url: url,
            data: { "deleteUserAccount": request, "userid": userid, "fullname": fullname },
            success: function(result) {
                //console.log(result);
                if (result == 1) {
                    $("#userRow" + userid).attr("style", "background-color:#dd4b39");
                    $("#userRow" + userid).fadeOut('slow',
                        function() {
                            $("#userRow" + userid).remove();
                        }
                    );
                } else { //--- error saving ----
                    $('#alertError').removeAttr("style");
                    $(window).scrollTop(0);

                    window.setTimeout(function() {
                        document.getElementById("alertError").style.display = 'none';
                    }, 3000);
                    $('#loader').hide();
                    console.error(result);
                }
            }
        });
    }
});






//============================================= RESETTING USER'S PASSWORD ====================================================
$('#sysUsersTbl').on('click', '.resetPass', function() {
    var row = $(this).closest('tr');
    var userid = row.find("span.userid").text();
    var fullname = row.find("span.fullname").text();
    //console.log(`selectedUser:${userid}`);

    $('#selectedUserId').val(userid);
    $('#fullname').val(fullname);
    $('#changePassMdl').modal('show');
    document.getElementById("changePassMdlTitle").innerHTML = `Reset Password of ${fullname}`;
});


$('#saveNewPassword').click(function() {
    var userid = $('#selectedUserId').val();
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
        //console.log(`currentUser: ${userid} - newpass: ${newPassword}`);
        $.ajax({
            type: 'POST',
            url: url,
            data: { "resetUserPassword": request, "userid": userid, "newPassword": newPassword, "fullname": fullname },
            success: function(result) {
                //console.error(result);
                if (result == 1) {
                    alert("Password has been changed!");
                    $('#changePassMdl').modal('hide');
                    $('#newPassword').val("");
                    $('#confPassword').val("");
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