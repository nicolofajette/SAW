//jQuery Document
$(document).ready(function(){
	//If user wants to end session
	$("#exit").click(function(){
		window.location = 'pagina_chat.php?logout=true';   
	});
});
 
//If user submits the form
$("#submitmsg").click(function(){
		var clientmsg = $("#usermsg").val();
		$.post("send_chat_msg.php", {testo: clientmsg});             
		$("#usermsg").val('');
	return false;
});


