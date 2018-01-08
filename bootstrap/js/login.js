$('document').ready(function()
{ 
    /* validation */
	$("#login-form").validate({
		rules: {
			pwd: {
				required: true,
			},
			email: {
				required: true,
				email: true
			}
		},
		messages: {
			pwd: {
				required: "Inserisca la password"
			},
			email: {
                		required: "Inserisca l'email",
               			email: "Inserisca un indirizzo email valido"
			}
		},

		submitHandler: submitForm 
    });  
    /* validation */    

    /* login submit */
    function submitForm()
    {  
		var data = $('#login-form').serialize();
    
		$.ajax({
    
			type : 'POST',
			url  : 'login.php',
			data : data,
			beforeSend: function()
			{ 
				$("#error").fadeOut();
				$("#btn-login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; Invio ...');
			},
			success :  function(response)
			{      
				if(response=="ok"){
			 
					$("#btn-login").html('<img src="img/ajax-loader.gif" /> &nbsp; Login in corso ...');
					setTimeout(' window.location.href = "segnalazioni.php"; ',500);
				}
				else{
			 		$("#error").fadeIn(500, function(){      
						$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
						$("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Invia');
					});
				}
			}
		});
		return false;
	}
    /* login submit */
});