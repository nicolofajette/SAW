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
					<div class="col-lg-12 text-center">
						<div id="carousel-example-generic" class="carousel slide">
							<!-- Indicators -->
							<ol class="carousel-indicators hidden-xs">
								<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
								<li data-target="#carousel-example-generic" data-slide-to="1"></li>
								<li data-target="#carousel-example-generic" data-slide-to="2"></li>
							</ol>

							<!-- Wrapper for slides -->
							<div class="carousel-inner">
								<div class="item active">
									<img class="img-responsive img-full" src="img/slide-1.jpg" alt="">
								</div>
								<div class="item">
									<img class="img-responsive img-full" src="img/slide-2.jpg" alt="">
								</div>
								<div class="item">
									<img class="img-responsive img-full" src="img/slide-3.jpg" alt="">
								</div>
							</div>

							<!-- Controls -->
							<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
								<span class="icon-prev"></span>
							</a>
							<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
								<span class="icon-next"></span>
							</a>
						</div>
						<h2 class="brand-before">
							<small>Benvenuto in</small>
						</h2>
						<h1 class="brand-name">Wi-Fi a portata di click</h1>
						<hr class="tagline-divider">
						<h2>
							<small>Trova il Wi-fi libero pi&ugrave; vicino a te a
								<strong>Genova</strong>
							</small>
						</h2>
					</div>
				</div>
			</div>

			<?php
				if(!isset($_SESSION["username"])) {
					echo '	<div class="row">
								<div class="box">
									<div class="col-lg-12">
										<hr>
											<h2 class="intro-text text-center"> 
												<strong>Registrati</strong>
												in pochi passi
											</h2>
										<hr>
										<img class="img-responsive img-border img-left" src="img/register-pic.jpg" alt="">
										<hr class="visible-xs">
										<p>Registrarsi è davvero velocissimo, bastano pochi secondi.</p>
										<p><a href="registrazione.php">Accedi alla registrazione</a>  oppure  <a href="#" id="myBtn1" data-toggle="modal" data-target="#basicModal">Loggati</a></p>
										<p>Una volta loggato avrai la possibilità di utilizzare la nostra banca dati e con un semplice click cercare il Wi-Fi libero pi&ugrave; vicino a te. Se non disponi della localizzazione potrai, comunque, inserire l&rsquo;indirizzo in cui ti trovi per cercare la tua "ancora della salvezza".</p>
										<p>Unige mette a disposizione per i propri studenti un Wi-Fi libero all&rsquo;interno dei suoi locali e se ti capitasse, per caso, di dover utilizzare internet nelle vicinaze di una delle strutture univeritarie...non ti preoccupare potrai trovare anche i Wi-Fi Eduroam disponibili sulla nostra piattaforma.</p>
									</div>
								</div>
							</div>';
				} else {
					echo '	<div class="row">
								<div class="box">
									<div class="col-lg-12">
										<hr>
											<h2 class="intro-text text-center"> 
												Hai effettuato l&rsquo;accesoo
											</h2>
										<hr>
										<img class="img-responsive img-border img-left" src="img/register-pic.jpg" alt="">
										<hr class="visible-xs">
										<p>Adesso puoi cercare il WiFi pi&ugrave; vicino a te.</p>
										<p>Puoi scegliere quale categoria mostrare: liberi, univeristari o entrambe le tipologie.</p>
										<p><a href="segnalazioni.php">Accedi alla pagina dei WiFi liberi</a></p>
									</div>
								</div>
							</div>';
				}
			?>
			<div class="row">
				<div class="box">
					<div class="col-lg-12">
						<hr>
						<h2 class="intro-text text-center">
							<strong>Fai la tua parte</strong>
						</h2>
						<hr>
						<p>Aiutaci ad allargare la nostra banca dati segnalando a tua volta un Wi-Fi libero.</p>
						<?php 
							if(!isset($_SESSION["username"])) {
								echo '<p>Segnala un WiFi</p>';
							} else {
								echo '<p><a href="segnala.php">Segnala un Wi-Fi</a></p>';
							}
						?>
						<p>Dai un giudizio alle segnalazioni di altri utenti; segnale se un Wi-Fi non è in funzione e se necessiti di ulteriori informazioni su una segnalazione comunica direttamente con l'autore della stessa grazie alla nostra chat interna.</p>
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

		<script>
		$('.carousel').carousel({
			interval: 5000 //changes the speed
		})
		</script>

	</body>

</html>
