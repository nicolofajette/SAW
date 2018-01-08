<?php 
	require_once('autologin.php');
	if(!isset($_SESSION['username'])) {
		header('Location: index.php');
	}else {
		//passaggio a https per utilizzare posizione
	
		if(!isset($_SESSION['HTTPS'])){
			$cond = 0;
			if(!empty($_SERVER['HTTPS'])) {
				$cond = 1;
				if($_SERVER['HTTPS'] !== 'off') {
					$cond = 2;
				}
			}
			if ($cond == 0 ) {
				$_SESSION['HTTPS'] = true;
				header('Location: https://webdev.dibris.unige.it/~S4078757/sito/bootstrap/segnala.php');
			} else if ($cond == 1) {
				$_SESSION['HTTPS'] = true;
				$redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
				header('Location:$redirect'); 
			}
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
		<link rel="icon" href="data:,">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0W3mlTakNctxFJL2RRks8FRIbvFsoENY"></script>

		<!-- Custom CSS -->
		<link href="css/freeWiFi.css" rel="stylesheet">
		
		<!-- Custom JS -->
		<script type="text/javascript" src="js/segnala.js"></script>

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
					<div class="col-lg-12">
						<hr>
						<h2 class="intro-text text-center">
							<strong>Segnala WiFi</strong>
						</h2>
						<hr>
						
						<form class="form-inline text-center" method="POST" id="form-segnala" >
							<select class="form-control" name="wifi_type">
								<option value="pubblico interno">Pubblico interno</option>
								<option value="pubblico esterno">Pubblico esterno</option>
								<option value="universitario">Universitario</option>
							</select>
							<div style="display:inline">
								<input id="SSID" class="form-control" name="SSID" type="textbox" placeholder="Enter Wi-Fi name" required>
							</div>
							<div style="display:inline">
								<input id="address" class="form-control" name="address" type="textbox" placeholder = "Inserisci indirizzo">
							</div>
							<input type="button" class="btn btn-default" value="Centra mappa" onclick="codeAddress()">
							<button name="submit_report" type="submit" class="btn btn-default" name="btn-segnala">Submit</button>
							<a href="#" title="Informazioni" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Per segnalare il WiFi è necessario posizione il marker sulla mappa cliccando sulla posizione desiderata. Se si vuole centrare la mappa in una posizione che non sia quella attuale &egrave; necessario utilizzare il campo indirizzo per settarla.">
								<span class="glyphicon glyphicon-info-sign"></span>
							</a>
							<div style="display:block" >
								<input id="geoloc" class="form-control" name="geoloc" type="text" style="width:0; height:0; padding:0" required>
								<label class="error"></label>
							</div>
							<div id="error-segnala">
							<!-- error will be shown here ! -->
							</div>
						</form>
						<div class="alert alert-info" id="message" style="display: none; text-align:center; margin-top:15px;">
							<strong>Info!</strong> Errore nella determinazione della posizione. Utilizzare il campo indirizzo per centrare la mappa!
						</div>
						<div id="map" class="segnala_map well"></div>
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