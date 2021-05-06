let url = "includes/handlers/outletstock_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');
    $('#loader').removeAttr('style');

    $('#brandname').css("background-color", "white");
    $('#productName').css("background-color", "white");
    $('#description').css("background-color", "white");
    $('#type').css("background-color", "white");
    $('#stocksLeft').css("background-color", "white");
    $('#unit').css("background-color", "white");
    $('#stocksFull').css("background-color", "white");
    $('#unitCost').css("background-color", "white");

    loadAllOutletStocks();

    //modal buttons
    //$("#editBtn").hide();
    $("#cancelEditingBtn").hide();
    $("#updateBtn").hide();
});



//========================================= LOAD ALL STOCKS ==============================================
function loadAllOutletStocks() {
    $.ajax({
        type: "POST",
        url: url,
        data: { "getAllOutletStocks": request },
        success: function(result) {
            var html = '';
            if (result) {
                for (var i = 0; i < result.length; i++) {
                    if (result[i].percentage < 50) {
                        html += "<tr id='row" + result[i].itemID + "' style='color:#c20000'>" +
                            "<td style='display:none'><span class='itemID'>" + result[i].itemID + "</span> <span class='productID'>" + result[i].productID + "</span> <span class='unitcost'>" + result[i].unitcost + "</span> <span class='stocksFull'>" + result[i].stocksfull + "</span> </td>" +
                            "<td><span class='brandname'>" + result[i].brandname + "</span></td>" +
                            "<td><span class='productname'>" + result[i].productname + "</span></td>" +
                            "<td><span class='description'>" + result[i].description + "</span></td>" +
                            "<td><span class='stocksLeft'>" + result[i].stocksleft + "</span></td>" +
                            "<td><span class='unit'>" + result[i].unit + "</span></td>" +
                            "<td><span class='type'>" + result[i].type + "</span></td>" +
                            "<td> <button type='button' class='btn btn-primary btn-sm viewStockInfoBtn' title='View other information of this item'><span class='fas fa-eye'></span></button> </td>" +
                            "</tr>";
                    } else {
                        html += "<tr id='row" + result[i].itemID + "'>" +
                            "<td style='display:none'><span class='itemID'>" + result[i].itemID + "</span> <span class='productID'>" + result[i].productID + "</span> <span class='unitcost'>" + result[i].unitcost + "</span> <span class='stocksFull'>" + result[i].stocksfull + "</span> </td>" +
                            "<td><span class='brandname'>" + result[i].brandname + "</span></td>" +
                            "<td><span class='productname'>" + result[i].productname + "</span></td>" +
                            "<td><span class='description'>" + result[i].description + "</span></td>" +
                            "<td><span class='stocksLeft'>" + result[i].stocksleft + "</span></td>" +
                            "<td><span class='unit'>" + result[i].unit + "</span></td>" +
                            "<td><span class='type'>" + result[i].type + "</span></td>" +
                            "<td> <button type='button' class='btn btn-primary btn-sm viewStockInfoBtn' title='View other information of this item'><span class='fas fa-eye'></span></button> </td>" +
                            "</tr>";
                    }
                }
            }
            $("#stocksTbody").html(html); // table body
            $("#stocksTbl").DataTable({
                "order": [
                    [1, "asc"]
                ],
                bAutoWidth: false,
                pageLength: 25,
                aoColumns: [
                    { sWidth: '1%' },
                    { sWidth: '20%' },
                    { sWidth: '20%' },
                    { sWidth: '20%' },
                    { sWidth: '9%' },
                    { sWidth: '9%' },
                    { sWidth: '13%' },
                    { sWidth: '8%' }
                ]
            });
            $('#loader').hide();
        }
    });
}



$("#stocksTbl").on('click', '.viewStockInfoBtn', function() {
    let row = $(this).closest("tr");
    let itemId = row.find("span.itemID").text();
    let productID = row.find("span.productID").text();
    let brandname = row.find("span.brandname").text();
    let productname = row.find("span.productname").text();
    let description = row.find("span.description").text();
    let type = row.find("span.type").text();
    let stocksLeft = row.find("span.stocksLeft").text();
    let unit = row.find("span.unit").text();
    let stocksFull = row.find("span.stocksFull").text();
    let unitcost = row.find("span.unitcost").text();

    $("#itemID").val(itemId);
    $("#productId").val(productID);
    $('#brandname').val(brandname);
    $('#productName').val(productname);
    $('#description').val(description);
    $('#type').val(type);
    $('#stocksLeft').val(stocksLeft);
    $('#unit').val(unit);
    $('#stocksFull').val(stocksFull);
    $('#stocksCeiling').val(stocksFull);
    $('#unitCost').val(unitcost);

    document.getElementById("viewStockModalLbl").innerHTML = `${brandname} ${productname}`;
    $("#viewStockInfoMdl").modal("show");
});


