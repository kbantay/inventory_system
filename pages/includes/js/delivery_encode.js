let url = "includes/handlers/delivery_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');
    loadSuppliers();

    //Date picker
    $('#deliveryDate').datepicker({
        autoclose: true
    });

    let designation = $("#page").val();
    loadSupervisorEmail(designation);
});


let loadSuppliers = () => {
    $.ajax({
        type: "POST",
        url: "includes/handlers/supplier_controller",
        data: { "getConsSuppliers": request },
        success: function(result) {
            var html = '';
            if (result) {
                html += '<option value="" selected disabled> Select Supplier </option>';
                for (var i = 0; i < result.length; i++) {
                    html += '<option value="' + result[i].supplierId + '">' + result[i].supplierName + '</option>';
                }
            }
            $('#supplierDdown').html(html);
        }
    });
}

let loadSupervisorEmail = (designation) => {
    $.ajax({
        type: 'POST',
        url: "includes/handlers/user_controller",
        data: { "loadCurrentEmailReceiver": request, "designation": designation },
        success: function(response) {
            //console.log(response);
            if (response) {
                var email = response[0].emailaddress;
                $("#supervisorEmail").val(email);
            } else {
                console.error(response);
            }

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
            url: "includes/handlers/supply_controller",
            data: { "getSearchedItem": request, "searchedItem": searchedItem },
            success: function(result) {
                //console.log(result);
                var html = '';
                if (result != "") {
                    for (var i = 0; i < result.length; i++) {
                        html += "<tr>" +
                            "<td style='display:none'><span class='productID'>" + result[i].productID + "</span> <span class='unitcost'>" + result[i].unitcost + "</span> <span class='unit'>" + result[i].unit + "</span> <span class='stocksFull'>" + result[i].stocksFull + "</span> </td>" +
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
    let stocksFull = row.find("span.stocksFull").text();

    $("#productID").val(productId);
    $("#brandname").val(brandname);
    $("#productName").val(productname);
    $("#description").val(description);
    $("#unitCost").val(unitcost);
    $("#unit").val(unit);
    $("#stocksFull").val(stocksFull);

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
    let stocksFull = $("#stocksFull").val();
    let unit = $("#unit").val();
    let subtot = qty * unitcost;
    let subtotal = subtot.toFixed(2);

    if (qty == 0 || qty == "") {
        alert("Please enter quantity!");
    } else {
        $("#selectedItemMdl").modal("hide");
        $("#quantity").val("");

        let newRow = "<tr>" +
            "<td style='display:none'><span class='productID'>" + productId + "</span> <span class='stocksFull'>" + stocksFull + "</span></td>" +
            "<td><span class='brandname'>" + brandname + "</span></td>" +
            "<td><span class='productname'>" + productname + "</span></td>" +
            "<td><span class='description'>" + description + "</span></td>" +
            "<td><span class='quantity'>" + qty + "</span></td>" +
            "<td><span class='unit'>" + unit + "</span></td>" +
            "<td><span class='unitCost'>" + unitcost + "</span></td>" +
            "<td><span class='subtotal'>" + subtotal + "</span></td>" +
            "<td> <button type='button' class='btn btn-danger btn-xs removeItem' title='Remove this item'><span class='fas fa-trash'></span></button> </td>" +
            "</tr>";
        $("#deliveredTbody").append(newRow);
        $("#deliveredTbl").removeAttr("style");
        $("#submitDeliveriesBtn").removeAttr("style");
        getTotalDeliveries();
        $("#tfootTotal").removeAttr("style");
    }

});

$(quantity).on('keypress', function(e) {
    if (e.which == 13) {
        $("#selectItemBtn").trigger("click");
    }
});


//===================== REMOVE THIS ITEM FROM DELIVERED ITEMS LIST =====================
$("#deliveredTbl").on('click', '.removeItem', function() {
    let row = $(this).closest("tr");
    row.remove();
    getTotalDeliveries();

    let tbodyCount = $("#deliveredTbody tr").length;
    if (tbodyCount < 1) {
        $("#deliveredTbl").attr("style", "display:none");
        $("#tfootTotal").attr("style", "display:none");
        $('#submitDeliveriesBtn').attr("style", "display:none");
    }
});


//-------------- compute total subtotal amount of delivered items -------------
let getTotalDeliveries = () => {
    var total = 0;

    $("#deliveredTbl > tbody > tr").each(function() {
        var row = $(this).closest('tr');
        var subtotal = row.find("span.subtotal").text();

        var toInt = parseFloat(subtotal);
        total += toInt;
    });
    //console.log(`total: ${total}`);
    var tot = total.toFixed(2)
    $('#delTotal').text(tot);
}


//==================== SUBMIT THIS DELIVERED ITEMS ===================
$("#submitDeliveriesBtn").click(function() {
    if ($('#supplierDdown')[0].selectedIndex <= 0) {
        var supplier = "";
    } else {
        var supplier = $('#supplierDdown option:selected').text();
    }
    let invoiceNum = $("#invoiceNumber").val();
    let dateDelivered = $("#deliveryDate").val();
    let totalAmount = $("#delTotal").text();
    let remarks = $("#remarks").val();

    var email = $("#supervisorEmail").val();
    var subject = "New consumable supplies delivery";
    var message = "New consumable supplies delivery entry has been submitted. Supervisor approval needed in order for the new stocks to update the current inventory.";

    //console.log(`sup: ${supplier} - inv: ${invoiceNum} - date: ${dateDelivered} - tot: ${totalAmount} - rem: ${remarks}`);

    if (supplier == "" || invoiceNum == "" || dateDelivered == "") {
        //------------ Auto-close the alert box! ------------
        $('#alertBox').removeAttr("style");
        window.setTimeout(function() {
            document.getElementById("alertBox").style.display = 'none';
        }, 3000);

        if (supplier == "") {
            $('#supplierValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
        if (invoiceNum == "") {
            $('#invoiceNumValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
        if (dateDelivered == "") {
            $('#deliveryDateValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
    } else {
        if (confirm("Is everything correct?")) {
            $.ajax({
                type: "POST",
                url: url,
                data: { "saveDeliveryInfo": request, "supplier": supplier, "invoiceNum": invoiceNum, "totalAmount": totalAmount, "dateDelivered": dateDelivered, "remarks": remarks, "email": email, "subject": subject, "message": message },
                success: function(data) {
                    var delSuppId = data;

                    $("#deliveredTbl > tbody > tr").each(function() {
                        var row = $(this).closest('tr');
                        var productId = row.find("span.productID").text();
                        var brandname = row.find("span.brandname").text();
                        var productname = row.find("span.productname").text();
                        var description = row.find("span.description").text();
                        var quantity = row.find("span.quantity").text();
                        var unit = row.find("span.unit").text();
                        var unitPrice = row.find("span.unitCost").text();
                        var subtotal = row.find("span.subtotal").text();
                        var stocksFull = row.find("span.stocksFull").text();

                        //console.log(`did:${delSuppId}, pid:${productId}, brnd:${brandname}, prod:${productname}, desc:${description}, qty:${quantity}, unit:${unit}, price:${unitPrice}, sub:${subtotal}`);

                        $.ajax({
                            type: "POST",
                            url: url,
                            data: { "saveDeliveryItems": request, "delSuppId": delSuppId, "productId": productId, "brandname": brandname, "productname": productname, "description": description, "quantity": quantity, "unit": unit, "unitPrice": unitPrice, "subtotal": subtotal, "stocksFull": stocksFull },
                            success: function(result) {
                                //console.log(result);
                                if (result != "1") {
                                    console.error(result);
                                }
                            }
                        });
                    });

                    alert("This delivery has been submitted.");
                    //------- clear this page --------
                    $('#supplierDdown')[0].selectedIndex = 0;
                    $("#invoiceNumber").val("");
                    $("#deliveryDate").val("");
                    $("#remarks").val("");
                    $("#itemSearch").val("");
                    $("#quantity").val("");
                    $("#itemsTbl").attr("style", "display:none");
                    $(".removeItem").trigger("click");
                    $("#deliveredTbl").attr("style", "display:none");
                    window.open('../pages/delivery_pending.php', '_self');
                }
            });
        }
    }
});


$('#supplierDdown').change(function() {
    $('#supplierValidate').removeClass("has-error");
});

$('#invoiceNumber').keypress(function() {
    $('#invoiceNumValidate').removeClass("has-error");
});

$('#deliveryDate').change(function() {
    $('#deliveryDateValidate').removeClass("has-error");
});