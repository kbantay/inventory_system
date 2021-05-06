let supplyUrl = "includes/handlers/supply_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');
    //$('#loader').removeAttr('style');

    //Date picker
    $('#dateRequested').datepicker({
        autoclose: true
    });

    loadDepartment();

});


//========================================================================================================================
let loadDepartment = () => {
    var request = "";
    $.ajax({
        type: 'POST',
        url: 'includes/handlers/department_controller',
        data: { "loadAllDepartments": request },
        success: function(result) {
            var html = '';
            if (result) {
                html += '<option value="" selected disabled> Select Department </option>';
                for (var i = 0; i < result.length; i++) {
                    html += '<option value="' + result[i].deptID + '">' + result[i].deptName + '</option>';
                }
            }
            $('#departmentDdown').html(html);
            //$('#loader').hide();
            var dept = $("#curUserDept").val();
            $('#departmentDdown')[0].selectedIndex = dept;
        }
    });
}


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
        getTotalRequested();
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


//-------------- compute total subtotal amount of requested items -------------
let getTotalRequested = () => {
    var total = 0;

    $("#requestedTbl > tbody > tr").each(function() {
        var row = $(this).closest('tr');
        var subtotal = row.find("span.subtotal").text();

        var toInt = parseFloat(subtotal);
        total += toInt;
    });
    //console.log(`total: ${total}`);
    var tot = total.toFixed(2)
    $('#delTotal').text(tot);
    //console.log(tot);
}


//----- Find Item Box show/ hide control -------
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


//==================== SAVE REQUESTED ITEMS ===================
$("#submitRequestedBtn").click(function() {
    let employeeName = $("#employeeSearch").val();
    if ($('#departmentDdown')[0].selectedIndex <= 0) {
        var department = "";
    } else {
        var department = $('#departmentDdown option:selected').text();
    }
    let dateRequested = $("#dateRequested").val();
    let purpose = $("#purpose").val();
    let totalAmount = $("#delTotal").text();
    let d = new Date();
    var mo = new Array();
    var year = d.getFullYear();
    mo[0] = "January";
    mo[1] = "February";
    mo[2] = "March";
    mo[3] = "April";
    mo[4] = "May";
    mo[5] = "June";
    mo[6] = "July";
    mo[7] = "August";
    mo[8] = "September";
    mo[9] = "October";
    mo[10] = "November";
    mo[11] = "December";
    var month = mo[d.getMonth()];
    if (month == "January" || month == "February" || month == "March") {
        var quarter = "1st";
    } else if (month == "April" || month == "May" || month == "June") {
        var quarter = "2nd";
    } else if (month == "July" || month == "August" || month == "September") {
        var quarter = "3rd";
    } else if (month == "October" || month == "November" || month == "December") {
        var quarter = "4th";
    }
    var status = "Pending";
    //console.log(`sup: ${department} - inv: ${employeeName} - date: ${dateRequested} - rem: ${purpose} - month: ${month} - year:${year}`);

    if (dateRequested == "") {
        //------------ Auto-close the alert box! ------------
        $('#alertBox').removeAttr("style");
        window.setTimeout(function() {
            document.getElementById("alertBox").style.display = 'none';
        }, 3000);
        $('#dateRequestedValidate').addClass("has-error");
        $(window).scrollTop(0);
    } else {
        if (confirm("Is everything correct?")) {
            $.ajax({
                type: "POST",
                url: supplyUrl,
                data: { "saveRequestedSuppliesInfo": request, "department": department, "employeeName": employeeName, "totalAmount": totalAmount, "dateRequested": dateRequested, "purpose": purpose, "status": status, "dateClaimed": "", "month": month, "year": year, "quarter": quarter, },
                success: function(data) {
                    var reqSupID = data;

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
                        var subtotal = row.find("span.subtotal").text();
                        var type = row.find("span.type").text();

                        //console.log(`did:${reqSupID}, pid:${productId}, item:${itemName}, qty:${quantity}, unit:${unit}, price:${unitPrice}, sub:${subtotal}, stocksFull:${stocksFull}, type:${type}, department:${department}, month:${month}, year:${year}, Quarter:${quarter}, status:${status}`);

                        // //------- computation for updating the new qty and perc --------
                        // var stocksLeft = row.find("span.stocksLeft").text();
                        // var newStocks = stocksLeft - quantity;
                        // var newStocksLeft = parseInt(newStocks);
                        // var perc = (newStocksLeft / stocksFull) * 100;
                        // var percentage = parseInt(perc);
                        //console.log(`curStock:${stocksLeft} --- newStocks: ${newStocksLeft} - newPerc: ${percentage}`);

                        $.ajax({
                            type: "POST",
                            url: supplyUrl,
                            data: { "submitRequestedItems": request, "reqSupID": reqSupID, "productId": productId, "itemName": itemName, "quantity": quantity, "unit": unit, "unitPrice": unitPrice, "subtotal": subtotal, "type": type, "department": department, "status": status, "employeeName": employeeName, "month": month, "year": year, "quarter": quarter },
                            success: function(result) {
                                //console.log(result);
                                if (result != "1") {
                                    console.error(result);
                                }
                            }
                        });
                    });

                    //------------ Auto-close the alert box! ------------
                    $(window).scrollTop(0);
                    $('#alertBoxSuccess').removeAttr("style");
                    window.setTimeout(function() {
                        document.getElementById("alertBoxSuccess").style.display = 'none';
                        window.open('../pages/home.php', '_self');
                    }, 1500);

                    //------- clear this page --------
                    // $('#departmentDdown')[0].selectedIndex = 0;
                    // $("#employeeSearch").val("");
                    // $("#dateRequested").val("");
                    $("#purpose").val("");
                    $("#itemSearch").val("");
                    $("#quantity").val("");
                    $("#itemsTbl").attr("style", "display:none");
                    $(".removeItem").trigger("click");
                    $("#requestedTbl").attr("style", "display:none");
                }
            });
        }
    }
});


$('#dateRequested').change(function() {
    $('#dateRequestedValidate').removeClass("has-error");
});