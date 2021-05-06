let url = "includes/handlers/user_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');
    $('#loader').removeAttr('style');

    loadAllUserRoles();
    loadAllDepartment();
});


//========================================================================================================================
function loadUserInfo() {
    //-------- Fetch the $_GET value ----------
    var getValue = [];
    location.search.replace('?', '').split('&').forEach(function(val) {
        split = val.split("=", 2);
        getValue[split[0]] = split[1];
    });

    var userID = getValue['id']; // of the user being edited
    $('#selectedUserID').val(userID);

    $.ajax({
        type: "POST",
        url: url,
        data: { "loadSpecificUser": request, "userID": userID },
        success: function(result) {
            var sysuserID = $("#sysuserID").val();
            //console.log(result);
            var fullName = result[0].fullname;
            var username = result[0].username;
            var designation = result[0].designation;
            var email = result[0].email;
            var department = parseInt(result[0].department);
            var secquestion = result[0].secquestion;
            var secanswer = result[0].secanswer;
            var role = parseInt(result[0].role);
            var profilePic = result[0].profilePhoto
                //console.log(deptID);

            //-- On user smallbox --
            $('#boxFullname').text(fullName);
            $('#boxUsername').text(username);
            $('#boxUserPosition').text(designation);
            $('#roleID').val(role);

            //-- On user main profile --
            $('#fullName').val(fullName);
            $('#designation').val(designation);
            $('#email').val(email);
            $('#userName').val(username);
            $('#secquestion').val(secquestion);
            $('#secanswer').val(secanswer);

            //---- dept dropdown or textbox validation ----
            $('#departmentDdown > option').each(function() {
                var deptID = parseInt($(this).val());
                var deptName = $(this).text();

                if (department == deptID) {
                    $('#departmentDdown').val(deptID).change();
                    $("#departmentTxt").val(deptName);
                }
            });
            var user_manage = $("#user_manage").val();
            if (user_manage == "true") {
                $('#departmentDdown').removeAttr('style');
                $("#departmentTxt").hide();

                $('#userRoleDdown > option').each(function() {
                    var roleID = parseInt($(this).val());

                    if (role == roleID) {
                        $('#userRoleDdown').val(roleID).change();
                    }
                });
            }
            //--- profile Pic ---
            if (userID != sysuserID) {
                if (profilePic != null) {
                    var userimgPath = `../dist/img/uploads/${profilePic}`;
                } else {
                    var userimgPath = "../dist/img/user.jpg";
                }
            } else {
                var userimgPath = $("#imgPath").val();
            }
            $('#profileImg').attr('src', userimgPath);
        }

    });
}



function loadAllDepartment() {
    //----------- Load the user department drop down selection ---------
    $.ajax({
        type: "POST",
        url: "includes/handlers/department_controller",
        data: { "loadAllDepartments": request },
        success: function(result) {
            var html = '';
            if (result) {
                html += '<option value="" selected disabled> Undefined Department </option>';
                for (var i = 0; i < result.length; i++) {
                    html += '<option value="' + result[i].deptID + '">' + result[i].deptName + '</option>';
                }
            }
            $('#departmentDdown').html(html);
            loadUserInfo();
            userUpdateProfilePermission();
            $('#loader').hide();
        }
    });
}


let loadAllUserRoles = () => {
    $.ajax({
        type: "POST",
        url: "includes/handlers/role_controller",
        data: { "loadAllRoles": request },
        success: function(result) {
            //var result = JSON.parse(response);
            var html = '';
            if (result) {
                html += '<option value="" selected disabled> Undefined Role </option>';
                for (var i = 0; i < result.length; i++) {
                    html += '<option value="' + result[i].roleID + '">' + result[i].roleName + '</option>';
                }
            }
            $("#userRoleDdown").html(html);
        }
    });
}



//========================================================================================================================
function userUpdateProfilePermission() {
    var userUpdateInfo = $('#user_updateInfo').val();
    if (userUpdateInfo != "true") {
        $('#fullName').attr("readonly", "readonly");
        $('#fullName').css("background-color", "white");
        $('#designation').attr("readonly", "readonly");
        $('#designation').css("background-color", "white");
        $('#email').attr("readonly", "readonly");
        $('#email').css("background-color", "white");
    }
}


