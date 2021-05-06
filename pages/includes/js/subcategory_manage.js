let url = "includes/handlers/subcategory_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');
    $('#loader').removeAttr('style');
    loadlAllSubcat();

    //----------- Load the categories on the drop down selection ---------
    var request = "loadCategories";
    $.ajax({
        type: "POST",
        url: "includes/handlers/category_controller",
        data: { "loadAllCategories": request },
        success: function(result) {
            var html = '';
            if (result) {
                html += '<option value="" selected disabled> Select Category </option>';
                for (var i = 0; i < result.length; i++) {
                    html += '<option value="' + result[i].categoryID + '">' + result[i].categoryName + '</option>';
                }
            }
            $('#categoryNameDdown').html(html);
            $('#categoryMdlDdown').html(html);
            $('#loader').hide();
        }
    });

});


//========================================================================================================================
function loadlAllSubcat() {
    $.ajax({
        type: "POST",
        url: url,
        data: { "loadAllSubcat": request },
        success: function(result) {
            //console.log(result);
            var html = '';
            if (result) {
                for (var i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td style='display:none'><span class='subcategoryID'>" + result[i].subcategoryID + "</span><span class='categoryID'>" + result[i].categoryID + "</span></td>" +
                        "<td><span class='categoryName'>" + result[i].categoryName + "</span></td>" +
                        "<td><span class='subcategoryName'>" + result[i].subcategoryName + "</span></td>" +
                        "<td><span class='subcatNotes'>" + result[i].subcatNotes + "</span></td>" +
                        "<td><div class='btn-group btn-group-sm'> <button type='button' class='btn btn-primary editSubcatBtn' title='Edit this subcategory's info'><span class='fas fa-edit'></span></a>  <button type='button' class='btn btn-danger deleteSubcatBtn' title='Delete this subcategory'><span class='fas fa-trash-alt'></span></button></td>" +
                        "</tr>";
                }
            }
            $("#subcatTbody").html(html); // table body
            $("#subcatTbl").DataTable();
            $('#loader').hide();
        }
    });
}


