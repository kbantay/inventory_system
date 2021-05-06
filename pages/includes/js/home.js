let assetUrl = "includes/handlers/asset_controller";
let delUrl = "includes/handlers/delivery_controller";
let supplyUrl = "includes/handlers/supply_controller";
let request = "";

let d = new Date();
let mo = new Array();
let year = d.getFullYear();
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
let month = mo[d.getMonth()];

$(document).ready(function() {
    //setInterval(timestamp, 1000);
    //Date picker
    $('#activityDate').datepicker({
        autoclose: true
    });
    $('#loader').removeAttr('style');

    var userID = $('#userid').val();
    //console.log(userID);
    //--------- check is_password_changed? --------
    $.ajax({
        type: 'POST',
        url: 'includes/handlers/user_checkIsPassChanged_handler',
        data: { "userID": userID },
        success: function(result) {
            //console.log(result)
            if (result == "0") { // pw not yet changed
                $('#updateDefaultPass').removeAttr('style');
                //$('#dashboardMain').hide(); already a comm
            } else {
                //timestamp();
                $('#dashboardMain').removeAttr('style');
                loadTotalAssetCount();
                loadTotalAssetCost();
                loadPendingDeliveries();
                loadTotalLoweringWHstocks();
                $('#shortcutBox').removeAttr('style');
                recentlyAddedAssets();

                lockModalTextbox();
            }
            $('#loader').hide();
        }
    });

    pendingEncodedDelivery();
    pendingRequestedSupplies();
    userRequestedSupplies();
    loadWHstocksInfo();
});



// function timestamp() {
//     $.ajax({
//         url: "includes/handlers/liveClock_handler",
//         success: function(data) {
//             //console.log(data);
//             document.getElementById('liveClockNow').innerHTML = data;
//         },
//     });
// }


function lockModalTextbox() {
    $('#category').prop("readonly", true);
    $('#tagnum').prop("readonly", true);
    $('#serialNum').prop("readonly", true);
    $('#brandModel').prop("readonly", true);
    $('#description').prop("readonly", true);
    $('#quantity').prop("readonly", true);
    $('#amount').prop("readonly", true);
    $('#purchasedDate').prop("readonly", true);
    $('#age').prop("readonly", true);
    $('#supplier').prop("readonly", true);
    $('#location').prop("readonly", true);
    $('#personInCharge').prop("readonly", true);
    $('#remarks').prop("readonly", true);

    $('#category').css("background-color", "white");
    $('#tagnum').css("background-color", "white");
    $('#serialNum').css("background-color", "white");
    $('#brandModel').css("background-color", "white");
    $('#description').css("background-color", "white");
    $('#quantity').css("background-color", "white");
    $('#amount').css("background-color", "white");
    $('#purchasedDate').css("background-color", "white");
    $('#age').css("background-color", "white");
    $('#supplier').css("background-color", "white");
    $('#location').css("background-color", "white");
    $('#personInCharge').css("background-color", "white");
    $('#remarks').css("background-color", "white");
}


function loadTotalAssetCount() {
    $.ajax({
        type: "POST",
        url: assetUrl,
        data: { "getTotalAssetCount": request },
        success: function(result) {
            $('#assetCount').text(result);
        }
    });
}



function loadTotalAssetCost() {
    $.ajax({
        type: "POST",
        url: assetUrl,
        data: { "getTotalAssetCost": request },
        success: function(result) {
            $('#assetCost').text(result);
        }
    });
}


function loadPendingDeliveries() {
    $.ajax({
        type: "POST",
        url: delUrl,
        data: { "getTotalPendingDeliveries": request },
        success: function(result) {
            $('#deliveredSupplies').text(result);
        }
    });
}


function loadTotalLoweringWHstocks() {
    $.ajax({
        type: "POST",
        url: supplyUrl,
        data: { "getTotalLoweringWHstocks": request },
        success: function(result) {
            $('#whLowStocks').text(result);
        }
    });
}



function recentlyAddedAssets() {
    $.ajax({
        type: "POST",
        url: assetUrl,
        data: { "loadRecentlyAdded": request },
        success: function(result) {
            //console.log(result);
            let html = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td><span class='tagnum'>" + result[i].tagnum + "</span></td>" +
                        "<td><span class='category'>" + result[i].category + "</span></td>" +
                        "<td><span class='brandmodel'>" + result[i].brandmodel + "</span></td>" +
                        "<td><span class='description'>" + result[i].description + "</span></td>" +
                        "<td><span class='location'>" + result[i].location + "</span></td>" +
                        "<td><span class='dateupdated'>" + result[i].dateupdated + "</span></td>" +
                        "</tr>";
                }
            }
            $("#rcntAddedTbody").html(html); // table body
            $("#rcntAddedTbl").DataTable({
                "order": [
                    [0, "desc"]
                ],
                "lengthMenu": [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                "pageLength": 10,
                bAutoWidth: false,
                aoColumns: [
                    { sWidth: '10%' },
                    { sWidth: '15%' },
                    { sWidth: '20%' },
                    { sWidth: '20%' },
                    { sWidth: '20%' },
                    { sWidth: '15%' }
                ]
            });
            //$('#loader').hide();
        }
    });
}

