<?php
  include("autologin.php");
  if(!isset($_SESSION['username'])){
    //Utente non loggato
    header('Location: index.php');
  }
  $user1 = $_SESSION['username'];  //Username utente 1
  $user2 = $_SESSION['receiver']; //Username utente 2
  $lastMsgId = (int) $_POST['last_msg_id']; //id ultimo messaggio scaricato
  require_once("db.php");
  $dbHandler = new db_handler();
  try{
    if($lastMsgId == -1){
      //Ancora nessun messaggio scaricato, devo scaricare tutti
      $response = $dbHandler->getConversation($user1, $user2);
    }else{
      //Scarico solo quelli successivi all'id dell'ultimo scaricato
      $response = $dbHandler->getConversationUpdates($user1, $user2, $lastMsgId);
    }
    $conversation = array();
    $lastId = -1;
		$jsonObj = new stdClass();	//Serve per creare una classe generca così da eliminare alert quando setto proprietà ad un oggetto non ancora creato
    if($response == null){
			//nessun messaggio da scaricare
			$jsonObj->status = 0;
		}else{
			$unreadMessages = array();
			foreach($response as $row){
				$msg = array("id"=>$row['id'], "Mittente"=>$row['mittente'], "Destinatario"=>$row['destinatario'], "Testo"=>$row['testo'], "Data"=>$row['data_invio'], "Visualizzato"=>$row['visualizzato']);
				array_push($conversation, $msg);  //Aggiungo il messaggio all'array contenente i messaggi della conversazione
				$lastId = $row['id']; //Tengo traccia dell'ultimo id del messaggio
				if($row['visualizzato'] == false && $row['destinatario'] == $_SESSION['username']){
					array_push($unreadMessages, $row['id']);	//Tengo traccia dei messaggi che mi hanno inviato che non ho ancora letto
				}
			}
			$jsonObj->status = 1;
			$jsonObj->conversation = $conversation;
			$jsonObj->last_msg_id = $lastId;
			try{
				$dbHandler->setMessagesAsRead($unreadMessages);
			}catch(Exception $e){
				$jsonObj->status = 0;
			}
			
		}
		$JSON_response = json_encode($jsonObj);  //Converto in JSON l'array contenente la conversazione
    echo $JSON_response;  //Stampo la risposta
  }catch(Exception $e){
    echo $e;
  }
?>