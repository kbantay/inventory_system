let url = "includes/handlers/asset_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');
    $('#loader').removeAttr('style');

    loadDisposedItems();
});



function loadDisposedItems() {
    $.ajax({
        type: "POST",
        url: url,
        data: { "loadDisposedItems": request },
        success: function(result) {
            //console.log(result);
            let html = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td style='display:none'><span class='itemID'>" + result[i].itemID + "</span></td>" +
                        "<td>" + result[i].tagnum + "</td>" +
                        "<td><span class='brandmodel'>" + result[i].brandmodel + "</span></td>" +
                        "<td><span class='description'>" + result[i].description + "</span></td>" +
                        "<td>" + result[i].remarks + "</td>" +
                        "<td>" + result[i].disposetype + "</td>" +
                        "<td>" + result[i].datedisposed + "</td>" +
                        "<td><button type='button' class='btn btn-primary viewDetailsBtn' title='View more details about this item'><span class='fas fa-clipboard-list'></span> &nbsp; View</button></td>" +
                        "</tr>";
                }
            }
            $("#disposedAssetTbody").html(html); // table body
            $("#disposedAssetTbl").DataTable({
                "order": [
                    [0, "desc"]
                ],
                "pageLength": 25,
                bAutoWidth: false,
                searching: false,
                aoColumns: [
                    { sWidth: '1%' },
                    { sWidth: '8%' },
                    { sWidth: '20%' },
                    { sWidth: '23%' },
                    { sWidth: '20%' },
                    { sWidth: '8%' },
                    { sWidth: '12%' },
                    { sWidth: '8%' }
                ]
            });
            $('#loader').hide();
        }
    });
}


$("#disposedAssetTbl").on('click', '.viewDetailsBtn', function() {
    $('#loader').show();
    let row = $(this).closest('tr');
    let itemID = row.find("span.itemID").text();
    let brandmodel = row.find("span.brandmodel").text();
    let description = row.find("span.description").text();

    document.getElementById("assetDetailsMdlLbl").innerHTML = `${brandmodel} ${description}`;
    loadAssetInfoHistory(itemID);
});

//------- event upon closing the modal -------//
$('#reportModalMain').on('hidden.bs.modal', function(e) {
    $('#detailsTab').trigger('click');
});


function loadAssetHistory() {
    var itemID = $('#itemID').val();

    $.ajax({
        type: "POST",
        url: url,
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

function loadAssetInfoHistory(itemID) {
    $('#itemID').val(itemID);
    clearAssetHistoryTbl();
    loadAssetHistory();

    // load asset details
    $.ajax({
        type: "POST",
        url: url,
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
            let classification = result[0].classification;

            $.ajax({
                type: "POST",
                url: url,
                data: { "loadDateAcquired": request, "itemID": itemID },
                success: function(data) {
                    //console.log(data);
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
                        url: url,
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
                                $('#itemClass').val(classification);

                                //--- change bg color of readonly text ---
                                $('#category').css({ "background-color": "white" });
                                $('#tagnum').css({ "background-color": "white" });
                                $('#serialNum').css({ "background-color": "white" });
                                $('#brandModel').css({ "background-color": "white" });
                                $('#description').css({ "background-color": "white" });
                                $('#quantity').css({ "background-color": "white" });
                                $('#amount').css({ "background-color": "white" });
                                $('#purchasedDate').css({ "background-color": "white" });
                                $('#age').css({ "background-color": "white" });
                                $('#supplier').css({ "background-color": "white" });
                                $('#location').css({ "background-color": "white" });
                                $('#personInCharge').css({ "background-color": "white" });
                                $('#remarks').css({ "background-color": "white" });

                                $('#assetDetailsMdl').modal('show');
                            } else {
                                console.error(result);
                            }
                            $('#loader').hide();
                        }
                    });

                }
            });


        }
    });
}