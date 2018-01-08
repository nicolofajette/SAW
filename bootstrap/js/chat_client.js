function getXMLHttpRequestObject() {  //Restituisce l'oggetto XMLHttpRequest che consente di eseguire chiamata HTTP tramite js
  var request = null;
  if (window.XMLHttpRequest) {
    request = new XMLHttpRequest();
  } else if (window.ActiveXObject) { // Per retrocompatibilità con IE :(
    request = new ActiveXObject("MSXML2.XMLHTTP.3.0");
  }
  return request;
}

var last_msg_id = -1; //Id ultimo messaggio scaricato, all'inizio -1
var messages_array = [];
var me;
var user2;

function setMe(io){
  me = io;
}

function setOther(lui){
  user2 = lui;
}

function setChat(io, lui){
  me = io;
  user2 = lui;
  console.log("set chat");
}

function chat(){
  var xhttp = getXMLHttpRequestObject();
  var parametri = "destinatario="+user2+"&last_msg_id="+last_msg_id;  //Dati da passare tramite POST
  xhttp.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      conversationHandler(this); //Funzione da chiamare quando ottengo la risposta
    }
  };
  xhttp.open("POST", "chat.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");  //Aggiungo header HTTP alla richiesta
  xhttp.send(parametri);
}

//Funzione che gestisce le risposte alle richieste di chat http fatte
function conversationHandler(answer){
  if(answer.responseText != null){
    var response = answer.responseText; //Estraggo la risposta json ricevuta
    console.log(response);
    var responseObj = JSON.parse(response); //Trasformo la risposta json in un oggetto JavaScript
    console.log("Scaricato");
    if(responseObj.status == 1){
      for(var i in responseObj.conversation){
        var msg = responseObj.conversation[i];
        var id = msg['id'];
        var mittente = msg['Mittente'];
        var destinatario = msg['Destinatario'];
        var testo = msg['Testo'];
        var invio = msg['Data'];
        var visualizzato = msg['Visualizzato'];
        var messaggio = {mittente:msg['Mittente'], destinatario:msg['Destinatario'], testo:msg['Testo'], invio:msg['Data']};
        var obj = document.createElement("div");
        var textObj = document.createTextNode(invio + " - " + testo);
        obj.appendChild(textObj);
				var li = document.createElement("li");
				li.className = "message";
				if(mittente == me){
					li.className = "message right";
				}else{
					li.className = "message left";
				}
				var wrapper = document.createElement("div");
				wrapper.className = "text_wrapper";
				if(visualizzato == false && mittente != me){
					var tick = document.createElement("span");
					tick.className = "glyphicon glyphicon-certificate";
					tick.style.color = "blue";
					li.appendChild(tick);
				}
				var text = document.createElement("div");
				obj.className = "text";
				wrapper.appendChild(obj);
				li.appendChild(wrapper);
				
				document.getElementById("messages").appendChild(li);
        //document.getElementById("chatbox").appendChild(obj);
        messages_array.push(messaggio);
      }
			
			var objDiv = document.getElementById("messages");	
			objDiv.scrollTop = objDiv.scrollHeight;
      last_msg_id = responseObj.last_msg_id;  //Id ultimo messaggio scaricato
      console.log("id ultimo messaggio: " + last_msg_id);
    }else{
      //Nessun nuovo messaggio
    }
  }else{
    //Nessun dato ricevuto
    console.log("Nessun dato ricevuto");
  }
  console.log("last_msg_id: " + last_msg_id);
}

function sendMsg(destinatario, testo){
  var xhttp = getXMLHttpRequestObject();
  var parametri = "destinatario="+destinatario+"&testo="+testo;  //Dati da passare tramite POST
  xhttp.onreadystatechange = sendMsgHandler(); //Funzione da chiamare quando ottengo la risposta
  xhttp.open("POST", "send_chat_msg.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");  //Aggiungo header HTTP alla richiesta
  xhttp.send(parametri);
}

function sendMsgHandler(){
  if (this.readyState == 4 && this.status == 200) {
    if(this.responseText != null){
      var response = this.responseText; //Estraggo la risposta json ricevuta
      var responseObj = JSON.parse(response); //Trasformo la risposta json in un oggetto JavaScript
      if(responseObj.status == "sent"){
        //Messaggio inviato con successo
      }else{
        //Errore invio messaggio
      }
    }else{
      //Nessun dato trasmesso
    }
  }else{
    //errore AJAX
  }
}