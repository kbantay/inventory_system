let delUrl = "includes/handlers/delivery_controller";
let request = "";

$(document).ready(function() {
    $('#loader').removeAttr('style');
    $('#dashboardMain').removeAttr('style');
    pendingEncodedDelivery();
});


let pendingEncodedDelivery = () => {
    $.ajax({
        type: 'POST',
        url: delUrl,
        data: { "loadEncodedDelivery": request },
        success: function(result) {
            //console.log(result);
            let tableData = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    tableData += "<tr id='curRow" + result[i].dlvrdSupID + "'>" +
                        "<td style='display:none'><span class='dlvrdSupID'>" + result[i].dlvrdSupID + "</span> <span class='remarks'>" + result[i].remarks + "</span></td>" +
                        "<td><span class='datedlvrd'>" + result[i].datedlvrd + "</span></td>" +
                        "<td><span class='suppliername'>" + result[i].suppliername + "</span></td>" +
                        "<td><span class='invoicenum'>" + result[i].invoicenum + "</span></td>" +
                        "<td><span class='totalAmount'>" + result[i].totalAmount + "</span></td>" +
                        "<td><span class='status'>" + result[i].status + "</span></td>" +
                        "<td> <button type='button' class='btn btn-primary btn-sm viewItemsDelBtn' title='View items in this delivery'><span class='fas fa-eye'></span></button> </td>" +
                        "</tr>";
                }
            }
            $("#encodedDeliveryTbody").append(tableData); // table body
            $("#loader").hide();
        }
    });
}

$("#encodedDeliveryTbl").on("click", ".viewItemsDelBtn", function() {
    let row = $(this).closest("tr");
    //$("#curRow").val(row);
    let dlvrdSupID = row.find("span.dlvrdSupID").text();
    $("#curRow").val(dlvrdSupID);
    let invoicenum = row.find("span.invoicenum").text();
    let suppliername = row.find("span.suppliername").text();
    let totalAmount = row.find("span.totalAmount").text();
    let datedlvrd = row.find("span.datedlvrd").text();
    let remarks = row.find("span.remarks").text();

    //console.log(dlvrdSupID);
    $('#dlvrdSupIDModal').val(dlvrdSupID);
    $("#supplierNameModal").val(suppliername);
    $("#dateDelivered").val(datedlvrd);
    $("#delRemarks").val(remarks);

    $("#delItemsTbl").DataTable().clear();
    $("#delItemsTbl").DataTable().destroy();

    document.getElementById("deliveredSuppliesLbl").innerHTML = `Deliverd Items from ${suppliername} with invoice: ${invoicenum}`;
    $("#deliveredSuppliesMdl").modal("show");

    $.ajax({
        type: "POST",
        url: delUrl,
        data: { "loadDeliveredItems": request, "dlvrdSupID": dlvrdSupID },
        success: function(result) {
            //console.log(result);
            let tableData = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    tableData += "<tr>" +
                        "<td style='display:none'><span class='productID'>" + result[i].productID + "</span> <span class='stocksFull'>" + result[i].stocksFull + "</span> </td>" +
                        "<td><span class='brandname'>" + result[i].brandname + "</span></td>" +
                        "<td><span class='productname'>" + result[i].productname + "</span></td>" +
                        "<td><span class='description'>" + result[i].description + "</span></td>" +
                        "<td><span class='quantity'>" + result[i].quantity + "</span></td>" +
                        "<td><span class='unit'>" + result[i].unit + "</span></td>" +
                        "<td><span class='unitPrice'>" + result[i].unitPrice + "</span></td>" +
                        "<td><span class='subAmount'>" + result[i].subAmount + "</span></td>" +
                        "</tr>";
                }
            }
            $("#delTotal").text(totalAmount);
            $("#delItemsTbody").append(tableData); // table body 
            $("#delItemsTbl").DataTable({
                "lengthMenu": [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                "pageLength": 25,
                "bLengthChange": false,
                "searching": false,
                bAutoWidth: false
            });
        }
    });
});