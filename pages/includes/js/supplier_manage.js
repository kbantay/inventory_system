let url = "includes/handlers/supplier_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');
    $('#loader').removeAttr('style');
    loadAllSuppliers();
});


//========================================================================================================================
function loadAllSuppliers() {
    $.ajax({
        type: "POST",
        url: url,
        data: { "getAllSuppliers": request },
        success: function(result) {
            //console.log(result);
            var html = '';
            if (result) {
                for (var i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td style='display:none'><span class='supplierId'>" + result[i].supplierId + "</span></td>" +
                        "<td><span class='supplierName'>" + result[i].supplierName + "</span></td>" +
                        "<td><span class='supAddress'>" + result[i].suppAddress + "</span></td>" +
                        "<td><span class='supContactNum'>" + result[i].suppContactNum + "</span></td>" +
                        "<td><div class='btn-group btn-group-sm'> <button type='button' class='btn btn-primary editSupplierBtn' title='Edit this supplier's info'><span class='fas fa-edit'></span></a>  <button type='button' class='btn btn-danger deleteSupplierBtn' title='Delete this supplier'><span class='fas fa-trash-alt'></span></button></td>" +
                        "</tr>";
                }
            }
            $("#supplierTbody").html(html); // table body
            $("#supplierTbl").DataTable({
                "order": [
                    [1, "asc"]
                ],
                bAutoWidth: false,
                aoColumns: [
                    { sWidth: '5%' },
                    { sWidth: '35%' },
                    { sWidth: '35%' },
                    { sWidth: '15%' },
                    { sWidth: '10%' }
                ]
            });
            $('#loader').hide();
        }
    });
}


