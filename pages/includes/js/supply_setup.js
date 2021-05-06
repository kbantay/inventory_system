let url = "includes/handlers/supply_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');
    $('#loader').removeAttr('style');

    loadAllSupplies();
});



//========================================================================================================================
function loadAllSupplies() {
    $.ajax({
        type: "POST",
        url: url,
        data: { "getAllSupplies": request },
        success: function(result) {
            //console.log(result);
            var html = '';
            if (result) {
                for (var i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td style='display:none'><span class='productID'>" + result[i].productID + "</span> <span class='unitcost unitcost" + result[i].productID + "'>" + result[i].unitcost + "</span> <span class='unit'>" + result[i].unit + "</span> <span class='stocksFull stocksFull" + result[i].productID + "'>" + result[i].stocksFull + "</span></td>" +
                        "<td><span class='brandname'>" + result[i].brandname + "</span></td>" +
                        "<td><span class='productname'>" + result[i].productname + "</span></td>" +
                        "<td><span class='description'>" + result[i].description + "</span></td>" +
                        "<td><span class='type'>" + result[i].type + "</span></td>" +
                        "<td> <button type='button' class='btn btn-primary btn-sm mngItemBtn' title='Update this item info'><span class='fas fa-eye'></span></button> <button type='button' class='btn btn-danger btn-sm delItemBtn' title='Delete this item'><span class='fas fa-trash'></span></button> </td>" +
                        "</tr>";
                }
            }
            $("#suppliesTbody").html(html); // table body
            $("#suppliesTbl").DataTable({
                "order": [
                    [1, "asc"]
                ],
                bAutoWidth: false,
                pageLength: 25,
                aoColumns: [
                    { sWidth: '1%' },
                    { sWidth: '20%' },
                    { sWidth: '20%' },
                    { sWidth: '30%' },
                    { sWidth: '20%' },
                    { sWidth: '9%' }
                ]
            });
            $('#loader').hide();
        }
    });
}


//===================== Load Supply Info to Modal =====================
$("#suppliesTbl").on('click', '.mngItemBtn', function() {
    let row = $(this).closest("tr");
    let itemId = row.find("span.productID").text();
    let brandname = row.find("span.brandname").text();
    let productname = row.find("span.productname").text();
    let description = row.find("span.description").text();
    let unitcost = row.find("span.unitcost").text();
    let unit = row.find("span.unit").text();
    let stocksFull = row.find("span.stocksFull").text();
    let type = row.find("span.type").text();

    $('#productId').val(itemId);
    $('#brandname').val(brandname);
    $('#productName').val(productname);
    $('#description').val(description);
    $('#type').val(type);
    $('#unitCost').val(unitcost);
    $('#stocksFull').val(stocksFull);
    $('#unit').val(unit);

    document.getElementById("editItemModalLbl").innerHTML = `Edit Info: ${brandname} ${productname}`;
    $('#editItemInfoMdl').modal("show");
});



//===================== Update Supply info ====================
$("#updateSupplyBtn").click(function() {
    let productId = $('#productId').val();
    let unitcost = $('#unitCost').val();
    let stocksFull = $('#stocksFull').val();
    let brandname = $('#brandname').val();
    let productName = $('#productName').val();
    let itemName = `${brandname} ${productName}`;

    $.ajax({
        type: "POST",
        url: url,
        data: { "updateSupplyInfo": request, "productId": productId, "unitcost": unitcost, "stocksFull": stocksFull, "itemName": itemName },
        success: function(result) {
            if (result == "1") {
                $('.unitcost' + productId).text(unitcost);
                $('.stocksFull' + productId).text(stocksFull);
                alert("This item's info has been updated!");
            } else {
                console.error(result);
            }
        }
    });
});




//===================== DELETING AN ITEM =====================
$("#suppliesTbl").on('click', '.delItemBtn', function() {
    let row = $(this).closest("tr");
    let itemId = row.find("span.productID").text();
    let brandname = row.find("span.brandname").text();
    let productName = row.find("span.productname").text();
    let itemName = `${brandname} ${productName}`;

    if (confirm("Deleting this item cannot be undone. Are you sure?")) {
        $.ajax({
            type: "POST",
            url: url,
            data: { "deleteItem": request, "productId": itemId, "itemName": itemName },
            success: function(result) {
                //console.log(result);
                if (result == "1") {
                    row.remove();
                } else {
                    console.error(result);
                }
            }
        });

    }
});