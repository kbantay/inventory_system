let url = "includes/handlers/user_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');
    loadAllUsers();
});


//========================================================================================================================
function loadAllUsers() {
    $('#loader').removeAttr('style');
    var request = "";
    $.ajax({
        type: "POST",
        url: url,
        data: { "loadAllUsers": request },
        success: function(result) {
            //console.log(result);
            let html = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td style='display:none'><span class='usersID'>" + result[i].userid + "</span></td>" +
                        "<td><span class='fullname'>" + result[i].fullname + "</span></td>" +
                        "<td><span class='email'>" + result[i].email + "</span></td>" +
                        "<td><span class='username'>" + result[i].username + "</span></td>" +
                        "<td><span class='designation'>" + result[i].designation + "</span></td>" +
                        "</tr>";
                }
            }
            $("#sysUsersTbody").html(html); // table body
            $("#sysUsersTbl").DataTable();
            $('#loader').hide();
        }
    });
}


$('#downloadScv').click(function() {
    $.ajax({
        url: url,
        type: "POST",
        data: { "downloadcsv": request },
        success: function(result) {
            console.log(result);
        }
    });
});