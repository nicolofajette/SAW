<?php
	session_start();
	if(isset($_COOKIE['autologin']) && !isset($_SESSION['username'])){	//Eseguo controllo solo se la sessione è scaduta e se l'autologin è attivo
		require_once('db.php');
		$dbHandler = new db_handler();
		$cookie = explode("%", $_COOKIE['autologin']);
		$id = $cookie[0];
		$token = $cookie[1];
		$token = hash('sha256',$token);
		try {
			$user = $dbHandler->checkCookie($id, $token);
			if ($user['scadenza_cookie'] > time()) {
				//Utente loggato
				$_SESSION['email'] = $user['email'];
				$_SESSION['username'] = $user['username'];
				//Modifico scadenza cookie e token
				$token_rand = rand();
				$token_new = hash('sha256',$token_rand);
				$expire_time = time()+60*60*7;
				setcookie('autologin', $id."%".$token_rand, $expire_time);
				$dbHandler->setCookieValue($user['username'], $id, $token_new, $expire_time);
			}
		} catch (Exception $e) {
			echo $e;
		}
	}
?>