<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog">
			
	<!-- Modal content -->
		<div class="modal-content">
			<div class="modal-header" style="padding:35px 50px;">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4><span class="glyphicon glyphicon-lock"></span> Login</h4>
			</div>
			<div class="modal-body" style="padding:40px 50px;">
				<form role="form" id="login-form"  method="POST">
					<div class="form-group">
						<label for="email"><span class="glyphicon glyphicon-user"></span>Email</label>
						<input type="email" class="form-control" id="email" name="email" placeholder="Inserisci l'email" required>
					</div>
					<div class="form-group">
						<label for="pwd"><span class="glyphicon glyphicon-eye-open"></span> Password</label>
						<input type="password" class="form-control" id="pwd" name="pwd" placeholder="Inserisci la password" required>
					</div>
					<div class="checkbox">
						<label><input type="checkbox" name="remember">Remember me</label>
					</div>
					<div id="error">
					<!-- error will be shown here ! -->
					</div>
					<button type="submit" id="btn-login" class="btn btn-success btn-block"><span class="glyphicon glyphicon-off"></span> Login</button>
				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Annulla</button>
				<p>Non sei iscritto? <a href="registrazione.php">Registrati</a></p>
			</div>
		</div>
		
	</div>
</div> 