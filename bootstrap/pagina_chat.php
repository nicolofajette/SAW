<?php 
	require_once('autologin.php');

	if (isset($_GET['logout'])) {   
		$_SESSION['receiver'] = null;
		header ( "Location: list_conversations.php" ); // Redirect the user
	}
 
?>
<!DOCTYPE html>
<head>
	<!-- Boostrap -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
	<!-- Custom CSS -->
	<link rel="stylesheet" href="css/pagina_chat.css">
	
	<!-- Custom JS -->
	<script type="text/javascript" src="js/pagina_chat.js"></script>
	<script type="text/javascript" src="js/chat_client.js"></script>
	
	<title>Chat - Customer Module</title>
</head>
<body onLoad="setChat(<?php echo "'".$_SESSION['username']."', '".$_SESSION['receiver']."'"; ?>)">
    <?php
		if( !isset( $_SESSION['receiver']) ){
			header('Location: list_conversations.php');
		}else{
    ?>
		
	<div class="chat_window">
		<div class="top_menu">
			<div class="buttons">
				<button type="button" class="close" id="exit"><span class="glyphicon glyphicon-remove-sign"></span></button>
			</div>
			<div class="title"><?php echo $_SESSION['receiver'];?></div>
		</div>
		<ul class="messages" id="messages"></ul>
		<div class="bottom_wrapper">
			<form name="message" action="">
				<div class="message_input_wrapper">
					<input name="usermsg" type="text" class="message_input" maxlength="64" placeholder="Inserisci qua il tuo messaggio..." id="usermsg" /> 
				</div>
				<input name="submitmsg" type="submit" class="send_message" value="Send" id="submitmsg" />
			</form>
		</div>
	</div>
	<script type="text/javascript">
		// jQuery Document
		$(document).ready(function(){
		});
		 
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
		 
		setInterval (chat, 1000);	//Eseguo una richiesta per ricerca nuovi messaggi ogni secondo
	</script>
	<?php
		}
	?>
</body>
</html>