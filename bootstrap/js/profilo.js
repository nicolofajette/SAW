$('document').ready(function()
{ 
	jQuery.validator.addMethod("notEqual", function(value, element, param) {
		return this.optional(element) || value != $(param).val();
		}, "utilizza una nuova password");

    /* validation */
	$("#form-profilo").validate({
		rules: {
			email: {
				required: true,
				email: true
			},
			new_password: {
				required: {
					depends: function(element) {
						return $("#old_password").val() != " ";
					}
				},
				notEqual: "#old_password"				
			},				
			confirm_password: {
				required: {
					depends: function(element) {
						return $("#old_password").val() != " ";
					}
				},
				equalTo: '[name="new_password"]',
				notEqual: "#old_password"
			}
		},
       messages:
		{	
            email:{
				required: "inserisca il suo nuovo indirizzo email",
				email: "inserisca un indirizzo email valido"
			},
			new_password: {
				required: "inserisca la nuova password"
			},
			confirm_password:{
				required: "confermi la nuova password",
				equalTo: "password non coincidenti"
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

    /* update submit */
    function submitForm() {  
		var data = $('#form-profilo').serialize();
    
		$.ajax({
    
			type : 'POST',
			url  : 'profilodb.php',
			data : data,
			beforeSend: function()
			{ 
				$("#error-prof").fadeOut();
			},
			success :  function(response)
			{      
				if(response=="ok"){
			 
					setTimeout(' window.location.href = "profilo.php"; ',500);
				}
				else{
			 
					$("#error-prof").fadeIn(500, function(){      
						$("#error-prof").html('<div class="alert alert-danger col-lg-offset-3 col-lg-8"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
					});
				}
			}
		});
		return false;
	}
    /* update submit */
	
	

	$( "#btn-password" ).click(function() {
		$("#modifica-password").css("display", "block");
		$("#btn-password").css("display", "none");
	});	

	$("#userfile_id").change(function() {

		var val = $(this).val();

		switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
			case 'gif': case 'jpg': case 'png': case 'PNG' : case 'JPG' :
				var tmppath = URL.createObjectURL(event.target.files[0]);
				$("#avatar").attr('src',tmppath);
				break;
			default:
				$(this).val('');
				// error message here
				$("#error-img").html('<div class="alert alert-danger col-lg-offset-2 col-lg-8"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; si possono caricare solo immagini!</div>');
				break;
		}
	});
	
	$("#btn-cancel").click(function() {
		window.location.replace("profilo.php");
	});
});	

function delete_segnalation(e) {
	var row = $(e).closest("tr");
	tds = row.find("td:nth-child(2)");
	$.ajax({

		type : 'POST',
		url  : 'profilodb.php',
		data : {id : tds.html(), cancella : 'si'}, 
		beforeSend: function()
		{ 
			$("#messaggio").fadeOut();
		},
		success :  function(response)
		{      
			if(response=="ok"){
				window.location.href = "profilo.php?cancellato=si";				
			}
			else{
				$("#messaggio").fadeIn(500, function(){      
					$("#messaggio").html('<div class="alert alert-danger col-lg-offset-3 col-lg-8"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
				});
			}
		}
	});
	return false;
}

function delete_rating(e) {
	var row = $(e).closest("tr");
	tds = row.find("td:nth-child(2)");
	$.ajax({

		type : 'POST',
		url  : 'profilodb.php',
		data : {id : tds.html(), cancellaRate : 'si'}, 
		beforeSend: function()
		{ 
			$("#messaggioRate").fadeOut();
		},
		success :  function(response)
		{      
			if(response=="ok"){
				window.location.href = "profilo.php?cancellatoRate=si";				
			}
			else{
				$("#messaggioRate").fadeIn(50, function(){      
					$("#messaggioRate").html('<div class="alert alert-danger col-lg-offset-3 col-lg-8"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
				});
			}
		}
	});
	return false;
}