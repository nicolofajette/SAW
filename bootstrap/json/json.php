<?php
	$reporter = "nicolo";  //Username utente 
	$position = $_POST['geoloc'];
	$wifi_name = strtoupper($_POST['SSID']);
	$wifi_type = $_POST['tipo'];
	if ($position != NULL || $wifi_name != NULL) {
		require_once('db.php');
		$dbHandler = new db_handler();
		try{
		if($dbHandler->addReport($reporter, $position, $wifi_name, $wifi_type) === true){
		$response = "sent";
		}else{
			$response = "errore segnalazione";
		}
		}catch(Exception $e){
			$response = "errore segnalazione";
		}
		echo $response;
	} else {
		$response = "campo vuoto";
		echo $response;
	}
?>