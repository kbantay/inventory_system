let url = "includes/handlers/asset_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');
    $('#loader').removeAttr('style');

    //Date picker
    $('#activityDate').datepicker({
        autoclose: true
    });
    $('#disposedDateMdl').datepicker({
        autoclose: true
    });
    $('#dateAcquired').datepicker({
        autoclose: true
    });


    //loadAllAsset();
    loadPerLocation();
    loadBuilding();
    loadCategory();
    loadSupplier();
});


function clearAllAssetTbl() {
    $('#allAssetTbl').DataTable().clear();
    $('#allAssetTbl').DataTable().destroy();
}

function reloadAllAssetTbl() {
    $('#allAssetTbl').DataTable().clear();
    $('#allAssetTbl').DataTable().destroy();
    loadAllAsset();
}

function loadAllAsset() {
    $.ajax({
        type: "POST",
        url: url,
        data: { "loadAllAssets": request },
        success: function(result) {
            //console.log(result);
            let html = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    html += "<tr id='row" + result[i].itemID + "'>" +
                        "<td style='display:none'><span class='itemID'>" + result[i].itemID + "</span> </td>" +
                        "<td><span class='tagnum'>" + result[i].tagnum + "</span></td>" +
                        "<td><span class='category'>" + result[i].category + "</span></td>" +
                        "<td><span class='brandmodel'>" + result[i].brandmodel + "</span></td>" +
                        "<td><span class='description'>" + result[i].description + "</span></td>" +
                        "<td id='loc" + result[i].itemID + "'><span class='location'>" + result[i].location + "</span></td>" +
                        "<td><div class='btn-group btn-group-sm'> <button type='button' class='btn btn-primary viewAssetBtn' title='View asset details'><span class='fas fa-eye'></span></a>  <button type='button' class='btn btn-danger disposeAssetBtn' title='Dispose this asset'><span class='fas fa-trash-alt'></span></button></td>" +
                        "</tr>";
                }
            }
            $("#allAssetTbody").html(html); // table body
            $("#allAssetTbl").DataTable({
                "order": [
                    [2, "asc"]
                ],
                "lengthMenu": [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                "pageLength": 50,
                bAutoWidth: false,
                aoColumns: [
                    { sWidth: '1%' },
                    { sWidth: '10%' },
                    { sWidth: '14%' },
                    { sWidth: '20%' },
                    { sWidth: '24%' },
                    { sWidth: '18%' },
                    { sWidth: '10%' }
                ]
            });
            $('#loader').hide();
        }
    });
}

//-------------------------------------------------------------- 
function loadCategory() {
    $.ajax({
        type: 'POST',
        url: 'includes/handlers/category_controller',
        data: { "loadAllCategories": request },
        success: function(result) {
            var html = '';
            if (result) {
                html += '<option value="All"> All </option>';
                for (var i = 0; i < result.length; i++) {
                    html += '<option value="' + result[i].categoryName + '">' + result[i].categoryName + '</option>';
                }
            }
            $('#categoryDdown').html(html);
            $('#categoryDdownMdl').html(html);

            let astAccess = $('#astAccess').val();
            $('#categoryDdown').val(astAccess);

            let category = $('#categoryDdown').val();
            loadAssetsPerCategory(category);
        }
    });
}

$('#categoryDdown').change(function() {
    let category = $('#categoryDdown').val();
    $('#loader').removeAttr('style');
    loadAssetsPerCategory(category);
});

