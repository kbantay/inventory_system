let url = "includes/handlers/role_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');
    $('#loader').removeAttr('style');

    $.ajax({
        type: "POST",
        url: url,
        data: { "loadAllRoles": request },
        success: function(response) {
            // console.log(response);
            var result = JSON.parse(response);
            // console.log(result);
            // console.log(typeof(result));

            var html = '';
            if (result) {
                for (var i = 0; i < result.length; i++) {
                    html += "<tr id='row" + result[i].roleID + "'>" +
                        "<td style='display:none'> <span class='roleID'>" + result[i].roleID + "</span></td>" +
                        "<td><span class='roleName'>" + result[i].roleName + "</span></td>" +
                        "<td><span class='roleDescription'>" + result[i].roleDescription + "</span></td>" +
                        "<td><div class='btn-group btn-group-sm'><a href='role_edit?id=" + result[i].roleID + "' class='btn btn-primary editRoleBtn' title='Edit Role Name and Permission'>Edit</a> <button type='button' class='btn btn-danger delRolePermBtn'><span class='fas fa-trash'></span></button>" +
                        "</tr>";
                }
            }
            $("#roleTbody").html(html); // table body
            $("#roleTbl").DataTable();
            $('#loader').hide();
        }
    });
});


//====================================================================================================================


$("#roleTbl").on("click", ".delRolePermBtn", function() {
    let row = $(this).closest("tr");
    let roleID = row.find("span.roleID").text();
    let roleName = row.find("span.roleName").text();

    if (confirm("You cannot undo this action. Are you sure?")) {
        $.ajax({
            type: "POST",
            url: url,
            data: { "deleteRolePermission": request, "roleID": roleID, "roleName": roleName },
            success: function(result) {
                if (result == 1) {
                    $("#row" + roleID).attr("style", "background-color:#dd4b39");
                    $("#row" + roleID).fadeOut('slow',
                        function() {
                            $("#row" + roleID).remove();
                        }
                    );
                } else {
                    console.error(result);
                    console.error("An error occured upon deleting role and permission");
                }
            }
        });
    }
});