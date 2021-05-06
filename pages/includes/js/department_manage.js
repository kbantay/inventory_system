let url = "includes/handlers/department_controller";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');
    $('#loader').removeAttr('style');

    loadAllDept();
});


//========================================================================================================================
function loadAllDept() {
    var request = "load";
    $.ajax({
        type: "POST",
        url: url,
        data: { "loadAllDepartments": request },
        success: function(result) {
            //console.log(result);
            var html = '';
            if (result) {
                for (var i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td style='display:none'><span class='deptID'>" + result[i].deptID + "</span></td>" +
                        "<td><span class='deptName'>" + result[i].deptName + "</span></td>" +
                        "<td><span class='deptShortName'>" + result[i].deptShortName + "</span></td>" +
                        "<td><span class='deptNotes'>" + result[i].deptNotes + "</span></td>" +
                        "<td><div class='btn-group btn-group-sm'> <button type='button' class='btn btn-primary editDeptBtn' title='Edit this departments's info'><span class='fas fa-edit'></span></a>  <button type='button' class='btn btn-danger deleteDeptBtn' title='Delete this department'><span class='fas fa-trash-alt'></span></button></td>" +
                        "</tr>";
                }
            }
            $("#departmentTbody").html(html); // table body
            $("#departmentTbl").DataTable();
            $('#loader').hide();
        }
    });
}


//==================================================  SAVE NEW DEPARTMENT  ========================================================
$('#saveDeptBtn').click(function() {
    let request = "";
    var deptName = $('#deptName').val();
    var deptShortName = $('#deptShortName').val();
    var deptNotes = $('#deptNotes').val();

    if (deptName == "" || deptShortName == "") {
        $('#alertBox').removeAttr("style");
        //------------ Auto-close the alert box! ------------
        window.setTimeout(function() {
            document.getElementById("alertBox").style.display = 'none';
        }, 3000);

        if (deptName == "") {
            $('#deptNameValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
        if (deptShortName == "") {
            $('#deptShortNameValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
    } else {
        if (confirm("Is everything correct?")) {
            $.ajax({
                type: "POST",
                url: url,
                data: { "saveNewDept": request, "deptName": deptName, "deptShortName": deptShortName, "deptNotes": deptNotes },
                success: function(result) {
                    //console.log(result);
                    if (result == "1") {
                        $('#departmentTbl').DataTable().clear();
                        $('#departmentTbl').DataTable().destroy();
                        loadAllDept();

                        $('#alertBoxSuccess').removeAttr("style");
                        $(window).scrollTop(0);
                        $('#resetBtn').click();

                        window.setTimeout(function() {
                            document.getElementById("alertBoxSuccess").style.display = 'none';
                        }, 3000);
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
        }
    }
});

$('#deptName').keypress(function() {
    $('#deptNameValidate').removeClass("has-error");
});

$('#deptShortName').keypress(function() {
    $('#deptShortNameValidate').removeClass("has-error");
});

$('#resetBtn').click(function() {
    $('#deptNameValidate').removeClass("has-error");
    $('#deptShortNameValidate').removeClass("has-error");
});




//===============================================  DELETE DEPARTMENT =========================================================
$('#departmentTbl').on('click', '.deleteDeptBtn', function() {
    if (confirm("Are you sure? Deleting this department is permanent, it cannot be undone!")) {
        let request = "";
        var row = $(this).closest('tr');
        var deptID = row.find("span.deptID").text();
        var deptName = row.find("span.deptName").text();

        $.ajax({
            type: 'POST',
            url: url,
            data: { "deleteDept": request, "deptID": deptID, "deptName": deptName },
            success: function(result) {
                if (result == 1) {
                    $('#departmentTbl').DataTable().clear();
                    $('#departmentTbl').DataTable().destroy();
                    loadAllDept();
                } else {
                    console.error(result)
                }
            }
        });
    }
});



//===============================================  EDIT DEPARTMENT INFO =========================================================
$('#departmentTbl').on('click', '.editDeptBtn', function() {
    let request = "";
    var row = $(this).closest('tr');
    var deptID = row.find('span.deptID').text();

    $.ajax({
        type: "POST",
        url: url,
        data: { "loadDeptInfo": request, "deptID": deptID },
        success: function(result) {
            //console.log(result);
            var deptID = result[0].deptID;
            var deptName = result[0].deptName;
            var deptShortName = result[0].deptShortName;
            var deptNotes = result[0].deptNotes;

            $('#deptID').val(deptID);
            $('#deptNameMdl').val(deptName);
            $('#deptShortNameMdl').val(deptShortName);
            $('#deptNotesMdl').val(deptNotes);

            document.getElementById('editDeptModalLbl').innerHTML = "Edit Department Info: " + deptName;
            $('#editDeptDetailsMdl').modal('show');
        }
    });

});



//===============================================  UPDATE DEPARTMENT INFO =========================================================
$('#updateBldgBtn').click(function() {
    let request = "";
    var deptID = $('#deptID').val();
    var deptName = $('#deptNameMdl').val();
    var deptShortName = $('#deptShortNameMdl').val();
    var deptNotes = $('#deptNotesMdl').val();

    $.ajax({
        type: "POST",
        url: url,
        data: { "updateDeptInfo": request, "deptID": deptID, "deptName": deptName, "deptShortName": deptShortName, "deptNotes": deptNotes },
        success: function(result) {
            $('#editDeptDetailsMdl').modal('hide');

            if (result == "1") {
                $('#alertBoxUpdateSuccess').removeAttr("style");
                $(window).scrollTop(0);
                window.setTimeout(function() {
                    document.getElementById("alertBoxUpdateSuccess").style.display = 'none';
                }, 3000);

                $('#departmentTbl').DataTable().clear();
                $('#departmentTbl').DataTable().destroy();
                loadAllDept();
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