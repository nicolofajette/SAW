<?php
  include('autologin.php');
  if(!isset($_SESSION['username'])){
    //Utente non loggato
    header('Location: index.php');
  }
  require_once('db.php');
  $dbHandler = new db_handler();
  $error = 0;
  
  function SearchUserForm() {
    echo '<div id="userform">
			<form action="list_conversations.php" method="post">
				<H3>Avvia nuova chat</H3>
			   <p>Inserisci il nome utente con cui iniziare la chat:</p>
			   <label for="name">Username:</label>
			   <input type="text" name="receiver" id="receiver" />
			   <input type="submit" name="enter" id="enter" value="Enter" />
			</form>
		</div>';
  }
	if(!((isset ( $_POST['enter'] )) && ($_POST['receiver'] != ""))){	
		if(isset($_GET['receiver'])){	//Click link chat già attiva
			if($dbHandler->checkUsernameUsed($_GET['receiver'])){
				$_SESSION['receiver'] = stripslashes(htmlspecialchars($_GET['receiver']));
				header('Location: pagina_chat.php');
			}
		}
	}

	try{
		if ((isset ( $_POST['enter'] )) && ($_POST['receiver'] != "")) {	//Tentativo di ricerca utente con cui iniziare chat
			if($dbHandler->checkUsernameUsed($_POST ['receiver'] )){
				//Utente esistente
				if ($_POST ['receiver'] == $_SESSION['username']) {
					$error = 1;
				}else{
					$_SESSION['receiver'] = stripslashes(htmlspecialchars($_POST['receiver']));
					header('Location: pagina_chat.php');
				}
			} else {
				$error = 2;
			}
		}
	}catch(Exception $e){
		echo "Errore interno, si prega di riprovare più tardi";
	}
?>
<html lang="it">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="trova Wi-Fi libero a Genova">
		<meta name="author" content="Wi-Fi a portata di click Genova">
    
    <title>Wi-Fi a portata di click</title>

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/bootstrap-social.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
  
    <!-- Custom CSS -->
		<link href="css/freeWiFi.css" rel="stylesheet">
    
    <!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div class="brand">Wi-Fi a portata di click<span class="fa fa-wifi"></span></div>
		<div class="address-bar">Con pochissimi passi potrai trovare il Wi-Fi libero più vicino a te</div>
    <?php
      include("navigator.php");
    ?>
    <div class="container">
      <div class="row">
        <div class="box">
          <div class="col-lg-offset-2 col-lg-8">
			<div class="text-center">
				<?php
				  try{
						$conversations = $dbHandler->getOpenConversations($_SESSION['username']);
						if($conversations == null){
							//Nessuna conversazione iniziata
							echo "<h3>Nessuna conversazione in corso</h3>";
						}else{
							echo '<div class="list-group">';
							echo '<h3>Chat attive</h3>';
							foreach($conversations as $conversation){
							echo "<a href='list_conversations.php?receiver=".$conversation['user']."' class='list-group-item'>";
							echo "<h3 class='list-group-item-heading'>".$conversation['user']."</h3>";
							$messaggi = $dbHandler->getConversation($conversation['user'], $_SESSION['username']);
							$unread = 0;
							foreach($messaggi as $messaggio){
								if($messaggio['visualizzato'] == false && $messaggio['destinatario'] == $_SESSION['username']){
									$unread = $unread + 1;
								}
							}
							$last_msg = array_pop($messaggi)['testo'];
							echo "<p class='list-group-item-text'>".$last_msg; //Ultimo messaggio di questa conversazione
							if($unread != 0){
								echo " <span class='badge' style='background-color:#3a87ad' >".$unread."</span>";
							}
							echo "</p>";
							echo "</a>";
							}
							echo '</div>';
						}
						SearchUserForm();
						if ($error == 1) {
							echo '<div class="alert alert-danger">Non puoi scrivere a te stesso!</div>';
						} else if ($error == 2) {
							echo '<div class="alert alert-danger">Utente inesistente!</div>';
						}
						
				  }catch(Exception $e){
						echo "Errore interno, si prega di riprovare più tardi";
				  }
				?>
			</div>
          </div>
        </div>
      </div>
    </div>
	
	<footer>
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<h2 class="intro-text">
							<strong>FOLLOW US</strong>
						</h2>
						<a class="fa fa-facebook social-icon" href="https://www.facebook.com/nicolo.fajette?fref=ts" target="_blank"></a>
						<a class="fa fa-twitter social-icon" href="https://twitter.com/andregrifone" target="_blank"></a>
						<a class="fa fa-instagram social-icon" href="https://www.instagram.com/borgioli.niccolo" target="_blank"></a>
						<a class="fa fa-youtube social-icon" href="https://www.youtube.com/user/GenoaMunicipality" target="_blank"></a>
						<hr>					
						<p class="intro-text" >Copyright &copy; Wi-Fi a portata di click Genova 2017</p>
					</div>					
				</div>
			</div>
	</footer>
  </body>
</html>