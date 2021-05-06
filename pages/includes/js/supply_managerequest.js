let supplyUrl = "includes/handlers/supply_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');
    $('#loader').removeAttr('style');

    pendingRequestedSupplies();
});



//=================================== PENDING REQUESTED SUPPLIES =============================//
let pendingRequestedSupplies = () => {
    $.ajax({
        type: 'POST',
        url: "includes/handlers/supply_controller",
        data: { "loadRequestedSupplies": request },
        success: function(result) {
            //console.log(result);
            let tableData = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    tableData += "<tr id='rqst" + result[i].rqstSupID + "'>" +
                        "<td style='display:none'> <span class='totalamount'>" + result[i].totalamount + "</span> <span class='month'>" + result[i].monthOf + "</span><span class='year'>" + result[i].year + "</span> </td>" +
                        "<td><span class='rqstSupID'>" + result[i].rqstSupID + "</span> </td>" +
                        "<td><span class='dateRequested'>" + result[i].dateRequested + "</span></td>" +
                        "<td><span class='requestor'>" + result[i].requestor + "</span></td>" +
                        "<td><span class='department'>" + result[i].department + "</span></td>" +
                        "<td><span class='rqstStats'>" + result[i].rqstStats + "</span></td>" +
                        "<td> <button type='button' class='btn btn-primary btn-sm viewRqstdItemsBtn' title='View requested items'><span class='fas fa-eye'></span></button> </td>" +
                        "</tr>";
                }
                $("#requestedSuppliesTbody").append(tableData); // table body
                $('#loader').hide();
            } else {
                $("#requestedSuppliesBox").hide();
            }
        }
    });
}

$("#requestedSuppliesTbl").on("click", ".viewRqstdItemsBtn", function() {
    var row = $(this).closest("tr");
    var rqstSupID = row.find("span.rqstSupID").text();
    var requestor = row.find("span.requestor").text();
    var dept = row.find("span.department").text();
    var reqSupAmt = row.find("span.totalamount").text();
    var month = row.find("span.month").text();
    var year = row.find("span.year").text();
    getConsumedRecord(dept, year, month);

    $("#reqsDept").val(dept);
    $("#reqsMonth").val(month);
    $("#reqsYear").val(year);
    $("#requestedSuppliesAmt").val(reqSupAmt)
    $("#rqstSupID").val(rqstSupID);

    $.ajax({
        type: "POST",
        url: supplyUrl,
        data: { "loadRequestedSupplyItems": request, "rqstSupID": rqstSupID },
        success: function(result) {
            //console.log(result);
            if (result) {
                var tableData = "";
                for (let i = 0; i < result.length; i++) {
                    tableData += "<tr>" +
                        "<td style='display:none'><span class='productID'>" + result[i].productID + "</span> <span class='stocksleft'>" + result[i].stocksleft + "</span> <span class='stocksfull'>" + result[i].stocksfull + "</span> </td>" +
                        "<td><span class='item'>" + result[i].item + "</span></td>" +
                        "<td><span class='quantity'>" + result[i].quantity + "</span></td>" +
                        "<td><span class='unit'>" + result[i].unit + "</span></td>" +
                        "<td><span class='type'>" + result[i].type + "</span></td>" +
                        "</tr>";
                }
                $("#requestedItemsTbody").html(tableData); // table body
                document.getElementById("requestedSuppliesLbl").innerHTML = `Requested Items of ${requestor}`;
                $("#requestedItemsMdl").modal("show");
            }
        }
    });
});

let getConsumedRecord = (dept, year, month) => {
    //console.log(`ID: ${consrecordID} - D: ${dept} - M: ${month} - Y: ${year}`);
    $.ajax({
        type: "POST",
        url: supplyUrl,
        data: { "loadConsumedRecords": request, "dept": dept, "month": month, "year": year },
        success: function(result) {
            //console.log(result);
            if (result) {
                let consrecordID = result[0].consrecordID;
                let dept = result[0].department;
                let totalAmt = result[0].totalamount;
                let month = result[0].month;
                let year = result[0].year;


                $("#consrecordID").val(consrecordID);
                $("#consDept").val(dept);
                $("#consTotalAmt").val(totalAmt);
                $("#consMonth").val(month);
                $("#consYear").val(year);
            } else {
                console.log("No result");
            }
        }

    });
}

