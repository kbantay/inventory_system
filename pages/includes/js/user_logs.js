$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');

    $('#loader').removeAttr('style');
    var request = "load";
    $.ajax({
        type: "POST",
        url: "includes/handlers/user_controller",
        data: { "loadUserLogs": request },
        success: function(result) {
            //console.log(result);
            let html = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td>" + result[i].logID + "</td>" +
                        "<td>" + result[i].fullName + "</td>" +
                        "<td>" + result[i].username + "</td>" +
                        "<td>" + result[i].activity + "</td>" +
                        "<td>" + result[i].dateAndTime + "</td>" +
                        "</tr>";
                }
            }
            $("#userLogsTbody").html(html); // table body
            $("#userLogsTbl").DataTable({
                "order": [
                    [0, "desc"]
                ],
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "pageLength": 25
            });
            $('#loader').hide();
        }
    });
});