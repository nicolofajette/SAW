$('document').ready(function()
{ 
    /* validation */
	$("#register-form").validate({
		rules: {
			nome: "required",
			cognome: "required",
			username: "required",
			data: "required",	
			email: {
				required: true,
				email: true
			},
			psw1: {
				required: true
			},
			psw2: {
				required: true,
				equalTo : '[name="psw1"]'
			},
			privacy: "required"
		},
       messages:
		{
			nome:{
				required: "Inserisci il nome"
           		},
			cognome:{
				required: "Inserisci il cognome"
			},
			username:{
				required: "Inserisci lo username"
			},
           		psw1:{
                		required: "Inserisi la password"
            		},
			psw2:{
				required: "Conferma la password",
				equalTo: "Password non coincidenti"
			},
            		email:{
				required: "Inserisci l'indirizzo email",
				email: "Inserisci un indirizzo email valido"
			},
			data:{
				required: "Inserisci la data di nascita"
			},
			privacy:{
				required: "Devi accettare la privacy"
			}
		},
		highlight: function(element) {
			$(element).parent().addClass('has-error');
		},
		unhighlight: function(element) {
			$(element).parent().removeClass('has-error');
		},
		submitHandler: submitForm 
    });  
    /* validation */    

    /* register submit */
    function submitForm() {  
		var data = $('#register-form').serialize();
    
		$.ajax({
    
			type : 'POST',
			url  : 'registra.php',
			data : data,
			beforeSend: function()
			{ 
				$("#error-reg").fadeOut();
				$("#btn-register").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; Invio ...');
			},
			success :  function(response)
			{      
				if(response=="ok"){
			 
					$("#btn-register").html('<img src="img/ajax-loader.gif" /> &nbsp; Registrandoti ...');
					setTimeout(' window.location.href = "index.php"; ',500);
				}
				else{
			 
					$("#error-reg").fadeIn(500, function(){      
						$("#error-reg").html('<div class="alert alert-danger col-lg-offset-2 col-lg-6"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
						$("#btn-register").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Registrati');
					});
				}
			}
		});
		return false;
	}
    /* register submit */
});