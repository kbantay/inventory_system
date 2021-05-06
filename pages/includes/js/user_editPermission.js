let url = "includes/handlers/user_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');

    $('#loader').removeAttr('style');
    //-------- Fetch the $_GET value ----------
    var getValue = [];
    location.search.replace('?', '').split('&').forEach(function(val) {
        split = val.split("=", 2);
        getValue[split[0]] = split[1];
    });

    var userID = getValue['id'];
    $('#userID').val(userID); // of the user being edited
    //console.log(userID);
    //---------- fetching username of the selected user to edit ------------
    $.ajax({
        type: "POST",
        url: url,
        data: { "loadUserWithRolePermission": request, "userID": userID },
        success: function(result) {
            console.log(result);
            if (result) {
                //------- user information -------
                var userName = result[0].username;
                var roleID = result[0].role;
                $('#roleID').val(roleID);
                //------- role information -------
                var roleName = result[0].roleName;
                var roleDesc = result[0].roleDescription;
                $('#roleName').val(roleName);
                $('#roleDesc').val(roleDesc);
                //------- role information -------
                var user_add = result[0].user_add;
                var user_view = result[0].user_view;
                var user_manage = result[0].user_manage;
                var user_logs = result[0].user_logs;
                var user_role = result[0].user_role;
                var user_updateInfo = result[0].user_updateInfo;

                var outlet_suplist = result[0].outlet_suplist;
                var outlet_reqsup = result[0].outlet_reqsup;
                var outlet_resitem = result[0].outlet_resitem;
                var outlet_pendingrestock = result[0].outlet_pendingrestock;

                var warehouse_regitem = result[0].warehouse_regitem;
                var warehouse_setupitem = result[0].warehouse_setupitem;
                var warehouse_suplist = result[0].warehouse_suplist;
                var warehouse_encreqsup = result[0].warehouse_encreqsup;
                var warehouse_encdel = result[0].warehouse_encdel;
                var warehouse_mngdel = result[0].warehouse_mngdel;
                var warehouse_resreq = result[0].warehouse_resreq;

                var asset_addnew = result[0].asset_addnew;
                var asset_mngasset = result[0].asset_mngasset;
                var asset_disposed = result[0].asset_disposed;

                var report_assets = result[0].report_assets;
                var report_cons = result[0].report_cons;
                var report_delsupplies = result[0].report_delsupplies;
                var report_delhistory = result[0].report_delhistory;
                var report_userlogs = result[0].report_userlogs;

                var settings_assetsubcat = result[0].settings_assetsubcat;
                var settings_outletemail = result[0].settings_outletemail;
                var settings_whemail = result[0].settings_whemail;
                var settings_supplier = result[0].settings_supplier;
                var settings_dept = result[0].settings_dept;
                var settings_location = result[0].settings_location;


                if (user_add == "true") {
                    $('#userAddChk').prop('checked', true);
                }
                if (user_view == "true") {
                    $('#userViewChk').prop('checked', true);
                }
                if (user_manage == "true") {
                    $('#userEditChk').prop('checked', true);
                }
                if (user_logs == "true") {
                    $('#userLogs').prop('checked', true);
                }
                if (user_role == "true") {
                    $('#userRole').prop('checked', true);
                }
                if (user_updateInfo == "true") {
                    $('#userUpdateInfo').prop('checked', true);
                }
                if (outlet_suplist == "true") {
                    $('#outletSupListChk').prop('checked', true);
                }
                if (outlet_reqsup == "true") {
                    $('#outletReqSupChk').prop('checked', true);
                }
                if (outlet_resitem == "true") {
                    $('#outletResItemChk').prop('checked', true);
                }
                if (outlet_pendingrestock == "true") {
                    $('#outletPendingRestockChk').prop('checked', true);
                }
                if (warehouse_regitem == "true") {
                    $('#whRegItemChk').prop('checked', true);
                }
                if (warehouse_setupitem == "true") {
                    $('#whSetupItemChk').prop('checked', true);
                }
                if (warehouse_suplist == "true") {
                    $('#whSupListChk').prop('checked', true);
                }
                if (warehouse_encreqsup == "true") {
                    $('#whEncReqSupChk').prop('checked', true);
                }
                if (warehouse_encdel == "true") {
                    $('#whEncDelChk').prop('checked', true);
                }
                if (warehouse_mngdel == "true") {
                    $('#whMngDelChk').prop('checked', true);
                }
                if (warehouse_resreq == "true") {
                    $('#whResReqChk').prop('checked', true);
                }
                if (asset_addnew == "true") {
                    $('#astAddNewChk').prop('checked', true);
                }
                if (asset_mngasset == "true") {
                    $('#astMngAssetChk').prop('checked', true);
                }
                if (asset_disposed == "true") {
                    $('#astDispItemAssetChk').prop('checked', true);
                }
                if (report_assets == "true") {
                    $('#assetsChk').prop('checked', true);
                }
                if (report_cons == "true") {
                    $('#repConsChk').prop('checked', true);
                }
                if (report_delsupplies == "true") {
                    $('#delSuppliesChk').prop('checked', true);
                }
                if (report_delhistory == "true") {
                    $('#repDisposedChk').prop('checked', true);
                }
                if (report_userlogs == "true") {
                    $('#userlogsChk').prop('checked', true);
                }
                if (settings_assetsubcat == "true") {
                    $('#setAssetSubChk').prop('checked', true);
                }
                if (settings_outletemail == "true") {
                    $('#setOutletEmailNotChk').prop('checked', true);
                }
                if (settings_whemail == "true") {
                    $('#setWhEmailNotChk').prop('checked', true);
                }
                if (settings_supplier == "true") {
                    $('#setSupplierChk').prop('checked', true);
                }
                if (settings_dept == "true") {
                    $('#setDeptChk').prop('checked', true);
                }
                if (settings_location == "true") {
                    $('#setLocationChk').prop('checked', true);
                }

                document.getElementById('selectedUser').innerHTML = userName;
                $('#loader').hide();
            } else {
                console.error(result);
                $('#loader').hide();
            }
        }
    });



});