//----- recently added show/ hide control -------
$('#hideRecAddedBoxBtn').click(function() {
    $('#hideRecAddedBoxBtn').attr('style', 'display:none');
    $('#showRecAddedBoxBtn').removeAttr('style');

    $('#rcntAddedBox').hide(300);
});
$('#showRecAddedBoxBtn').click(function() {
    $('#showRecAddedBoxBtn').attr('style', 'display:none');
    $('#hideRecAddedBoxBtn').removeAttr('style');

    $('#rcntAddedBox').show(300);
});






//================================ QUICK SEARCH ASSET ==================================
$('#searchBar').keyup(function() {
    $('#loader').removeAttr('style');
    let query = $(this).val();

    if (query != "") {
        $.ajax({
            type: "POST",
            url: assetUrl,
            data: { "loadSearchAsset": request, "searchedItem": query },
            success: function(result) {
                //console.log(result);
                let html = '';
                if (result) {
                    for (let i = 0; i < result.length; i++) {
                        let stat = result[i].status;
                        if (stat == "disposed") {
                            html += "<tr style='color:red'>" +
                                "<td style='display:none'><span class='itemID'>" + result[i].itemID + "</span></td>" +
                                "<td><span class='tagnum'>" + result[i].tagnum + "</span></td>" +
                                "<td><span class='category'>" + result[i].category + "</span></td>" +
                                "<td><span class='brandmodel'>" + result[i].brandmodel + "</span></td>" +
                                "<td><span class='description'>" + result[i].description + "</span></td>" +
                                "<td><span class='location'>" + result[i].location + "</span></td>" +
                                "<td ><span class='status'>" + result[i].status + "</span></td>" +
                                "<td><div class='btn-group btn-group-sm'> <button type='button' class='btn btn-primary viewAssetBtn' title='View this asset's details'><span class='fas fa-eye'></span></a> </td>" +
                                "</td>";
                        } else {
                            html += "<tr>" +
                                "<td style='display:none'><span class='itemID'>" + result[i].itemID + "</span></td>" +
                                "<td><span class='tagnum'>" + result[i].tagnum + "</span></td>" +
                                "<td><span class='category'>" + result[i].category + "</span></td>" +
                                "<td><span class='brandmodel'>" + result[i].brandmodel + "</span></td>" +
                                "<td><span class='description'>" + result[i].description + "</span></td>" +
                                "<td><span class='location'>" + result[i].location + "</span></td>" +
                                "<td><span class='status'>" + result[i].status + "</span></td>" +
                                "<td><div class='btn-group btn-group-sm'> <button type='button' class='btn btn-primary viewAssetBtn' title='View this asset's details'><span class='fas fa-eye'></span></a> </td>" +
                                "</td>";
                        }

                    }
                    $('#srchResultTbl').removeAttr("style");
                    //$('#srchResultTbl').attr("style", "width:100%");
                    $('#srchResultTbody').html(html);
                    $('#loader').hide();
                } else {
                    $('#srchResultTbl').hide();
                    $('#loader').hide();
                }
            }
        });
    } else { // if query is blank
        $('#srchResultTbl').hide();
        $('#loader').hide();
    }

});



function loadAssetHistory() {
    // load asset history
    var itemID = $('#itemID').val();

    $.ajax({
        type: "POST",
        url: assetUrl,
        data: { "loadAssetHistory": request, "itemID": itemID },
        success: function(result) {
            //console.log(result); 
            let html = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td style='display:none'><span class='itemID'>" + result[i].itemhistoryID + "</span></td>" +
                        "<td><span class='activity'>" + result[i].report + "</span></td>" +
                        "<td><span class='activitydate'>" + result[i].activitydate + "</span></td>" +
                        "<td><span class='updatedby'>" + result[i].updatedby + "</span></td>" +
                        "<td><span class='dateupdated'>" + result[i].dateupdated + "</span></td>" +
                        "</tr>";
                }
            }
            $("#historyTbody").html(html); // table body
            $("#historyTbl").DataTable({
                "order": [
                    [0, "desc"]
                ],
                "lengthMenu": [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                "pageLength": 10,
                "bLengthChange": false,
                "searching": false,
                bAutoWidth: false,
                aoColumns: [
                    { sWidth: '1%' },
                    { sWidth: '40%' },
                    { sWidth: '15%' },
                    { sWidth: '19%' },
                    { sWidth: '25%' }
                ]
            });
        }
    });
}

