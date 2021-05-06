let url = "includes/handlers/asset_controller";
let delUrl = "includes/handlers/delivery_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');
    $('#loader').removeAttr('style');

    loadBuilding();
    appendActionButtons();
    loadDepartment();
});


function appendActionButtons() {
    $('#reportingTbl > tbody > tr').each(function() {
        let row = $(this).closest('tr');
        row.append('<td>' + '<button type="button" class="btn btn-success genReportBtn" title="Generate this report"><span class="fas fa-file-import"></span> &nbsp; Generate </button>' + '</td>');
    });
    $('#loader').hide();
}

$('#reportingTbl').on('click', '.genReportBtn', function() {
    let rowID = $(this).closest('tr').attr('id');
    $('#loader').show();

    if (rowID == "allAssets") {
        $('#allAssetTbl').removeAttr('style');
        $('#filterClassDiv').removeAttr('style');
        document.title = "IGSL Asset Inventory Report - All assets";
        document.getElementById('reportModalLbl').innerHTML = "IGSL Asset Inventory Report: All assets";
        $('#filterClassDiv').attr('style', 'padding-left:25%;');
        loadCategory();
        $('#reportModalMain').modal("show");
    } else if (rowID == "assetsPerLoc") {
        $('#locationDiv').removeAttr('style');
        document.title = "IGSL Asset Inventory Report - Assets in a location";
        document.getElementById('reportModalLbl').innerHTML = "IGSL Asset Inventory Report: Assets in a location";
        $('#locationDiv').attr('style', 'padding-left:15%;');
        $('#reportModalMain').modal("show");
        $('#loader').hide();
    } else if (rowID == "assetsNumPerLoc") {
        $('#assetOnLocationTbl').removeAttr('style');
        document.title = "IGSL Asset Inventory Report - Number of Assets per Location";
        document.getElementById('reportModalLbl').innerHTML = "IGSL Asset Inventory Report: Number of Assets per Location";
        loadNumAssetsPerLocation();
        $('#reportModalMain').modal("show");
    } else if (rowID == "assetHistory") {
        $('#searchItemDiv').removeAttr('style');
        document.title = "IGSL Asset Inventory Report - Asset Activity-History";
        document.getElementById('reportModalLbl').innerHTML = "IGSL Asset Inventory Report: Asset Activity History";
        $('#searchItemDiv').attr('style', 'padding-left:25%;');
        $('#reportModalMain').modal("show");
        $('#loader').hide();
    } else if (rowID == "consumedSupplies") {
        $("#deptMonthDiv").removeAttr("style");
        $("#consumedSuppliesTbl").removeAttr("style");
        document.title = "IGSL Inventory Report - Monthly Consumed Supplies";
        document.getElementById('reportModalLbl').innerHTML = "IGSL Inventory Report: Monthly Consumed Supplies";
        loadMonthlyConsumedSupplies();
        $('#reportModalMain').modal("show");
        $('#loader').hide();
    } else if (rowID == "deliveredItems") {
        $('#deliveriesTbl').removeAttr('style');
        document.title = "IGSL Asset Inventory Report - Consumed Supplies Deliveries";
        document.getElementById('reportModalLbl').innerHTML = "IGSL Inventory Report: Consumed Supplies Deliveries";
        loadDeliveredItems();
        $('#reportModalMain').modal("show");
    } else if (rowID == "disposedAsset") {
        $('#disposedAssetTbl').removeAttr('style');
        document.title = "IGSL Asset Inventory Report - Disposed Asset";
        document.getElementById('reportModalLbl').innerHTML = "IGSL Asset Inventory Report: Disposed Asset";
        loadDisposedItems();
        $('#reportModalMain').modal("show");
    } else if (rowID == "userLog") {
        $('#userLogTbl').removeAttr('style');
        document.title = "IGSL Asset Inventory Report - Users Log";
        document.getElementById('reportModalLbl').innerHTML = "IGSL SAMS Report: Users Log";
        loadUserLogs();
        $('#reportModalMain').modal("show");
    }
});
//------- event upon closing the modal -------//
$('#reportModalMain').on('hidden.bs.modal', function(e) {
    clearAllAssetTbl()
    $('#allAssetTbl').attr('style', 'display:none');
    $('#filterClassDiv').attr('style', 'display:none');

    $('#buildingDdown')[0].selectedIndex = 0;
    $('#roomDdown')[0].selectedIndex = 0;
    $('#locationDiv').attr('style', 'display:none');

    $("#assetOnLocationTbl").DataTable().clear();
    $("#assetOnLocationTbl").DataTable().destroy();
    $('#assetOnLocationTbl').attr('style', 'display:none');

    $('#searchItemDiv').attr('style', 'display:none');
    $('#searchedItem').val("");
    $('#searchedItemTbl').attr('style', 'display:none');
    clearAssetHistoryTbl();

    $("#disposedAssetTbl").DataTable().clear();
    $("#disposedAssetTbl").DataTable().destroy();
    $('#disposedAssetTbl').attr('style', 'display:none');

    $("#consumedSuppliesTbl").DataTable().clear();
    $("#consumedSuppliesTbl").DataTable().destroy();
    $('#consumedSuppliesTbl').attr('style', 'display:none');
    $("#deptMonthDiv").attr('style', 'display:none');

    $("#userLogTbl").DataTable().clear();
    $("#userLogTbl").DataTable().destroy();
    $('#userLogTbl').attr('style', 'display:none');

    $("#deliveriesTbl").DataTable().clear();
    $("#deliveriesTbl").DataTable().destroy();
    $("#deliveriesTbl").hide();

    $("#deliveredItemsTbl").DataTable().clear();
    $("#deliveredItemsTbl").DataTable().destroy();
    $("#deliveredItemsTbl").hide();
});