//==================================================  SAVE NEW SUBCAT  ========================================================
$('#saveSubcatBtn').click(function() {
    if ($('#categoryNameDdown')[0].selectedIndex <= 0) {
        var categoryID = "";
    } else {
        var categoryID = $('#categoryNameDdown').val();
    }
    var categoryName = $('#categoryNameDdown option:selected').text();
    var subcategoryName = $('#subcategoryName').val();
    var subcategoryNotes = $('#subcategoryNotes').val();

    if (categoryID == "" || subcategoryName == "") {
        $('#alertBox').removeAttr("style");
        //------------ Auto-close the alert box! ------------
        window.setTimeout(function() {
            document.getElementById("alertBox").style.display = 'none';
        }, 3000);

        if (categoryID == "") {
            $('#categoryNameValidate').addClass("has-error");
            $(window).scrollTop(0);
        }

        if (subcategoryName == "") {
            $('#subcategoryNameValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
    } else {
        //console.log(categoryID+" "+categoryName+" "+subcategoryName+" "+subcategoryNotes);
        //if (confirm("Is everything correct?")) {
        $.ajax({
            type: "POST",
            url: url,
            data: { "saveNewCategory": request, "categoryID": categoryID, "categoryName": categoryName, "subcategoryName": subcategoryName, "subcategoryNotes": subcategoryNotes },
            success: function(result) {
                if (result == "1") {
                    $('#subcatTbl').DataTable().clear();
                    $('#subcatTbl').DataTable().destroy();
                    loadlAllSubcat();

                    $('#alertBoxSuccess').removeAttr("style");
                    $(window).scrollTop(0);
                    $('#resetBtn').click();

                    window.setTimeout(function() {
                        document.getElementById("alertBoxSuccess").style.display = 'none';
                    }, 3000);
                } else { // error on saving to db
                    console.log(result);
                }
            }
        });
        //}
    }
});

$('#categoryNameDdown').click(function() {
    $('#categoryNameValidate').removeClass("has-error");
});

$('#subcategoryName').keypress(function() {
    $('#subcategoryNameValidate').removeClass("has-error");
});

$('#resetBtn').click(function() {
    $('#categoryNameValidate').removeClass("has-error");
    $('#subcategoryNameValidate').removeClass("has-error");
});




//===============================================  DELETE SUBCAT =========================================================
$('#subcatTbl').on('click', '.deleteSubcatBtn', function() {
    if (confirm("Are you sure? Deleting this building is permanent, it cannot be undone!")) {
        var row = $(this).closest('tr');
        var subcategoryID = row.find("span.subcategoryID").text();
        var categoryName = row.find("span.categoryName").text();
        var subcategoryName = row.find("span.subcategoryName").text();

        $.ajax({
            type: 'POST',
            url: url,
            data: { "deleteSubcategory": request, "subcategoryID": subcategoryID, "categoryName": categoryName, "subcategoryName": subcategoryName },
            success: function(result) {
                if (result == "1") {
                    $('#subcatTbl').DataTable().clear();
                    $('#subcatTbl').DataTable().destroy();
                    loadlAllSubcat();

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



//===============================================  LOAD SUBCAT INFO =========================================================
$('#subcatTbl').on('click', '.editSubcatBtn', function() {
    var row = $(this).closest('tr');
    var subcategoryID = row.find('span.subcategoryID').text();

    $.ajax({
        type: "POST",
        url: url,
        data: { "loadSpecificSubcat": request, "subcategoryID": subcategoryID },
        success: function(result) {
            //console.log(result);

            var subcategoryID = result[0].subcategoryID;
            var category = result[0].categoryName;
            var subcategory = result[0].subcategoryName;
            var subcategoryNotes = result[0].subcatNotes;

            $('#subcategoryID').val(subcategoryID);

            if (category == "Housing") {
                $('#categoryMdlDdown')[0].selectedIndex = 1
            } else if (category == "Maintenance") {
                $('#categoryMdlDdown')[0].selectedIndex = 2
            } else if (category == "School Operation") {
                $('#categoryMdlDdown')[0].selectedIndex = 3
            } else if (category == "Tech") {
                $('#categoryMdlDdown')[0].selectedIndex = 4
            } else {
                $('#categoryMdlDdown')[0].selectedIndex = 0
            }

            $('#subcategoryMdl').val(subcategory);
            $('#subcatNotesMdl').val(subcategoryNotes);

            document.getElementById('editSubcatModalLbl').innerHTML = "Edit Subcategory Info: " + subcategory + " under " + category;
            $('#editSubcatDetailsMdl').modal('show');

        }
    });

});



//===============================================  UPDATE SUBCAT INFO =========================================================
$('#updateSubcatBtn').click(function() {
    var subcategoryID = $('#subcategoryID').val();
    var categoryID = $('#categoryMdlDdown').val();
    var category = $('#categoryMdlDdown option:selected').text();
    var subcategory = $('#subcategoryMdl').val();
    var subcatNotes = $('#subcatNotesMdl').val();

    $.ajax({
        type: "POST",
        url: url,
        data: { "updateSubcategory": request, "subcategoryID": subcategoryID, "categoryID": categoryID, "category": category, "subcategory": subcategory, "subcatNotes": subcatNotes },
        success: function(result) {
            $('#editSubcatDetailsMdl').modal('hide');

            if (result == "1") {
                $('#alertBoxUpdateSuccess').removeAttr("style");
                $(window).scrollTop(0);
                window.setTimeout(function() {
                    document.getElementById("alertBoxUpdateSuccess").style.display = 'none';
                }, 3000);

                $('#subcatTbl').DataTable().clear();
                $('#subcatTbl').DataTable().destroy();
                loadlAllSubcat();
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