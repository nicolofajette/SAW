<!-- Navigation -->
    <nav class="navbar navbar-default" role="navigation">
        <div class="container">
            <!-- Brand and toggle sono uniti quando lo schermo è piccolo<768px -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> <!--solo per Screen reader-->
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- navbar-brand is hidden on larger screens, but visible when the menu is collapsed -->
                <a class="navbar-brand" href="index.html">Free Wi-Fi Genova</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php"><span class="glyphicon glyphicon-home" style="padding-right:10px"></span>Home</a>
                    </li>
					<?php
						if (!isset($_SESSION["username"])) {
							echo '<li><a href="registrazione.php"><span class="glyphicon glyphicon-floppy-disk" style="padding-right:10px"></span>Registrati</a></li>';
						}else{
							echo '<li><a href="segnalazioni.php"><span class="glyphicon glyphicon-search" style="padding-right:10px"></span>Trova</a></li>';
							echo '<li><a href="segnala.php"><span class="fa fa-pencil" style="padding-right:10px"></span>Segnala</a></li>';
							echo '<li><a href="profilo.php"><span class="glyphicon glyphicon-user" style="padding-right:10px"></span>Profilo</a></li>';
							echo '<li><a href="pagina_chat.php"><span class="glyphicon glyphicon-comment" style="padding-right:10px"></span>Chat';
							require_once("db.php");
							$dbHandler = new db_handler();
							try{
								$unreadNum = $dbHandler->getUnreadMessagesNumber($_SESSION['username']);
								if($unreadNum != 0){
									echo " <span class='badge'>".$unreadNum."</span>";
								}
							}catch(Exception $e){
								//Errore
							}
							echo '</a></li>';
						}
					?>
                    <li>
                        <a href="about.php"><span class="fa fa-info" style="padding-right:10px"></span>About</a>
                    </li>
                    <li>
                        <a href="contact.php"><span class="glyphicon glyphicon-envelope" style="padding-right:10px"></span>Contattaci</a>
                    </li>
					<?php
						if (isset($_SESSION["username"])) {
							echo '<li><a href="logout.php"><span class="glyphicon glyphicon-log-out" style="padding-right:10px"></span>LOGOUT</a></li>';
						} else {
							echo '<li><a href="#" id="myBtn" data-toggle="modal" data-target="#basicModal"><span class="glyphicon glyphicon-log-in" style="padding-right:10px"></span>Accedi</a></li>';
						}
					?>					
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>