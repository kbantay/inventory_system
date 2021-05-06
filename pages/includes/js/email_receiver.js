let url = "includes/handlers/user_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');
    //$('#loader').removeAttr('style');

    let designation = $("#page").val();
    loadCurrentEmailReceiver(designation);
    loadAllUsers();
});


let loadCurrentEmailReceiver = (designation) => {
    $.ajax({
        type: 'POST',
        url: url,
        data: { "loadCurrentEmailReceiver": request, "designation": designation },
        success: function(response) {
            //console.log(response);
            if (response) {
                var name = response[0].fullname;
                var email = response[0].emailaddress;

                $("#fullName").val(name);
                $("#emailAddress").val(email);
            } else {
                console.error(response);
            }

        }
    });
}



//=====================================================
let loadAllUsers = () => {
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
                    html += "<tr>" +
                        "<td><span class='fullname'>" + result[i].fullname + "</span></td>" +
                        "<td><span class='email'>" + result[i].email + "</span></td>" +
                        "<td><button class='btn btn-info btn-sm selectUserBtn' type='button' title='Select this user'><span class='fas fa-arrow-right'></span></button> </td>" +
                        "</tr>";
                }
            }
            $("#sysUsersTbody").html(html); // table body
            $("#sysUsersTbl").DataTable({ "bLengthChange": false });
            $('#loader').hide();
        }
    });
}

$("#sysUsersTbl").on('click', '.selectUserBtn', function() {
    var row = $(this).closest("tr");
    var name = row.find("span.fullname").text();
    var email = row.find("span.email").text();

    $("#fullName").val(name);
    $("#emailAddress").val(email);
});



$("#updateEmailReceiver").click(function() {
    var name = $("#fullName").val();
    var email = $("#emailAddress").val();
    var designation = $("#page").val();
    //console.log(`name:${name} - email:${email} - desig:${designation}`);
    $.ajax({
        type: 'POST',
        url: url,
        data: { "updateCurrentEmailReceiver": request, "name": name, "email": email, "designation": designation },
        success: function(response) {
            if (response == "1") {
                $('#alertBoxSuccess').removeAttr("style");
                $(window).scrollTop(0);
                window.setTimeout(function() {
                    document.getElementById("alertBoxSuccess").style.display = 'none';
                }, 3000);
            } else {
                console.error(response);

                $('#alertBoxError').removeAttr("style");
                $(window).scrollTop(0);

                window.setTimeout(function() {
                    document.getElementById("alertBoxError").style.display = 'none';
                }, 3000);
            }
        }
    });
});