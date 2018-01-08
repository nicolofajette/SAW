<?php
  include("autologin.php");
  if(!isset($_SESSION['username'])){
    //Utente non loggato
    header('Location: index.php');
  }
  $mittente = $_SESSION['username'];  //Username utente 1
  $destinatario = $_SESSION['receiver']; //Username utente 2
  $testo = $_POST['testo'];
  echo $mittente;
  echo $destinatario;
  echo $testo;
  require_once('db.php');
  $dbHandler = new db_handler();
  try{
    if($dbHandler->addMsg($mittente, $destinatario, $testo) === true){
      $responseObj->status = "sent";
	  echo "sent";
    }else{
      $responseObj->status = "error";
	  echo "error";
    }
  }catch(Exception $e){
    $responseObj->status = "error";
  }
  echo json_encode($responseObj); //Stampo la risposta
?>
