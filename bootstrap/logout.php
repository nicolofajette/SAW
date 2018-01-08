<?php 
	session_start();
	require_once('db.php');
	$dbHandler = new db_handler();
	try {
		$dbHandler->setCookieValue($_SESSION['username'], 0, null, null);
		$_SESSION = array(); 
		session_destroy(); 
		setcookie('autologin', null, time()-60*60*7);
		header("location: index.php");
	} catch (Exception $e) {
		echo $e;
	}
	//exit();
?>