<?php 
	require_once('autologin.php');
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
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

		<!-- Custom CSS -->
		<link href="css/freeWiFi.css" rel="stylesheet">

		<!-- Custom JS -->
		<script type="text/javascript" src="js/login.js"></script>	
		<script type="text/javascript" src="js/modal.js"></script>

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
			
			<?php
				include ("modal.php");
			?>
		
			<div class="row">
				<div class="box">
					<div class="col-lg-12">
						<hr>
						<h2 class="intro-text text-center">
							<strong>La nostra attivit&agrave;</strong>
						</h2>
						<hr>
					</div>
					<div class="col-md-6">
						<img class="img-responsive img-border-left" src="img/about.jpg" alt="">
					</div>
					<div class="col-md-6">
						<p>Marzo 2017. Ci viene chiesto di pensare a un sito che potesse essere di qualche utilit&agrave; per la nostra comunit&agrave; per lo svolgimento di un progetto univeristario.</p>
						<p>Quale problema affligge la gente di oggigiorno se non l'internet? Cosa c'&egrave; di meglio di un Wi-Fi libero mentre aspettiamo di partire per un viaggio in aereoporto o in stazione?</p>
						<p>Ma tante volte non serve allontanarsi tanto da casa per avere un accesso a internet gratis, basta conoscere dove il comune o altre associazioni mettono a disposizione una connessione gratuita.</p>
						<p>Siamo proprio noi di <em>Wi-Fi a portata di click Genova</em> che mettiamo a disposizione di voi utenti la possibilità di cercare e segnalare accessi a Wi-FI liberi.</div>
					<div class="clearfix"></div>
				</div>
			</div>

			<div class="row">
				<div class="box">
					<div class="col-lg-12">
						<hr>
						<h2 class="intro-text text-center">Il nostro
							<strong>Team</strong>
						</h2>
						<hr>
					</div>
					<div class="col-sm-4 text-center">
						<img class="img-responsive" src="img/andrea.jpg" alt="">
						<h3>Andrea Costa
							<p><small>Ingegnere Informatico</small></p>
						</h3>
					</div>
					<div class="col-sm-4 text-center">
						<img class="img-responsive" src="img/nicolo.jpg" alt="">
						<h3>Nicol&ograve; Fajette
							<p><small>Ingegnere Informatico</small></p>
						</h3>
					</div>
					<div class="col-sm-4 text-center">
						<img class="img-responsive" src="img/niccolo.jpg" alt="">
						<h3>Niccol&ograve; Borgioli
							<p><small>Ingegnere Informatico</small></p>
						</h3>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>

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
</html>