$('#loadAssetLocBtn').click(function() {
    let bldg = $('#buildingDdown')[0].selectedIndex;
    let room = $('#roomDdown')[0].selectedIndex;

    if (bldg == 0 || room == 0) {
        alert("Please select building and/ or room first");
    } else {
        bldg = $('#buildingDdown option:selected').text();
        room = $('#roomDdown option:selected').text();
        let location = `${bldg} ${room}`;

        console.log(location);
        $('#buildingDdown')[0].selectedIndex = 0;
        $('#roomDdown')[0].selectedIndex = 0;

        //----- Loading the assets on the modal ------
        $('#loader').show();
        $('#allAssetTbl').removeAttr('style');
        document.title = `IGSL Asset Inventory Report - Assets in ${location}`;
        document.getElementById('reportModalLbl').innerHTML = `IGSL Asset Inventory Report: Assets in ${location}`;
        loadAllAssetsPerLocation(location);
        $('#reportModalMain').modal("show");
    }
});



//====================================== REPORT 1: ALL ASSETS/ CATEGORIES ===================================//
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

            //--- Pre selecting the category dropdown depending on the asset access of the user ---
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
    clearAllAssetTbl();
    if (category == "All") {
        loadAllAsset();
    } else {
        // Load assset per selected category on filter by
        $.ajax({
            type: "POST",
            url: url,
            data: { "loadAssetCategory": request, "category": category },
            success: function(result) {
                let html = '';
                if (result) {
                    for (let i = 0; i < result.length; i++) {
                        html += "<tr>" +
                            "<td>" + (i + 1) + "</td>" +
                            "<td><span class='tagnum'>" + result[i].tagnum + "</span></td>" +
                            "<td><span class='category'>" + result[i].category + "</span></td>" +
                            "<td><span class='brandmodel'>" + result[i].brandmodel + "</span></td>" +
                            "<td><span class='description'>" + result[i].description + "</span></td>" +
                            "<td id='loc" + result[i].itemID + "'><span class='location'>" + result[i].location + "</span></td>" +
                            "</tr>";
                    }
                }
                $("#allAssetTbody").html(html); // table body
                $("#allAssetTbl").DataTable({
                    "order": [
                        [0, "asc"]
                    ],
                    "lengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "pageLength": 50,
                    bAutoWidth: false,
                    searching: false,
                    aoColumns: [
                        { sWidth: '1%' },
                        { sWidth: '11%' },
                        { sWidth: '20%' },
                        { sWidth: '30%' },
                        { sWidth: '20%' },
                        { sWidth: '18%' }
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'excel', 'csv', 'pdf', 'print'
                    ]
                });
                $('#loader').hide();
            }
        });
    }
}