let clearTable = () => {
    $("#stocksTbl").DataTable().clear();
    $("#stocksTbl").DataTable().destroy();
}

//======================================== LOAD LOWERING STOCKS =========================================
function loadLoweringStocks() {
    $.ajax({
        type: "POST",
        url: url,
        data: { "getLoweringStocks": request },
        success: function(result) {
            var html = '';
            if (result) {
                for (var i = 0; i < result.length; i++) {
                    html += "<tr id='row" + result[i].itemID + "' style='color:#c20000'>" +
                        "<td style='display:none'><span class='itemID'>" + result[i].itemID + "</span> <span class='productID'>" + result[i].productID + "</span> <span class='unitcost'>" + result[i].unitcost + "</span> <span class='unit'>" + result[i].unit + "</span> <span class='stocksFull'>" + result[i].stocksfull + "</span></td>" +
                        "<td><span class='brandname'>" + result[i].brandname + "</span></td>" +
                        "<td><span class='productname'>" + result[i].productname + "</span></td>" +
                        "<td><span class='description'>" + result[i].description + "</span></td>" +
                        "<td><span class='stocksLeft'>" + result[i].stocksleft + "</span></td>" +
                        "<td><span class='unit'>" + result[i].unit + "</span></td>" +
                        "<td><span class='type'>" + result[i].type + "</span></td>" +
                        "<td> <button type='button' class='btn btn-primary btn-sm viewStockInfoBtn' title='View other information of this item'><span class='fas fa-eye'></span></button> </td>" +
                        "</tr>";
                }
            }
            $("#stocksTbody").html(html); // table body
            $("#stocksTbl").DataTable({
                "order": [
                    [1, "asc"]
                ],
                bAutoWidth: false,
                pageLength: 25,
                aoColumns: [
                    { sWidth: '1%' },
                    { sWidth: '20%' },
                    { sWidth: '20%' },
                    { sWidth: '20%' },
                    { sWidth: '9%' },
                    { sWidth: '9%' },
                    { sWidth: '13%' },
                    { sWidth: '8%' }
                ]
            });
            $('#loader').hide();
        }
    });
}


$('#lowStocksBtn').click(function() {
    $('#loader').show();
    clearTable();
    loadLoweringStocks();
});

$('#allStocksBtn').click(function() {
    $('#loader').show();
    clearTable();
    loadAllOutletStocks();
});



$("#editBtn").click(function() {
    //modal buttons
    $("#editBtn").hide();
    $("#cancelEditingBtn").show();
    $("#updateBtn").show();

    $("#stocksFull").removeAttr('readonly');
    $("#stocksFull").css("background-color", "#fffef0");
});

$("#cancelEditingBtn").click(function() {
    //modal buttons
    $("#editBtn").show();
    $("#cancelEditingBtn").hide();
    $("#updateBtn").hide();

    let curStocks = $('#stocksCeiling').val()
    $("#stocksFull").val(curStocks);
    $("#stocksFull").attr('readonly');
    $("#stocksFull").css("background-color", "white");
});

$("#updateBtn").click(function() {
    let itemID = $("#itemID").val();
    let productID = $("#productId").val();
    let stocksfull = $("#stocksFull").val();
    let stocksLeft = $("#stocksLeft").val();

    var perc = (stocksLeft / stocksfull) * 100;
    var percentage = parseInt(perc);
    //console.log(`prodID: ${productID} - full: ${stocksfull} - left: ${stocksLeft} - perc: ${percentage}`);

    if (stocksfull == "") {
        alert("Stocks in full cannot be empty. Please input quantity");
    } else {
        $.ajax({
            type: "POST",
            url: url,
            data: { "updateStocksFullOutletStocks": request, "stocksfull": stocksfull, "productID": productID, "percentage": percentage },
            success: function(result) {
                if (result == "1") {
                    //modal buttons
                    $("#editBtn").show();
                    $("#cancelEditingBtn").hide();
                    $("#updateBtn").hide();

                    let newStocks = $('#stocksFull').val()
                    $("#stocksCeiling").val(newStocks);
                    $("#stocksFull").attr('readonly');
                    $("#stocksFull").css("background-color", "white");

                    $("#viewStockInfoMdl").modal("hide");
                    $("#stocksTbl").DataTable().clear();
                    $("#stocksTbl").DataTable().destroy();
                    loadAllOutletStocks();
                } else {
                    console.error(result);
                    console.error("An error occured upon updating data");
                }

            }
        });
    }
});


$("#viewStockInfoMdl").on("hidden.bs.modal", function() {
    //modal buttons
    $("#editBtn").show();
    $("#cancelEditingBtn").hide();
    $("#updateBtn").hide();

    $("#stocksFull").attr('readonly');
    $("#stocksFull").css("background-color", "white");
});