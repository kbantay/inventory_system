let url = "includes/handlers/role_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');

    // $('#loader').removeAttr('style');

    // //-------- Fetch the $_GET value ----------
    // var getValue = [];
    // location.search.replace('?', '').split('&').forEach(function(val) {
    //     split = val.split("=", 2);
    //     getValue[split[0]] = split[1];
    // });

    // var roleID = getValue['id'];
    // $.ajax({
    //     type: "POST",
    //     url: url,
    //     data: { "loadSpecificRole": request, "roleID": roleID },
    //     success: function(data) {
    //         var roleName = data[0].roleName;
    //         var roleDesc = data[0].roleDescription;
    //         // console.log(roleName+" "+roleDesc);

    //         var userID = "";
    //         $.ajax({
    //             type: "POST",
    //             url: url,
    //             data: { "loadPermissions": request, "roleID": roleID, "userID": userID },
    //             success: function(data) {
    //                 var user_add = data[0].user_add;
    //                 var user_view = data[0].user_view;
    //                 var user_manage = data[0].user_manage;
    //                 var user_logs = data[0].user_logs;
    //                 var user_addRole = data[0].user_role;
    //                 var user_updateInfo = data[0].user_updateInfo;
    //                 var employee_add = data[0].employee_add;
    //                 var employee_view = data[0].employee_view;
    //                 var employee_manage = data[0].employee_manage;
    //                 var room_add = data[0].room_add;
    //                 var room_manage = data[0].room_manage;
    //                 var roomtype_manage = data[0].roomtype_manage;
    //                 var guest_manage = data[0].guest_manage;
    //                 var reservation_add = data[0].reservation_add;
    //                 var reservation_manage = data[0].reservation_manage;
    //                 var saleitems_manage = data[0].saleitems_manage;
    //                 var order_add = data[0].order_add;
    //                 var billing_manage = data[0].billing_manage;
    //                 var occupancy_list = data[0].occupancy_list;
    //                 var inventory_add = data[0].inventory_add;
    //                 var inventory_manage = data[0].inventory_manage;

    //                 // console.log("user_add: "+user_add+", user_view: "+user_view+", user_manage: "+user_manage+", user_logs: "+user_logs+", user_addRole: "+user_addRole+", employee_add: "+employee_add+", employee_view: "+employee_view+", employee_manage: "+employee_manage);

    //                 //-------------- Load data to UI --------------
    //                 $('#roleName').val(roleName);
    //                 $('#roleDesc').val(roleDesc);
    //                 if (user_add == "true") {
    //                     $('#userAddChk').prop('checked', true);
    //                 }
    //                 if (user_view == "true") {
    //                     $('#userViewChk').prop('checked', true);
    //                 }
    //                 if (user_manage == "true") {
    //                     $('#userEditChk').prop('checked', true);
    //                 }
    //                 if (user_logs == "true") {
    //                     $('#userLogs').prop('checked', true);
    //                 }
    //                 if (userRole == "true") {
    //                     $('#userRole').prop('checked', true);
    //                 }
    //                 if (user_updateInfo == "true") {
    //                     $('#userUpdateInfo').prop('checked', true);
    //                 }
    //                 if (employee_add == "true") {
    //                     $('#employeeAddChk').prop('checked', true);
    //                 }
    //                 if (employee_view == "true") {
    //                     $('#employeeViewChk').prop('checked', true);
    //                 }
    //                 if (employee_manage == "true") {
    //                     $('#employeeEditChk').prop('checked', true);
    //                 }
    //                 if (room_add == "true") {
    //                     $('#roomAddChk').prop('checked', true);
    //                 }
    //                 if (room_manage == "true") {
    //                     $('#manageRoomChk').prop('checked', true);
    //                 }
    //                 if (roomtype_manage == "true") {
    //                     $('#roomTypeChk').prop('checked', true);
    //                 }
    //                 if (guest_manage == "true") {
    //                     $('#mngGuestChk').prop('checked', true);
    //                 }
    //                 if (reservation_add == "true") {
    //                     $('#addReserveChk').prop('checked', true);
    //                 }
    //                 if (reservation_manage == "true") {
    //                     $('#mngReserveChk').prop('checked', true);
    //                 }
    //                 if (saleitems_manage == "true") {
    //                     $('#mngSaleitemsChk').prop('checked', true);
    //                 }
    //                 if (order_add == "true") {
    //                     $('#addOrderChk').prop('checked', true);
    //                 }
    //                 if (billing_manage == "true") {
    //                     $('#billingChk').prop('checked', true);
    //                 }
    //                 if (occupancy_list == "true") {
    //                     $('#occupancyRptChk').prop('checked', true);
    //                 }
    //                 if (inventory_add == "true") {
    //                     $('#addStockChk').prop('checked', true);
    //                 }
    //                 if (inventory_manage == "true") {
    //                     $('#mngStockChk').prop('checked', true);
    //                 }

    //                 $('#loader').hide();
    //             }
    //         });
    //         //----------------
    //     }
    // });
});



