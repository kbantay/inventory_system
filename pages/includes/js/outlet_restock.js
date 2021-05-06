let outletUrl = "includes/handlers/outletstock_controller";
let supplyUrl = "includes/handlers/supply_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');
    //$('#loader').removeAttr('style');
    loadPendingOutletRestockRequest();
});

//------------------------------------------------------------------------------------------------------------------------------------------------
//=================================================== FOR SAVING NEW OUTLET RESTOCK RESQUEST =====================================================
//------------------------------------------------------------------------------------------------------------------------------------------------

$("#itemSearch").keyup(function() {
    let searchedItem = $(this).val();
    $('#loader').removeAttr('style');

    if (searchedItem == "") {
        $("#itemsTbl").attr("style", "display:none");
        $('#loader').hide();
    } else {
        $.ajax({
            type: "POST",
            url: supplyUrl,
            data: { "loadSearchedSupply": request, "searchedItem": searchedItem },
            success: function(result) {
                //console.log(result);
                var html = '';
                if (result != "") {
                    for (var i = 0; i < result.length; i++) {
                        html += "<tr>" +
                            "<td style='display:none'><span class='productID'>" + result[i].productID + "</span> <span class='unitcost'>" + result[i].unitcost + "</span> <span class='unit'>" + result[i].unit + "</span> <span class='stocksFull'>" + result[i].stocksfull + "</span> <span class='stocksleft'>" + result[i].stocksleft + "</span> <span class='type'>" + result[i].type + "</span> </td>" +
                            "<td><span class='brandname'>" + result[i].brandname + "</span></td>" +
                            "<td><span class='productname'>" + result[i].productname + "</span></td>" +
                            "<td><span class='description'>" + result[i].description + "</span></td>" +
                            "<td> <button type='button' class='btn btn-primary btn-xs selectItem' title='Select this item'><span class='fas fa-hand-pointer'></span></button> </td>" +
                            "</tr>";
                    }
                    $("#itemsTbody").html(html);
                    $("#itemsTbl").removeAttr("style");
                    $('#loader').hide();
                } else {
                    $('#loader').hide();
                }

            }
        });
    }
});


//===================== SELECT THIS ITEM FROM SEARCHED LIST TO MODAL ====================
$('#itemsTbl').on("click", ".selectItem", function() {
    let row = $(this).closest("tr");
    let productId = row.find("span.productID").text();
    let brandname = row.find("span.brandname").text();
    let productname = row.find("span.productname").text();
    let description = row.find("span.description").text();
    let unitcost = row.find("span.unitcost").text();
    let unit = row.find("span.unit").text();
    let stocksleft = row.find("span.stocksleft").text();
    let stocksFull = row.find("span.stocksFull").text();
    let type = row.find("span.type").text();


    $("#productID").val(productId);
    $("#brandname").val(brandname);
    $("#productName").val(productname);
    $("#description").val(description);
    $("#unitCost").val(unitcost);
    $("#unit").val(unit);
    $("#stocksLeft").val(stocksleft);
    $("#stocksFull").val(stocksFull);
    $("#itemType").val(type);

    document.getElementById("selectedItemLbl").innerHTML = `Specify quantity for ${brandname} ${productname} ${description}`;
    $("#selectedItemMdl").modal("show");

    // $.ajax({
    //     type: "POST",
    //     url: supplyUrl,
    //     data: { "loadStockLeft": request, "productId": productId },
    //     success: function(data) {
    //         if (!data) {
    //             console.error("An error occured: No productID found from WH stocks");
    //             alert("Sorry! This item is not on the supplies inventory database.")
    //         } else {

    //         }
    //     }
    // });
});


