<?php
	include("autologin.php");
	if(!isset($_SESSION['username'])){
	//Utente non loggato
	header('Location: index.php');
	}
	$reporter = $_SESSION['username'];  //Username utente 
	$position = $_POST['geoloc'];
	$wifi_name = $_POST['SSID'];
	$wifi_type = $_POST['wifi_type'];
	if ($position != NULL && $wifi_name != NULL) {
		require_once('db.php');
		$dbHandler = new db_handler();
		try{
			if($dbHandler->addReport($reporter, $position, $wifi_name, $wifi_type)){
			$response = "sent";
		}else{
			$response = "Errore segnalazione";
		}
		}catch(Exception $e){
			$response = "Errore segnalazione";
		}
		echo $response;
	} else {
		$response = "Campo vuoto";
		echo $response;
	}
?>