function clearAssetHistoryTbl() {
    $('#historyTbl').DataTable().clear();
    $('#historyTbl').DataTable().destroy();
}


function thousands_separators(num) {
    var num_parts = num.toString().split(".");
    num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return num_parts.join(".");
}

$('#srchResultTbl').on('click', '.viewAssetBtn', function() {
    let row = $(this).closest('tr');
    var itemID = row.find("span.itemID").text(); +
    $('#itemID').val(itemID);

    clearAssetHistoryTbl();
    loadAssetHistory();

    // load asset details
    $.ajax({
        type: "POST",
        url: assetUrl,
        data: { "assetLoadSpecific": request, "itemID": itemID },
        success: function(result) {
            //console.log(result);
            let itemID = result[0].itemID;
            let category = result[0].category;
            let tagnum = result[0].tagnum;
            let serialnum = result[0].serialnum;
            let brandmodel = result[0].brandmodel;
            let description = result[0].description;
            let quantity = result[0].quantity;
            let unitcost = result[0].unitcost;
            let amount = thousands_separators(unitcost);
            let dateacquired = result[0].dateacquired;
            let supplier = result[0].supplier;
            let location = result[0].location;
            let personincharge = result[0].personincharge;
            let remarks = result[0].remarks;

            $.ajax({
                type: "POST",
                url: assetUrl,
                data: { "loadDateAcquired": request, "itemID": itemID },
                success: function(data) {
                    //-------- calculate the life in years/ month of an asset ---------
                    var doaMonth = parseInt(data.substring(0, 2), 10);
                    var doaDay = parseInt(data.substring(3, 5), 10);
                    var doaYear = parseInt(data.substring(6, 10), 10);
                    //console.log(data+": month: "+doaMonth+", day: "+doaDay+", year: "+doaYear)
                    var today = new Date();
                    var dateOfAcquisition = new Date(doaYear, doaMonth - 1, doaDay);

                    var differenceInMilisecond = today.valueOf() - dateOfAcquisition.valueOf();

                    var year_age = Math.floor(differenceInMilisecond / 31536000000);
                    var day_age = Math.floor((differenceInMilisecond % 31536000000) / 86400000);
                    var month_age = Math.floor(day_age / 31);
                    //day_age = day_age % 30;
                    if (year_age < 1) {
                        var lifeInYears = month_age + " month(s)";
                    } else {
                        var lifeInYears = year_age + " year(s) and " + month_age + " month(s)";
                    }

                    //--- Updating the life in years/ age from acquisition
                    $.ajax({
                        type: "POST",
                        url: assetUrl,
                        data: { "updateLifeYears": request, "itemID": itemID, "lifeInYears": lifeInYears },
                        success: function(result) {
                            if (result == "1") {
                                $('#itemID').val(itemID);
                                $('#category').val(category);
                                $('#tagnum').val(tagnum);
                                $('#serialNum').val(serialnum);
                                $('#brandModel').val(brandmodel);
                                $('#description').val(description);
                                $('#quantity').val(quantity);
                                $('#amount').val(amount);
                                $('#purchasedDate').val(dateacquired);
                                $('#age').val(lifeInYears);
                                $('#supplier').val(supplier);
                                $('#location').val(location);
                                $('#personInCharge').val(personincharge);
                                $('#remarks').val(remarks);

                                document.getElementById('assetDetailsMdlLbl').innerHTML = brandmodel;
                                $('#assetDetailsMdl').modal('show');
                            } else {
                                console.error(result);
                            }
                        }
                    });

                }
            });


        }
    });
});

$('#historyTab').click(function() {
    clearAssetHistoryTbl();
    loadAssetHistory();
});


$('#updateHistoryBtn').click(function() {
    let itemID = $('#itemID').val();
    let brandmodel = $('#brandModel').val();
    let newActivity = $('#newActivity').val();
    let activityDate = $('#activityDate').val();

    if (newActivity == "" || activityDate == "") {
        if (newActivity == "") {
            $('#activityVld').addClass("has-error");
            $(window).scrollTop(0);
        }

        if (activityDate == "") {
            $('#activityDateVld').addClass("has-error");
            $(window).scrollTop(0);
        }
    } else {
        console.log(`${itemID} ${brandmodel} has been ${newActivity} on ${activityDate}`);
        $.ajax({
            type: 'POST',
            url: 'includes/handlers/asset_saveHistory_handler',
            data: { "itemID": itemID, "brandmodel": brandmodel, "newActivity": newActivity, "activityDate": activityDate },
            success: function(result) {
                if (result == "success") {
                    $('#newActivity').val("");
                    $('#activityDate').val("");

                    clearAssetHistoryTbl();
                    loadAssetHistory();
                } else {
                    console.error(result);
                }
            }
        });
    }
});

