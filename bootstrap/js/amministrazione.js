 $('document').ready(function()
 {
	$( "#btn_visualizza" ).click(function() {
		$("#btn_visualizza").css("display", "none");
		$("#btn_chiudi").css("display", "inline");		
		$("#tabella").css("display", "block");
	});
	
	$( "#btn_chiudi" ).click(function() {
		$("#btn_visualizza").css("display", "inline");
		$("#btn_chiudi").css("display", "none");		
		$("#tabella").css("display", "none");
	});
	
	$( "#btn_visualizzaBanned" ).click(function() {
		$("#btn_visualizzaBanned").css("display", "none");
		$("#btn_chiudiBanned").css("display", "inline");		
		$("#tabella_banned").css("display", "block");
	});
	
	$( "#btn_chiudiBanned" ).click(function() {
		$("#btn_visualizzaBanned").css("display", "inline");
		$("#btn_chiudiBanned").css("display", "none");		
		$("#tabella_banned").css("display", "none");
	});
	
	$("#form-blocca").submit( function() {
		var data = $('#form-blocca').serialize();

		$.ajax({

			type : 'POST',
			url  : 'amministrazionedb.php',
			data : data,
			beforeSend: function()
			{ 
				$("#error-blocca").fadeOut();
			},
			success :  function(response)
			{      
				if(response=="ok"){
					$("#error-blocca").fadeIn(50, function(){ 
							$("#error-blocca").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-ok"></span> &nbsp; Utente bloccato!</div>');
						});
				}
				else{
					$("#error-blocca").fadeIn(1000, function(){      
						$("#error-blocca").html('<div class="alert alert-danger col-lg-offset-3 col-lg-8"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
					});
				}
			}
		});
		return false;
	});
	
	$("#form-sblocca").submit( function () {
		var data = $('#form-sblocca').serialize();

		$.ajax({

			type : 'POST',
			url  : 'amministrazionedb.php',
			data : data,
			beforeSend: function()
			{ 
				$("#error-sblocca").fadeOut();
			},
			success :  function(response)
			{      
				if(response=="ok"){
					$("#error-sblocca").fadeIn(50, function(){ 
							$("#error-sblocca").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-ok"></span> &nbsp; Utente sbloccato!</div>');
						});
				}
				else{
					$("#error-sblocca").fadeIn(1000, function(){      
						$("#error-sblocca").html('<div class="alert alert-danger col-lg-offset-3 col-lg-6"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
					});
				}
			}
		});
		return false;
	});
	
	$("#form-eliminasegn").submit( function () {
		var data = $('#form-eliminasegn').serialize();

		$.ajax({

			type : 'POST',
			url  : 'amministrazionedb.php',
			data : data,
			beforeSend: function()
			{ 
				$("#error-eliminasegn").fadeOut();
			},
			success :  function(response)
			{      
				if(response=="ok"){
					$("#error-eliminasegn").fadeIn(50, function(){ 
							$("#error-eliminasegn").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-ok"></span> &nbsp; Segnalazione cancellata!</div>');
						});
				}
				else{
					$("#error-eliminasegn").fadeIn(1000, function(){      
						$("#error-eliminasegn").html('<div class="alert alert-danger col-lg-offset-3 col-lg-6"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
					});
				}
			}
		});
		return false;
	});
});