//==================================================  SAVE NEW SUPPLIER  ========================================================
$('#saveSupplierBtn').click(function() {
    var supplierName = $('#supplierName').val();
    var supAddress = $('#supAddress').val();
    var supContactNum = $('#supContactNum').val();
    if ($('#supTypeDdown')[0].selectedIndex <= 0) {
        var supType = "";
    } else {
        var supType = $('#supTypeDdown').val();
    }

    if (supplierName == "" || supAddress == "" || supContactNum == "" || supType == "") {
        $('#alertBox').removeAttr("style");
        //------------ Auto-close the alert box! ------------
        window.setTimeout(function() {
            document.getElementById("alertBox").style.display = 'none';
        }, 3000);

        if (supplierName == "") {
            $('#supplierNameValidate').addClass("has-error");
            $(window).scrollTop(0);
        }

        if (supAddress == "") {
            $('#supAddressValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
        if (supContactNum == "") {
            $('#supContactNumValidate').addClass("has-error");
            $(window).scrollTop(0);
        }

        if (supType == "") {
            $('#supTypeValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
    } else {
        //if (confirm("Is everything correct?")) {
        $.ajax({
            type: "POST",
            url: url,
            data: { "saveNewSupplier": request, "supplierName": supplierName, "supAddress": supAddress, "supContactNum": supContactNum, "supType": supType },
            success: function(result) {
                if (result == "1") {
                    $('#supplierTbl').DataTable().clear();
                    $('#supplierTbl').DataTable().destroy();
                    loadAllSuppliers();

                    $('#alertBoxSuccess').removeAttr("style");
                    $(window).scrollTop(0);
                    //$('#resetBtn').click();

                    window.setTimeout(function() {
                        document.getElementById("alertBoxSuccess").style.display = 'none';
                    }, 3000);
                } else { // error on saving to db
                    console.error(result);
                }
            }
        });
        //}
    }
});

$('#supTypeDdown').click(function() {
    $('#supTypeValidate').removeClass("has-error");
});

$('#supplierName').keypress(function() {
    $('#supplierNameValidate').removeClass("has-error");
});

$('#supAddress').keypress(function() {
    $('#supAddressValidate').removeClass("has-error");
});

$('#supContactNum').keypress(function() {
    $('#supContactNumValidate').removeClass("has-error");
});

$('#resetBtn').click(function() {
    $('#supTypeValidate').removeClass("has-error");
    $('#supplierNameValidate').removeClass("has-error");
    $('#supAddressValidate').removeClass("has-error");
    $('#supContactNumValidate').removeClass("has-error");
});




//===============================================  DELETE SUPPLIER =========================================================
$('#supplierTbl').on('click', '.deleteSupplierBtn', function() {
    if (confirm("Are you sure? Deleting this building is permanent, it cannot be undone!")) {
        var row = $(this).closest('tr');
        var supplierId = row.find("span.supplierId").text();
        var supplierName = row.find("span.supplierName").text();

        $.ajax({
            type: 'POST',
            url: url,
            data: { "deleteSupplier": request, "supplierId": supplierId, "supplierName": supplierName },
            success: function(result) {
                if (result == "1") {
                    $('#supplierTbl').DataTable().clear();
                    $('#supplierTbl').DataTable().destroy();
                    loadAllSuppliers();

                    $('#alertBoxSuccessDelRoom').removeAttr("style");
                    $(window).scrollTop(0);

                    window.setTimeout(function() {
                        document.getElementById("alertBoxSuccessDelRoom").style.display = 'none';
                    }, 3000);
                } else {
                    console.error(result);
                }
            }
        });
    }
});



//===============================================  EDIT SUPPLIER INFO =========================================================
$('#supplierTbl').on('click', '.editSupplierBtn', function() {
    var row = $(this).closest('tr');
    var supplierId = row.find('span.supplierId').text();

    $.ajax({
        type: "POST",
        url: url,
        data: { "getSpecificSupplier": request, "supplierId": supplierId },
        success: function(result) {
            var supplierId = result[0].supplierId;
            var supplierName = result[0].supplierName;
            var suppAddress = result[0].suppAddress;
            var suppContactNum = result[0].suppContactNum;
            var suppType = result[0].suppType;

            $('#supplierIdMdl').val(supplierId);
            $('#supplierNameMdl').val(supplierName);
            $('#supAddressMdl').val(suppAddress);
            $('#supContactNumMdl').val(suppContactNum);
            if (suppType == "Asset") {
                $('#supTypeMdlDdown')[0].selectedIndex = 1
            } else if (suppType == "Supplies") {
                $('#supTypeMdlDdown')[0].selectedIndex = 2
            } else {
                $('#supTypeMdlDdown')[0].selectedIndex = 0
            }

            document.getElementById('editSupplierModalLbl').innerHTML = "Edit Supplier Info: " + supplierName;
            $('#editSupplierDetailsMdl').modal('show');

        }
    });

});



//===============================================  UPDATE SUPPLIER INFO =========================================================
$('#updateSupplierBtn').click(function() {
    var supplierId = $('#supplierIdMdl').val();
    var supplierName = $('#supplierNameMdl').val();
    var suppAddress = $('#supAddressMdl').val();
    var suppContactNum = $('#supContactNumMdl').val();
    var suppType = $('#supTypeMdlDdown').val();

    $.ajax({
        type: "POST",
        url: url,
        data: { "updateSupplierInfo": request, "supplierId": supplierId, "supplierName": supplierName, "suppAddress": suppAddress, "suppContactNum": suppContactNum, "suppType": suppType },
        success: function(result) {
            $('#editSupplierDetailsMdl').modal('hide');

            if (result == "1") {
                $('#alertBoxUpdateSuccess').removeAttr("style");
                $(window).scrollTop(0);
                window.setTimeout(function() {
                    document.getElementById("alertBoxUpdateSuccess").style.display = 'none';
                }, 3000);

                $('#supplierTbl').DataTable().clear();
                $('#supplierTbl').DataTable().destroy();
                loadAllSuppliers();
            } else {
                $('#alertBoxUpdateError').removeAttr("style");
                $(window).scrollTop(0);
                window.setTimeout(function() {
                    document.getElementById("alertBoxUpdateError").style.display = 'none';
                }, 3000);
                console.error(result);
            }
        }
    });
});