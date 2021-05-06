$(document).ready(function() {
    var max = $("#max").val();
    //console.log(max);
    exportCSV(0, max);
});

let csvdata = "data:text/csv;charset=utf-8,productID,brandname,productname\n";

let exportCSV = (start, max) => {
    if (start > max) {
        var button = `<a href="${csvdata}" type="button" download="supplies.csv" class="btn btn-warning pull-right"><span class="fas fa-upload">&nbsp;</span> Download File</a>`;
        $("#response").html(button);
        return;
    }

    $.ajax({
        method: 'POST',
        url: "includes/handlers/csvexport_handler",
        dataType: 'json',
        data: {
            start: start
        },
        success: function(response) {
            console.log(response);
            csvdata += response.data;
            exportCSV((start + 50), max);
        }
    });

}