function clearAllAssetTbl() {
    $('#allAssetTbl').DataTable().clear();
    $('#allAssetTbl').DataTable().destroy();
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
                    html += "<tr>" +
                        "<td>" + (i + 1) + "</td>" +
                        "<td><span class='tagnum'>" + result[i].tagnum + "</span></td>" +
                        "<td><span class='category'>" + result[i].category + "</span></td>" +
                        "<td><span class='brandmodel'>" + result[i].brandmodel + "</span></td>" +
                        "<td><span class='description'>" + result[i].description + "</span></td>" +
                        "<td id='loc" + result[i].itemID + "'><span class='location'>" + result[i].location + "</span></td>" +
                        "</tr>";
                }
            }
            $("#allAssetTbody").html(html); // table body
            $("#allAssetTbl").DataTable({
                "order": [
                    [0, "asc"]
                ],
                "pageLength": 50,
                bAutoWidth: false,
                searching: false,
                aoColumns: [
                    { sWidth: '1%' },
                    { sWidth: '11%' },
                    { sWidth: '20%' },
                    { sWidth: '30%' },
                    { sWidth: '20%' },
                    { sWidth: '18%' }
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'csv', 'pdf', 'print'
                ]
            });
            $('#loader').hide();
        }
    });
}
//============================================================================================================



//====================================== REPORT 2: ALL ASSETS IN A SPECIFIED ROOM ===================================//
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
            }
            $('#roomDdown').html(html);
        }
    });
});

$('#roomDdown').change(function() {
    clearAllAssetTbl();
    bldg = $('#buildingDdown option:selected').text();
    room = $('#roomDdown option:selected').text();
    let location = `${bldg} ${room}`;

    //----- Loading the assets on the modal ------
    $('#loader').show();
    $('#allAssetTbl').removeAttr('style');
    document.title = `IGSL Asset Inventory Report - Assets in ${location}`;
    document.getElementById('reportModalLbl').innerHTML = `IGSL Asset Inventory Report: Assets in ${location}`;
    loadAllAssetsPerLocation(location);
});


//======================================= REPORT 3: ASSET PER LOCATION =======================================
function loadAllAssetsPerLocation(location) {
    $.ajax({
        type: "POST",
        url: url,
        data: { "loadAllAssetsPerLocation": request, "location": location },
        success: function(result) {
            //console.log(result);
            let html = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td>" + (i + 1) + "</td>" +
                        "<td><span class='tagnum'>" + result[i].tagnum + "</span></td>" +
                        "<td><span class='category'>" + result[i].category + "</span></td>" +
                        "<td><span class='brandmodel'>" + result[i].brandmodel + "</span></td>" +
                        "<td><span class='description'>" + result[i].description + "</span></td>" +
                        "<td id='loc" + result[i].itemID + "'><span class='location'>" + result[i].location + "</span></td>" +
                        "</tr>";
                }
            }
            $("#allAssetTbody").html(html); // table body
            $("#allAssetTbl").DataTable({
                "order": [
                    [0, "asc"]
                ],
                "pageLength": 10,
                bAutoWidth: false,
                searching: false,
                aoColumns: [
                    { sWidth: '1%' },
                    { sWidth: '11%' },
                    { sWidth: '20%' },
                    { sWidth: '30%' },
                    { sWidth: '20%' },
                    { sWidth: '18%' }
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'csv', 'pdf', 'print'
                ]
            });
            $('#loader').hide();
        }
    });
}



function loadNumAssetsPerLocation() {
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
                        "<td>" + (i + 1) + "</td>" +
                        "<td><span class='location'>" + result[i].location + "</span></td>" +
                        "<td><span class='numOfItems'>" + result[i].numOfItems + "</span></td>" +
                        "<td><span class='lastUpdated'>" + result[i].lastUpdated + "</span></td>" +
                        "</tr>";
                }
            }
            $("#assetOnLocationTbody").html(html); // table body
            $("#assetOnLocationTbl").DataTable({
                "order": [
                    [0, "asc"]
                ],
                "pageLength": 50,
                bAutoWidth: false,
                searching: false,
                aoColumns: [
                    { sWidth: '1%' },
                    { sWidth: '39%' },
                    { sWidth: '20%' },
                    { sWidth: '30%' }
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'csv', 'pdf', 'print'
                ]
            });
            $('#loader').hide();
        }
    });
}


