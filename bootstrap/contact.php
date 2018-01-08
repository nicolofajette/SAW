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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
					<div class="col-lg-12 text-center">
						<hr>
						<h2 class="intro-text">
							<strong>Contattaci</strong>
						</h2>
						<hr>
						<p>Per qualsiasi informazione contattaci attraverso una delle seguenti opzioni:</p>
						<p><span class="fa fa-map-marker"></span><a href="https://maps.google.com/?q=Genova, Italia" target="_blank">  Genoa, Italy </a></p>
						<p><span class="fa fa fa-envelope"></span>  E-mail: <a href="mailto:info@WiFiaportatadiclick.com">info@WiFiaportatadiclick.com</a></p>
						<p><span class="fa fa-phone"></span>  Telefono: +39 010 3760002</p>
						</br>
						<p>Oppure contattaci alle mail personali:</p>
						<p><span class="fa fa-at"></span>  Nicol&ograve; Fajette: <a href="mailto:nicolo.fajette@WiFiaportatadiclick.com">nicolo.fajette@WiFiaportatadiclick.com</a></p>
						<p><span class="fa fa-at"></span>  Niccol&ograve; Borgioli: <a href="mailto:niccolo.borgioli@WiFiaportatadiclick.com">niccolo.borgioli@WiFiaportatadiclick.com</a></p>
						<p><span class="fa fa-at"></span>  Andrea Costa: <a href="mailto:andrea.costa@WiFiaportatadiclick.com">andrea.costa@WiFiaportatadiclick.com</a></p>	
					</div>
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
