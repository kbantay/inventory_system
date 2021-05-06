let assetUrl = "includes/handlers/asset_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');
    $('#loader').removeAttr('style');

    //Date picker
    $('#dateAcquired').datepicker({
        autoclose: true
    });

    loadCategory();
    loadSupplier();
    loadBuilding();
    loadDepartment();
    loadRtnData();

});


//-------------------------------------------------------------- 
function loadCategory() {
    $.ajax({
        type: 'POST',
        url: 'includes/handlers/category_controller',
        data: { "loadAllCategories": request },
        success: function(result) {
            var html = '';
            if (result) {
                html += '<option value="" selected disabled> Select Category </option>';
                for (var i = 0; i < result.length; i++) {
                    html += '<option value="' + result[i].categoryID + '">' + result[i].categoryName + '</option>';
                }
            }
            $('#categoryDdown').html(html);

            var assetAccess = $("#assetAccess").val();
            //console.log(assetAccess);
            if (assetAccess != "All") {
                if (assetAccess == "Housing") {
                    $('#categoryDdown')[0].selectedIndex = 1;
                    var category = 1;
                } else if (assetAccess == "Maintenance") {
                    $('#categoryDdown')[0].selectedIndex = 2;
                    var category = 2;
                } else if (assetAccess == "Office") {
                    $('#categoryDdown')[0].selectedIndex = 3;
                    var category = 3;
                } else if (assetAccess == "Tech") {
                    $('#categoryDdown')[0].selectedIndex = 4;
                    var category = 4;
                }
                loadSubcategoryPerCatId(category);
            }

        }
    });
}

$('#categoryDdown').change(function() {
    var category = $('#categoryDdown')[0].selectedIndex;
    loadSubcategoryPerCatId(category);
});

let loadSubcategoryPerCatId = (category) => {
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
            $('#subcategoryDdown').html(html);
        }
    });
}



//-------------------------------------------------------------- 
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



//-------------------------------------------------------------- 
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
                $('#roomDdown')[0].selectedIndex = 0
            }

        }
    });
});



//-------------------------------------------------------------- 
function loadDepartment() {
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
            $('#loader').hide();
        }
    });
}

//--------------------------------------------------------------
function loadRtnData() {
    //---------- load user retain data ------------ load_userRetainData_handler
    var userID = $('#curUserID').val();
    $.ajax({
        type: "POST",
        url: "includes/handlers/user_loadRetainData_handler",
        data: { "userID": userID },
        success: function(data) {
            if (data == "true") {
                $('#retainDataChk').prop('checked', true);
            }
        }
    });
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
    $('#departmentDdown')[0].selectedIndex = dept;
    $('#departmentValidate').removeClass("has-error");
});
//===================================================================================




//============================= SAVING THE ASSET ============================
function getCurrentSumItemsOfLocation(location) {
    //---- get number of items in a location ----
    var totalAssets = "";
    $.ajax({
        type: "POST",
        url: assetUrl,
        dataType: "html",
        async: false,
        data: { "checkAssetLocationExistence": request, "location": location },
        success: function(response) {
            if (response) {
                totalAssets = response;
            } else {
                totalAssets = 0;
            }
        }
    })
    return totalAssets;
}

// $('#try').click(function() {
//     if ($('#buildingDdown')[0].selectedIndex <= 0) {
//         var building = "";
//     } else {
//         var building = $('#buildingDdown option:selected').text();
//     }

//     if ($('#roomDdown')[0].selectedIndex <= 0) {
//         var room = "";
//         var location = building;
//     } else {
//         var room = $('#roomDdown option:selected').text();
//         var location = building + " " + room;
//     }

//     var assetData = getCurrentSumItemsOfLocation(location);
//     var existingAsset = JSON.parse(assetData);
//     var assetLocID = existingAsset[0].assetLocID;
//     console.log(`locID: ${assetLocID}`);
// });