//========================================================================================================================
$('#saveUserInfoBtn').click(function() {
    var selectedUserID = $('#selectedUserID').val();
    var systemUserID = $("#sysuserID").val();
    if (selectedUserID == systemUserID) {
        var userID = systemUserID;
    } else {
        var userID = selectedUserID;
    }
    var user_manage = $("#user_manage").val();

    var fullName = $('#fullName').val();
    var designation = $('#designation').val();
    var userName = $('#userName').val();
    var email = $('#email').val();
    if (user_manage == "true") {
        if ($('#departmentDdown')[0].selectedIndex <= 0) {
            var department = "";
        } else {
            var department = $('#departmentDdown').val();
        }
        if ($('#userRoleDdown')[0].selectedIndex <= 0) {
            var userRole = "";
        } else {
            var userRole = $("#userRoleDdown").val()
        }
    } else {
        var userRole = $("#roleID").val();
        var department = $("#departmentDdown").val();
    }

    var secquestion = $('#secquestion').val();
    var secanswer = $('#secanswer').val();

    //console.log(`userID:${userID} - usrManage:${user_manage} - Name:${fullName} - designation:${designation} - username:${userName} - email:${email} - department:${department} - role:${userRole} - secQ:${secquestion} - secA:${secanswer}`);

    if (department == "" || userRole == "") {
        $('#alertBox').removeAttr("style");
        //------------ Auto-close the alert box! ------------
        window.setTimeout(function() {
            document.getElementById("alertBox").style.display = 'none';
        }, 3000);

        if (department == "") {
            $('#deptValidate').addClass("has-error");
            $(window).scrollTop(0);
        }

        if (userRole == "") {
            $('#roleValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
    } else {
        $.ajax({
            type: 'POST',
            url: url,
            data: { "updateUserProfile": request, "userID": userID, "userName": userName, "userRole": userRole, "fullName": fullName, "designation": designation, "email": email, "department": department, "secquestion": secquestion, "secanswer": secanswer },
            success: function(result) {
                //console.log(result);
                if (result == 1) {
                    $('#boxUsername').text(userName);
                    $('#alertBoxSuccess').removeAttr("style");
                    $(window).scrollTop(0);

                    window.setTimeout(function() {
                        document.getElementById("alertBoxSuccess").style.display = 'none';
                    }, 3000);
                } else {
                    console.error(result);
                }

            }
        });
    }
});


$('#departmentDdown').change(function() {
    $('#deptValidate').removeClass("has-error");
});

$("#userRoleDdown").change(function() {
    $('#roleValidate').removeClass("has-error");
});


//==================================================================================================================//
//=============================================== USER_PROFILE PAGE ================================================//
//==================================================================================================================//




$('#changePassBtn').click(function() {
    $('#changePassMdl').modal('show');
});


$('#saveNewPassword').click(function() {
    var selectedUserID = $('#selectedUserID').val();
    var systemUserID = $("#sysuserID").val();
    if (selectedUserID == systemUserID) {
        var userID = systemUserID;
    } else {
        var userID = selectedUserID;
    }
    var currentPass = $('#currentPassword').val();
    var newPassword = $('#newPassword').val();
    var confPassword = $('#confPassword').val();
    var min = 8;
    var passwordLen = $("#newPassword").val().length;

    if (currentPass == "" || newPassword == "" || confPassword == "") {

        if (currentPass == "") {
            $('#currentPassValidate').addClass("has-error");
        }
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
        var activity = "Changed the user own password";
        $.ajax({
            type: 'POST',
            url: 'includes/handlers/profile_checkPass_handler', //--> also saving
            data: { "userID": userID, "currentPass": currentPass, "newPassword": newPassword, "activity": activity },
            success: function(result) {
                if (result == "success") {
                    alert("Password has been changed!");
                    $('#changePassMdl').modal('hide');
                } else {
                    alert(result);
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



$('#currentPassword').keypress(function() {
    $('#currentPassValidate').removeClass("has-error");
});


$('#newPassword').keypress(function() {
    $('#newPassValidate').removeClass("has-error");
});


$('#confPassword').keypress(function() {
    $('#confPasswordValidate').removeClass("has-error");
});




//=========================== UPLOAD PROFILE PHOTO ============================
$("#openUploadBtn").click(function() {
    $("#uploadPhotoMdl").modal("show");
});

$("#uploadBtn").click(function() {
    var sysuserID = $("#sysuserID").val();
    var userID = $('#selectedUserID').val();
    var formData = new FormData();
    var files = $('#file')[0].files[0];
    formData.append('uploadPhoto', request);
    formData.append('userID', userID);
    formData.append('sysuserID', sysuserID);
    formData.append('file', files);
    //console.log(`sysUser: ${sysuserID} - selUser:${userID} - file: ${files}`);
    $.ajax({
        type: "POST",
        url: "includes/handlers/uploadPhoto_handler",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            //console.log(response);
            var resp = response.split("-");
            if (resp[0] == 1) {
                var newImgPath = `../dist/img/uploads/${resp[1]}`;
                $('#profileImg').attr('src', newImgPath);
                if (sysuserID == userID) {
                    $('#bannerImg').attr('src', newImgPath);
                    $('#dropdownImg').attr('src', newImgPath);
                }
                $("#uploadPhotoMdl").modal('hide');
            } else {
                console.error(resp[1]);
                if (resp[1] == "") {
                    alert(`An error occured. Please try another photo`);
                } else {
                    alert(`An error occured: ${resp[1]}`);
                }

            }
        }
    });
});