$('#updatePermBtn').click(function() {
    $('#loader').removeAttr('style');

    var selectedUser = $('#selectedUser').text();
    var userId = $('#userID').val(); // id of the user being edited
    var roleID = $('#roleID').val();
    // var roleName = $('#roleName').val();
    // var roleDesc = $('#roleDesc').val();

    var user_add = $('#userAddChk').prop('checked');
    var user_view = $('#userViewChk').prop('checked');
    var user_manage = $('#userEditChk').prop('checked');
    var user_role = $('#userRole').prop('checked');
    var user_logs = $('#userLogs').prop('checked');
    var user_updateInfo = $('#userUpdateInfo').prop('checked');

    var outlet_suplist = $('#outletSupListChk').prop('checked');
    var outlet_reqsup = $('#outletReqSupChk').prop('checked');
    var outlet_resitem = $('#outletResItemChk').prop('checked');
    var outlet_pendingrestock = $("#outletPendingRestockChk").prop('checked'); //

    var warehouse_regitem = $('#whRegItemChk').prop('checked');
    var warehouse_setupitem = $('#whSetupItemChk').prop('checked');
    var warehouse_suplist = $('#whSupListChk').prop('checked');
    var warehouse_encreqsup = $("#whEncReqSupChk").prop('checked'); //
    var warehouse_encdel = $('#whEncDelChk').prop('checked');
    var warehouse_mngdel = $('#whMngDelChk').prop('checked');
    var warehouse_resreq = $('#whResReqChk').prop('checked');

    var asset_addnew = $('#astAddNewChk').prop('checked');
    var asset_mngasset = $('#astMngAssetChk').prop('checked');
    var asset_disposed = $('#astDispItemAssetChk').prop('checked');

    var report_assets = $("#assetsChk").prop('checked'); //
    var report_cons = $('#repConsChk').prop('checked');
    var report_delsupplies = $('#delSuppliesChk').prop('checked'); //
    var report_delhistory = $('#repDisposedChk').prop('checked');
    var report_userlogs = $('#userlogsChk').prop('checked'); //

    var settings_assetsubcat = $('#setAssetSubChk').prop('checked');
    var settings_outletemail = $('#setOutletEmailNotChk').prop('checked');
    var settings_whemail = $('#setWhEmailNotChk').prop('checked');
    var settings_supplier = $('#setSupplierChk').prop('checked');
    var settings_dept = $('#setDeptChk').prop('checked'); //
    var settings_location = $('#setLocationChk').prop('checked'); //


    if (roleName == "" || roleDesc == "") {
        //------------ Auto-close the alert box! ------------
        window.setTimeout(function() {
            document.getElementById("alertBox").style.display = 'none';
        }, 3000);

        if (roleName == "") {
            $('#roleNameValidate').addClass("has-error");
            //$('#roleDescValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
        if (!roleDesc) {
            $('#roleDescValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
        $('#loader').hide();
    } else {
        //--------------------- Actual Save Script ------------------
        if (confirm("Is everything correct?")) {
            //-------------- Save User Permission --------------
            $.ajax({
                type: "POST",
                url: url,
                data: { "updateUserPermission": request, "selectedUser": selectedUser, "roleID": roleID, "userID": userId, "user_add": user_add, "user_view": user_view, "user_manage": user_manage, "user_role": user_role, "user_logs": user_logs, "user_updateInfo": user_updateInfo, "outlet_suplist": outlet_suplist, "outlet_reqsup": outlet_reqsup, "outlet_resitem": outlet_resitem, "outlet_pendingrestock": outlet_pendingrestock, "warehouse_regitem": warehouse_regitem, "warehouse_setupitem": warehouse_setupitem, "warehouse_suplist": warehouse_suplist, "warehouse_encreqsup": warehouse_encreqsup, "warehouse_encdel": warehouse_encdel, "warehouse_mngdel": warehouse_mngdel, "warehouse_resreq": warehouse_resreq, "asset_addnew": asset_addnew, "asset_mngasset": asset_mngasset, "asset_disposed": asset_disposed, "report_assets": report_assets, "report_cons": report_cons, "report_delsupplies": report_delsupplies, "report_delhistory": report_delhistory, "report_userlogs": report_userlogs, "settings_assetsubcat": settings_assetsubcat, "settings_outletemail": settings_outletemail, "settings_whemail": settings_whemail, "settings_supplier": settings_supplier, "settings_dept": settings_dept, "settings_location": settings_location },
                success: function(result) {
                    if (result == "1") {
                        $('#alertBoxSuccess').removeAttr("style");
                        $(window).scrollTop(0);

                        $('#loader').hide();
                        window.setTimeout(function() {
                            document.getElementById("alertBoxSuccess").style.display = 'none';
                        }, 3000);
                    } else {
                        console.error(result);
                        console.error("An error occured upon updating user's permission");
                    }
                }
            });
        }
        //------ end of confirm ---
        else {
            $('#loader').hide();
        }
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