$('#newActivity').keypress(function() {
    $('#activityVld').removeClass("has-error");
})

$('#activityDate').change(function() {
        $('#activityDateVld').removeClass("has-error");
    })
    //=====================================================================================================




//=================================== MY OWN REQUESTED SUPPLIES =============================//
let userRequestedSupplies = () => {
    var currentUser = $("#curUser").val();
    //console.log(`current user: ${currentUser}`);
    $.ajax({
        type: 'POST',
        url: "includes/handlers/supply_controller",
        data: { "loadUserRequestedSupplies": request, "currentUser": currentUser },
        success: function(result) {
            //console.log(result);
            let tableData = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    tableData += "<tr>" + //id='rqst" + result[i].rqstSupID + "'
                        "<td style='display:none'> <span class='totalamount'>" + result[i].totalamount + "</span> <span class='month'>" + result[i].monthOf + "</span><span class='year'>" + result[i].year + "</span> </td>" +
                        "<td><span class='rqstSupID'>" + result[i].rqstSupID + "</span> </td>" +
                        "<td><span class='dateRequested'>" + result[i].dateRequested + "</span></td>" +
                        "<td><span class='requestor'>" + result[i].requestor + "</span></td>" +
                        "<td><span class='department'>" + result[i].department + "</span></td>" +
                        "<td><span class='rqstStats'>" + result[i].rqstStats + "</span></td>" +
                        "<td> <button type='button' class='btn btn-primary btn-sm viewRqstdItemsBtn' title='View requested items'><span class='fas fa-eye'></span></button> <button type='button' class='btn btn-danger btn-sm cancelRequestBtn' title='Cancel this requested items'><span class='fas fa-trash'></span></button></td>" +
                        "</tr>";
                }
                $("#userReqSuppliesTbody").append(tableData); // table body
            } else {
                $("#userReqSuppliesBox").hide();
            }
        }
    });
}

