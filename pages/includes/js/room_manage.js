let url = "includes/handlers/room_controller";


$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');
    $('#loader').removeAttr('style');
    loadAllRooms();

    //----------- Load the buildings drop down selection ---------
    var request = "";
    $.ajax({
        type: "POST",
        url: "includes/handlers/building_controller",
        data: { "loadAllBldg": request },
        success: function(result) {
            var html = '';
            if (result) {
                html += '<option value="" selected disabled> Select Building </option>';
                for (var i = 0; i < result.length; i++) {
                    html += '<option value="' + result[i].bldgID + '" data-bldg="' + result[i].bldgShortName + '">' + result[i].bldgName + '</option>';
                }
            }
            $('#bldgNameDdown').html(html);
            $('#bldgNameMdlDdown').html(html);
            $('#loader').hide();
        }
    });

});


//========================================================================================================================
function loadAllRooms() {
    var request = "loadAllRooms";
    $.ajax({
        type: "POST",
        url: url,
        data: { "loadAllRooms": request },
        success: function(result) {
            //console.log(result);
            var html = '';
            if (result) {
                for (var i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td style='display:none'><span class='roomID'>" + result[i].roomID + "</span></td>" +
                        "<td><span class='bldgName'>" + result[i].bldgName + "</span></td>" +
                        "<td><span class='roomName'>" + result[i].roomName + "</span></td>" +
                        "<td><span class='roomNotes'>" + result[i].roomNotes + "</span></td>" +
                        "<td><div class='btn-group btn-group-sm'> <button type='button' class='btn btn-primary editRoomBtn' title='Edit this room's info'><span class='fas fa-edit'></span></a>  <button type='button' class='btn btn-danger deleteRoomBtn' title='Delete this room'><span class='fas fa-trash-alt'></span></button></td>" +
                        "</tr>";
                }
            }
            $("#roomsTbody").html(html); // table body
            $("#roomsTbl").DataTable({ "pageLength": 100 });
            $('#loader').hide();
        }
    });
}


