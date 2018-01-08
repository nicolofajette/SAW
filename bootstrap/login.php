<?php
	if (isset($_POST['email']) && !empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$email = trim($_POST['email']);
	} else {
		//campo email vuoto o email che non segue il formato
		echo "email o password non inserite."; // wrong details
	}

	if (isset($_POST['pwd']) && !empty($_POST['pwd'])) {
		$pwd = trim($_POST['pwd']);
	} else {
		//campo pwd vuoto
		echo "email o password non inserite."; // wrong details
	}
	if (!isset($_POST['remember'])) {
		$remember = false;
	} else {
		$remember = true;
	}
	

	//verifica esistenza utente
	session_start();
	require_once('db.php');
	$dbHandler = new db_handler();
	try{
		$user = $dbHandler->getUserInfo($email);
		if($user != null){
			if (!$user['bloccato']) {
				if(password_verify($pwd, $user['password']) == true){
					//Utente loggato
					$_SESSION['email'] = $user['email'];
					$_SESSION['username'] = $user['username'];
					if ($remember == true) {
						$series_id = rand();
						$token_rand = rand();
						$expire_time = time()+60*60*7;	
						setcookie('autologin', $series_id."%".$token_rand, $expire_time );
						$token = hash('sha256',$token_rand);
						$dbHandler->setCookieValue($user['username'], $series_id, $token, $expire_time);
					}
					echo "ok"; // log in
				}else{
					//Password sbagliata
					echo "email o password non corretti."; // wrong details 
				}
			} else {
				//Utente bloccato
				echo "UTENTE BLOCCATO"; // banned user
			}
		}else{
			//Utente inesistente
			echo "email o password non corretti"; // wrong details 
		}
	}catch(Exception $e){
		echo "email o password non corretti"; // wrong details 
	}
?>