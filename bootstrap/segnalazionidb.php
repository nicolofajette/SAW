<?php
	include("autologin.php");
	if(!isset($_SESSION['username'])){
		//Utente non loggato
		header('Location: index.php');
	}
	if (isset($_POST['filtro'])) {
		$filter = $_POST['filtro'];
		require_once("db.php");
		$dbHandler = new db_handler();
		try{
			$response = $dbHandler->getReports($filter, $_SESSION['username']);
			$jsonObj = new stdClass();
			if($response == null) {
				//nessun segnalazione di quel tipo
				$jsonObj->status = 0;
			} else{
				$jsonObj->status = 1;
				$jsonObj->segnalazioni = $response;
				$jsonObj->utente = $_SESSION['username'];
			}
			$JSON_response = json_encode($jsonObj);  //Converto in JSON l'array contenente le segnalazioni
			echo $JSON_response;  //Stampo la risposta
		}catch(Exception $e){
			echo "errore caricamento";
		}
	}else if (isset($_POST['rate'])) {
		if ($_POST['segnalatore'] != $_SESSION['username']) {
			$id = $_POST['id'];
			$user = $_SESSION['username'];
			$star = $_POST['rate'];
			require_once("db.php");
			$dbHandler = new db_handler();
			try{
				if($dbHandler->addRating($id, $star, $user)) {
					echo "ok";
				}
			} catch(Exception $e){
				echo $e;
			}
		} else {
			echo "stai valutando una tua segnalazione";
		}
	}
?>