//==================================================  SAVE NEW ROOM  ========================================================
$('#saveRoomBtn').click(function() {
    let request = "";
    if ($('#bldgNameDdown')[0].selectedIndex <= 0) {
        var bldgID = "";
    } else {
        var bldgID = $('#bldgNameDdown').val();
    }
    var bldgName = $('#bldgNameDdown option:selected').text();
    var bldgShort = $('#bldgNameDdown option:selected').data('bldg');
    var roomName = $('#roomName').val();
    var location = bldgShort + " " + roomName;
    var roomNotes = $('#roomNotes').val();

    if (bldgName == "" || roomName == "") {
        $('#alertBox').removeAttr("style");
        //------------ Auto-close the alert box! ------------
        window.setTimeout(function() {
            document.getElementById("alertBox").style.display = 'none';
        }, 3000);

        if (bldgName == "") {
            $('#bldgNameValidate').addClass("has-error");
            $(window).scrollTop(0);
        }

        if (roomName == "") {
            $('#roomNameValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
    } else {
        //if (confirm("Is everything correct?")) {
        $.ajax({
            type: "POST",
            url: url,
            data: { "saveNewRoom": request, "bldgName": bldgName, "bldgID": bldgID, "roomName": roomName, "location": location, "roomNotes": roomNotes },
            success: function(result) {
                if (result == "1") {
                    console.log(result);
                    $('#roomsTbl').DataTable().clear();
                    $('#roomsTbl').DataTable().destroy();
                    loadAllRooms();

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

$('#bldgNameDdown').click(function() {
    $('#bldgNameValidate').removeClass("has-error");
});

$('#roomName').keypress(function() {
    $('#roomNameValidate').removeClass("has-error");
});

$('#resetBtn').click(function() {
    $('#bldgNameValidate').removeClass("has-error");
    $('#roomNameValidate').removeClass("has-error");
});




//===============================================  DELETE ROOM =========================================================
$('#roomsTbl').on('click', '.deleteRoomBtn', function() {
    if (confirm("Are you sure? Deleting this building is permanent, it cannot be undone!")) {
        let request = "";
        var row = $(this).closest('tr');
        var roomID = row.find("span.roomID").text();
        var bldgName = row.find("span.bldgName").text();
        var roomName = row.find("span.roomName").text();

        $.ajax({
            type: 'POST',
            url: url,
            data: { "deleteRoom": request, "roomID": roomID, "bldgName": bldgName, "roomName": roomName },
            success: function(result) {

                $('#roomsTbl').DataTable().clear();
                $('#roomsTbl').DataTable().destroy();
                loadAllRooms();

                $('#alertBoxSuccessDelRoom').removeAttr("style");
                $(window).scrollTop(0);

                window.setTimeout(function() {
                    document.getElementById("alertBoxSuccessDelRoom").style.display = 'none';
                }, 3000);
            }
        });
    }
});



//===============================================  EDIT ROOM INFO =========================================================
$('#roomsTbl').on('click', '.editRoomBtn', function() {
    let request = "";
    var row = $(this).closest('tr');
    var roomID = row.find('span.roomID').text();

    $.ajax({
        type: "POST",
        url: url,
        data: { "editRoomInfo": request, "roomID": roomID },
        success: function(result) {
            var roomID = result[0].roomID;
            var bldgName = result[0].bldgName;
            var roomName = result[0].roomName;
            var roomNotes = result[0].roomNotes;

            $('#roomID').val(roomID);
            if (bldgName == "Asian Leadership Center") {
                $('#bldgNameMdlDdown')[0].selectedIndex = 1
            } else if (bldgName == "Light House") {
                $('#bldgNameMdlDdown')[0].selectedIndex = 2
            } else if (bldgName == "Bright House") {
                $('#bldgNameMdlDdown')[0].selectedIndex = 3
            } else if (bldgName == "Mansion") {
                $('#bldgNameMdlDdown')[0].selectedIndex = 4
            } else if (bldgName == "Koinonia") {
                $('#bldgNameMdlDdown')[0].selectedIndex = 5
            } else if (bldgName == "Ezra House") {
                $('#bldgNameMdlDdown')[0].selectedIndex = 6
            } else if (bldgName == "Dynamic Learning Center") {
                $('#bldgNameMdlDdown')[0].selectedIndex = 7
            } else if (bldgName == "Shop") {
                $('#bldgNameMdlDdown')[0].selectedIndex = 8
            } else if (bldgName == "Guard House") {
                $('#bldgNameMdlDdown')[0].selectedIndex = 9
            } else if (bldgName == "Canteen") {
                $('#bldgNameMdlDdown')[0].selectedIndex = 10
            } else {
                $('#bldgNameMdlDdown')[0].selectedIndex = 0
            }


            $('#roomNameMdl').val(roomName);
            $('#roomNotesMdl').val(roomNotes);

            document.getElementById('editRoomModalLbl').innerHTML = "Edit Room Info: " + bldgName + " " + roomName;
            $('#editRoomDetailsMdl').modal('show');

        }
    });

});



//===============================================  UPDATE ROOM INFO =========================================================
$('#updateRoomBtn').click(function() {
    let request = "";
    var roomID = $('#roomID').val();
    var bldgID = $('#bldgNameMdlDdown').val();
    var bldgName = $('#bldgNameMdlDdown option:selected').text();
    var bldgShort = $('#bldgNameDdown option:selected').data('bldg');
    var roomName = $('#roomNameMdl').val();
    var roomNotes = $('#roomNotesMdl').val();

    $.ajax({
        type: "POST",
        url: url,
        data: { "updateRoom": request, "roomID": roomID, "bldgID": bldgID, "bldgName": bldgName, "bldgShort": bldgShort, "roomName": roomName, "roomNotes": roomNotes },
        success: function(result) {
            $('#editRoomDetailsMdl').modal('hide');
            console.log(result);
            if (result != "success") {
                $('#alertBoxUpdateSuccess').removeAttr("style");
                $(window).scrollTop(0);
                window.setTimeout(function() {
                    document.getElementById("alertBoxUpdateSuccess").style.display = 'none';
                }, 3000);

                $('#roomsTbl').DataTable().clear();
                $('#roomsTbl').DataTable().destroy();
                loadAllRooms();
            } else {
                $('#alertBoxUpdateError').removeAttr("style");
                $(window).scrollTop(0);
                window.setTimeout(function() {
                    document.getElementById("alertBoxUpdateError").style.display = 'none';
                }, 3000);
                console.log(result);
            }
        }
    });
});