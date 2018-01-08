<?php 
	require_once('autologin.php');
	if(!isset($_SESSION['username'])) {
		header('Location: index.php');
	}
	require_once("db.php");
	$dbHandler = new db_handler();
	try{
		$response = $dbHandler->getUserInfoUsername($_SESSION['username']);
		if ($response == null || $response['admin'] == false) {
			header('Location: index.php');
		} else{
			$segnalations = $dbHandler->getReports("Tutti",$_SESSION['username']);
			$banned = $dbHandler->getBannedUser();
		}
	} catch(Exception $e){
		echo $e;
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
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

		<!-- Custom CSS -->
		<link href="css/freeWiFi.css" rel="stylesheet">

		<!-- Custom JS -->
		<script type="text/javascript" src="js/amministrazione.js"></script>
	
		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic" rel="stylesheet" type="text/css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

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
					<div class="col-lg-12 text-center">
						<h1 class="intro-text">
							<strong>Pagina amministratore</strong></br>
							<?php
								echo "Benvenuto ".$_SESSION['username']." nella pagina di amministrazione";
							?>
						</h1>
					</div>						
				</div>
			</div>
			
			<div class="row">
				<div class="box">
					<div class="col-lg-12 text-center">
						<hr>
						<h2 class="intro-text">
							<strong>Blocca utente</strong>
							</br>Inserisci username dell'utente da bloccare
						</h2>
						<form class="col-lg-6 col-lg-offset-3" role="form" method="POST" id="form-blocca" >
							<div class="form-group">
								<input id="username_blocca" class="form-control" name="username_blocca" type="textbox" required>
							</div>
							<input class="btn btn-default" value="Blocca" type="submit" id="btn_blocca" name="btn_blocca">
							<div id="error-blocca">
							
							</div>
						</form>
					</div>	
					<div class="text-center">
						<p>Visualizza utenti bloccati</p>
						<button type="button" class="btn btn-default" id="btn_visualizzaBanned">Visualizza</button>
						<button type="button" class="btn btn-danger" id="btn_chiudiBanned" style="display:none">Chiudi</button>
					</div>
					<div class="table-bordered table-responsive" id="tabella_banned" style="display:none">          
						<table class="table" id="table_banned">
							<thead>
								<tr>
									<th>#</th>
									<th>Username</th>
									<th>Email</th>
								</tr>
							</thead>
							<tbody>
				<?php
					for ($i = 0; $i < count($banned); $i++) {	
					echo		"<tr>
									<td>".($i+1)."</td>
									<td>".$banned[$i]['username']."</td>
									<td>".$banned[$i]['email']."</td>
								</tr>";
				}
				?>
							</tbody>
						</table>
					</div>			
				</div>
			</div>
			
			<div class="row">
				<div class="box">
					<div class="col-lg-12 text-center">
						<hr>
						<h2 class="intro-text">
							<strong>Sblocca utente</strong>
							</br>Inserisci username dell'utente da sbloccare
						</h2>
						<form class="col-lg-6 col-lg-offset-3" role="form" method="POST" id="form-sblocca" >
							<div class="form-group">
								<input id="username_sblocca" class="form-control" name="username_sblocca" type="textbox" required>
							</div>
							<input class="btn btn-default" value="Sblocca" type="submit" id="btn_sblocca" name="btn_sblocca">
							<div id="error-sblocca">
							
							</div>
						</form>
					</div>						
				</div>
			</div>
			
			<div class="row">
				<div class="box">
					<div class="col-lg-12 text-center">
						<hr>
						<h2 class="intro-text">
							<strong>Elimina segnalazione</strong>
							</br>Inserisci id della segnalazione da eliminare
						</h2>
						<form class="col-lg-6 col-lg-offset-3" role="form" method="POST" id="form-eliminasegn" >
							<div class="form-group">
								<input id="eliminasegn" class="form-control" name="eliminasegn" type="textbox" required>
								
							</div>
							<input class="btn btn-default" value="Elimina" type="submit" id="btn_eliminasegn" name="btn_eliminasegn">
							<div id="error-eliminasegn">
							
							</div>
						</form>
					</div>						
				</div>
			</div>
			
			<div class="row">
				<div class="box">
					<hr>
					<h2 class="intro-text text-center">
						<strong>Visualizza segnalazioni</strong>
					</h2>
					<hr>
					<div class="text-center">
						<button type="button" class="btn btn-default" id="btn_visualizza">Visualizza</button>
						<button type="button" class="btn btn-danger" id="btn_chiudi" style="display:none">Chiudi</button>
					</div>
					<div class="table-bordered table-responsive" id="tabella" style="display:none">          
						<table class="table" id="table_segnalations">
							<thead>
								<tr>
									<th>id</th>
									<th>Nome</th>
									<th>Tipologia</th>
									<th>Posizione</th>
									<th>Segnalatore</th>
									<th>Valutazione</th>
								</tr>
							</thead>
							<tbody>
				<?php
					for ($i = 0; $i < count($segnalations); $i++) {	
					echo		"<tr>
									<td>".$segnalations[$i]['id']."</td>
									<td>".$segnalations[$i]['SSID']."</td>
									<td>".$segnalations[$i]['tipologia']."</td>
									<td>".$segnalations[$i]['posizione']."</td>
									<td>".$segnalations[$i]['segnalatore']."</td>
									<td>".$segnalations[$i]['media']."</td>
								</tr>";
				}
				?>
							</tbody>
						</table>
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