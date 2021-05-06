let url = "includes/handlers/supply_controller";
let request = "";

$(document).ready(function() {
    $('#dashboardMain').removeAttr('style');
    //$('#loader').removeAttr('style');


});


$('#addItemBtn').click(function() {
    let brandname = $('#brandname').val();
    let productName = $('#productName').val();
    let description = $('#description').val();
    let amount = $('#amount').val();
    if ($('#unitDdown')[0].selectedIndex <= -1) {
        var unit = "";
    } else {
        var unit = $('#unitDdown').val();
    }
    let stocksFull = $('#stocksFull').val();
    if ($('#typeDdown')[0].selectedIndex <= -1) {
        var type = "";
    } else {
        var type = $('#typeDdown').val();
    }

    if (brandname == "" || productName == "" || amount == "" || unit == "" || stocksFull == "" || type == "") {
        $('#alertBox').removeAttr("style");
        //------------ Auto-close the alert box! ------------
        window.setTimeout(function() {
            document.getElementById("alertBoxFailed").style.display = 'none';
        }, 3000);

        if (brandname == "") {
            $('#brandNameValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
        if (productName == "") {
            $('#productNameValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
        if (amount == "") {
            $('#amountValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
        if (unit == "") {
            $('#unitValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
        if (stocksFull == "") {
            $('#stocksFullValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
        if (type == "") {
            $('#typeValidate').addClass("has-error");
            $(window).scrollTop(0);
        }
    } else {
        if (confirm("Is everything correct?")) {
            $.ajax({
                type: "POST",
                url: url,
                data: { "registerNewItem": request, "brandname": brandname, "productName": productName, "description": description, "amount": amount, "unit": unit, "stocksFull": stocksFull, "type": type },
                success: function(result) {
                    if (result == "1") {
                        $('#alertBoxSuccess').removeAttr("style");
                        $(window).scrollTop(0);
                        $('#resetBtn').click();

                        window.setTimeout(function() {
                            document.getElementById("alertBoxSuccess").style.display = 'none';
                        }, 3000);
                    } else {
                        console.error(result);
                    }
                }
            });
        }
    }
});



$('#brandname').keypress(function() {
    $('#brandNameValidate').removeClass("has-error");
});

$('#productName').keypress(function() {
    $('#productNameValidate').removeClass("has-error");
});

$('#amount').keypress(function() {
    $('#amountValidate').removeClass("has-error");
});

$('#stocksFull').keypress(function() {
    $('#stocksFullValidate').removeClass("has-error");
});


$('#resetBtn').click(function() {
    $('#brandNameValidate').removeClass("has-error");
    $('#productNameValidate').removeClass("has-error");
    $('#amountValidate').removeClass("has-error");
    $('#stocksFullValidate').removeClass("has-error");
});