//========================== ADD THIS ITEM WITH QUANTITY FROM MODAL =======================
$("#selectItemBtn").click(function() {
    let qty = $("#quantity").val();
    let productId = $("#productID").val();
    let brandname = $("#brandname").val();
    let productname = $("#productName").val();
    let description = $("#description").val();
    let unitcost = $("#unitCost").val();
    let stocksLeft = $("#stocksLeft").val();
    let stocksFull = $("#stocksFull").val();
    let type = $("#itemType").val();
    let unit = $("#unit").val();
    let subtot = qty * unitcost;
    let subtotal = subtot.toFixed(2);

    if (qty == 0 || qty == "") {
        alert("Please enter quantity!");
    } else if (parseInt(qty) > parseInt(stocksLeft)) {
        alert("Sorry! Stocks left is not enough.");
    } else {
        $("#selectedItemMdl").modal("hide");
        $("#quantity").val("");

        let newRow = "<tr>" +
            "<td style='display:none'><span class='productID'>" + productId + "</span> <span class='stocksLeft'>" + stocksLeft + "</span> <span class='stocksFull'>" + stocksFull + "</span> <span class='type'>" + type + "</span> </td>" +
            "<td><span class='brandname'>" + brandname + "</span></td>" +
            "<td><span class='productname'>" + productname + "</span></td>" +
            "<td><span class='description'>" + description + "</span></td>" +
            "<td><span class='quantity'>" + qty + "</span></td>" +
            "<td><span class='unit'>" + unit + "</span></td>" +
            "<td style='display:none'><span class='unitCost'>" + unitcost + "</span></td>" +
            "<td style='display:none'><span class='subtotal'>" + subtotal + "</span></td>" +
            "<td> <button type='button' class='btn btn-danger btn-xs removeItem' title='Remove this item'><span class='fas fa-trash'></span></button> </td>" +
            "</tr>";
        $("#requestedTbody").append(newRow);
        $("#requestedTbl").removeAttr("style");
        $("#submitRequestedBtn").removeAttr("style");
        //getTotalRequested();
        //$("#tfootTotal").removeAttr("style");
    }

});

$("#quantity").on('keypress', function(e) {
    if (e.which == 13) {
        $("#selectItemBtn").trigger("click");
    }
});


//===================== REMOVE THIS ITEM FROM DELIVERED ITEMS LIST =====================
$("#requestedTbl").on('click', '.removeItem', function() {
    let row = $(this).closest("tr");
    row.remove();
    //getTotalRequested();

    let tbodyCount = $("#requestedTbody tr").length;
    if (tbodyCount < 1) {
        $("#requestedTbl").attr("style", "display:none");
        $("#tfootTotal").attr("style", "display:none");
        $('#submitRequestedBtn').attr("style", "display:none");
    }
});


// //-------------- compute total subtotal amount of requested items -------------
// let getTotalRequested = () => {
//     var total = 0;

//     $("#requestedTbl > tbody > tr").each(function() {
//         var row = $(this).closest('tr');
//         var subtotal = row.find("span.subtotal").text();

//         var toInt = parseFloat(subtotal);
//         total += toInt;
//     });
//     //console.log(`total: ${total}`);
//     var tot = total.toFixed(2)
//     $('#delTotal').text(tot);
//     //console.log(tot);
// }


//----- recently added show/ hide control -------
$('#hideFindItemBoxBtn').click(function() {
    $('#hideFindItemBoxBtn').attr('style', 'display:none');
    $('#showFindItemBoxBtn').removeAttr('style');

    $('#findItemBox').hide(300);
});
$('#showFindItemBoxBtn').click(function() {
    $('#showFindItemBoxBtn').attr('style', 'display:none');
    $('#hideFindItemBoxBtn').removeAttr('style');

    $('#findItemBox').show(300);
});