function loadAssetsPerCategory(category) {
    if (category == "All") {
        reloadAllAssetTbl();
    } else {
        // Load assset per selected category on filter by
        $.ajax({
            type: "POST",
            url: url,
            data: { "loadAssetCategory": request, "category": category },
            success: function(result) {
                //console.log(result);
                clearAllAssetTbl();

                let html = '';
                if (result) {
                    for (let i = 0; i < result.length; i++) {
                        html += "<tr id='row" + result[i].itemID + "'>" +
                            "<td style='display:none'><span class='itemID'>" + result[i].itemID + "</span></td>" +
                            "<td><span class='tagnum'>" + result[i].tagnum + "</span></td>" +
                            "<td><span class='category'>" + result[i].category + "</span></td>" +
                            "<td><span class='brandmodel'>" + result[i].brandmodel + "</span></td>" +
                            "<td><span class='description'>" + result[i].description + "</span></td>" +
                            "<td id='loc" + result[i].itemID + "'><span class='location'>" + result[i].location + "</span></td>" +
                            "<td><div class='btn-group btn-group-sm'> <button type='button' class='btn btn-primary viewAssetBtn' title='View asset details'><span class='fas fa-eye'></span></a>  <button type='button' class='btn btn-danger disposeAssetBtn' title='Dispose this asset'><span class='fas fa-trash-alt'></span></button></td>" +
                            "</tr>";
                    }
                }
                $("#allAssetTbody").html(html); // table body
                $("#allAssetTbl").DataTable({
                    "order": [
                        [2, "asc"]
                    ],
                    "lengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "pageLength": 50,
                    bAutoWidth: false,
                    aoColumns: [
                        { sWidth: '1%' },
                        { sWidth: '10%' },
                        { sWidth: '14%' },
                        { sWidth: '20%' },
                        { sWidth: '24%' },
                        { sWidth: '18%' },
                        { sWidth: '10%' }
                    ]
                });
                $('#loader').hide();
            }
        });
    }
}