$("#userReqSuppliesTbl").on("click", ".viewRqstdItemsBtn", function() {
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
    $("#requestedSuppliesAmt").val(reqSupAmt);
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

$("#userReqSuppliesTbl").on("click", ".cancelRequestBtn", function() {
    if (confirm("This can't be undone. Are you sure?")) {
        var row = $(this).closest("tr");
        var rqstSupID = row.find("span.rqstSupID").text();
        var rowCount = $("#userReqSuppliesTbody tr").length;

        $.ajax({
            type: "POST",
            url: supplyUrl,
            data: { "cancelRequestedSupply": request, "rqstSupID": rqstSupID },
            success: function(result) {
                //console.log(result);
                if (result == "1") {
                    row.attr("style", "background-color:#dd4b39");
                    row.fadeOut('slow',
                        function() {
                            row.remove();
                            console.log(rowCount);
                            if (rowCount <= 1) {
                                $("#userReqSuppliesBox").attr("style", "display:none");
                            }
                        }
                    );

                } else {
                    console.error(result)
                }
            }
        });
    }
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










//==================================== PENDING ENCODED DELIVERY ===============================//
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
                $("#encodedDeliveryTbody").append(tableData); // table body
            }
            // $("#encodedDeliveryTbody").append(tableData); // table body
            else {
                $("#encodedDeliveryBox").hide();
            }
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

$("#approveDeliveryBtn").click(function() {
    if (confirm("Is everything correct?")) {
        let dlvrdSupID = $('#dlvrdSupIDModal').val();
        let supplierName = $("#supplierNameModal").val();

        //-- update deliveredSup ---
        $.ajax({
            type: "POST",
            url: delUrl,
            data: { "updateDeliveredSup": request, "dlvrdSupID": dlvrdSupID, "supplierName": supplierName },
            success: function(result) {
                if (result != "1") {
                    console.error(result);
                }
            }
        });
        //----------------------

        $("#delItemsTbl > tbody > tr").each(function() {
            //-------- updating the supplies inventory --------
            var row = $(this).closest('tr');
            var productId = row.find("span.productID").text();
            var brandname = row.find("span.brandname").text();
            var productname = row.find("span.productname").text();
            var description = row.find("span.description").text();
            var quantity = row.find("span.quantity").text();
            var unit = row.find("span.unit").text();
            var unitPrice = row.find("span.unitPrice").text();
            var subAmount = row.find("span.subAmount").text();
            var stocksFull = row.find("span.stocksFull").text();
            //console.log(`prodId:${productId} - curQty:${quantity}`);

            var tbl = getWhStockInfo(productId);
            var whStockId = tbl[0];
            var whStocksLeft = tbl[1];
            var whStocksFull = tbl[2];

            if (whStockId == 0) {
                //insert new item stock on WHstocks table
                var perc = (quantity / stocksFull) * 100;
                var percentage = parseInt(perc);

                var postData = { "deliverySaveNewStocks": request, "brandname": brandname, "productname": productname, "description": description, "unitPrice": unitPrice, "unit": unit, "stocksFull": stocksFull, "stocksLeft": quantity, "percentage": percentage, "productId": productId };
                //console.log("insert new item stock on WHstocks table");
            } else {
                //update the current stock on WHstocks table
                var newStocksLeft = parseInt(whStocksLeft) + parseInt(quantity);
                var newPerc = (newStocksLeft / whStocksFull) * 100;
                var newPercentage = parseInt(newPerc);

                var postData = { "deliveryUpdateStocks": request, "stocksLeft": newStocksLeft, "percentage": newPercentage, "productId": productId };
                //console.log(`whStockId:${whStockId} - prevStocks: ${whStocksLeft} - delQty: ${quantity} - newStocks: ${newStocksLeft} - newPerc: ${newPercentage}`);
            }

            $.ajax({
                type: "POST",
                url: "includes/handlers/supply_controller",
                data: postData,
                success: function(result) {
                    if (result == "1") {
                        $("#deliveredSuppliesMdl").modal("hide");
                        var supId = $("#curRow").val();
                        $("#curRow" + supId).remove();
                    } else {
                        console.error(result);
                    }
                }
            });

            // $.ajax({
            //     type: "POST",
            //     url: delUrl,
            //     data: { "loadStocksInfo": request, "productId": productId },
            //     success: function(data) {

            //         if (data) {
            //             console.log(data);
            //             var itemID = data[0].itemID;
            //             var pid = data[0].productID;
            //             console.log(pid);
            //         }
            //         // var newStocksLeft = parseInt(stocksLeft) + parseInt(quantity);
            //         // var newPerc = (newStocksLeft / stocksFull) * 100;
            //         // var newPercentage = parseInt(newPerc);
            //         // console.log(`pid:${productId} - newStocks: ${newStocksLeft} - newPerc: ${newPercentage}`);
            //     }
            // });
        });
    }
});
//=============================================================================================//





let getWhStockInfo = (productId) => {
    var pInfo = [0, "", ""];

    $("#whStockInfoTbody > tr").each(function() {
        var whrow = $(this).closest('tr');
        var whprodId = whrow.find("span.productID").text();
        var stocksFull = whrow.find("span.stocksFull").text();
        var stocksLeft = whrow.find("span.stocksLeft").text();

        if (productId == whprodId) {
            pInfo = [whprodId, stocksLeft, stocksFull];
        }
    });
    return pInfo;
}


let loadWHstocksInfo = () => {
    $.ajax({
        type: "POST",
        url: "includes/handlers/supply_controller",
        data: { "getAllWhStocks": request },
        success: function(result) {
            //console.log(result);
            let tableData = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    tableData += "<tr>" +
                        "<td><span class='itemID'>" + result[i].itemID + "</span></td>" +
                        "<td><span class='productID'>" + result[i].productID + "</span></td>" +
                        "<td><span class='stocksFull'>" + result[i].stocksfull + "</span></td>" +
                        "<td><span class='stocksLeft'>" + result[i].stocksleft + "</span></td>" +
                        "<td><span class='percentage'>" + result[i].percentage + "</span></td>" +
                        "</tr>";
                }
            }
            $("#whStockInfoTbody").append(tableData); // table body
        }
    });
}


// function tableToJson(table) {
//     var data = []; // first row needs to be headers 
//     var headers = [];
//     for (var i = 0; i < table.rows[0].cells.length; i++) {
//         headers[i] = table.rows[0].cells[i].innerHTML.toLowerCase().replace(/ /gi, '');
//     }
//     // go through cells
//     for (var i = 1; i < table.rows.length; i++) {
//         var tableRow = table.rows[i];
//         var rowData = {};
//         for (var j = 0; j < tableRow.cells.length; j++) {
//             rowData[headers[j]] = tableRow.cells[j].innerHTML;
//         }
//         data.push(rowData);
//     }
//     return data;
// }