//======================================= REPORT 4: ASSET HISTORY =======================================
$('#searchedItem').keyup(function() {
    let searchedItem = $('#searchedItem').val();
    //console.log(searchedItem);
    if (searchedItem == "") {
        $('#searchedItemTbl').hide();
    } else {
        $('#loader').show();
        loadSearchedActiveItem(searchedItem);
    }
    clearAssetHistoryTbl();
});


function loadSearchedActiveItem(searchedItem) {
    $.ajax({
        type: "POST",
        url: url,
        data: { "loadSearchActiveAsset": request, "searchedItem": searchedItem },
        success: function(result) {
            //console.log(result);
            let html = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td style='display:none'><span class='itemID'>" + result[i].itemID + "</span></td>" +
                        "<td>" + result[i].tagnum + "</td>" +
                        "<td><span class='brandmodel'>" + result[i].brandmodel + "</span></td>" +
                        "<td>" + result[i].category + "</td>" +
                        "<td>" + result[i].lcoation + "</td>" +
                        "<td><button type='button' class='btn btn-success showReportBtn' title='Generate this report'><span class='fas fa-file-import'></span></button></td>" +
                        "</tr>";
                }
            }
            $("#searchedItemTbody").html(html);
            $('#searchedItemTbl').removeAttr('style');
            $('#loader').hide();
        }
    });
}


$('#searchedItemTbl').on('click', '.showReportBtn', function() {
    $('#loader').show();
    let row = $(this).closest('tr');
    let itemId = row.find("span.itemID").text();
    let brandmodel = row.find("span.brandmodel").text();

    //console.log(itemId);
    $('#searchedItemTbl').attr('style', 'display:none');
    document.title = `IGSL Asset Inventory Report - Activity History of ${brandmodel}`;
    document.getElementById('reportModalLbl').innerHTML = `IGSL Asset Inventory Report: Activity History of ${brandmodel}`;
    $('#assetHistoryTbl').removeAttr('style');
    loadAssetHistory(itemId);
});


function loadAssetHistory(itemId) {
    $.ajax({
        type: "POST",
        url: url,
        data: { "loadAssetHistory": request, "itemID": itemId },
        success: function(result) {
            //console.log(result);
            let html = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td>" + result[i].report + "</span></td>" +
                        "<td>" + result[i].activitydate + "</td>" +
                        "<td>" + result[i].updatdby + "</td>" +
                        "<td>" + result[i].dateupdated + "</td>" +
                        "</tr>";
                }
            }
            $('#assetHistoryTbl').removeAttr('style');
            $("#assetHistoryTbody").html(html);
            $("#assetHistoryTbl").DataTable({
                "order": [
                    [0, "desc"]
                ],
                "pageLength": 10,
                bAutoWidth: false,
                searching: false,
                aoColumns: [
                    { sWidth: '40%' },
                    { sWidth: '10%' },
                    { sWidth: '20%' },
                    { sWidth: '30%' }
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'csv', 'pdf', 'print'
                ]
            });
            $('#loader').hide();
        }
    });
}

function clearAssetHistoryTbl() {
    $("#assetHistoryTbl").DataTable().clear();
    $("#assetHistoryTbl").DataTable().destroy();
    $('#assetHistoryTbl').hide();
}



//================================================ REPORT 5: MONTHLY CONSUMED SUPPLIES =============================================
let consTitle = "IGSL Inventory Report - Monthly Consumed Supplies";

function loadMonthlyConsumedSupplies() {

    $.ajax({
        type: "POST",
        url: "includes/handlers/supply_controller",
        data: { "loadAllConsumedRecords": request },
        success: function(result) {
            //console.log(result);
            let html = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td>" + result[i].department + "</td>" +
                        "<td> <span class='totalamount'>" + result[i].totalamount + "<span></td>" +
                        "<td>" + result[i].month + "</td>" +
                        "<td>" + result[i].year + "</td>" +
                        "</tr>";
                }

            }
            $("#consumedSuppliesTbody").html(html); // table body
            getTotalAmtConsumed();
            $("#consumedSuppliesTbl").DataTable({
                "order": [
                    [1, "asc"]
                ],
                "pageLength": 25,
                bAutoWidth: false,
                searching: false,
                aoColumns: [
                    { sWidth: '40%' },
                    { sWidth: '20%' },
                    { sWidth: '25%' },
                    { sWidth: '15%' }
                ],
                dom: 'Btirp',
                buttons: [{
                        extend: 'csvHtml5',
                        text: 'CSV',
                        filename: consTitle,
                        footer: true
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        filename: consTitle,
                        footer: true
                    }
                ]
            });

            $('#loader').hide();
        }
    });
}

