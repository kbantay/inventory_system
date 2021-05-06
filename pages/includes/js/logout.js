


$('#logoutBtn').click(function(){
	//------------ Save logout activity for user ------------
	var userID = $('#userid').val();
	$.ajax({
		type: "POST",
		url: "includes/handlers/logout_saveActivity_handler",
		data: {"userID":userID},
		success: function(){
			//--------------- Logout JQuery -----------
			window.open('../pages/includes/handlers/logout_handler.php', '_self');	
		}
	});
});

