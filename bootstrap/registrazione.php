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

		<title>Wi-Fi a portata di click Genova</title>

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
		<script type="text/javascript" src="js/registrazione.js"></script>
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
							<strong>Registrazione</strong>
						</h2>
						<hr>
						<p>Compila il form di registrazione per poter utilizzare il nostro servizio. Per adesso abbiamo bisogno solo di questi dati, potrai aggiungere eventuali altre informazioni in un secondo momento.</p>
						
						<form role="form" id="register-form" class="form-horizontal col-lg-offset-2" method="POST" >
							<div class="form-group">
								<label class="control-label col-lg-2" for="email">Email:</label>								
								<div class="col-lg-6">
									<input type="email" class="form-control" id="email" placeholder="Inserisci email" name="email" required>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2" for="username">Username:</label>
								<div class="col-lg-6">
									<input type="text" class="form-control" id="username" placeholder="Inserisci username" name="username" required>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2" for="nome">Nome:</label>
								<div class="col-lg-6">
									<input type="text" class="form-control" id="nome" placeholder="Inserisci nome" name="nome" required>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2" for="cognome">Cognome:</label>
								<div class="col-lg-6">
									<input type="text" class="form-control" id="cognome" placeholder="Inserisci cognome" name="cognome" required>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2" for="data">Data di nascita:</label>
								<div class="col-lg-4">
									<input type="date" id="data" name="data" class="form-control" placeholder="MM/DD/YYYY" required/>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2" for="psw1">Password:</label>
								<div class="col-lg-6">          
									<input type="password" class="form-control" id="psw1" placeholder="Enter password" name="psw1" required>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-lg-2" for="psw2">Ripeti password:</label>
								<div class="col-lg-6">          
									<input type="password" class="form-control" id="psw2" placeholder="Repeat password" name="psw2" required>
								</div>
							</div>
							<div class="checkbox col-lg-offset-2 col-lg-10" style="padding-top:0; padding-left:0; margin-bottom:10px">
								<label style="padding-left:0">
									<a href="#" data-toggle="modal" data-target="#privacy"><u style="color:black">Acconsenta il trattamento dei dati</u></a>
									<input type="checkbox" name="privacy" id="privacy-check" title="Acconsenta al trattamento dei dati!" required>
									<label for="privacy" class="error" style="font-weight:700"></label>
								</label>								
							</div>
							<div id="error-reg">
								<!-- error will be shown here ! -->
							</div>
							<div class="form-group">        
							  <div class="col-lg-offset-2 col-lg-10">
								<button type="submit" id="btn-register" class="btn btn-default">Registrati</button>
							  </div>
							</div>
						</form>
						
						<?php
							include("privacy.php");
						?>						
						  
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