<?php 
	require_once('autologin.php');
	if(!isset($_SESSION['username'])) {
		header('Location: index.php');
	}
	if(isset($_GET['segnalatore']) && $_GET['segnalatore'] != $_SESSION['username']) {
		$username = $_GET['segnalatore'];
		require_once("db.php");
		$dbHandler = new db_handler();
		try{
			$response = $dbHandler->getUserInfoUsername($username);
		} catch(Exception $e){
			echo $e;
		}
	} else {
		$username = $_SESSION['username'];
		require_once("db.php");
		$dbHandler = new db_handler();
		try{
			$response = $dbHandler->getUserInfoUsername($username);
			$segnalations = $dbHandler->getUsernameReports($username);
			$valutazioni = $dbHandler->getUsernameRating($username);
		} catch(Exception $e){
			echo $e;
		}
	}
?>
<!DOCTYPE html>
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
		
		<!-- Custom JS -->
		<script type="text/javascript" src="js/profilo.js"></script>

		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

	</head>

	<body>

	   <div class="brand">Wi-Fi a portata di click<span class="fa fa-wifi"></span></div>
		<div class="address-bar">Con pochissimi passi potrai trovare il Wi-Fi libero più vicino a te</div>

	   <?php
			include ("navigator.php");
		?>
		<div class="container">		
			<div class="row">
				<div class="box">
					<div class="col-lg-offset-2 col-lg-8 personal-info">
						<div class="text-center">
							<img src="<?php if($response['immagine'] !=null) {echo 'data:image/jpeg;base64,'.base64_encode($response['immagine']); } else { echo 'img/avatar.jpg'; }?>" class="img-thumbnail" alt="avatar" id="avatar">
							<?php if(!isset($_GET['segnalatore']) || $_GET['segnalatore'] == $_SESSION['username']) {
								echo '<form enctype="multipart/form-data" method="POST" id="form_immagine" action="profilodb.php"> 
										<h6>Scegli una nuova foto...</h6>
										<input type="hidden" name="MAX_FILE_SIZE" value="8388607" />
										<input type="file" class="text-center center-block well well-sm" id="userfile_id" name="userfile">
										<div id="error-img">
											<!-- error will be shown here ! --> ';
											
												if (isset($_GET['errore']) && !empty($_GET['errore'])) {
													echo '<div class="alert alert-danger col-lg-offset-2 col-lg-8"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '.$_GET["errore"].' !</div>';
												}
								echo	'</div>
										<input type="submit" class="btn btn-primary" name="btn_image" id="btn_image" value="Aggiorna immagine"/>
									</form>';
								}
							?>
						</div>
						<div class="text-center">
							<h3>Informazioni personali</h3>
						</div>
						<form class="form-horizontal" role="form" id="form-profilo" method="POST" enctype="multipart/form-data">
							<div class="form-group">
								<label class="col-lg-3 control-label">Username:</label>
								<div class="col-lg-8">
									<input class="form-control" name="username" id="username" type="text" value="<?php echo $response['username']; ?>" disabled>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">Nome:</label>
								<div class="col-lg-8">
									<input class="form-control" name="nome" id="nome" type="text" value="<?php echo $response['nome']; ?>" disabled>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">Cognome:</label>
								<div class="col-lg-8">
									<input class="form-control" name="cognome" id="cognome" type="text" value="<?php echo $response['cognome']; ?>" disabled>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3 control-label">Data di nascita:</label>
								<div class="col-lg-8">
            						<input class="form-control" name="data" id="data" type="text" value="<?php echo date("d-m-Y", strtotime($response['data'])); ?>" disabled>
								</div>
							</div>
							<fieldset id="myFieldset" disabled>
								<div class="form-group">
									<label class="col-lg-3 control-label">Email:</label>
									<div class="col-lg-8">
										<input class="form-control" name="email" id="email" type="email" value="<?php echo $response['email']; ?>">
									</div>
								</div>
								<div class="form-group" >
									<label class="col-lg-3 control-label">Indirizzo:</label>
									<div class="col-lg-8">
										<input class="form-control" name="indirizzo" id="indirizzo" type="text" value="<?php echo $response['indirizzo']; ?>">
									</div>
								</div>
								<div class="form-group" >
									<label class="col-lg-3 control-label">Citt&agrave;:</label>
									<div class="col-lg-8">
										<input class="form-control" name="luogo" id="luogo" type="text" value="<?php echo $response['luogo']; ?>">
									</div>
								</div>
								<div class="form-group" >
									<label class="col-lg-3 control-label">Informazioni:</label>	
									<div class="col-lg-8">
										<textarea class="form-control" name="informazioni" id="informazioni" rows="3" maxlenght="1023"><?php echo $response['informazioni']; ?></textarea>
									</div>
								</div>
							</fieldset>
							<div class="form-group" id="social">
								<label class="col-lg-3 control-label">Social:</label>
								<div class="col-lg-8">
									<a class="btn btn-social-icon btn-facebook" <?php if($response['facebook'] !=null) { echo 'href="'.$response['facebook'].'"';} else { echo 'class="not-active"';} ?> target="_blank"><span class="fa fa-facebook"></span></a>
									<a  class="btn btn-social-icon btn-twitter" <?php if($response['twitter'] !=null) { echo 'href="'.$response['twitter'].'"';} else { echo 'class="not-active"';} ?> target="_blank"><span class="fa fa-twitter"></span></a>
									<a class="btn btn-social-icon btn-instagram" <?php if($response['instagram'] !=null) { echo 'href="'.$response['instagram'].'"';} else { echo 'class="not-active"';} ?> target="_blank"><span class="fa fa-instagram"></span></a>
								</div>
							</div>
							<?php
								if(!isset($_GET['segnalatore']) || $_GET['segnalatore'] == $_SESSION['username']) {
									echo 
										'<div class="form-group" id="modifica-social" style="display:none">
											<label class="col-lg-3 control-label">Facebook:</label>
											<div class="col-lg-8">
												<input class="form-control" name="facebook" id="facebook" type="text">
											</div>
											<label class="col-lg-3 control-label">Twitter:</label>
											<div class="col-lg-8">
												<input class="form-control" name="twitter" id="twitter" type="text">
											</div>
											<label class="col-lg-3 control-label">Instagram:</label>
											<div class="col-lg-8">
												<input class="form-control" name="instagram" id="instagram" type="text">
											</div>
										</div>							
										<div id="modifica-password" style="display:none">
											<div class="form-group" >
												<label class="col-lg-3 control-label">Vecchia password:</label>
												<div class="col-lg-8">
													<input class="form-control" name="old_password" id="old_password" type="password">
												</div>
											</div>
											<div class="form-group" >
												<label class="col-lg-3 control-label">Password:</label>
												<div class="col-lg-8">
													<input class="form-control" name="new_password" id="new_password" type="password">
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-3 control-label">Conferma password:</label>
												<div class="col-lg-8">
													<input class="form-control" name="confirm_password" id="confirm_password" type="password">
												</div>
											</div>
										</div>
										<div id="error-prof">
											<!-- error will be shown here ! -->
										</div>
										<div class="form-group">
											<label class="col-lg-2 control-label"></label>
											<div class="col-lg-8 text-center">
												<input class="btn btn-default" value="Modifica profilo" type="button" id="btn-modifica">
												<input class="btn btn-primary" value="Salva" type="submit" id="btn-invia" name="btn-invia" style="display:none">
												<span></span>
												<input class="btn btn-default" value="Modifica password" type="button" id="btn-password" style="display:none">
												<span></span>
												<input class="btn btn-danger" value="Annulla" type="button" id="btn-cancel" style="display:none">
											</div>
										</div>';
									} else {
										echo '<div class="form-group">
												<label class="col-lg-2 control-label"></label>
												<div class="col-lg-8 text-center">
													<input class="btn btn-primary" value="Invia messaggio" type="submit" id="btn-chat" name="btn-chat">
												</div>
											</div>';
									}
								?>
						</form>
					</div>
				</div>
			</div>
			
			<?php
				if(!isset($_GET['segnalatore']) || $_GET['segnalatore'] == $_SESSION['username']) {
					if ($response != null && $response['admin'] == true) {
						echo '<div class="row">
								<div class="box text-center">
									<button class="btn btn-info" onclick="amministrazione()">PAGINA AMMINISTRATORE</button>
								</div>
							</div>';
					} 	
					echo '<div class="row">
							<div class="box">
								<hr>
								<h2 class="intro-text text-center">
									<strong>Segnalazioni effettuate</strong>									
								</h2>
								<p class="text-center"> &egrave; possibile eliminare la segnalazione nel caso di eventuali errori al momento compilazione del form.</p>
								<hr>
								<div id="messagio">';
					if (isset($_GET['cancellato']) && $_GET['cancellato'] == "si") {
						echo '<div class="alert alert-success text-center"> <span class="glyphicon glyphicon-ok"></span> &nbsp;Segnalazione eliminata!</div>';
					} 
					echo 		'</div>
								<div class="table-bordered table-responsive">          
									<table class="table" id="table_segnalations">
										<thead>
											<tr>
												<th>#</th>
												<th>id</th>
												<th>Nome</th>
												<th>Tipologia</th>
												<th>Posizione</th>
												<th></th>
											</tr>
										</thead>
										<tbody>';
					for ($i = 0; $i < count($segnalations); $i++) {	
							echo			"<tr>
												<td>".($i+1)."</td>
												<td>".$segnalations[$i]['id']."</td>
												<td>".$segnalations[$i]['SSID']."</td>
												<td>".$segnalations[$i]['tipologia']."</td>
												<td>".$segnalations[$i]['posizione']."</td>
												<td><button class='btn btn-danger' onclick='delete_segnalation(this)'>Elimina</button></td>
											</tr>";
					}
					echo				'</tbody>
									</table>
								</div>
							</div>
						</div>';
				
					echo '<div class="row">
							<div class="box">
								<hr>
								<h2 class="intro-text text-center">
									<strong>Rating effettuati</strong>									
								</h2>
								<p class="text-center"> &egrave; possibile eliminare la valutazione data.</p>
								<hr>
								<div id="messagioRate">';
					if (isset($_GET['cancellatoRate']) && $_GET['cancellatoRate'] == "si") {
						echo '<div class="alert alert-success text-center"> <span class="glyphicon glyphicon-ok"></span> &nbsp;Valutazione eliminata!</div>';
					} 
					echo 		'</div>
								<div class="table-bordered table-responsive">          
									<table class="table" id="table_rating">
										<thead>
											<tr>
												<th>#</th>
												<th>id valutazione</th>
												<th>id segnalazione</th>
												<th>Voto</th>
												<th>Nome</th>
												<th></th>
											</tr>
										</thead>
										<tbody>';
					for ($i = 0; $i < count($valutazioni); $i++) {	
							echo			"<tr>
												<td>".($i+1)."</td>
												<td>".$valutazioni[$i]['id']."</td>
												<td>".$valutazioni[$i]['segnalazione']."</td>
												<td>".$valutazioni[$i]['voto']."</td>
												<td>".$valutazioni[$i]['SSID']."</td>
												<td><button class='btn btn-danger' onclick='delete_rating(this)'>Elimina</button></td>
											</tr>";
					}
					echo				'</tbody>
									</table>
								</div>
							</div>
						</div>';
				}
			?>
		</div>
		<!-- /.container -->
		
		

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
	
	<script>
	function amministrazione() {
		location.href = "amministrazione.php";
	}
	$( "#btn-modifica" ).click(function() {
		$("#btn-invia").css("display", "inline");
		$("#btn-password").css("display", "inline");
		$("#btn-modifica").css("display", "none");
		$("#btn-cancel").css("display", "inline");
		$("#modifica-social").css("display", "block");
		$("#social").css("display", "none");
		$("#myFieldset").prop('disabled', false);
		$("#facebook").val("<?php echo $response['facebook']; ?>");
		$("#twitter").val("<?php echo $response['twitter']; ?>");
		$("#instagram").val("<?php echo $response['instagram']; ?>");
	});
		
	$("#btn-chat").click(function() {
		var username = "<?php if(isset($_GET['segnalatore'])) { echo $_GET['segnalatore']; } else { echo null;} ?>";
		window.location.replace("list_conversations.php?receiver="+username+"");
	});
	</script>
	
</html>