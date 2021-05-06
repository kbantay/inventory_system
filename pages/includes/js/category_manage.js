let url = "includes/handlers/category_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');
    $('#loader').removeAttr('style');

    loadAllCat();
});


//========================================================================================================================
function loadAllCat() {
    $.ajax({
        type: "POST",
        url: url,
        data: { "loadAllCategories": request },
        success: function(result) {
            //console.log(result);
            var html = '';
            if (result) {
                for (var i = 0; i < result.length; i++) {
                    html += "<tr>" +
                        "<td style='display:none'><span class='catID'>" + result[i].categoryID + "</span></td>" +
                        "<td><span class='catName'>" + result[i].categoryName + "</span></td>" +
                        "<td><span class='catNotes'>" + result[i].categoryNotes + "</span></td>" +
                        "<td><div class='btn-group btn-group-sm'> <button type='button' class='btn btn-primary editCatBtn' title='Edit this category's info'><span class='fas fa-edit'></span></a>  <button type='button' class='btn btn-danger deleteCatBtn' title='Delete this category'><span class='fas fa-trash-alt'></span></button></td>" +
                        "</tr>";
                }
            }
            $("#categoryTbody").html(html); // table body
            $("#categoryTbl").DataTable();
            $('#loader').hide();
        }
    });
}


//==================================================  SAVE NEW CATEGORY  ========================================================
$('#saveCatBtn').click(function() {
    let request = "saveNewCategory";
    var catName = $('#categoryName').val();
    var catNotes = $('#categoryNotes').val();

    if (catName == "") {
        $('#alertBox').removeAttr("style");
        //------------ Auto-close the alert box! ------------
        window.setTimeout(function() {
            document.getElementById("alertBox").style.display = 'none';
        }, 3000);

        $('#categoryNameValidate').addClass("has-error");
        $(window).scrollTop(0);
    } else {
        if (confirm("Is everything correct?")) {
            $.ajax({
                type: "POST",
                url: url,
                data: { "saveNewCategory": request, "catName": catName, "catNotes": catNotes },
                success: function(result) {
                    if (result == "1") {
                        $('#categoryTbl').DataTable().clear();
                        $('#categoryTbl').DataTable().destroy();
                        loadAllCat();

                        $('#alertBoxSuccess').removeAttr("style");
                        $(window).scrollTop(0);
                        $('#resetBtn').click();

                        window.setTimeout(function() {
                            document.getElementById("alertBoxSuccess").style.display = 'none';
                        }, 3000);
                    } else { // error on saving to db
                        console.error(result);
                    }
                }
            });
        }
    }
});

$('#categoryName').keypress(function() {
    $('#categoryNameValidate').removeClass("has-error");
});


$('#resetBtn').click(function() {
    $('#categoryNameValidate').removeClass("has-error");
});




//===============================================  DELETE DEPARTMENT =========================================================
$('#categoryTbl').on('click', '.deleteCatBtn', function() {
    if (confirm("Are you sure? Deleting this department is permanent, it cannot be undone!")) {
        let request = "deleteCategory";
        var row = $(this).closest('tr');
        var catID = row.find("span.catID").text();
        var catName = row.find("span.catName").text();

        $.ajax({
            type: 'POST',
            url: url,
            data: { "deleteCategory": request, "catID": catID, "catName": catName },
            success: function(result) {
                if (result == "1") {
                    $('#categoryTbl').DataTable().clear();
                    $('#categoryTbl').DataTable().destroy();
                    loadAllCat();
                } else {
                    console.error(result);
                }
            }
        });
    }
});



//===============================================  EDIT DEPARTMENT INFO =========================================================
$('#categoryTbl').on('click', '.editCatBtn', function() {
    let request = "loadSpecificCategory";
    var row = $(this).closest('tr');
    var catID = row.find('span.catID').text();

    $.ajax({
        type: "POST",
        url: url,
        data: { "loadSpecificCategory": request, "catID": catID },
        success: function(result) {
            var catID = result[0].categoryID;
            var catName = result[0].categoryName;
            var catNotes = result[0].categoryNotes;

            $('#categoryID').val(catID);
            $('#categoryNameMdl').val(catName);
            $('#categoryNotesMdl').val(catNotes);

            document.getElementById('editCategoryModalLbl').innerHTML = "Edit Category Info: " + catName;
            $('#editCategoryDetailsMdl').modal('show');
        }
    });

});



//===============================================  UPDATE DEPARTMENT INFO =========================================================
$('#updateCatBtn').click(function() {
    let request = "updateCategoryInfo";
    var catID = $('#categoryID').val();
    var catName = $('#categoryNameMdl').val();
    var catNotes = $('#categoryNotesMdl').val();

    $.ajax({
        type: "POST",
        url: url,
        data: { "updateCategoryInfo": request, "catID": catID, "catName": catName, "catNotes": catNotes },
        success: function(result) {
            $('#editCategoryDetailsMdl').modal('hide');

            if (result == "1") {
                $('#alertBoxUpdateSuccess').removeAttr("style");
                $(window).scrollTop(0);
                window.setTimeout(function() {
                    document.getElementById("alertBoxUpdateSuccess").style.display = 'none';
                }, 3000);

                $('#categoryTbl').DataTable().clear();
                $('#categoryTbl').DataTable().destroy();
                loadAllCat();
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