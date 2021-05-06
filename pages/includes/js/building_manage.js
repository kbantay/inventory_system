let url = "includes/handlers/building_controller";


$(document).ready(function() {
    $('#loader').removeAttr('style');
    $('#dashboardMain').removeAttr('style');

    loadAllBldg();
});


//========================================================================================================================
function loadAllBldg() {
    let request = "loadAllBldg";

    $.ajax({
        type: "POST",
        url: url,
        data: { "loadAllBldg": request },
        success: function(result) {
            //console.log(result);
            var html = '';
            if (result) {
                for (var i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td style='display:none'><span class='bldgID'>" + result[i].bldgID + "</span></td>" +
                        "<td><span class='bldgName'>" + result[i].bldgName + "</span></td>" +
                        "<td><span class='bldgShortName'>" + result[i].bldgShortName + "</span></td>" +
                        "<td><span class='bldgNotes'>" + result[i].bldgNotes + "</span></td>" +
                        "<td><div class='btn-group btn-group-sm'> <button type='button' class='btn btn-primary editBldgBtn' title='Edit this building's info'><span class='fas fa-edit'></span></a>  <button type='button' class='btn btn-danger deleteBldgBtn' title='Delete this building'><span class='fas fa-trash-alt'></span></button></td>" +
                        "</tr>";
                }
            }
            $("#buildingTbody").html(html); // table body
            $("#buildingTbl").DataTable();
            $('#loader').hide();
        }
    });
}


//==================================================  SAVE NEW BUILDING  ========================================================
$('#saveBldgBtn').click(function() {
    let request = "addNewBldg";
    var bldgName = $('#bldgName').val();
    var bldgShortName = $('#bldgShortName').val();
    var bldgNotes = $('#bldgNotes').val();

    if (bldgName == "" || bldgShortName == "") {
        $('#alertBox').removeAttr("style");
        //------------ Auto-close the alert box! ------------
        window.setTimeout(function() {
            document.getElementById("alertBox").style.display = 'none';
        }, 3000);

        if (bldgName == "") {
            $('#bldgNameValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
        if (bldgShortName == "") {
            $('#bldgShortNameValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
    } else {
        if (confirm("Is everything correct?")) {
            $.ajax({
                type: "POST",
                url: url,
                data: { "addNewBldg": request, "bldgName": bldgName, "bldgShortName": bldgShortName, "bldgNotes": bldgNotes },
                success: function(result) {
                    //console.log(result);
                    if (!result) {
                        $('#buildingTbl').DataTable().clear();
                        $('#buildingTbl').DataTable().destroy();
                        loadAllBldg();

                        $('#alertBoxSuccess').removeAttr("style");
                        $(window).scrollTop(0);
                        $('#resetBtn').click();

                        window.setTimeout(function() {
                            document.getElementById("alertBoxSuccess").style.display = 'none';
                        }, 3000);
                    } else { // error on saving to db
                        console.error("Error!");
                    }
                }
            });
        }
    }
});

$('#bldgName').keypress(function() {
    $('#bldgNameValidate').removeClass("has-error");
});

$('#bldgShortName').keypress(function() {
    $('#bldgShortNameValidate').removeClass("has-error");
});

$('#resetBtn').click(function() {
    $('#bldgNameValidate').removeClass("has-error");
    $('#bldgShortNameValidate').removeClass("has-error");
});




//===============================================  DELETE BUILDING =========================================================
$('#buildingTbl').on('click', '.deleteBldgBtn', function() {
    if (confirm("Are you sure? Deleting this building is permanent, it cannot be undone!")) {
        let request = "deleteBldg";
        var row = $(this).closest('tr');
        var bldgID = row.find("span.bldgID").text();
        var bldgName = row.find("span.bldgName").text();

        $.ajax({
            type: 'POST',
            url: url,
            data: { "deleteBldg": request, "bldgID": bldgID, "bldgName": bldgName },
            success: function(result) {
                //console.log(result);
                $('#buildingTbl').DataTable().clear();
                $('#buildingTbl').DataTable().destroy();
                loadAllBldg();
            }
        });
    }
});



//===============================================  EDIT BUILDING INFO =========================================================
$('#buildingTbl').on('click', '.editBldgBtn', function() {
    let request = "editBldgInfo";
    var row = $(this).closest('tr');
    var bldgID = row.find('span.bldgID').text();

    $.ajax({
        type: "POST",
        url: url,
        data: { "editBldgInfo": request, "bldgID": bldgID },
        success: function(result) {
            //console.log(result);
            var bldgID = result[0].bldgID;
            var bldgName = result[0].bldgName;
            var bldgShortName = result[0].bldgShortName;
            var bldgNotes = result[0].bldgNotes;

            $('#bldgID').val(bldgID);
            $('#bldgNameMdl').val(bldgName);
            $('#bldgShortNameMdl').val(bldgShortName);
            $('#bldgNotesMdl').val(bldgNotes);

            document.getElementById('editBldgModalLbl').innerHTML = "Edit Building Info: " + bldgName;
            $('#editBldgDetailsMdl').modal('show');
        }
    });

});



//===============================================  UPDATE BUILDING INFO =========================================================
$('#updateBldgBtn').click(function() {
    let request = "updateBldgInfo";
    var bldgID = $('#bldgID').val();
    var bldgName = $('#bldgNameMdl').val();
    var bldgShortName = $('#bldgShortNameMdl').val();
    var bldgNotes = $('#bldgNotesMdl').val();

    $.ajax({
        type: "POST",
        url: url,
        data: { "updateBldgInfo": request, "bldgID": bldgID, "bldgName": bldgName, "bldgShortName": bldgShortName, "bldgNotes": bldgNotes },
        success: function(result) {
            $('#editBldgDetailsMdl').modal('hide');

            if (!result) {
                $('#alertBoxUpdateSuccess').removeAttr("style");
                $(window).scrollTop(0);
                window.setTimeout(function() {
                    document.getElementById("alertBoxUpdateSuccess").style.display = 'none';
                }, 3000);

                $('#buildingTbl').DataTable().clear();
                $('#buildingTbl').DataTable().destroy();
                loadAllBldg();
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