$("#deptDdown").change(function() {
    if ($('#deptDdown')[0].selectedIndex <= 0) {
        var department = "All";
    } else {
        var department = $('#deptDdown option:selected').text();
    }

    if ($('#monthDdown')[0].selectedIndex <= 0) {
        var month = "All";
    } else {
        var month = $('#monthDdown option:selected').text();
    }

    $("#consumedSuppliesTbl").DataTable().clear();
    $("#consumedSuppliesTbl").DataTable().destroy();

    if (department == "All" && month == "All") {
        //console.log("All month all dept");
        loadMonthlyConsumedSupplies();
    } else if (department != "All" && month == "All") {
        //console.log(`${department} - all month`);
        loadConsumedSuppliesPerDepartment(department);
    } else if (department == "All" && month != "All") {
        //console.log(`${department} - all month`);
        loadConsumedRecordsPerMonth(month);
    } else if (department != "All" && month != "All") {
        //console.log(`${department} - ${month}`);
        loadSpecificConsumedRecordsDeptMonth(department, month);
    }
});

$("#monthDdown").change(function() {
    if ($('#deptDdown')[0].selectedIndex <= 0) {
        var department = "All";
    } else {
        var department = $('#deptDdown option:selected').text();
    }

    if ($('#monthDdown')[0].selectedIndex <= 0) {
        var month = "All";
    } else {
        var month = $('#monthDdown option:selected').text();
    }

    $("#consumedSuppliesTbl").DataTable().clear();
    $("#consumedSuppliesTbl").DataTable().destroy();

    if (department == "All" && month == "All") {
        //console.log("All month all dept");
        loadMonthlyConsumedSupplies();
    } else if (department == "All" && month != "All") {
        //console.log(`${department} - all month`);
        loadConsumedRecordsPerMonth(month);
    } else if (department != "All" && month == "All") {
        //console.log(`${department} - all month`);
        loadConsumedSuppliesPerDepartment(department);
    } else if (department != "All" && month != "All") {
        //console.log(`${department} - ${month}`);
        loadSpecificConsumedRecordsDeptMonth(department, month);
    }
});

//-------------- compute total subtotal amount of delivered items -------------
let getTotalAmtConsumed = () => {
    var total = 0;

    $("#consumedSuppliesTbl > tbody > tr").each(function() {
        var row = $(this).closest('tr');
        var totalamount = row.find("span.totalamount").text();

        var toInt = parseFloat(totalamount);
        total += toInt;
    });
    //console.log(`total: ${total}`);
    var tot = total.toFixed(2);
    var totalRow = "<tr style='background-color:#fffdeb'><td style='text-align:right'>Grand Total: </td><td>" + tot + "</td><td></td><td></td></tr>";

    $('#consumedSuppliesTbl > tfoot').html(totalRow);
}

function loadDepartment() {
    var request = "";
    $.ajax({
        type: 'POST',
        url: 'includes/handlers/department_controller',
        data: { "loadAllDepartments": request },
        success: function(result) {
            var html = '';
            if (result) {
                html += '<option selected> All Departments </option>';
                for (var i = 0; i < result.length; i++) {
                    html += '<option value="' + result[i].deptID + '">' + result[i].deptName + '</option>';
                }
            }
            $('#deptDdown').html(html);
        }
    });
}

