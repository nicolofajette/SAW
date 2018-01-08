<?php
	$error = 0;
	
	if (!isset($_POST['privacy'])) {
		$error = 5;
	} else {
		if (isset($_POST['email']) && !empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$email = trim($_POST['email']);
			} else {
			//campo email vuoto o email che non segue il formato
			$error = 1;		
		}
		
		if (isset($_POST['psw1']) && !empty($_POST['psw1'])) {
			$psw1 = trim($_POST['psw1']);
		} else {
			//campo psw1 vuoto
			$error = 1;
		}
		
		if (isset($_POST['psw2']) && !empty($_POST['psw2'])) {
			//$psw2 = addcslashes(trim($_POST['psw2']));
			$psw2 = trim($_POST['psw2']);
		} else {
			//campo nome vuoto
			$error = 1;	
		}
		
		if($psw1 !== $psw2) {
			//psw non coincidono
			$error = 2;
		}
		
		//Controllo altre variabili
		if (isset($_POST['nome']) && !empty($_POST['nome'])) {
			$nome = trim($_POST['nome']);
			} else {
			//campo email vuoto o email che non segue il formato
			$error = 1;
		}
		
		if (isset($_POST['cognome']) && !empty($_POST['cognome'])) {
			$cognome = trim($_POST['cognome']);
			} else {
			//campo cognome vuoto o email che non segue il formato
			$error = 1;
		}

		if (isset($_POST['username']) && !empty($_POST['username'])) {
			$username = trim($_POST['username']);
			} else {
			//campo username vuoto o email che non segue il formato
			$error = 1;
		}
		
		if (isset($_POST['data']) && !empty($_POST['data'])) {
			$data = trim($_POST['data']);
			} else {
			//campo data vuoto o email che non segue il formato
			$error = 1;
		}
	}
	
	
	
	if($error == 0){
		require_once('db.php');
		$dbHandler = new db_handler();

		if($dbHandler->checkUserExist($email)){
			//Utente già registrato
			echo "Email gi&agrave; in uso";
		}else{
			if($dbHandler->checkUsernameUsed($username)) {
				//Username già usato
				echo "Username gi&agrave; in uso";
			} else {
				if($dbHandler->insertUser($nome, $cognome, $data, $email, $username, password_hash($psw1, PASSWORD_DEFAULT))){
					//Utente registrato
					echo "ok";
				}else{
					//Errore inserimento
					echo "Errore registrazione";
				}
			}
		}
	}else if($error == 2){
		echo "Password non coincidenti";
	}else{
		echo "Errore registrazione";
	}
?>