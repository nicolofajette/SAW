<?php 
	include("autologin.php");
	if(!isset($_SESSION['username'])){
		//Utente non loggato
		header('Location: index.php');
	}
	require_once("db.php");
	$dbHandler = new db_handler();
	try{
		$response = $dbHandler->getUserInfoUsername($_SESSION['username']);
		if ($response == null || $response['admin'] == false) {
			header('Location: index.php');
		} else{
			if (isset($_POST['username_blocca'])) {
				$username = $_POST['username_blocca'];
				try {
					if($dbHandler->banUser($username, 1)) {
						echo "ok";
					} else {
						echo "utente inesistente";
					}
				} catch(Exception $e){
					echo "errore";
				}
			} else if (isset($_POST['username_sblocca'])) {
				$username = $_POST['username_sblocca'];
				try {
					if($dbHandler->banUser($username, 0)) {
						echo "ok";
					} else {
						echo "utente inesistente";
					}
				} catch(Exception $e) {
					echo "errore" ;
				}
			} else if (isset($_POST['eliminasegn'])) {
				$id = $_POST['eliminasegn'];
				if($dbHandler->deleteReport($id)) {
					echo "ok";
				}
			}				
		}
	} catch(Exception $e){
		echo $e;
	}
?>