function loadConsumedSuppliesPerDepartment(department) {
    $.ajax({
        type: "POST",
        url: "includes/handlers/supply_controller",
        data: { "loadConsumedRecordsPerDepartment": request, "department": department },
        success: function(result) {
            //console.log(result);
            let html = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td>" + result[i].department + "</td>" +
                        "<td> <span class='totalamount'>" + result[i].totalamount + "<span></td>" +
                        "<td>" + result[i].month + "</td>" +
                        "<td>" + result[i].year + "</td>" +
                        "</tr>";
                }
            }
            $("#consumedSuppliesTbody").html(html); // table body
            getTotalAmtConsumed();
            $("#consumedSuppliesTbl").DataTable({
                "order": [
                    [1, "asc"]
                ],
                "pageLength": 25,
                bAutoWidth: false,
                searching: false,
                aoColumns: [
                    { sWidth: '40%' },
                    { sWidth: '20%' },
                    { sWidth: '25%' },
                    { sWidth: '15%' }
                ],
                dom: 'Btirp',
                buttons: [{
                        extend: 'csvHtml5',
                        text: 'CSV',
                        filename: consTitle,
                        footer: true
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        filename: consTitle,
                        footer: true
                    }
                ]
            });
            $('#loader').hide();
        }
    });
}

function loadConsumedRecordsPerMonth(month) {
    $.ajax({
        type: "POST",
        url: "includes/handlers/supply_controller",
        data: { "loadConsumedRecordsPerMonth": request, "month": month },
        success: function(result) {
            //console.log(result);
            let html = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td>" + result[i].department + "</td>" +
                        "<td> <span class='totalamount'>" + result[i].totalamount + "<span></td>" +
                        "<td>" + result[i].month + "</td>" +
                        "<td>" + result[i].year + "</td>" +
                        "</tr>";
                }
            }
            $("#consumedSuppliesTbody").html(html); // table body
            getTotalAmtConsumed();
            $("#consumedSuppliesTbl").DataTable({
                "order": [
                    [0, "asc"]
                ],
                "pageLength": 25,
                bAutoWidth: false,
                searching: false,
                aoColumns: [
                    { sWidth: '40%' },
                    { sWidth: '20%' },
                    { sWidth: '25%' },
                    { sWidth: '15%' }
                ],
                dom: 'Btirp',
                buttons: [{
                        extend: 'csvHtml5',
                        text: 'CSV',
                        filename: consTitle,
                        footer: true
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        filename: consTitle,
                        footer: true
                    }
                ]
            });
            $('#loader').hide();
        }
    });
}

function loadSpecificConsumedRecordsDeptMonth(department, month) {
    let d = new Date();
    let year = d.getFullYear();

    $.ajax({
        type: "POST",
        url: "includes/handlers/supply_controller",
        data: { "loadConsumedRecords": request, "dept": department, "month": month, "year": year },
        success: function(result) {
            //console.log(result);
            let html = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td>" + result[i].department + "</td>" +
                        "<td> <span class='totalamount'>" + result[i].totalamount + "<span></td>" +
                        "<td>" + result[i].month + "</td>" +
                        "<td>" + result[i].year + "</td>" +
                        "</tr>";
                }
            }
            $("#consumedSuppliesTbody").html(html); // table body
            getTotalAmtConsumed();
            $("#consumedSuppliesTbl").DataTable({
                "order": [
                    [1, "asc"]
                ],
                "pageLength": 25,
                bAutoWidth: false,
                searching: false,
                aoColumns: [
                    { sWidth: '40%' },
                    { sWidth: '20%' },
                    { sWidth: '25%' },
                    { sWidth: '15%' }
                ],
                dom: 'Btirp',
                buttons: [{
                        extend: 'csvHtml5',
                        text: 'CSV',
                        filename: consTitle,
                        footer: true
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        filename: consTitle,
                        footer: true
                    }
                ]
            });
            $('#loader').hide();
        }
    });
}






//================================================ REPORT 6: DELIVERIES ==============================================
function loadDeliveredItems() {
    $.ajax({
        type: "POST",
        url: delUrl,
        data: { "loadApprovedDeliveries": request },
        success: function(result) {
            //console.log(result);
            let html = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td style='display:none'><span class='dlvrdSupID'>" + result[i].dlvrdSupID + "</span></td>" +
                        "<td><span class='datedlvrd'>" + result[i].datedlvrd + "</span></td>" +
                        "<td><span class='suppliername'>" + result[i].suppliername + "</span></td>" +
                        "<td><span class='invoicenum'>" + result[i].invoicenum + "</span></td>" +
                        "<td><span class='totalAmount'>" + result[i].totalAmount + "</span></td>" +
                        "<td><button type='button' class='btn btn-primary viewItemsBtn' title='View Items in this delivery'><span class='fas fa-eye'></span></button></td>" +
                        "</tr>";
                }
            }
            $("#deliveriesTbody").html(html); // table body
            $("#deliveriesTbl").DataTable({
                "order": [
                    [0, "desc"]
                ],
                "pageLength": 25,
                bAutoWidth: false,
                searching: true,
                aoColumns: [
                    { sWidth: '1%' },
                    { sWidth: '14%' },
                    { sWidth: '40%' },
                    { sWidth: '15%' },
                    { sWidth: '20%' },
                    { sWidth: '10%' }
                ]
            });
            $('#loader').hide();
        }
    });
}