$("#claimItemsBtn").click(function() { //--- Claim requested supplies
    let rqstSupID = $("#rqstSupID").val();
    let status = "Claimed";
    let dateClaimed = $("#dateNow").val();
    var rowCount = $("#requestedSuppliesTbody tr").length;
    //console.log(`rsdtID: ${rqstSupID} - stat: ${status} - dateClm: ${dateClaimed} - rowCount: ${rowCount}`);
    var consrecordID = $("#consrecordID").val();
    var dept = $("#consDept").val();
    var totalAmt = parseFloat($("#consTotalAmt").val());
    var month = $("#consMonth").val();
    var year = $("#consYear").val();

    //console.log(`ConsID: ${consrecordID}`);

    if (confirm("Is everything correct?")) {
        if (consrecordID == "") {
            //save new cons record
            var reqDept = $("#reqsDept").val();
            var reqMonth = $("#reqsMonth").val();
            var reqYear = $("#reqsYear").val();
            var reqAmt = $("#requestedSuppliesAmt").val();
            $.ajax({
                type: "POST",
                url: supplyUrl,
                data: { "saveNewConsumedRecord": request, "dept": reqDept, "totalAmt": reqAmt, "month": reqMonth, "year": reqYear },
                success: function(result) {
                    if (result != "1") {
                        console.error(result);
                    }
                }
            });
        } else {
            //add to existing cons record
            let reqsTotalAmt = parseFloat($("#requestedSuppliesAmt").val());
            let newTotAmt = totalAmt + reqsTotalAmt;
            let newTotalAmt = newTotAmt.toFixed(2);
            $.ajax({
                type: "POST",
                url: supplyUrl,
                data: { "updateConsumedRecord": request, "newTotalAmt": newTotalAmt, "consrecordID": consrecordID },
                success: function(result) {
                    if (result != "1") {
                        console.error(result);
                    }
                }
            });
        }


        $.ajax({
            type: "POST",
            url: supplyUrl,
            data: { "updateRequestedSupplyInfo": request, "rqstSupID": rqstSupID, "status": status, "dateClaimed": dateClaimed },
            success: function(result) {
                //console.log(result);
                $("#requestedItemsTbl > tbody > tr").each(function() {
                    //-------- updating the supplies inventory --------
                    var row = $(this).closest('tr');
                    var productId = row.find("span.productID").text();
                    var requestedQty = row.find("span.quantity").text();
                    var stocksLeft = row.find("span.stocksleft").text();
                    var stocksFull = row.find("span.stocksfull").text();
                    var newStocks = stocksLeft - requestedQty;
                    var newStocksLeft = parseInt(newStocks);
                    var perc = (newStocksLeft / stocksFull) * 100;
                    var percentage = parseInt(perc);

                    //console.log(`pid: ${productId} - curQty: ${requestedQty} - curStkLeft: ${stocksLeft} - curStkFull: ${stocksFull} - newStocks: ${newStocksLeft} - newPerc: ${percentage}`);
                    $.ajax({
                        type: "POST",
                        url: supplyUrl,
                        data: { "updateRequestedItems": request, "rqstSupID": rqstSupID, "status": status, "dateClaimed": dateClaimed, "productId": productId, "newStocksLeft": newStocksLeft, "percentage": percentage },
                        success: function(result) {
                            if (result != "1") {
                                console.error(result);
                            } else {
                                $("#requestedItemsMdl").modal("hide");
                                $("#rqst" + rqstSupID).attr("style", "background-color:#dd4b39");
                                $("#rqst" + rqstSupID).fadeOut('slow',
                                    function() {
                                        $("#rqst" + rqstSupID).remove();
                                        //console.log(rowCount);
                                        if (rowCount <= 1) {
                                            $("#requestedSuppliesBox").attr("style", "display:none");
                                        }
                                    }
                                );

                                //removing the same request from own users request table if exists
                                $("#userReqSuppliesTbl > tbody > tr").each(function() {
                                    var userRow = $(this).closest("tr");
                                    var userRequestID = userRow.find("span.rqstSupID").text();
                                    if (rqstSupID == userRequestID) {
                                        userRow.remove();
                                        var userRowCount = $("#userReqSuppliesTbody tr").length;
                                        if (userRowCount < 1) {
                                            $("#userReqSuppliesBox").attr("style", "display:none");
                                        }
                                    }
                                });

                            }
                        }
                    });
                });


            }
        });


    }
});
//=============================================================================================//