//==================== SAVE OUTLET RESTOCK REQUESTED ITEMS ===================
$("#submitRequestedBtn").click(function() {
    let requestor = $("#requestor").val();
    let department = $("#department").val();
    let dateRequested = $("#dateRequested").val();
    let remarks = $("#remarks").text();
    var status = "Pending";
    //console.log(`sup: ${department} - inv: ${employeeName} - date: ${dateRequested} - rem: ${purpose} - month: ${month} - year:${year}`);


    if (confirm("Is everything correct?")) {
        $.ajax({
            type: "POST",
            url: outletUrl,
            data: { "saveRestockRequestInfo": request, "dateRequested": dateRequested, "requestor": requestor, "department": department, "status": status, "remarks": remarks },
            success: function(data) {
                var outletRstkID = data;

                $("#requestedTbl > tbody > tr").each(function() {
                    var row = $(this).closest('tr');
                    var productId = row.find("span.productID").text();
                    var brandname = row.find("span.brandname").text();
                    var productname = row.find("span.productname").text();
                    var description = row.find("span.description").text();
                    var itemName = `${brandname} ${productname} ${description}`;
                    var quantity = row.find("span.quantity").text();
                    var unit = row.find("span.unit").text();
                    var stocksFull = row.find("span.stocksFull").text();
                    var unitPrice = row.find("span.unitCost").text();
                    var type = row.find("span.type").text();

                    //console.log(`did:${outletRstkID}, pid:${productId}, item:${itemName}, qty:${quantity}, unit:${unit}, price:${unitPrice}, sub:${subtotal}, stocksFull:${stocksFull}, type:${type}, department:${department}, month:${month}, year:${year}, Quarter:${quarter}, status:${status}`);

                    $.ajax({
                        type: "POST",
                        url: outletUrl,
                        data: { "saveOutletRestockItems": request, "outletRstkID": outletRstkID, "productId": productId, "brandname": brandname, "productname": productname, "description": description, "itemName": itemName, "quantity": quantity, "unit": unit, "unitPrice": unitPrice, "stocksFull": stocksFull, "type": type, "status": status },
                        success: function(result) {
                            //console.log(result);
                            if (result != "1") {
                                console.error(result);
                                console.error("An error occured while saving data");
                            }
                        }
                    });
                });

                alert("An Outlet Restock Request has been submitted successfully");
                window.open('../pages/outlet_pendingrestock.php', '_self');
                // //------------ Auto-close the alert box! ------------
                // $('#alertBoxSuccess').removeAttr("style");
                // $(window).scrollTop(0);
                // window.setTimeout(function() {
                //     document.getElementById("alertBoxSuccess").style.display = 'none';
                // }, 3000);
                // //------- clear this page --------
                // $('#departmentDdown')[0].selectedIndex = 0;
                // $("#employeeSearch").val("");
                // $("#dateRequested").val("");
                // $("#dateClaimed").val("");
                // $("#purpose").val("");
                // $("#itemSearch").val("");
                // $("#quantity").val("");
                // $("#itemsTbl").attr("style", "display:none");
                // $(".removeItem").trigger("click");
                // $("#requestedTbl").attr("style", "display:none");
            }
        });
    }

});





//--------------------------------------------------------------------------------------------------------------------//
//====================================== FOR PENDING OUTLET RESTOCK REQUEST PAGE =====================================//
//--------------------------------------------------------------------------------------------------------------------//

let loadPendingOutletRestockRequest = () => {
    $.ajax({
        type: "POST",
        url: outletUrl,
        data: { "getPendingOutletRestockRequest": request },
        success: function(result) {
            if (result) {
                var tableRows = "";
                for (var i = 0; i < result.length; i++) {
                    tableRows += "<tr id='reqs" + result[i].outletRstkID + "'>" +
                        "<td style='display:none'><span class='outletRstkID'>" + result[i].outletRstkID + "</span></td>" +
                        "<td><span class='dateRequested'>" + result[i].dateRequested + "</span></td>" +
                        "<td><span class='requestor'>" + result[i].requestor + "</span></td>" +
                        "<td><span class='department'>" + result[i].department + "</span></td>" +
                        "<td><span class='remarks'>" + result[i].remarks + "</span></td>" +
                        "<td><span class='status'>" + result[i].status + "</span></td>" +
                        "<td><button type='button' class='btn btn-primary btn-sm viewItemsBtn' placeholder='View items in this request'><span class='fas fa-eye'></span></button></td>" +
                        "</tr>";
                }
                $("#outletRestockTbody").html(tableRows);
                $("#outletRestockTbl").DataTable({
                    "order": [
                        [0, "asc"]
                    ],
                    "bLengthChange": false,
                    "searching": false,
                    bAutoWidth: false
                });
            } else {
                console.error(result);
                console.error("An error occured upon fetching data");
            }
        }
    });
}

