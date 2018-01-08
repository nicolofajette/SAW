<?php
	define("USER_TABLE", "utenti");
	define("USER_TABLE_ID", "id");
	define("USER_TABLE_NAME", "nome");
	define("USER_TABLE_SURNAME", "cognome");
	define("USER_TABLE_DATE", "data");
	define("USER_TABLE_PLACE", "luogo");
	define("USER_TABLE_ADDRESS", "indirizzo");
	define("USER_TABLE_EMAIL", "email");
	define("USER_TABLE_USERNAME", "username");
	define("USER_TABLE_PASSWORD", "password");
	define("USER_TABLE_INFORMATION", "informazioni");
	define("USER_TABLE_FACEBOOK", "facebook");
	define("USER_TABLE_TWITTER", "twitter");
	define("USER_TABLE_INSTAGRAM", "instagram");
	define("USER_TABLE_IMAGE", "immagine");
	define("USER_TABLE_COOKIE_SERIES", "cookie_series");
	define("USER_TABLE_COOKIE_TOKEN", "cookie_token");
	define("USER_TEBLE_EXPIRE_COOKIE", "scadenza_cookie");
	define("USER_TABLE_BANNED", "bloccato");
	define("USER_TABLE_ADMIN", "admin");

	define("CHAT_TABLE", "chat");
	define("CHAT_TABLE_ID", "id_msg");
	define("CHAT_TABLE_SEND", "mittente");
	define("CHAT_TABLE_RECEIVE", "destinatario");
	define("CHAT_TABLE_TEXT", "testo");
	define("CHAT_TABLE_SEND_TIME", "data_invio");
	define("CHAT_TABLE_VIEWED", "visualizzato");

	define("REPORTS_TABLE", "segnalazioni");
	define("REPORTS_TABLE_ID", "id_segn");
	define("REPORTS_TABLE_SSID", "SSID");
	define("REPORTS_TABLE_TYPE", "tipologia");
	define("REPORTS_TABLE_LOCATION", "posizione");
	define("REPORTS_TABLE_REPORTER", "segnalatore");
	
	define("RATING_TABLE", "rating");
	define("RATING_TABLE_ID", "id_rate");
	define("RATING_TABLE_SEGNALATION", "id_segnalazione");
	define("RATING_TABLE_RATE", "rate");
	define("RATING_TABLE_USERNAME", "utente");
	
	class db_handler{
		
		
		private $conn = null;	//Variabile di connessione, null se nessuna connessione
		
		private function startConn(){
			require('mysqlconn.php');
			$this->conn = new mysqli($servername, $usernamedb, $passworddb, $db);
			if(mysqli_connect_error()){
				return false;
			}else{
				return true;
			}
		}
		
		private function endConn(){
			$this->conn->close();
		}
		
		public function insertUser($nome, $cognome, $data, $email, $username, $password){
			if($this->checkUserExist($email) == false){
				//Utente non presente nel db
				if($this->startConn()){
					$query = "INSERT INTO ".USER_TABLE." (".USER_TABLE_NAME.", ".USER_TABLE_SURNAME.", ".USER_TABLE_DATE.", ".USER_TABLE_EMAIL.", ".USER_TABLE_USERNAME.", ".USER_TABLE_PASSWORD.") VALUES (?, ?, ?, ?, ?, ?)";
					$stmt = $this->conn->prepare($query);
					//Eseguo la sanitizzazione dei dati
					$nome = $this->conn->real_escape_string($nome);
					$cognome = $this->conn->real_escape_string($cognome);
					$data = $this->conn->real_escape_string($data);
					$data_formatted = date("Y-m-d", strtotime($data));
					$email = $this->conn->real_escape_string($email);
					$username = $this->conn->real_escape_string($username);
					if($stmt) { 
							$stmt->bind_param("ssssss", $nome, $cognome, $data_formatted, $email, $username, $password);
					}else{
						$this->endConn();
						return false;
					}
					if(!$stmt->execute()){
						//Errore nell'esecuzione dello statement
						$stmt->close();
						$this->endConn();
						return false;
					}else{
						$stmt->close();
						$this->endConn();
						return true;
					}
				}else{
					return false;
				}
			}
		}
		
		public function checkUserExist($email){
			if($this->startConn()){
				$email = $this->conn->real_escape_string($email);
				$sql = "SELECT * FROM ".USER_TABLE." WHERE ".USER_TABLE_EMAIL." = ?";
				$stmt = $this->conn->prepare($sql);
				if($stmt){
					$stmt->bind_param("s", $email);
					$result = $stmt->execute();
					if(!$result){
						//Errore esecuzione statement
						$stmt->close();
						$this->endConn();
						throw new Exception("Errore esecuzione statement");
					}else{
						$stmt->store_result();
						if($stmt->num_rows == 1){
							$stmt->close();
							$this->endConn();
							return true;
						}else{
							//Utente inesistente
							$stmt->close();
							$this->endConn();
							return false;
						}
					}
				}else{
					//Errore preparazione statement
					$this->endConn();
					throw new Exception("Errore preparazione statement");
				}
			}else{
				throw new Exception("Errore connessione");
			}
		}
		
		public function checkUsernameUsed($username){
			if($this->startConn()){
				$username = $this->conn->real_escape_string($username);
				$sql = "SELECT * FROM ".USER_TABLE." WHERE ".USER_TABLE_USERNAME." = ?";
				$stmt = $this->conn->prepare($sql);
				if($stmt){
					$stmt->bind_param("s", $username);
					$result = $stmt->execute();
					if(!$result){
						$stmt->close();
						$this->endConn();
						throw new Exception("Errore esecuzione statement");
					}else{
						$stmt->store_result();
						if($stmt->num_rows == 1){
							$stmt->close();
							$this->endConn();
							return true;
						}else{
							$stmt->close();
							$this->endConn();
							return false;
						}
					}
				}else{
					//Errore preparazione statement
					$this->endConn();
					throw new Exception("Errore preparazione statement");
				}
			}else{
				$this->endConn();
				throw new Exception("Errore connessione");
			}
		}
		
		public function getUserInfo($email){
			if($this->startConn()){
				$email = $this->conn->real_escape_string($email);
				$sql = "SELECT * FROM ".USER_TABLE." WHERE ".USER_TABLE_EMAIL." = ?";
				$stmt = $this->conn->prepare($sql);
				if($stmt){
					$stmt->bind_param("s", $email);
					$result = $stmt->execute();
					if(!$result){
						$stmt->close();
						$this->endConn();
						throw new Exception("Errore esecuzione statement");
					}else{
						$stmt->store_result();
						if($stmt->num_rows == 1){
							$stmt->bind_result($nome, $cognome, $data, $luogo, $indirizzo, $email, $username, $password, $informazioni, $facebook, $twitter, $instagram, $immagine, $cookie_series, $cookie_token, $scadenza_token, $bloccato, $admin);
							$stmt->fetch();
							$row = array("nome"=>$nome, "cognome"=>$cognome, "data"=>$data, "luogo"=>$luogo, "indirizzo"=>$indirizzo, "email"=>$email, "username"=>$username, "password"=>$password, "informazioni"=>$informazioni, "facebook"=>$facebook, "twitter"=>$twitter, "instagram"=>$instagram, "immagine"=>$immagine, "cookie_series"=>$cookie_series, "cookie_token"=>$cookie_token, "scadenza_token"=>$scadenza_token, "bloccato"=>$bloccato, "admin"=>$admin);
							$stmt->close();
							$this->endConn();
							return $row;
						}else{
							$stmt->close();
							$this->endConn();
							return null;
						}
					}
				}else{
					$this->endConn();
					throw new Exception("Errore preparazione statement");
				}
			}else{
				throw new Exception("Errore connessione");
			}
		}
		
		public function getUserInfoUsername($username){
			if($this->startConn()){
				$username = $this->conn->real_escape_string($username);
				$sql = "SELECT * FROM ".USER_TABLE." WHERE ".USER_TABLE_USERNAME." = ?";
				$stmt = $this->conn->prepare($sql);
				if($stmt){
					$stmt->bind_param("s", $username);
					$result = $stmt->execute();
					if(!$result){
						$stmt->close();
						$this->endConn();
						throw new Exception("Errore esecuzione statement");
					}else{
						$stmt->store_result();
						if($stmt->num_rows == 1){
							$stmt->bind_result($nome, $cognome, $data, $luogo, $indirizzo, $email, $username, $password, $informazioni, $facebook, $twitter, $instagram, $immagine, $cookie_series, $cookie_token, $scadenza_token, $bloccato, $admin);
							$stmt->fetch();
							$row = array("nome"=>$nome, "cognome"=>$cognome, "data"=>$data, "luogo"=>$luogo, "indirizzo"=>$indirizzo, "email"=>$email, "username"=>$username, "password"=>$password, "informazioni"=>$informazioni, "facebook"=>$facebook, "twitter"=>$twitter, "instagram"=>$instagram, "immagine"=>$immagine, "cookie_series"=>$cookie_series, "cookie_token"=>$cookie_token, "scadenza_token"=>$scadenza_token, "bloccato"=>$bloccato, "admin"=>$admin);
							$stmt->close();
							$this->endConn();
							return $row;
						}else{
							$stmt->close();
							$this->endConn();
							throw new Exception("Errore nessun utente");
						}
					}
				}else{
					$this->endConn();
					throw new Exception("Errore preparazione statement");
				}
			}else{
				throw new Exception("Errore connessione");
			}
		}
		
		public function updateUser($username, $email, $indirizzo, $luogo, $informazioni, $facebook, $twitter, $instagram, $password){
			if($this->checkUsernameUsed($username)){
				if($this->startConn()){
					$username = $this->conn->real_escape_string($username);
					$email = $this->conn->real_escape_string($email);
					$indirizzo = $this->conn->real_escape_string($indirizzo);
					$luogo = $this->conn->real_escape_string($luogo);
					$informazioni = $this->conn->real_escape_string($informazioni);
					$facebook = $this->conn->real_escape_string($facebook);
					$twitter = $this->conn->real_escape_string($twitter);
					$instagram = $this->conn->real_escape_string($instagram);
					$password = $this->conn->real_escape_string($password);
					$query = "UPDATE ".USER_TABLE." SET ".USER_TABLE_EMAIL." = ?, ".USER_TABLE_ADDRESS." = ?, ".USER_TABLE_PLACE." = ?, ".USER_TABLE_INFORMATION." = ?, ".USER_TABLE_FACEBOOK." = ?, ".USER_TABLE_TWITTER." = ?, ".USER_TABLE_INSTAGRAM." = ?, ".USER_TABLE_PASSWORD." = ? WHERE ".USER_TABLE_USERNAME." = ?";
					$stmt = $this->conn->prepare($query);
					if($stmt){
						//preparazione statement ok
						$stmt->bind_param("sssssssss", $email, $indirizzo, $luogo, $informazioni, $facebook, $twitter, $instagram, $password, $username);
						if(!$stmt->execute()){
							//Errore esecuzione statement
							$stmt->close();
							$this->endConn();
							return false;	
						}else{
							$stmt->close();
							$this->endConn();
							return true;
						}
					}else{
						//Errore preparazione statement
						$this->endConn();
						return false;						
					}
				}else{
					//Errore connessione
					return false;
				}
			}else{
				//Errore utente inesistente
				return false;
			}
		}
		
		public function updateImage($username, $image) {
			if($this->checkUsernameUsed($username)){
				if($this->startConn()){
					$username = $this->conn->real_escape_string($username);
					$sql = "UPDATE ".USER_TABLE." SET ".USER_TABLE_IMAGE." = '".$image."' WHERE ".USER_TABLE_USERNAME." = '".$username."'";
					if ($this->conn->query($sql) === TRUE) {
						$this->endConn();
						return true;
					}else{
						$this->endConn();
						throw new Exception("Errore aggiornamento");	
					}
				}else{
					//Errore connessione
					throw new Exception("Errore connessione");
				}
			} else{
				//Errore utente inesistente
				throw new Exception("Utente inesistente");
			}
		}					
		
		public function setCookieValue($username, $series, $token, $timestamp){
			if($this->checkUsernameUsed($username)){
				if($this->startConn()){
					$username = $this->conn->real_escape_string($username);
					$series = (int) $series;
					$token = $this->conn->real_escape_string($token);
					$timestamp = $this->conn->real_escape_string($timestamp);
					$query = "UPDATE ".USER_TABLE." SET ".USER_TABLE_COOKIE_SERIES." = ?, ".USER_TABLE_COOKIE_TOKEN." = ?, ".USER_TEBLE_EXPIRE_COOKIE." = ? WHERE ".USER_TABLE_USERNAME." = ?";
					$stmt = $this->conn->prepare($query);
					if($stmt){
						$stmt->bind_param("isss", $series, $token, $timestamp, $username);
						$result = $stmt->execute();
						if($result){
							$stmt->close();
							$this->endConn();
							return true;
						}else{
							$stmt->close();
							$this->endConn();
							throw new Exception("Errore esecuzione statement");
						}
					}else{
						throw new Exception("Errore preparazione statement");
					}
				}else{
					throw new Exception("Errore connessione");
				}
			}else{
				throw new Exception("Username inesistente");
			}
		}
			
		public function checkCookie($series, $token){
			if($this->startConn()){
				$series = (int) $series;
				$token = $this->conn->real_escape_string($token);
				$query = "SELECT ".USER_TABLE_EMAIL.", ".USER_TABLE_USERNAME.", ".USER_TEBLE_EXPIRE_COOKIE." FROM ".USER_TABLE." WHERE ".USER_TABLE_COOKIE_SERIES." = ? AND ".USER_TABLE_COOKIE_TOKEN." = ? ";
				$stmt = $this->conn->prepare($query);
				if($stmt){
					$stmt->bind_param("is", $series, $token);
					$result = $stmt->execute();
					if(!$result){
						//Errore esecuzione statement
						$stmt->close();
						$this->endConn();
						throw new Exception("Errore esecuzione statement");
					}else{
						//Statement eseguito con successo
						$stmt->store_result();
						if($stmt->num_rows == 1){
							$stmt->bind_result($email, $username, $scadenza_cookie);
							$stmt->fetch();
							$row = array("email"=>$email, "username"=>$username, "scadenza_cookie"=>$scadenza_cookie);
							$stmt->close();
							$this->endConn();
							return $row;
						}else{
							//Nessun cookie
							$stmt->close();
							$this->endConn();
							throw new Exception("Nessun cookie");
						}
					}
				}else{
					$this->endConn();
					throw new Exception("Errore preparazione statement");
				}
			} else{
				throw new Exception("Errore connessione");
			}
		}
		
		public function getBannedUser() {
			if($this->startConn() == false){
				throw new Exception("Errore connessione db");
			}else {
				$query = "SELECT ".USER_TABLE_USERNAME.", ".USER_TABLE_EMAIL." FROM ".USER_TABLE." WHERE ".USER_TABLE_BANNED." = 1";
				$stmt = $this->conn->prepare($query);
				if($stmt){
					$result = $stmt->execute();
					if(!$result){
						//Errore esecuzione statement
						$stmt->close();
						$this->endConn();
						throw new Exception("Errore esecuzione statement");
					}else{
						//Statement eseguito con successo
						$stmt->store_result();
						if($stmt->num_rows >= 1){
							$stmt->bind_result($username,$email);
							$response = array();
							while($stmt->fetch()){
								$row = array("username"=>$username, "email"=>$email);
								array_push($response, $row);
							}
							$stmt->close();
							$this->endConn();
							return $response;
						}else{
							//Nessun utente bannato
							$stmt->close();
							$this->endConn();
							return null;
						}
					}
				}else{
					$this->endConn();
					throw new Exception("Errore preparazione statement");
				}
			}
		}
		
		public function banUser($username, $ban_sban) {
			if($this->checkUsernameUsed($username)){
				if($this->startConn()){
					$username = $this->conn->real_escape_string($username);
					$query = "UPDATE ".USER_TABLE." SET ".USER_TABLE_BANNED." = ? WHERE ".USER_TABLE_USERNAME." = ?";
					$stmt = $this->conn->prepare($query);
					if($stmt){
						$stmt->bind_param("is", $ban_sban, $username);
						$result = $stmt->execute();
						if($result){
							$stmt->close();
							$this->endConn();
							return true;
						}else{
							$stmt->close();
							$this->endConn();
							throw new Exception("Errore esecuzione statement");
						}
					}else{
						throw new Exception("Errore preparazione statement");
					}
				}else{
					throw new Exception("Errore connessione");
				}
			}else{
				return false;
			}
		}
		
		//-------------------------------------------FUNZIONI INTERAZIONE TABELLA CHAT-------------------------------------------------
		public function addMsg($sender, $receiver, $text){
			if($this->checkUsernameUsed($sender) && $this->checkUsernameUsed($receiver)){
				//Mittente e destinatario esistono
				if($this->startConn() == false){
					//errore connessione al db
					throw new Exception("Errore connessione al db");
				}else{
					$sender = $this->conn->real_escape_string($sender);
					$receiver = $this->conn->real_escape_string($receiver);
					$text = $this->conn->real_escape_string($text);
					$query = "INSERT INTO ".CHAT_TABLE." (".CHAT_TABLE_SEND.", ".CHAT_TABLE_RECEIVE.", ".CHAT_TABLE_TEXT.") VALUES (?, ?, ?)";
					$stmt = $this->conn->prepare($query);
					if($stmt){
						//Statement preparato
						$stmt->bind_param("sss", $sender, $receiver, $text);
					}else{
						//Errore preparazione statement
						$this->endConn();
						throw new Exception("Errore preparazione statement");
					}
					if(!$stmt->execute()){
						//Errore esecuzione statement
						$stmt->close();
						$this->endConn();
						throw new Exception("Errore esecuzione statement");
					}else{
						//Statement eseguito con successo
						$stmt->close();
						$this->endConn();
						return true;
					}
				}
			}else{
				//Errore: mittente o destinatario inesistente
				throw new Exception("Mittente o destinatario inesistente");
			}
		}
		
		public function getOpenConversations($user){
			if($this->checkUsernameUsed($user)){
				if($this->startConn() == false){
					throw new Exception("Errore connessione db");
				}else{
					$user = $this->conn->real_escape_string($user);
					$query = "(SELECT ".CHAT_TABLE_RECEIVE." FROM ".CHAT_TABLE." WHERE ".CHAT_TABLE_SEND." = ? GROUP BY ".CHAT_TABLE_RECEIVE.") UNION (SELECT ".CHAT_TABLE_SEND." FROM ".CHAT_TABLE." WHERE ".CHAT_TABLE_RECEIVE." = ? GROUP BY ".CHAT_TABLE_SEND.")";
					$stmt = $this->conn->prepare($query);
					if($stmt){
						$stmt->bind_param("ss", $user, $user);
						$result = $stmt->execute();
						if(!$result){
							//Errore esecuzione statement
							$stmt->close();
							$this->endConn();
							throw new Exception("Errore esecuzione statement");
						}else{
							//Statement eseguito con successo
							$stmt->store_result();
							if($stmt->num_rows >= 1){
								$stmt->bind_result($chatReceiver);
								$response = array();
								while($stmt->fetch()){
									$row = array("user"=>$chatReceiver);
									array_push($response, $row);
								}
								$stmt->close();
								$this->endConn();
								return $response;
							}else{
								//Nessuna conversazione iniziata
								$stmt->close();
								$this->endConn();
								return null;
							}
						}
					}else{
						$this->endConn();
						throw new Exception("Errore preparazione statement");
					}
				}
			}else{
				throw new Exception("Utente inesistente");
			}
		}
		
		public function getAllMessages($user){
			if($this->checkUsernameUsed($user)){
				if($this->startConn()){
					$user = $this->conn->real_escape_string($user);
					$query = "SELECT * FROM ".CHAT_TABLE." WHERE ".CHAT_TABLE_SEND." = ? OR ".CHAT_TABLE_RECEIVE." = ? ORDER BY ".CHAT_TABLE_SEND_TIME;
					$stmt = $this->conn->prepare($query);
					if(!$stmt){
						//Errore preparazione statement
						$this->endConn();
						throw new Exception("Errore preparazione statement");
					}else{
						//Statement preparato
						$stmt->bind_param("ss", $user, $user);
						$result = $stmt->execute();
						if(!$result){
							//Errore esecuzione statement
							$stmt->close();
							$this->endConn();
							throw new Exception("Errore esecuzione statement");
						}else{
							$stmt->store_result();
							$stmt->close();
							$this->endConn();
							return $result;
						}
					}
				}else{
					//Errore connessione db
					throw new Exception("Errore connessione al db");
				}
			}else{
				//Utente inesistente
				throw new Exception("Utente inesistente");
			}
		}
		
		public function getConversation($user1, $user2){
			if($this->checkUsernameUsed($user1) && $this->checkUsernameUsed($user2)){
				if(!$this->startConn()){
					throw new Exception("Errore connessione");
				}
				$user1 = $this->conn->real_escape_string($user1);
				$user2 = $this->conn->real_escape_string($user2);
				$query = "SELECT * FROM ".CHAT_TABLE." WHERE (".CHAT_TABLE_SEND." = ? AND ".CHAT_TABLE_RECEIVE." = ?) OR (".CHAT_TABLE_SEND." = ? AND ".CHAT_TABLE_RECEIVE." = ?) ORDER BY ".CHAT_TABLE_SEND_TIME;
				$stmt = $this->conn->prepare($query);
				if(!$stmt){
					$this->conn->endConn();
					throw new Exception("Errore preparazione statement");
				}
				$stmt->bind_param("ssss", $user1, $user2, $user2, $user1);
				$result = $stmt->execute();
				if(!$result){
					$stmt->close();
					$this->conn->endConn();
					throw new Exception("Errore esecuzione statement");
				}
				$stmt->store_result();
				if($stmt->num_rows >= 1){
					$stmt->bind_result($id_msg, $mittente, $destinatario, $testo, $data_invio, $visualizzato);
					$response = array();
					while($stmt->fetch()){
						$row = array("id"=>$id_msg, "mittente"=>$mittente, "destinatario"=>$destinatario, "testo"=>$testo, "data_invio"=>$data_invio, "visualizzato"=>$visualizzato);
						array_push($response, $row);
					}
					$stmt->close();
					$this->endConn();
					return $response;	
				}else{
					$stmt->close();
					$this->endConn();
					return null;
				}
			}else{
				throw new Exception("Utente inesistente");
			}
		}
		
		public function getConversationUpdates($user1, $user2, $last_downloaded_id){
			if($this->checkUsernameUsed($user1) && $this->checkUsernameUsed($user2)){
				if(!$this->startConn()){
					throw new Exception("Errore connessione");
				}
				$user1 = $this->conn->real_escape_string($user1);
				$user2 = $this->conn->real_escape_string($user2);
				$last_downloaded_id = (int) $last_downloaded_id;
				$query = "SELECT * FROM ".CHAT_TABLE." WHERE ( (".CHAT_TABLE_SEND." = ? AND ".CHAT_TABLE_RECEIVE." = ?) OR (".CHAT_TABLE_SEND." = ? AND ".CHAT_TABLE_RECEIVE." = ?) ) AND ".CHAT_TABLE_ID." > ? ORDER BY ".CHAT_TABLE_SEND_TIME;
				$stmt = $this->conn->prepare($query);
				if(!$stmt){
					$this->conn->endConn();
					throw new Exception("Errore preparazione statement");
				}
				$stmt->bind_param("ssssi", $user1, $user2, $user2, $user1, $last_downloaded_id);
				$result = $stmt->execute();
				if(!$result){
					$stmt->close();
					$this->conn->endConn();
					throw new Exception("Errore esecuzione statement");
				}
				$stmt->store_result();
				if($stmt->num_rows >= 1){
					$stmt->bind_result($id_msg, $mittente, $destinatario, $testo, $data_invio, $visualizzato);
					$response = array();
					while($stmt->fetch()){
						$row = array("id"=>$id_msg, "mittente"=>$mittente, "destinatario"=>$destinatario, "testo"=>$testo, "data_invio"=>$data_invio, "visualizzato"=>$visualizzato);
						array_push($response, $row);
					}
					$stmt->close();
					$this->endConn();
					return $response;
				}else{
					$stmt->close();
					$this->endConn();
					return null;
				}
			}else{
				throw new Exception("Utente inesistente");
			}
		}
		
		public function getUnreadMessagesNumber($user){
			if($this->checkUsernameUsed($user)){
				if(!$this->startConn()){
					throw new Exception("Errore connessione al db");
				}
				$query = "SELECT * FROM ".CHAT_TABLE." WHERE ".CHAT_TABLE_RECEIVE." = ? AND ".CHAT_TABLE_VIEWED." = False";
				$stmt = $this->conn->prepare($query);
				if($stmt){
					//Statement preparato
					$stmt->bind_param("s", $user);
					if(!$stmt->execute()){
						$stmt->close();
						$this->endConn();
						throw new Exception("Errore esecuzione statement");
					}
					$stmt->store_result();
					$num = $stmt->num_rows;
					$stmt->close();
					$this->endConn();
					return $num;
				}else{
					$this->endConn();
					throw new Exception("Errore preparazione statement");
				}
			}else{
				throw new Exception("Utente inesistente");
			}
		}
		
		public function setMessagesAsRead($msgIdList){
			if($this->startConn()){
				$query = "UPDATE ".CHAT_TABLE." SET ".CHAT_TABLE_VIEWED." = True WHERE ".CHAT_TABLE_ID." = ? ";
				$stmt = $this->conn->prepare($query);
				if(!$stmt){
					$this->endConn();
					throw new Exception("Errore preparazione statement");
				}
				$msgId;
				$stmt->bind_param("i", $msgId);
				foreach($msgIdList as $msgId){
					if(!$stmt->execute()){
						throw new Exception("Errore esecuzione statement");
					}
				}
			}else{
				throw new Exception("Errore connessione al db");
			}
		}
		
		//-------------------------------------------FUNZIONI INTERAZIONE TABELLA SEGNALAZIONI E RATING-------------------------------------------------
		public function addReport($reporter, $position, $wifi_name, $type){
			if($this->checkUsernameUsed($reporter)){
				//Segnalatore esistente
				if($this->startConn() == false){
					//errore connessione al db
					throw new Exception("Errore connessione al db");
				}else{
					//Sanitizzazione dati
					$reporter = $this->conn->real_escape_string($reporter);
					$position = $this->conn->real_escape_string($position); //formato lat,lng
					$wifi_name = $this->conn->real_escape_string($wifi_name);
					$type = $this->conn->real_escape_string($type);
					$query = "INSERT INTO ".REPORTS_TABLE." (".REPORTS_TABLE_LOCATION.", ".REPORTS_TABLE_SSID.", ".REPORTS_TABLE_TYPE.", ".REPORTS_TABLE_REPORTER.") VALUES (?, ?, ?, ?)";
					$stmt = $this->conn->prepare($query);
					if($stmt){
						//Statement preparato
						$stmt->bind_param("ssss", $position, $wifi_name, $type, $reporter);
					}else{
						//Errore preparazione statement
						$this->endConn();
						throw new Exception("Errore preparazione statement");
					}
					if(!$stmt->execute()){
						//Errore esecuzione statement
						$stmt->close();
						$this->endConn();
						throw new Exception("Errore esecuzione statement");
					}else{
						//Statement eseguito con successo
						$stmt->close();
						$this->endConn();
						return true;
					}
				}
				
			}else{
				//Errore: mittente o destinatario inesistente
				throw new Exception("reporter inesistente");
			}
		}
		
		public function getUsernameReports($username) {
			if($this->checkUsernameUsed($username)){
				//Segnalatore esistente
				if($this->startConn() == false){
					//Errore avvio connessione
					throw new Exception("Errore connessione al db");
				} else {
					$username = $this->conn->real_escape_string($username);
					$query = "SELECT * FROM ".REPORTS_TABLE." WHERE ".REPORTS_TABLE_REPORTER." = ?";
					$stmt = $this->conn->prepare($query);
					if($stmt){
						//Statement preparato
						$stmt->bind_param("s", $username);
					}else{
						//Errore preparazione statement
						$this->endConn();
						throw new Exception("Errore preparazione statement");
					}
					if(!$stmt->execute()){
						//Errore esecuzione statement
						$stmt->close();
						$this->endConn();
						throw new Exception("Errore esecuzione statement");
					}else{
						//Statement eseguito con successo
						$stmt->store_result();
						if($stmt->num_rows >= 1){
							$stmt->bind_result($id, $SSID, $tipologia, $posizione, $segnalatore);
							$segnalazioni = array();
							while($stmt->fetch()){
								$segnalazione = array("id"=>$id, "SSID"=>$SSID, "tipologia"=>$tipologia, "posizione"=>$posizione, "segnalatore"=>$segnalatore);
								array_push($segnalazioni, $segnalazione);
							}
							$stmt->close();
							$this->endConn();
							return $segnalazioni;
						}else{
							//Nessuna segnalazione di quel tipo
							$stmt->close();
							$this->endConn();
							return null;
						}
					}
				}
			}
		}			
		
		public function getReports($filter, $username){
			if($this->startConn() == false){
				//Errore avvio connessione
				throw new Exception("Errore connessione al db");
			}
			$filter = $this->conn->real_escape_string($filter);
			if($filter == "Tutti"){
				//Restituisco tutte le segnalazioni
				$query = "SELECT ".REPORTS_TABLE_ID.", ".REPORTS_TABLE_SSID.", ".REPORTS_TABLE_TYPE.", ".REPORTS_TABLE_LOCATION.", ".REPORTS_TABLE_REPORTER.", AVG(".RATING_TABLE_RATE."), COUNT(".RATING_TABLE_SEGNALATION.") FROM ".REPORTS_TABLE." LEFT JOIN ".RATING_TABLE." ON ".REPORTS_TABLE.".".REPORTS_TABLE_ID." = ".RATING_TABLE.".".RATING_TABLE_SEGNALATION." GROUP BY ".REPORTS_TABLE_ID." ";
				$stmt = $this->conn->prepare($query);
				if(!$stmt){
					$this->endConn();
					throw new Exception("Errore preparazione statement");
				}
			}else{
				//Filtro tra Universitari o pubblici
				$query = "SELECT ".REPORTS_TABLE_ID.", ".REPORTS_TABLE_SSID.", ".REPORTS_TABLE_TYPE.", ".REPORTS_TABLE_LOCATION.", ".REPORTS_TABLE_REPORTER.", AVG(".RATING_TABLE_RATE."), COUNT(".RATING_TABLE_SEGNALATION.") FROM ".REPORTS_TABLE." LEFT JOIN ".RATING_TABLE." ON ".REPORTS_TABLE.".".REPORTS_TABLE_ID." = ".RATING_TABLE.".".RATING_TABLE_SEGNALATION." WHERE ".REPORTS_TABLE_TYPE." = ? GROUP BY ".REPORTS_TABLE_ID." ";
				$stmt = $this->conn->prepare($query);
				if($stmt){
					$stmt->bind_param("s", $filter);
				}else{
					$this->endConn();
					throw new Exception("Errore preparazione statement");
				}
			}
			if(!$stmt->execute()){
				//Errore esecuzione statement
				$stmt->close();
				$this->endConn();
				throw new Exception("Errore esecuzione statement");
			}else{
				//Statement eseguito con successo
				$stmt->store_result();
				if($stmt->num_rows >= 1){
					$stmt->bind_result($id, $SSID, $tipologia, $posizione, $segnalatore, $avg, $count);
					$segnalazioni = array();
					while($stmt->fetch()){
						if ($this->checkRate($id, $username)) {							
							$segnalazione = array("id"=>$id, "SSID"=>$SSID, "tipologia"=>$tipologia, "posizione"=>$posizione, "segnalatore"=>$segnalatore, "media"=>$avg, "conteggio"=>$count, "rated"=>true);
						} else {
							$segnalazione = array("id"=>$id, "SSID"=>$SSID, "tipologia"=>$tipologia, "posizione"=>$posizione, "segnalatore"=>$segnalatore, "media"=>$avg, "conteggio"=>$count, "rated"=>false);
						}
						array_push($segnalazioni, $segnalazione);
					}
					$stmt->close();
					return $segnalazioni;
				}else{
					//Nessuna segnalazione di quel tipo
					$stmt->close();
					$this->endConn();
					return null;
				}
			}
		}
		
		//é stata settata proprietà on delete cascade nel satabase alla tabella rating quindi eliminando una riga delle segnalazioni 
		//elimino dal database le rispettive valutazioni effettuate da altri utenti
		public function deleteReport($id) {
			if($this->startConn()){
				$id = (int) $id;
				$sql = "DELETE ".REPORTS_TABLE." FROM ".REPORTS_TABLE." WHERE ".REPORTS_TABLE_ID." = ?";
				$stmt = $this->conn->prepare($sql);
				if($stmt){
					//Statement preparato
					$stmt->bind_param("i", $id);
				}else{
					//Errore preparazione statement
					$this->endConn();
					throw new Exception("Errore preparazione statement");
				}
				if(!$stmt->execute()){
					//Errore esecuzione statement
					$stmt->close();
					$this->endConn();
					throw new Exception("Errore esecuzione statement");
				}else{
					//Statement eseguito con successo
					$stmt->close();
					$this->endConn();
					return true;
				}
			} else {
				//Errore avvio connessione
				throw new Exception("Errore connessione al db");
			}
		}	

		public function addRating($id_segnalation, $rate, $username){
			if($this->checkUsernameUsed($username)){
				//Segnalatore esistente
				if($this->startConn() == false){
					//errore connessione al db
					throw new Exception("Errore connessione al db");
				}else{
					//Sanitizzazione dati
					$id_segnalation = (int) $id_segnalation;
					$rate = (double) $rate;
					$username = $this->conn->real_escape_string($username);
					$query = "INSERT INTO ".RATING_TABLE." (".RATING_TABLE_SEGNALATION.", ".RATING_TABLE_RATE.", ".RATING_TABLE_USERNAME.") VALUES (?, ?, ?)";
					$stmt = $this->conn->prepare($query);
					if($stmt){
						//Statement preparato
						$stmt->bind_param("ids", $id_segnalation, $rate, $username);
					}else{
						//Errore preparazione statement
						$this->endConn();
						throw new Exception("Errore preparazione statement");
					}
					if(!$stmt->execute()){
						//Errore esecuzione statement
						$stmt->close();
						$this->endConn();
						throw new Exception("Errore esecuzione statement");
					}else{
						//Statement eseguito con successo
						$stmt->close();
						$this->endConn();
						return true;
					}
				}
				
			}else{
				//Errore: mittente o destinatario inesistente
				throw new Exception("username inesistente");
			}
		}
		
		public function checkRate($id_segnalation,$username){
			if($this->startConn()){
				$id_segnalation = (int) $id_segnalation;
				$username = $this->conn->real_escape_string($username);
				$sql = "SELECT * FROM ".RATING_TABLE." WHERE ".RATING_TABLE_SEGNALATION." = ? AND ".RATING_TABLE_USERNAME." = ?";
				$stmt = $this->conn->prepare($sql);
				if($stmt){
					$stmt->bind_param("is", $id_segnalation, $username);
					$result = $stmt->execute();
					if(!$result){
						$stmt->close();
						$this->endConn();
						throw new Exception("Errore esecuzione statement");
					}else{
						$stmt->store_result();
						if($stmt->num_rows == 1){
							$stmt->close();
							$this->endConn();
							return true;
						}else{
							$stmt->close();
							$this->endConn();
							return false;
						}
					}
				}else{
					//Errore preparazione statement
					$this->endConn();
					throw new Exception("Errore preparazione statement");
				}
			}else{
				$this->endConn();
				throw new Exception("Errore connessione");
			}
		}
		
		public function getUsernameRating($username) {
			if($this->checkUsernameUsed($username)){
				//Segnalatore esistente
				if($this->startConn() == false){
					//Errore avvio connessione
					throw new Exception("Errore connessione al db");
				} else {
					$username = $this->conn->real_escape_string($username);
					$query = "SELECT ".RATING_TABLE_ID.", ".RATING_TABLE_SEGNALATION.", ".RATING_TABLE_RATE.", ".REPORTS_TABLE_SSID." FROM ".RATING_TABLE." INNER JOIN ".REPORTS_TABLE." ON ".RATING_TABLE.".".RATING_TABLE_SEGNALATION." = ".REPORTS_TABLE.".".REPORTS_TABLE_ID." WHERE ".RATING_TABLE_USERNAME." = ?";
					$stmt = $this->conn->prepare($query);
					if($stmt){
						//Statement preparato
						$stmt->bind_param("s", $username);
					}else{
						//Errore preparazione statement
						$this->endConn();
						throw new Exception("Errore preparazione statement");
					}
					if(!$stmt->execute()){
						//Errore esecuzione statement
						$stmt->close();
						$this->endConn();
						throw new Exception("Errore esecuzione statement");
					}else{
						//Statement eseguito con successo
						$stmt->store_result();
						if($stmt->num_rows >= 1){
							$stmt->bind_result($id, $id_segnalation, $rate, $SSID);
							$valutazioni = array();
							while($stmt->fetch()){
								$valutazione = array("id"=>$id, "segnalazione"=>$id_segnalation, "voto"=>$rate, "SSID"=>$SSID);
								array_push($valutazioni, $valutazione);
							}
							$stmt->close();
							$this->endConn();
							return $valutazioni;
						}else{
							//Nessuna segnalazione di quel tipo
							$stmt->close();
							$this->endConn();
							return null;
						}
					}
				}
			}
		}	

		public function deleteRate($id) {
			if($this->startConn()){
				$id = (int) $id;
				$sql = "DELETE FROM ".RATING_TABLE." WHERE ".RATING_TABLE_ID." = ?";
				$stmt = $this->conn->prepare($sql);
				if($stmt){
					//Statement preparato
					$stmt->bind_param("i", $id);
				}else{
					//Errore preparazione statement
					$this->endConn();
					throw new Exception("Errore preparazione statement");
				}
				if(!$stmt->execute()){
					//Errore esecuzione statement
					$stmt->close();
					$this->endConn();
					throw new Exception("Errore esecuzione statement");
				}else{
					//Statement eseguito con successo
					$stmt->close();
					$this->endConn();
					return true;
				}
			} else {
				//Errore avvio connessione
				throw new Exception("Errore connessione al db");
			}
		}	
	}
?>