function loadSupplier() {
    $.ajax({
        type: 'POST',
        url: 'includes/handlers/supplier_controller',
        data: { "getAllSuppliers": request },
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


function loadBuilding() {
    var request = "";
    $.ajax({
        type: 'POST',
        url: 'includes/handlers/building_controller',
        data: { "loadAllBldg": request },
        success: function(result) {
            var html = '';
            if (result) {
                html += '<option value="" selected disabled> Select Building </option>';
                for (var i = 0; i < result.length; i++) {
                    html += '<option value="' + result[i].bldgID + '">' + result[i].bldgName + '</option>';
                }
            }
            $('#buildingDdown').html(html);
        }
    });
}

$('#buildingDdown').change(function() {
    let request = "";
    var bldg = $('#buildingDdown')[0].selectedIndex;
    $.ajax({
        type: 'POST',
        url: 'includes/handlers/room_controller',
        data: { "loadRoomPerBldg": request, "bldgID": bldg },
        success: function(result) {
            var html = '';
            if (result) {
                html += '<option value="" selected disabled> Select Room </option>';
                for (var i = 0; i < result.length; i++) {
                    html += '<option value="' + result[i].locationName + '">' + result[i].roomName + '</option>';
                }
                $('#roomDdown').html(html);
                $('#roomDdown').show();
            } else {
                $('#roomDdown').hide();
            }
            $('#roomDdown').html(html);
        }
    });
});


//============================  LOAD ASSET DETAILS AND HISTORY INTO THE MODAL ==========================

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

function readonlyAssetDetails() {
    $('#serialNum').attr("readonly", "readonly");
    $('#brandModel').attr("readonly", "readonly");
    $('#description').attr("readonly", "readonly");
    $('#quantity').attr("readonly", "readonly");
    $('#amount').attr("readonly", "readonly");
    $('#personInCharge').attr("readonly", "readonly");
    $('#remarks').attr("readonly", "readonly");

    $('.readonly').css("background-color", "#fafafa");
}

function assetAccessValidation() {
    //hiding edit details button on the modal
    let astAcs = $('#astAccess').val();
    let itmClass = $('#itemClass').val();

    if (astAcs == itmClass || astAcs == "All") {
        $('#editAssetDetailsBtn').show();
        $('#updateHistoryBtn').show();
    } else {
        $('#editAssetDetailsBtn').hide();
        $('#updateHistoryBtn').hide();
    }
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

                                $('#serialNumMdl').val(serialnum);
                                $('#brandModelMdl').val(brandmodel);
                                $('#descriptionMdl').val(description);
                                $('#quantityMdl').val(quantity);
                                $('#amountMdl').val(amount);
                                $("#personInChargeMdl").val(personincharge);

                                document.getElementById('assetDetailsMdlLbl').innerHTML = brandmodel + " " + description;
                                readonlyAssetDetails();

                                assetAccessValidation();
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

$('#allAssetTbl').on('click', '.viewAssetBtn', function() {
    $('#loader').removeAttr('style');
    let row = $(this).closest('tr');
    var itemID = row.find("span.itemID").text();
    //console.log(row);

    loadAssetInfoHistory(itemID);
});





//============================ EDIT ASSET DETAILS CRUD AND VALIDATION ==========================//

$('#editAssetDetailsBtn').click(function() {
    $('#editAssetDetailsBtn').hide();
    $('#cancelEditingBtn').show();
    $('#updateAssetDetailsBtn').show();

    //---- change of input-text bgcolor -----
    $('#personInCharge').animate({ backgroundColor: '#fffff0' }, 'fast');
    $('#personInCharge').removeAttr("readonly");
    $('#remarks').animate({ backgroundColor: '#fffff0' }, 'fast');
    $('#remarks').removeAttr("readonly");
    //------ additional details to edit maybe temporary ---------
    $("#serialNum").removeAttr("readonly");
    $("#serialNum").animate({ backgroundColor: '#fffff0' }, 'fast');
    $("#brandModel").removeAttr("readonly");
    $('#brandModel').animate({ backgroundColor: '#fffff0' }, 'fast');
    $("#description").removeAttr("readonly");
    $('#description').animate({ backgroundColor: '#fffff0' }, 'fast');
    $("#quantity").removeAttr("readonly");
    $('#quantity').animate({ backgroundColor: '#fffff0' }, 'fast');
    $("#amount").removeAttr("readonly");
    $('#amount').animate({ backgroundColor: '#fffff0' }, 'fast');
    //---- show these items ------
    $("#categoryDdownMdl").removeAttr("style");
    $("#subcategoryDdownMdl").removeAttr("style");
    $("#dateAcqBox").removeAttr("style");
    $('#supplierDdown').removeAttr("style");

    //------- hide this items
    $('#location').hide();
    $('#locationDdowns').show();
    $("#purchasedDate").hide();
    $("#supplier").hide();
    $("#category").hide();
});

$('#categoryDdownMdl').change(function() {
    var category = $('#categoryDdownMdl')[0].selectedIndex;
    $.ajax({
        type: 'POST',
        url: 'includes/handlers/subcategory_controller',
        data: { "loadPerCategory": request, "categoryID": category },
        success: function(result) {
            var html = '';
            if (result) {
                html += '<option value="" selected disabled> Select Subcategory </option>';
                for (var i = 0; i < result.length; i++) {
                    html += '<option value="' + result[i].subcategoryID + '">' + result[i].subcategoryName + '</option>';
                }
            }
            $('#subcategoryDdownMdl').html(html);
        }
    });
});







$('#cancelEditingBtn').click(function() {
    //--- show these items ---
    $('#editAssetDetailsBtn').show();
    $('#location').show();
    $("#category").show();
    $("#purchasedDate").show();
    $("#supplier").show();

    //--- hide this items ---
    $('#cancelEditingBtn').hide();
    $('#updateAssetDetailsBtn').hide();
    $('#locationDdowns').hide();
    $("#categoryDdownMdl").hide();
    $("#subcategoryDdownMdl").hide();
    $("#dateAcqBox").hide();
    $('#supplierDdown').hide();

    //--- prev data ---
    var serNum = $("#serialNumMdl").val();
    var brand = $("#brandModelMdl").val();
    var desc = $("#descriptionMdl").val();
    var qty = $("#quantityMdl").val();
    var amt = $("#amountMdl").val();
    var person = $("#personInChargeMdl").val();
    //--- back to current data ---
    $('#serialNum').val(serNum);
    $('#brandModel').val(brand);
    $('#description').val(desc);
    $('#quantity').val(qty);
    $('#amount').val(amt);
    $("#personInCharge").val(person);

    // $('#serialNum').attr("readonly", "readonly");
    // $('#brandModel').attr("readonly", "readonly");
    // $('#description').attr("readonly", "readonly");
    // $('#quantity').attr("readonly", "readonly");
    // $('#amount').attr("readonly", "readonly");
    // $('#personInCharge').attr("readonly", "readonly");
    // $('#remarks').attr("readonly", "readonly");
    readonlyAssetDetails();
});


function getItemsCountLocation(location) {
    //---- get number of items in a location ----
    var totalAssets = false;
    $.ajax({
        type: "POST",
        url: url,
        data: { "totalNumAssetLoc": request, "location": location },
        dataType: "html",
        async: false,
        success: function(data) {
            totalItems = data;
        }
    });
    return totalItems;
}


//=========================== auto search of person in charge ==============================
$('#personInCharge').keyup(function() {
    var searched = $(this).val();
    if (searched == "") {
        $("#searchResultBox").attr("style", "display:none");
    } else {
        $("#searchResultBox").removeAttr("style");
        loadSearchedNames(searched);
    }
});

let loadSearchedNames = (searchedName) => {
    $.ajax({
        type: 'POST',
        url: 'includes/handlers/user_controller',
        data: { "loadSearchedName": request, "searchedName": searchedName },
        success: function(result) {
            var list = '';
            if (result) {
                for (var i = 0; i < result.length; i++) {
                    list += '<li class="search-result-item" value="' + result[i].department + '">' + result[i].fullname + '</li>';
                }
            }
            $('#searchResult').html(list);
        }
    });
}

$("#searchResult").on("click", ".search-result-item", function() {
    var name = $(this).text();
    var dept = $(this).val();
    $('#personInCharge').val(name);
    $("#searchResultBox").attr("style", "display:none");

    //console.log(`name:${name} dept:${dept}`);
    // $('#departmentDdown')[0].selectedIndex = dept;
    // $('#departmentValidate').removeClass("has-error");
});
//===================================================================================


$('#updateAssetDetailsBtn').click(function() {
    $('#editAssetDetailsBtn').show();
    $('#cancelEditingBtn').hide();
    $('#updateAssetDetailsBtn').hide();

    var itemID = $('#itemID').val();
    if ($('#subcategoryDdownMdl')[0].selectedIndex <= 0) {
        var category = $('#category').val();
    } else {
        var category = $('#subcategoryDdownMdl option:selected').text();
    }
    var serialnum = $('#serialNum').val();
    var brandmodel = $('#brandModel').val();
    var description = $('#description').val();
    var quantity = $('#quantity').val();
    var amount = $('#amount').val();
    var dateAcquired = $("#dateAcquired").val();
    if (dateAcquired == "") {
        purchasedDate = $('#purchasedDate').val();
    } else {
        purchasedDate = $("#dateAcquired").val();
    }
    if ($('#categoryDdownMdl')[0].selectedIndex <= 0) {
        var classification = $('#itemClass').val();
    } else {
        var classification = $('#categoryDdownMdl option:selected').text();
    }
    if ($('#supplierDdown')[0].selectedIndex <= 0) {
        var supplier = $('#supplier').val();
    } else {
        var supplier = $('#supplierDdown option:selected').text();
    }
    if ($('#buildingDdown')[0].selectedIndex <= 0) {
        var location = $('#location').val();
    } else {
        var building = $('#buildingDdown option:selected').text();
        if ($('#roomDdown')[0].selectedIndex <= 0) {
            var location = building;
        } else {
            var room = $('#roomDdown option:selected').text();
            var location = building + " " + room;
        }
    }
    var prevLocation = $('#location').val();

    // if (location == "") {
    //     newlocation = prevLocation;
    // } else {
    //     
    // }
    var personincharge = $('#personInCharge').val();
    var remarks = $('#remarks').val();

    // console.log(`itemId: ${itemID} - cat: ${category} - serial#: ${serialnum} - brandmodel: ${brandmodel} - description: ${description} - quantity: ${quantity} - amount: ${amount} - dateAcquired: ${purchasedDate} - class: ${classification} - supplier: ${supplier} - location: ${location} - inCharge: ${personincharge} - remarks: ${remarks}`);
    if (confirm("Is everything okay?")) {
        if (prevLocation != location) {
            var prevAssetCount = getItemsCountLocation(prevLocation);
            var prevLocTotal = prevAssetCount - quantity;
            //console.log("before: " + prevAssetCount + ", Now: " + prevLocTotal);

            //--- Update Previous Location Total Asset ---//
            $.ajax({
                type: "POST",
                url: url,
                data: { "updateAssetTotalLocation": request, "location": prevLocation, "totalCount": prevLocTotal },
                success: function(result) {
                    if (result == "1") {
                        //--- updating asset details ---
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: { "updateAssetDetails": request, "itemID": itemID, "category": category, "serialnum": serialnum, "brandmodel": brandmodel, "description": description, "quantity": quantity, "amount": amount, "purchasedDate": purchasedDate, "classification": classification, "supplier": supplier, "location": location, "personInCharge": personincharge, "remarks": remarks },
                            success: function(result) {
                                if (result == "1") {
                                    //--- updating new location ---//
                                    var newAssetCount = getItemsCountLocation(location);

                                    $.ajax({
                                        type: "POST",
                                        url: url,
                                        data: { "updateAssetTotalLocation": request, "location": location, "totalCount": newAssetCount },
                                        success: function(result) {
                                            if (result == "1") {
                                                //console.log("before: " + prevAssetCount + ", Now: " + prevLocTotal);
                                                loadAssetInfoHistory(itemID);
                                                readonlyAssetDetails();

                                                var tdid = "#loc" + itemID + " span";
                                                var td = $(tdid).text(location);

                                                //need to reload also the per location table
                                                clearLocationsTbl();
                                                loadPerLocation();

                                                //--- show these items ---
                                                $('#editAssetDetailsBtn').show();
                                                $('#location').show();
                                                $("#category").show();
                                                $("#purchasedDate").show();
                                                $("#supplier").show();

                                                //--- hide this items ---
                                                $('#cancelEditingBtn').hide();
                                                $('#updateAssetDetailsBtn').hide();
                                                $('#locationDdowns').hide();
                                                $("#categoryDdownMdl").hide();
                                                $("#subcategoryDdownMdl").hide();
                                                $("#dateAcqBox").hide();
                                                $('#supplierDdown').hide();

                                                //--- show the new data ---
                                                $('#serialNum').val(serialnum);
                                                $('#brandModel').val(brandmodel);
                                                $('#description').val(description);
                                                $('#quantity').val(quantity);
                                                $('#amount').val(amount);
                                                $("#personInCharge").val(personincharge);

                                                // $('#serialNum').attr("readonly", "readonly");
                                                // $('#brandModel').attr("readonly", "readonly");
                                                // $('#description').attr("readonly", "readonly");
                                                // $('#quantity').attr("readonly", "readonly");
                                                // $('#amount').attr("readonly", "readonly");
                                                // $('#personInCharge').attr("readonly", "readonly");
                                                // $('#remarks').attr("readonly", "readonly");
                                                readonlyAssetDetails();
                                                //--------------------------

                                                alert("Asset details updated successfully!");
                                            } else {
                                                console.error(result);
                                            }
                                        }
                                    });

                                } else {
                                    console.error(result);
                                }
                            }
                        });
                    } else {
                        console.error(result);
                    }
                }
            });
        } else {
            //--- updating asset details of the same location---
            $.ajax({
                type: "POST",
                url: url,
                data: { "updateAssetDetails": request, "itemID": itemID, "category": category, "serialnum": serialnum, "brandmodel": brandmodel, "description": description, "quantity": quantity, "amount": amount, "purchasedDate": purchasedDate, "classification": classification, "supplier": supplier, "location": location, "personInCharge": personincharge, "remarks": remarks },
                success: function(result) {
                    if (result == "1") {
                        loadAssetInfoHistory(itemID);

                        //--- show these items ---
                        $('#editAssetDetailsBtn').show();
                        $('#location').show();
                        $("#category").show();
                        $("#purchasedDate").show();
                        $("#supplier").show();

                        //--- hide this items ---
                        $('#cancelEditingBtn').hide();
                        $('#updateAssetDetailsBtn').hide();
                        $('#locationDdowns').hide();
                        $("#categoryDdownMdl").hide();
                        $("#subcategoryDdownMdl").hide();
                        $("#dateAcqBox").hide();
                        $('#supplierDdown').hide();

                        //--- show the new data ---
                        $('#serialNum').val(serialnum);
                        $('#brandModel').val(brandmodel);
                        $('#description').val(description);
                        $('#quantity').val(quantity);
                        $('#amount').val(amount);
                        $("#personInCharge").val(personincharge);
                        readonlyAssetDetails();

                        alert("Asset details updated successfully!");
                    } else {
                        console.error(result);
                    }
                }
            });
        }
    }
});

//------------- Event upon closing modal ------------------------//
$('#assetDetailsMdl').on('hidden.bs.modal', function(e) {
    $('#cancelEditingBtn').trigger('click');
});







//===============================================================================================//







$('#historyTab').click(function() {
    clearAssetHistoryTbl();
    loadAssetHistory();
    $('#cancelEditingBtn').trigger('click');
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
        //console.log(`${itemID} ${brandmodel} has been ${newActivity} on ${activityDate}`);
        $.ajax({
            type: 'POST',
            url: url,
            data: { "saveHistory": request, "itemID": itemID, "brandmodel": brandmodel, "newActivity": newActivity, "activityDate": activityDate },
            success: function(result) {
                if (result == "1") {
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
});

$('#activityDate').change(function() {
    $('#activityDateVld').removeClass("has-error");
});





//====================================== DISPOSING AN ASSET =================================
function showDisposeAssetModal(itemID, tagnum, brandmodel) {
    if (confirm("Disposing this item cannot be undone. Are you sure?")) {
        $('#tagnumDelMdl').val(tagnum);
        $('#brandDelMdl').val(brandmodel);
        $('#itemIDMdl').val(itemID);

        $('#disposeAssetMdl').modal('show');
    }
}

$('#allAssetTbl').on('click', '.disposeAssetBtn', function() {
    let row = $(this).closest('tr');
    let itemID = row.find("span.itemID").text();
    let tagnum = row.find("span.tagnum").text();
    let brandmodel = row.find("span.brandmodel").text();

    showDisposeAssetModal(itemID, tagnum, brandmodel);
});


$('#disposeBtn').click(function() {
    let itemid = $('#itemIDMdl').val();
    //let selectedRow = "row" + itemid;
    let brandmodel = $('#brandDelMdl').val();

    var disposedDateMdl = $('#disposedDateMdl').val();
    if ($('#delTypeDdownMdl')[0].selectedIndex <= 0) {
        var delType = "";
    } else {
        var delType = $('#delTypeDdownMdl option:selected').text();
    }
    var delReasonMdl = $('#delReasonMdl').val();

    if (disposedDateMdl == "" || delType == "" || delReasonMdl == "") {
        if (disposedDateMdl == "") {
            $('#dateDisposedVld').addClass("has-error");
            $(window).scrollTop(0);
        }

        if (delType == "") {
            $('#disposeTypeVld').addClass("has-error");
            $(window).scrollTop(0);
        }

        if (delReasonMdl == "") {
            $('#disposeReasonVld').addClass("has-error");
            $(window).scrollTop(0);
        }
    } else {
        if (confirm("Is everything correct?")) {
            $.ajax({
                type: 'POST',
                url: url,
                data: { "disposeAsset": request, "itemid": itemid, "brandmodel": brandmodel, "disposedDateMdl": disposedDateMdl, "delType": delType, "delReasonMdl": delReasonMdl },
                success: function(result) {
                    if (result == "1") {
                        $('#tagnumDelMdl').val("");
                        $('#brandDelMdl').val("");
                        $('#delTypeDdownMdl')[0].selectedIndex = 0
                        $('#disposedDateMdl').val("");
                        $('#delReasonMdl').val("");
                        $('#disposeAssetMdl').modal('hide');
                        //$('#alertBoxSuccess').removeAttr("style");
                        $("#row" + itemid).attr("style", "background-color:#dd4b39");
                        $("#row" + itemid).fadeOut('slow',
                            function() {
                                $("#row" + itemid).remove();
                            }

                        );
                        // $(window).scrollTop(0);
                        // window.setTimeout(function() {
                        //     document.getElementById("alertBoxSuccess").style.display = 'none';
                        // }, 3000);
                        // reloadAllAssetTbl();
                    } else {
                        console.error(result);
                    }
                }

            });

        }
    }
});


$('#disposedDateMdl').change(function() {
    $('#dateDisposedVld').removeClass("has-error");
});

$('#delTypeDdownMdl').change(function() {
    $('#disposeTypeVld').removeClass("has-error");
});

$('#delReasonMdl').keypress(function() {
    $('#disposeReasonVld').removeClass("has-error");
});

$('#historyTab').click(function() {
    $('#assetDetailsUpdateBtns').hide();
});

$('#detailsTab').click(function() {
    $('#assetDetailsUpdateBtns').show();
    assetAccessValidation();
});


//=================================================================================================================//
//------------------------------------------- SCRIPTS FOR PER LOCATION TAB ----------------------------------------//
//=================================================================================================================//

//=========================================== LOAD ALL LOCATIONS ========================================
function loadPerLocation() {
    $.ajax({
        type: "POST",
        url: url,
        data: { "loadLocations": request },
        success: function(result) {
            //console.log(result);
            let html = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td style='display:none'><span class='assetLocID'>" + result[i].assetLocID + "</span></td>" +
                        "<td><span class='location'>" + result[i].location + "</span></td>" +
                        "<td><span class='numOfItems'>" + result[i].numOfItems + "</span></td>" +
                        "<td><span class='lastUpdated'>" + result[i].lastUpdated + "</span></td>" +
                        "<td><div class='btn-group btn-group-sm'> <button type='button' class='btn btn-primary viewAssetsBtn' title='View assets in this location'><span class='fas fa-clipboard-list'></span> &nbsp; View Assets</button></div></td>" +
                        "</tr>";
                }
            }
            $("#perLocationTbody").html(html); // table body
            $("#perLocationTbl").DataTable({
                "order": [
                    [1, "asc"]
                ],
                "lengthMenu": [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                "pageLength": 50,
                bAutoWidth: false,
                aoColumns: [
                    { sWidth: '1%' },
                    { sWidth: '39%' },
                    { sWidth: '20%' },
                    { sWidth: '25%' },
                    { sWidth: '15%' }
                ]
            });
            //$('#loader').hide();
        }
    });
}

function updateSumItemsPerLocation(assetLocID, location) {
    //---- get number of items in a location ----
    var totalAssets = false;
    $.ajax({
        type: "POST",
        url: url,
        data: { "totalNumAssetLoc": request, "location": location },
        dataType: "html",
        async: false,
        success: function(data) {
            totalAssets = data;

            //--- update number of assets on asset location ---
            $.ajax({
                type: "POST",
                url: url,
                data: { "updateTotalNumAssetLoc": request, "totalAssets": totalAssets, "assetLocID": assetLocID },
                success: function(data) {
                    //console.log(data);
                }
            });

        }
    });
    return totalAssets;
}

function clearLocationsTbl() {
    $("#perLocationTbl").DataTable().clear();
    $("#perLocationTbl").DataTable().destroy();
}

function clearAssetsLocationTbl() {
    $("#locAssetTbl").DataTable().clear();
    $("#locAssetTbl").DataTable().destroy();
}

$('#perLocationTbl').on('click', '.viewAssetsBtn', function() {
    //$('#loader').removeAttr('style');
    $('#loader').show();
    var row = $(this).closest('tr');
    var loc = row.find("span.location").text();
    var assetLocID = row.find("span.assetLocID").text();

    document.getElementById('assetLocationMdlLbl').innerHTML = "Asset List: " + loc;
    var tot = updateSumItemsPerLocation(assetLocID, loc);
    row.find("span.numOfItems").text(tot);

    $.ajax({
        type: "POST",
        url: url,
        data: { "loadAssetsLocation": request, "location": loc },
        success: function(result) {
            //console.log(result);
            let html = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    html += "<tr id='row" + result[i].itemID + "'>" +
                        "<td style='display:none'><span class='itemID'>" + result[i].itemID + "</span></td>" +
                        "<td><span class='tagnum'>" + result[i].tagnum + "</span></td>" +
                        "<td><span class='category'>" + result[i].category + "</span></td>" +
                        "<td><span class='brandmodel'>" + result[i].brandmodel + "</span></td>" +
                        "<td><span class='description'>" + result[i].description + "</span></td>" +
                        "<td><div class='btn-group btn-group-sm'> <button type='button' class='btn btn-primary viewAssetBtn' title='View asset details'><span class='fas fa-eye'></span></a>  <button type='button' class='btn btn-danger disposeAssetBtn' title='Dispose this asset'><span class='fas fa-trash-alt'></span></button></td>" +
                        "</tr>";
                }
            }
            clearAssetsLocationTbl();
            $("#locAssetTbody").html(html); // table body
            $("#locAssetTbl").DataTable({
                "order": [
                    [2, "asc"]
                ],
                "lengthMenu": [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                bAutoWidth: false,
                aoColumns: [
                    { sWidth: '1%' },
                    { sWidth: '10%' },
                    { sWidth: '19%' },
                    { sWidth: '28%' },
                    { sWidth: '30%' },
                    { sWidth: '12%' }
                ]
            });
            $('#loader').hide();

            $('#assetLocationMdl').modal('show');
        }
    });
});


$('#locAssetTbl').on('click', '.viewAssetBtn', function() {
    var row = $(this).closest('tr');
    var itemID = row.find("span.itemID").text();
    loadAssetInfoHistory(itemID)
});


$('#locAssetTbl').on('click', '.disposeAssetBtn', function() {
    let row = $(this).closest('tr');
    let itemID = row.find("span.itemID").text();
    let tagnum = row.find("span.tagnum").text();
    let brandmodel = row.find("span.brandmodel").text();

    showDisposeAssetModal(itemID, tagnum, brandmodel);
});

function tableLoop() {
    //var tbl = $('#perLocationTbl tr').DataTable({ "pageLength": 300 });
    $('#perLocationTbl > tbody > tr').each(function() {
        var row = $(this).closest('tr');
        var loc = row.find("span.location").text();
        var assetLocID = row.find("span.assetLocID").text();

        updateSumItemsPerLocation(assetLocID, loc);

        console.log('AssetLocId: ' + assetLocID + "; Loc: " + loc);
    });
}

$('#perLocTab').click(function() {

});

$('#updateData').click(function() {
    tableLoop();
    var rowCount = $('#perLocationTbl > tbody > tr').length;
    console.log(rowCount);
});