$('#saveRoleBtn').click(function() {

    //var userId = $('#userID').val();
    var roleName = $('#roleName').val();
    var roleDesc = $('#roleDesc').val();

    var user_add = $('#userAddChk').prop('checked');
    var user_view = $('#userViewChk').prop('checked');
    var user_manage = $('#userEditChk').prop('checked');
    var user_role = $('#userRole').prop('checked');
    var user_logs = $('#userLogs').prop('checked');
    var user_updateInfo = $('#userUpdateInfo').prop('checked');

    var outlet_suplist = $('#outletSupListChk').prop('checked');
    var outlet_reqsup = $('#outletReqSupChk').prop('checked');
    var outlet_resitem = $('#outletResItemChk').prop('checked');
    var outlet_pendingrestock = $("#outletPendingRestockChk").prop('checked');

    var warehouse_regitem = $('#whRegItemChk').prop('checked');
    var warehouse_setupitem = $('#whSetupItemChk').prop('checked');
    var warehouse_suplist = $('#whSupListChk').prop('checked');
    var warehouse_encreqsup = $("#whEncReqSupChk").prop('checked');
    var warehouse_encdel = $('#whEncDelChk').prop('checked');
    var warehouse_mngdel = $('#whMngDelChk').prop('checked');
    var warehouse_resreq = $('#whResReqChk').prop('checked');

    var asset_addnew = $('#astAddNewChk').prop('checked');
    var asset_mngasset = $('#astMngAssetChk').prop('checked');
    var asset_disposed = $('#astDispItemAssetChk').prop('checked');

    var report_assets = $("#assetsChk").prop('checked');
    var report_cons = $('#repConsChk').prop('checked');
    var report_delsupplies = $('#delSuppliesChk').prop('checked');
    var report_delhistory = $('#repDisposedChk').prop('checked');
    var report_userlogs = $('#userlogsChk').prop('checked');

    var settings_assetsubcat = $('#setAssetSubChk').prop('checked');
    var settings_outletemail = $('#setOutletEmailNotChk').prop('checked');
    var settings_whemail = $('#setWhEmailNotChk').prop('checked');
    var settings_supplier = $('#setSupplierChk').prop('checked');
    var settings_dept = $('#setDeptChk').prop('checked');
    var settings_location = $('#setLocationChk').prop('checked');


    if (roleName == "" || roleDesc == "") {
        $('#alertBox').removeAttr("style");
        //------------ Auto-close the alert box! ------------
        window.setTimeout(function() {
            document.getElementById("alertBox").style.display = 'none';
        }, 3000);

        if (roleName == "") {
            $('#roleNameValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
        if (!roleDesc) {
            $('#roleDescValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
        $('#loader').hide();
    } else {
        //console.log(roleName+" "+roleDesc+" "+user_add+" "+user_view+" "+user_manage+" "+user_role+" "+user_logs+" "+user_manage+" "+user_role+" "+user_logs);
        //--------------------- Actual Save Script ------------------ +" "++" "++" "++" "++" "++" "++" "++" "++" "+
        if (confirm("Is everything correct?")) {
            //-------------- Save Role --------------
            $.ajax({
                type: "POST",
                url: url,
                data: { "saveNewRole": request, "roleName": roleName, "roleDesc": roleDesc },
                success: function(data) {
                    //console.log(data);
                    var roleID = data;
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: { "savePermission": request, "roleId": roleID, "user_add": user_add, "user_view": user_view, "user_manage": user_manage, "user_role": user_role, "user_logs": user_logs, "user_updateInfo": user_updateInfo, "outlet_suplist": outlet_suplist, "outlet_reqsup": outlet_reqsup, "outlet_resitem": outlet_resitem, "outlet_pendingrestock": outlet_pendingrestock, "warehouse_regitem": warehouse_regitem, "warehouse_setupitem": warehouse_setupitem, "warehouse_suplist": warehouse_suplist, "warehouse_encreqsup": warehouse_encreqsup, "warehouse_encdel": warehouse_encdel, "warehouse_mngdel": warehouse_mngdel, "warehouse_resreq": warehouse_resreq, "asset_addnew": asset_addnew, "asset_mngasset": asset_mngasset, "asset_disposed": asset_disposed, "report_assets": report_assets, "report_cons": report_cons, "report_delsupplies": report_delsupplies, "report_delhistory": report_delhistory, "report_userlogs": report_userlogs, "settings_assetsubcat": settings_assetsubcat, "settings_outletemail": settings_outletemail, "settings_whemail": settings_whemail, "settings_supplier": settings_supplier, "settings_dept": settings_dept, "settings_location": settings_location },
                        success: function(result) {
                            //console.log(result);
                            if (result == 1) {
                                $('#alertBoxSuccess').removeAttr("style");
                                $(window).scrollTop(0);
                                $('#resetBtn').trigger("click");

                                window.setTimeout(function() {
                                    document.getElementById("alertBoxSuccess").style.display = 'none';
                                }, 3000);
                                $('#loader').hide();
                            } else { //--- error saving ----
                                $('#alertError').removeAttr("style");
                                $(window).scrollTop(0);

                                window.setTimeout(function() {
                                    document.getElementById("alertError").style.display = 'none';
                                }, 3000);
                                $('#loader').hide();
                                console.error(result);
                            }

                        }
                    });
                }
            });
        } else {
            $('#loader').hide();
        }
        //------ end of confirm ---
    }
});

$('#roleName').keypress(function() {
    $('#roleNameValidate').removeClass("has-error");
});

$('#roleDesc').keypress(function() {
    $('#roleDescValidate').removeClass("has-error");
});

$('#resetBtn').click(function() {
    $('#roleNameValidate').removeClass("has-error");
    $('#roleDescValidate').removeClass("has-error");
});