$('#saveAssetBtn').click(function() {
    var dateAcquired = $('#dateAcquired').val();
    if ($('#categoryDdown')[0].selectedIndex <= 0) {
        var category = "";
    } else {
        var category = $('#categoryDdown option:selected').text();
    }

    if ($('#subcategoryDdown')[0].selectedIndex <= 0) {
        var subcategory = "";
    } else {
        var subcategory = $('#subcategoryDdown option:selected').text();
    }
    var brandModel = $('#brandModel').val();
    var description = $('#description').val();
    var serialNumber = $('#serialNumber').val();
    var quantity = $('#quantity').val();
    var unitCost = $('#unitCost').val();
    if ($('#supplierDdown')[0].selectedIndex <= 0) {
        var supplier = "";
    } else {
        var supplier = $('#supplierDdown option:selected').text();
    }
    var referenceNum = $('#referenceNum').val();

    if ($('#buildingDdown')[0].selectedIndex <= 0) {
        var building = "";
    } else {
        var building = $('#buildingDdown option:selected').text();
    }

    if ($('#roomDdown')[0].selectedIndex <= 0) {
        var room = "";
        var location = building;
    } else {
        var room = $('#roomDdown option:selected').text();
        var location = building + " " + room;
    }
    // var assetData = getCurrentSumItemsOfLocation(location);
    // var existingAsset = JSON.parse(assetData);
    // if (assetData != 0) {
    //     var assetLocID = existingAsset[0].assetLocID;
    //     var curItemsCount = existingAsset[0].numOfItems;
    //     console.log(`locId: ${assetLocID} - itemsCount: ${curItemsCount}`);
    // } else {
    //     console.log(existingAsset);
    // }
    var personInCharge = $('#personInCharge').val();

    if ($('#departmentDdown')[0].selectedIndex <= 0) {
        var department = "";
    } else {
        var department = $('#departmentDdown').val();
    }
    var remarksNotes = $('#remarks').val();

    //console.log(`bldg: ${building} - room: ${room}`);

    if (dateAcquired == "" || category == "" || subcategory == "" || brandModel == "" || description == "" || quantity == "" || unitCost == "" || building == "" || personInCharge == "" || department == "") {
        $('#alertBox').removeAttr("style");
        //------------ Auto-close the alert box! ------------
        window.setTimeout(function() {
            document.getElementById("alertBox").style.display = 'none';
        }, 3000);

        if (dateAcquired == "") {
            $('#dateAcquiredValidate').addClass("has-error");
            $(window).scrollTop(0);
        }

        if (category == "") {
            $('#categoryValidate').addClass("has-error");
            $(window).scrollTop(0);
        }

        if (subcategory == "") {
            $('#subcategoryValidate').addClass("has-error");
            $(window).scrollTop(0);
        }

        if (brandModel == "") {
            $('#brandModelValidate').addClass("has-error");
            $(window).scrollTop(0);
        }

        if (description == "") {
            $('#descriptionValidate').addClass("has-error");
            $(window).scrollTop(0);
        }

        if (quantity == "") {
            $('#quantityValidate').addClass("has-error");
            $(window).scrollTop(0);
        }

        if (unitCost == "") {
            $('#unitCostValidate').addClass("has-error");
            $(window).scrollTop(0);
        }

        if (building == "") {
            $('#buildingValidate').addClass("has-error");
            $(window).scrollTop(0);
        }

        if (personInCharge == "") {
            $('#personInChargeValidate').addClass("has-error");
            $(window).scrollTop(0);
        }

        if (department == "") {
            $('#departmentValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
    } else if (room == "" && building == "Asian Leadership Center") {
        $('#roomValidate').addClass("has-error");
        alert("Please select a room");
    } else if (room == "" && building == "Light House") {
        $('#roomValidate').addClass("has-error");
        alert("Please select a room");
    } else if (room == "" && building == "Bright House") {
        $('#roomValidate').addClass("has-error");
        alert("Please select a room");
    } else if (room == "" && building == "Ezra House") {
        $('#roomValidate').addClass("has-error");
        alert("Please select a room");
    } else if (room == "" && building == "Mansion") {
        $('#roomValidate').addClass("has-error");
        alert("Please select a room");
    } else if (room == "" && building == "Koinonia") {
        $('#roomValidate').addClass("has-error");
        alert("Please select a room");
    } else if (room == "" && building == "Dynamic Learning Center") {
        $('#roomValidate').addClass("has-error");
        alert("Please select a room");
    } else if (quantity < 1) {
        $('#alertBoxQty').removeAttr("style");
        window.setTimeout(function() {
            document.getElementById("alertBoxQty").style.display = 'none';
        }, 3000);

        $('#quantityValidate').addClass("has-error");
        $(window).scrollTop(0);
    } else if (unitCost < 0) {
        $('#alertBoxCost').removeAttr("style");
        window.setTimeout(function() {
            document.getElementById("alertBoxCost").style.display = 'none';
        }, 3000);

        $('#quantityValidate').addClass("has-error");
        $(window).scrollTop(0);
    } else {

        if (confirm("Is everything correct?")) {
            $('#loader').removeAttr('style');
            $.ajax({
                type: 'POST',
                url: assetUrl,
                data: { "assetIDidentifier": request },
                success: function(data) {
                    console.log("new itemID: " + data);
                    var d = new Date($.now());
                    var year = d.getFullYear().toString().substr(2, 2);
                    var newId = data;
                    var tagNum = year + "-" + newId;
                    var status = "active";

                    var day = d.getDate().toString().padStart(2, '0');
                    var month = new Array();
                    month[0] = "Jan";
                    month[1] = "Feb";
                    month[2] = "Mar";
                    month[3] = "Apr";
                    month[4] = "May";
                    month[5] = "Jun";
                    month[6] = "Jul";
                    month[7] = "Aug";
                    month[8] = "Sep";
                    month[9] = "Oct";
                    month[10] = "Nov";
                    month[11] = "Dec";
                    var monthName = month[d.getMonth()];
                    var dateToday = monthName + "-" + day + "-" + d.getFullYear();
                    if (remarksNotes != "") {
                        var remarks = dateToday + ": " + remarksNotes;
                    } else {
                        var remarks = "";
                    }

                    // console.log(dateAcquired+" "+category+" "+subcategory+" "+brandModel+" "+description+" "+quantity+" "+location+" "+personInCharge+" "+department+" "+serialNumber+" "+referenceNum+" "+unitCost+" "+supplier+" "+tagNum+" "+remarks+" "+dateToday+" "+status);
                    $.ajax({
                        type: 'POST',
                        url: assetUrl,
                        data: { "saveNewAsset": request, "dateAcquired": dateAcquired, "classification": category, "category": subcategory, "brandModel": brandModel, "description": description, "quantity": quantity, "location": location, "personInCharge": personInCharge, "department": department, "serialNumber": serialNumber, "referenceNum": referenceNum, "unitCost": unitCost, "supplier": supplier, "tagNum": tagNum, "remarks": remarks, "dateUpdated": dateToday, "status": status },
                        success: function(result) {
                            if (result == "1") {
                                //------- update asset in assetLocation -------
                                var assetData = getCurrentSumItemsOfLocation(location);
                                var existingAsset = JSON.parse(assetData);
                                if (assetData != 0) {
                                    var assetLocID = existingAsset[0].assetLocID;
                                    var curItemsCount = existingAsset[0].numOfItems;
                                    var newItemsCount = parseInt(curItemsCount) + parseInt(quantity);
                                    //console.log(`locId: ${assetLocID} - itemsCount: ${curItemsCount} - newCount: ${newItemsCount}`);
                                    // update items count in asset location
                                    $.ajax({
                                        type: "POST",
                                        url: assetUrl,
                                        data: { "updateTotalNumAssetLoc": request, "totalAssets": newItemsCount, "assetLocID": assetLocID },
                                        success: function(response) {
                                            //console.log(`Updated items count: ${newItemsCount} - locID: ${assetLocID} - response: ${response}`);
                                            if (response != "1") {
                                                console.error(response);
                                            }
                                        }
                                    });
                                } else {
                                    // location not yet exist in asset location thus save new location and itemCOunt
                                    $.ajax({
                                        type: "POST",
                                        url: assetUrl,
                                        data: { "saveNewLocationItemsCount": request, "location": location, "numOfItems": quantity, "lastUpdated": dateToday },
                                        success: function(response) {
                                            // console.log(`Added a new location: ${location} - with items count: ${quantity} - response: ${response}`);
                                            if (response != "1") {
                                                console.error(response);
                                            }
                                        }
                                    });
                                }

                                //--------- update retain data status ------------
                                var rtnData = $('#retainDataChk').prop('checked');
                                var userID = $('#curUserID').val();
                                $.ajax({
                                    type: 'POST',
                                    url: 'includes/handlers/user_updateRtnDataStatus_handler',
                                    data: { "userID": userID, "rtnData": rtnData },
                                    success: function(result) {
                                        $('#brandModelMdl').val(brandModel);
                                        $('#descriptionMdl').val(description);
                                        document.getElementById('tagnumLblMdl').innerHTML = tagNum;
                                        $('#newAssetDetailsMdl').modal('show');

                                        if (rtnData == false) {
                                            $('#resetBtn').click();
                                        }

                                        if (result == "success") {
                                            //console.log("success on updating retain data status!");
                                        } else {
                                            console.error(result);
                                        }
                                        $('#loader').hide();
                                    }
                                });
                            } else {
                                $('#alertBoxSaveError').removeAttr("style");
                                $(window).scrollTop(0);
                                window.setTimeout(function() {
                                    document.getElementById("alertBoxSaveError").style.display = 'none';
                                }, 3000);
                                console.error(result);
                            }
                        }
                    });

                }
            });


        }
    }
});

$('#okMdlBtn').click(function() {
    $('#newAssetDetailsMdl').modal('hide');
})



//========================== REMOVING THE RED HIGHLIGHT AFTER VALIDATION ======================
$('#dateAcquired').change(function() {
    $('#dateAcquiredValidate').removeClass("has-error");
});

$('#categoryDdown').change(function() {
    $('#categoryValidate').removeClass("has-error");
});

$('#subcategoryDdown').change(function() {
    $('#subcategoryValidate').removeClass("has-error");
});

$('#brandModel').keypress(function() {
    $('#brandModelValidate').removeClass("has-error");
});

$('#description').keypress(function() {
    $('#descriptionValidate').removeClass("has-error");
});

$('#quantity').keypress(function() {
    $('#quantityValidate').removeClass("has-error");
});

$('#unitCost').keypress(function() {
    $('#unitCostValidate').removeClass("has-error");
});

$('#buildingDdown').change(function() {
    $('#buildingValidate').removeClass("has-error");
});

$('#roomDdown').change(function() {
    $('#roomValidate').removeClass("has-error");
});


$('#personInCharge').keypress(function() {
    $('#personInChargeValidate').removeClass("has-error");
});

$('#departmentDdown').change(function() {
    $('#departmentValidate').removeClass("has-error");
});