$("#deliveriesTbl").on('click', '.viewItemsBtn', function() {
    let row = $(this).closest("tr");
    let dlvrdSupID = row.find("span.dlvrdSupID").text();
    let datedlvrd = row.find("span.datedlvrd").text();
    let suppliername = row.find("span.suppliername").text();
    let totalAmount = row.find("span.totalAmount").text();

    $("#deliveredItemsTbl").DataTable().clear();
    $("#deliveredItemsTbl").DataTable().destroy();

    $.ajax({
        type: "POST",
        url: delUrl,
        data: { "loadDeliveredItems": request, "dlvrdSupID": dlvrdSupID },
        success: function(result) {
            //console.log(result);

            $("#deliveriesTbl").fadeOut('fast',
                function() {
                    $("#deliveriesTbl").hide();
                    $("#deliveriesTbl").DataTable().clear();
                    $("#deliveriesTbl").DataTable().destroy();
                }
            );
            let tableData = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    tableData += "<tr>" +
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
            document.title = `IGSL SAMS Report - Items delivered by ${suppliername} on ${datedlvrd}`;
            document.getElementById('reportModalLbl').innerHTML = `IGSL SAMS Report: Items delivered by ${suppliername} on ${datedlvrd}`;

            $("#deliveredItemsTbl").removeAttr("style");
            $("#delTotal").text(totalAmount);
            $("#deliveredItemsTbody").html(tableData); // table body 
            $("#deliveredItemsTbl").DataTable({
                "lengthMenu": [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                "pageLength": 25,
                "bLengthChange": false,
                "searching": false,
                bAutoWidth: false,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'csv', 'pdf', 'print'
                ]
            });
        }
    });
});




//================================================== REPORT 7: DISPOSED ASSETS ================================================
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
                        "<td>" + (i + 1) + "</td>" +
                        "<td>" + result[i].tagnum + "</td>" +
                        "<td>" + result[i].brandmodel + "</td>" +
                        "<td>" + result[i].description + "</td>" +
                        "<td>" + result[i].remarks + "</td>" +
                        "<td>" + result[i].disposetype + "</td>" +
                        "<td>" + result[i].datedisposed + "</td>" +
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
                    { sWidth: '9%' },
                    { sWidth: '20%' },
                    { sWidth: '30%' },
                    { sWidth: '20%' },
                    { sWidth: '10%' },
                    { sWidth: '10%' }
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'csv', 'pdf', 'print'
                ]
            });
            $('#loader').hide();
        }
    });
}


//================================================ REPORT 8: USER LOGS =============================================
function loadUserLogs() {
    $.ajax({
        type: "POST",
        url: "includes/handlers/user_controller",
        data: { "loadUserLogs": request },
        success: function(result) {
            //console.log(result);
            let html = '';
            if (result) {
                for (let i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td>" + result[i].logID + "</td>" +
                        "<td>" + result[i].fullName + "</td>" +
                        "<td>" + result[i].username + "</td>" +
                        "<td>" + result[i].activity + "</td>" +
                        "<td>" + result[i].dateAndTime + "</td>" +
                        "</tr>";
                }
            }
            $("#userLogTbody").html(html); // table body
            $("#userLogTbl").DataTable({
                "order": [
                    [0, "desc"]
                ],
                "pageLength": 25,
                bAutoWidth: false,
                searching: false,
                aoColumns: [
                    { sWidth: '1%' },
                    { sWidth: '20%' },
                    { sWidth: '19%' },
                    { sWidth: '40%' },
                    { sWidth: '20%' }
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'csv', 'pdf', 'print'
                ]
            });
            $('#loader').hide();
        }
    });
}