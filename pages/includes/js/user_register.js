// function isEmail(email) {
//   var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
//               //====  /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
//   if(!regex.test(email)) {
//     return false;
//   }else{
//     return true;
//   }
// }
let url = "includes/handlers/user_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');
    //----------- Load the user role drop down selection ---------
    $('#loader').removeAttr('style');

    $.ajax({
        type: "POST",
        url: "includes/handlers/role_controller",
        data: { "loadAllRoles": request },
        success: function(response) {
            var result = JSON.parse(response);
            let html = '';
            if (result) {
                html += '<option value="" selected disabled> Select Role </option>';
                for (let i = 0; i < result.length; i++) {
                    html += '<option value="' + result[i].roleID + '" title="' + result[i].roleDescription + '">' + result[i].roleName + '</option>';
                }
            }
            $('#accessLevelDdown').html(html);
            $('#loader').hide();
        }
    });
    loadCategory();
    loadDepartment();
});

//-------------------------------------------------------------- 
function loadCategory() {
    $.ajax({
        type: 'POST',
        url: 'includes/handlers/category_controller',
        data: { "loadAllCategories": request },
        success: function(result) {
            var html = '';
            if (result) {
                html += '<option value="None" selected> None </option>';
                for (var i = 0; i < result.length; i++) {
                    html += '<option value="' + result[i].categoryName + '">' + result[i].categoryName + '</option>';
                }
            }
            $('#categoryDdown').html(html);
        }
    });
}

//=========================================================================================================
let loadDepartment = () => {
    var request = "";
    $.ajax({
        type: 'POST',
        url: 'includes/handlers/department_controller',
        data: { "loadAllDepartments": request },
        success: function(result) {
            var html = '';
            if (result) {
                html += '<option value="" selected disabled> Select Department </option>';
                for (var i = 0; i < result.length; i++) {
                    html += '<option value="' + result[i].deptID + '">' + result[i].deptName + '</option>';
                }
            }
            $('#departmentDdown').html(html);
            //$('#loader').hide();
        }
    });
}


$('#addUserBtn').click(function() {
    var fullname = $('#fullname').val();
    var designation = $('#designation').val();
    //var department = $('#department').val();
    if ($('#departmentDdown')[0].selectedIndex <= 0) {
        var department = "";
    } else {
        var department = $('#departmentDdown option:selected').text();
    }
    var email = $('#email').val();
    var username = $('#username').val();
    var password = $('#password').val();
    var confPassword = $('#confPassword').val();
    if ($('#accessLevelDdown')[0].selectedIndex <= 0) {
        var userRole = "";
    } else {
        var userRole = $('#accessLevelDdown').val();
    }
    var min = 8;
    var usernameLen = $("#username").val().length;
    var passwordLen = $("#password").val().length;
    if ($('#seqQuestionDdown')[0].selectedIndex <= 0) {
        var secquestion = "";
    } else {
        var secquestion = $('#seqQuestionDdown').val();
    }
    var secanswer = $('#secAns').val();
    var assetAccess = $('#categoryDdown').val();

    if (fullname == "" || designation == "" || department == "" || email == "" || username == "" || password == "" || confPassword == "" || userRole == "") {
        $('#alertBox').removeAttr("style");
        //------------ Auto-close the alert box! ------------
        window.setTimeout(function() {
            document.getElementById("alertBox").style.display = 'none';
        }, 3000);

        if (fullname == "") {
            $('#fullnameValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
        if (designation == "") {
            $('#designationValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
        if (department == "") {
            $('#departmentValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
        if (email == "") {
            $('#emailValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
        if (username == "") {
            $('#usernameValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
        if (password == "") {
            $('#passwordValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
        if (confPassword == "") {
            $('#confPasswordValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
        if (userRole == "") {
            $('#accessLevelValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
    } else if (password != confPassword) {
        $('#alertUnmatchPass').removeAttr("style");
        $(window).scrollTop(0);

        window.setTimeout(function() {
            document.getElementById("alertUnmatchPass").style.display = 'none';
        }, 3000);
    } else if (usernameLen < min) {
        $('#alertUserMin').removeAttr("style");
        $(window).scrollTop(0);

        window.setTimeout(function() {
            document.getElementById("alertUserMin").style.display = 'none';
        }, 3000);
    } else if (passwordLen < min) {
        $('#alertUserMin').removeAttr("style");
        $(window).scrollTop(0);

        window.setTimeout(function() {
            document.getElementById("alertUserMin").style.display = 'none';
        }, 3000);
    } else {
        //--------------------- Actual Save Script ------------------
        if (confirm("Is everything correct?")) {
            //console.log(`Asset access: ${assetAccess}`);
            // check if user exists before saving
            $.ajax({
                type: "POST",
                url: url,
                data: { "checkUserExists": request, "username": username },
                success: function(result) {
                    if (result != "") {
                        alert(username + " has already been taken. Please enter another.");
                    } else {
                        // Save new user
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: { "registerNewUser": request, "fullname": fullname, "designation": designation, "department": department, "email": email, "username": username, "password": password, "userRole": userRole, "assetAccess": assetAccess, "secquestion": secquestion, "secanswer": secanswer },
                            success: function(result) {
                                if (result == "1") {
                                    // saving permission
                                    //console.log("saving permission for the user");
                                    $.ajax({
                                        type: "POST",
                                        url: url,
                                        data: { "saveUserPermission": request, "username": username, "userRole": userRole },
                                        success: function(result) {
                                            console.log(result);
                                            if (result == 1) {
                                                $('#alertBoxSuccess').removeAttr("style");
                                                $(window).scrollTop(0);
                                                $('#resetBtn').click();

                                                window.setTimeout(function() {
                                                    document.getElementById("alertBoxSuccess").style.display = 'none';
                                                }, 3000);
                                            } else {
                                                console.error(result);
                                            }
                                        }
                                    });
                                } else { //--- error saving ----
                                    console.log(result);
                                }
                            },
                            error: function() {
                                console.log("Error");
                            }
                        });
                        //
                    }
                }
            });
        }
        //------ end of confirm ---
    }
});

$('#fullname').keypress(function() {
    $('#fullnameValidate').removeClass("has-error");
});

$('#designation').keypress(function() {
    $('#designationValidate').removeClass("has-error");
});

$('#department').keypress(function() {
    $('#departmentValidate').removeClass("has-error");
});

$('#email').keypress(function() {
    $('#emailValidate').removeClass("has-error");
});

$('#username').keypress(function() {
    $('#usernameValidate').removeClass("has-error");
});

$('#password').keypress(function() {
    $('#passwordValidate').removeClass("has-error");
});

$('#confPassword').keypress(function() {
    $('#confPasswordValidate').removeClass("has-error");
});

$('#accessLevelDdown').click(function() {
    $('#accessLevelValidate').removeClass("has-error");
});

$('#resetBtn').click(function() {
    $('#fullnameValidate').removeClass("has-error");
    $('#designationValidate').removeClass("has-error");
    $('#departmentValidate').removeClass("has-error");
    $('#emailValidate').removeClass("has-error");
    $('#usernameValidate').removeClass("has-error");
    $('#passwordValidate').removeClass("has-error");
    $('#confPasswordValidate').removeClass("has-error");
    $('#accessLevelValidate').removeClass("has-error");
});