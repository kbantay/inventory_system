let url = "includes/handlers/user_controller";
let request = "";

$(document).ready(function() {

});


$("#verifyUserBtn").click(function() {
    var username = $("#username").val();

    if (username == "") {
        //alert("Please enter your username");
        $('#alertErrorNoUser').removeAttr("style");
        $(window).scrollTop(0);

        window.setTimeout(function() {
            document.getElementById("alertErrorNoUser").style.display = 'none';
        }, 3000);
    } else {
        $('#loader').removeAttr('style');
        $.ajax({
            type: "POST",
            url: url,
            data: { "loadUserPerUsername": request, "username": username },
            success: function(result) {
                //console.log(result);
                if (result) {
                    var username = result[0].username;
                    var fullname = result[0].fullname;
                    var userID = result[0].userid;
                    $('#selectedUserID').val(userID);
                    $('#fullname').val(fullname);
                    var secquestion = result[0].secquestion;
                    if (secquestion) {
                        $("#usernameBox").hide();
                        $("#questionBox").removeAttr('style');
                        document.getElementById("secQuestion").innerHTML = `${secquestion}?`;
                    } else {
                        //---------- no question found --------------
                        $('#alertErrorNoQuestion').removeAttr("style");
                        $(window).scrollTop(0);

                        window.setTimeout(function() {
                            document.getElementById("alertErrorNoQuestion").style.display = 'none';
                        }, 10000);
                    }
                } else {
                    //---------- no response: no username --------------
                    $('#alertErrorInvalidUser').removeAttr("style");
                    $(window).scrollTop(0);

                    window.setTimeout(function() {
                        document.getElementById("alertErrorInvalidUser").style.display = 'none';
                    }, 3000);
                }
                $('#loader').hide();
            }
        });
    }
});

$('#username').keypress(function(e) {
    var key = e.which;
    if (key == 13) {
        $('#verifyUserBtn').click();
        return false;
    }
});




$("#submitAnswerBtn").click(function() {
    var userID = $('#selectedUserID').val();
    var answer = $("#answer").val();
    if (answer == "") {
        $('#alertErrorNoAnswer').removeAttr("style");
        $(window).scrollTop(0);
        window.setTimeout(function() {
            document.getElementById("alertErrorNoAnswer").style.display = 'none';
        }, 3000);
    } else {
        $('#loader').show();
        $.ajax({
            type: "POST",
            url: url,
            data: { "verifyUserAnswer": request, "userID": userID },
            success: function(result) {
                var answerResult = result;
                if (answer) {
                    if (answer == answerResult) {
                        var username = $('#username').val();
                        document.getElementById("changePassMdlTitle").innerHTML = `Reset password of ${username}`;
                        $('#changePassMdl').modal('show');
                    } else {
                        $('#alertErrorInvalidAnswer').removeAttr("style");
                        $(window).scrollTop(0);
                        window.setTimeout(function() {
                            document.getElementById("alertErrorInvalidAnswer").style.display = 'none';
                        }, 10000);
                    }
                } else {
                    $('#alertErrorNoAnswerFound').removeAttr("style");
                    $(window).scrollTop(0);
                    window.setTimeout(function() {
                        document.getElementById("alertErrorNoAnswerFound").style.display = 'none';
                    }, 3000);
                }
                $('#loader').hide();
            }
        });
    }
});

$('#answer').keypress(function(e) {
    var key = e.which;
    if (key == 13) {
        $('#submitAnswerBtn').click();
        return false;
    }
});




//============================================= RESETTING USER'S PASSWORD ====================================================
$('#saveNewPassword').click(function() {
    var userid = $('#selectedUserID').val();
    var username = $('#username').val();
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
            data: { "resetOwnUserPassword": request, "userid": userid, "username": username, "newPassword": newPassword, "fullname": fullname },
            success: function(result) {
                //console.error(result);
                if (result == 1) {
                    $('#changePassMdl').modal('hide');
                    $('#newPassword').val("");
                    $('#confPassword').val("");
                    $('#alertSuccessPasswordReset').removeAttr("style");
                    $(window).scrollTop(0);
                    window.setTimeout(function() {
                        document.getElementById("alertSuccessPasswordReset").style.display = 'none';
                        window.open('../index.php', '_self');
                    }, 2000);
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

$('#newPassword').keypress(function() {
    $('#newPassValidate').removeClass("has-error");
});


$('#confPassword').keypress(function() {
    $('#confPasswordValidate').removeClass("has-error");
});