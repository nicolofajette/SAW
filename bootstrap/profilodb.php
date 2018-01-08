<?php 
	include("autologin.php");
	if(!isset($_SESSION['username'])){
	//Utente non loggato
	header('Location: index.php');
	}
	$username = $_SESSION['username'];
	if(isset($_POST['btn_image'])) {
		if ($_FILES['userfile']['size'] > 0) {
			if($_FILES['userfile']['size'] > 8388607) {
				header('Location: profilo.php?errore=immagine troppo grande');
			} else {
				$allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "PNG");
				$extension = end(explode(".", $_FILES["userfile"]["name"]));
				if (in_array($extension, $allowedExts)) {
					$tmpName  = $_FILES['userfile']['tmp_name'];
					$fp = fopen($tmpName, 'r');
					$content = fread($fp, filesize($tmpName));
					$content = addslashes($content);
					fclose($fp);
				
					require_once('db.php');
					$dbHandler = new db_handler();
					try {
						if($dbHandler->updateImage($username,$content)) {
							header('Location: profilo.php');
						}
					} catch(Exception $e) {
						header('Location: profilo.php?errore=errore aggiornamento');
					}
				} else {
					header('Location: profilo.php?errore=estensione non supportata');
				}
			}
		} else {
			header('Location: profilo.php?errore=errore caricamento, nessun file');
		}
	} else if(isset($_POST['btn-invia'])) {
		$error = 0;
		$password_cond = false;
		if (isset($_POST['email']) && !empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$email = trim($_POST['email']);
			} else {
			//campo email vuoto o email che non segue il formato
			$error = 1;		
		}
		$indirizzo = trim($_POST['indirizzo']);
		$luogo = trim($_POST['luogo']);
		$informazioni = trim($_POST['informazioni']);
		$facebook = trim($_POST['facebook']);
		$twitter = trim($_POST['twitter']);
		$instagram = trim($_POST['instagram']);
		if (isset($_POST['old_password']) && !empty($_POST['old_password'])) {
			$pwd_o = trim($_POST['old_password']);
			if (isset($_POST['new_password']) && !empty($_POST['new_password'])) {
				$pwd_n = trim($_POST['new_password']);
				if ($pwd_o != $pwd_n) {
					if (isset($_POST['confirm_password']) && !empty($_POST['confirm_password'])) {
						$pwd_c = trim($_POST['confirm_password']);
						if ($pwd_n == $pwd_c) {
							$password_cond= true;
						} else {
							$error = 2; //conferma diversa
						}
					} else {
						$error = 1; //conferma mancante 
					}
				} else {
					$error = 3;  //password nuova uguale a quella vecchia
				}
			} else {
				$error = 1; //nuova password mancante
			}
		} else if (isset($_POST['new_password']) && !empty($_POST['new_password'])) {
			$error = 4; //vecchia password mancante 
		}
			
		if($error == 0){
			require_once('db.php');
			$dbHandler = new db_handler();
			if($email != $_SESSION['email'] && $dbHandler->checkUserExist($email)){
				echo "email gi&agrave; in uso";
			} else{
				try {
					$user = $dbHandler->getUserInfoUsername($username);
					$pwd = null;
					if($user != null){
						if (!$password_cond) {
							if($dbHandler->updateUser($username, $email, $indirizzo, $luogo, $informazioni, $facebook, $twitter, $instagram, $user['password'])){
								//Aggiornamento ok
								$_SESSION['email'] = $email;
								echo "ok";
							} else {
								echo "errore aggiornamento";
							}
						} else {
							if(password_verify($pwd_o, $user['password']) == true){
								if($dbHandler->updateUser($username, $email, $indirizzo, $luogo, $informazioni, $facebook, $twitter, $instagram, password_hash($pwd_n, PASSWORD_DEFAULT))){
									//Aggiornamento ok
									$_SESSION['email'] = $email;
									echo "ok";
								} else {
									echo "errore aggiornamento";
								}
							} else {	
								echo "vecchia password sbagliata";
							}
						}
					} else {
						echo "errore aggiornamento";
					}
				} catch(Exception $e){
					echo "errore aggiornamento";
				}
			}
		} else if ($error == 2) {
			echo "password non coincidenti";
		} else if ($error == 3) {
			echo "password vecchia e nuova sono uguali";
		} else if ($error == 4) {
			echo "errore vecchia password mancante";
		} else {
			echo "errore aggiornamento";
		}
	} else if (isset($_POST['cancella'])) {
		$id = $_POST['id'];
		require_once('db.php');
		$dbHandler = new db_handler();
		try {
			if($dbHandler->deleteReport($id)) {
				echo "ok";
			} 
		} catch (Exception $e){
			echo "errore cancellazione";
		}
	} else if (isset($_POST['cancellaRate'])) {
		$id = $_POST['id'];
		require_once('db.php');
		$dbHandler = new db_handler();
		try {
			if($dbHandler->deleteRate($id)) {
				echo "ok";
			} 
		} catch (Exception $e){
			echo "errore cancellazione";
		}
	} 
?>