$("#outletRestockTbl").on('click', ".viewItemsBtn", function() {
    let row = $(this).closest("tr");
    let outletRstkID = row.find("span.outletRstkID").text();
    let requestor = row.find("span.requestor").text();
    $("#outletRstkID").val(outletRstkID);

    //console.log(outletRstkID);
    $.ajax({
        type: "POST",
        url: outletUrl,
        data: { "loadOutletRestockRequestItems": request, "outletRstkID": outletRstkID },
        success: function(result) {
            if (result) {
                var tblRows = "";
                for (var i = 0; i < result.length; i++) {
                    tblRows += "<tr>" +
                        "<td style='display:none'><span class='outletRstkID'>" + result[i].outletRstkID + "</span> <span class='productID'>" + result[i].productID + "</span> <span class='stocksleft'>" + result[i].stocksleft + "</span> <span class='stocksfull'>" + result[i].stocksfull + "</span></td>" +
                        "<td><span class='brandname'>" + result[i].brandname + "</span></td>" +
                        "<td><span class='productname'>" + result[i].productname + "</span></td>" +
                        "<td><span class='description'>" + result[i].description + "</span></td>" +
                        "<td><span class='quantity'>" + result[i].quantity + "</span></td>" +
                        "<td><span class='unit'>" + result[i].unit + "</span></td>" +
                        "</tr>";
                }
                $("#outletReqsItemsTbody").html(tblRows);
                $("#outletReqsItemsTbl").DataTable({
                    "bLengthChange": false,
                    "searching": false,
                    bAutoWidth: false
                });
                document.getElementById("outletRestkSuppliesLbl").innerHTML = `Requested Restock Supplies for Outlet/ Reception`;
                $("#approveOutletRestockDiv").removeAttr("style");
                $("#outletRestkSuppliesMdl").modal("show");
            } else {
                console.error(result);
            }
        }
    });
});

$("#outletRestkSuppliesMdl").on('hidden.bs.modal', function() {
    $("#outletReqsItemsTbl").DataTable().clear();
    $("#outletReqsItemsTbl").DataTable().destroy();
});


// $("#approveOutletRestockDiv").click(function() {
//     let outletRstkID = $("#outletRstkID").val();
//     console.log(outletRstkID)
// });



$("#approveOutletRestockBtn").click(function() {
    let outletRstkID = $("#outletRstkID").val();
    let status = "Approved";

    if (confirm("Is everything correct?")) {
        $.ajax({
            type: "POST",
            url: outletUrl,
            data: { "approveOutletRestockRequest": request, "outletRstkID": outletRstkID, "status": status },
            success: function(result) {
                //console.log()
                if (result == "1") {
                    $("#outletReqsItemsTbl > tbody > tr").each(function() {
                        let row = $(this).closest("tr");
                        let productId = row.find("span.productID").text();
                        let curStocksleft = row.find("span.stocksleft").text();
                        let stocksfull = row.find("span.stocksfull").text();
                        let quantity = row.find("span.quantity").text();

                        var newStocks = curStocksleft - quantity;
                        var newStocksLeft = parseInt(newStocks);
                        var perc = (newStocksLeft / stocksfull) * 100;
                        var percentage = parseInt(perc);
                        //console.log(`ProdID: ${productId} - curStock: ${curStocksleft} - newStocks: ${newStocks} - newPerc: ${percentage}`);

                        $.ajax({
                            type: "POST",
                            url: outletUrl,
                            data: { "approveOutletRestockItems": request, "status": status, "newStocksLeft": newStocksLeft, "percentage": percentage, "productId": productId, "outletRstkID": outletRstkID },
                            success: function(result) {
                                //console.log(result)
                                if (result == "1") {
                                    $("#outletRestkSuppliesMdl").modal("hide");
                                    $("#outletReqsItemsTbl").DataTable().clear();
                                    $("#outletReqsItemsTbl").DataTable().destroy();
                                    $("#reqs" + outletRstkID).remove();
                                } else {
                                    console.error(result);
                                    console.error("An error occured upon updating data");
                                }
                            }
                        });
                    });
                    alert("Outlet restock request has been approved successfully!");
                } else {
                    console.error(result);
                    console.error("An error occured upon fetching data");
                }
            }
        });
    }
});