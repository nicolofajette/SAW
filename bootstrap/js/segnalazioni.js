var geocoder;
var map;
var Lat;
var Lng;
var markers = [];
var infoWindows = [];
google.maps.event.addDomListener(window, 'load', initMap);
function initMap() {
	geocoder = new google.maps.Geocoder();
	var latlng = new google.maps.LatLng(44.40565,  8.946256);
	var mapOptions = {
	  zoom: 8,
	  center: latlng,
	  disableDoubleClickZoom: true
	}
	map = new google.maps.Map(document.getElementById('map'), mapOptions);
	
	// Try HTML5 geolocation.
	if (navigator.geolocation) {
	  navigator.geolocation.getCurrentPosition(function(position) {
		var pos = {
		  lat: position.coords.latitude,
		  lng: position.coords.longitude,
		};
		var marker = new google.maps.Marker({
			position: pos,
			map: map,
			title: 'Sei qui!'
		});
		var contentString = "Sei qui!";
		var infowindow = new google.maps.InfoWindow({
			content: contentString
        });
		marker.addListener('click', function() {
			infowindow.open(map, marker);
        });
		map.setCenter(pos);
		map.setZoom(15);
	  }, function() {
		handleLocationError(true, map.getCenter());
	  });
	} else {
	  // Browser doesn't support Geolocation
	  handleLocationError(false, map.getCenter());
	}	
}
	
function handleLocationError(browserHasGeolocation, pos) {
	document.getElementById("message").style.display = 'block';
	address = document.getElementById("address");
	address.style.borderColor = "#31708f";
}

function codeAddress() {
	var address = document.getElementById('address').value
	geocoder.geocode( { 'address': address}, function(results, status) {
	  if (status == 'OK') {
		map.setCenter(results[0].geometry.location);
		map.setZoom(15);
		document.getElementById('address').value = null;
	  } else {
		alert('Geolocalizzazione non possibile: ' + status);
	  }
	});
}

function addMarker(location, tipologia,i) {
	if (tipologia == "pubblico esterno" ) {
		var marker = new google.maps.Marker({
			position: location,
			map: map,
			icon : 'img/green-dot.jpg',
			infoWindowIndex : i
		});
	} else if (tipologia == "pubblico interno") {
		var marker = new google.maps.Marker({
			position: location,
			map: map,
			icon : 'img/yellow-dot.jpg',
			infoWindowIndex : i
		});
	} else {
		var marker = new google.maps.Marker({
			position: location,
			map: map,
			icon : 'img/blue-dot.jpg',
			infoWindowIndex : i
		});
	}
	markers.push(marker);
}
  
function clearMarkers() {
	setMapOnAll(null);
}

function setMapOnAll(map) {
	for (var i = 0; i < markers.length; i++) {
	  markers[i].setMap(map);
	}
}

$(document).ready(function(){
		$('[data-toggle="popover"]').popover();   
	});
	
function submitForm()
{  
	var data = $('#form-segnalazioni').serialize();
	clearMarkers();
	markers = [];
	infoWindows = [];

	$.ajax({

		type : 'POST',
		url  : 'segnalazionidb.php',
		data : data,
		dataType: 'json',
		beforeSend: function()
		{ 
			$("#error-segnalazioni").fadeOut();
		},
		success :  function(response)
		{      
			if(response=="errore caricamento"){
				$("#error-segnalazioni").fadeIn(500, function(){      
					$("#error-segnalazioni").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
				});					
			}
			else{
				var json = $.parseJSON(JSON.stringify(response));
				if (json.status == 0) {
					$("#error-segnalazioni").fadeIn(500, function(){      
						$("#error-segnalazioni").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Nessuna segnalazione di questo tipo!</div>');
					});
				} else {
					$.each(json.segnalazioni, function (i, segnalazione) {
						var latlngStr = segnalazione.posizione.split(',', 2);
						var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
						addMarker(latlng, segnalazione.tipologia,i);
						var infowindow = new google.maps.InfoWindow({
							content: " "
						});	
						if (segnalazione.media == null) {
							segnalazione.media = 0;
						}
						google.maps.event.addListener(markers[i], 'click', function() {
								if (segnalazione.rated ) {
									infowindow.setContent("<div class='text-center'>" +
														"<h5>"+segnalazione.tipologia+"</h5>" +
														"</div>"+
														"<div>Nome WiFi: "+segnalazione.SSID+"</div>" +
														"<div id='segn-id' style='display:none' value='"+segnalazione.id+"'></div>" +
														"<div>Segnalatore: <a id='profile-link' href='profilo.php?segnalatore="+segnalazione.segnalatore+"'>"+segnalazione.segnalatore+"</a></div>" +
														"<div>Rating medio: "+segnalazione.media+" su "+segnalazione.conteggio+" valutazioni</div>" +
														"<div class='bg-success text-white'>Hai gi&agrave; valutato questa segnalazione</div>");
								} else if( json.utente == segnalazione.segnalatore) { 
									infowindow.setContent("<div class='text-center'>" +
														"<h5>"+segnalazione.tipologia+"</h5>" +
														"</div>"+
														"<div>Nome WiFi: "+segnalazione.SSID+"</div>" +
														"<div id='segn-id' style='display:none' value='"+segnalazione.id+"'></div>" +
														"<div>Segnalatore: <a id='profile-link' href='profilo.php?segnalatore="+segnalazione.segnalatore+"'>Io</a></div>" +
														"<div>Rating medio: "+segnalazione.media+" su "+segnalazione.conteggio+" valutazioni</div>");
								} else {
									infowindow.setContent("<div class='text-center'>" +
														"<h5>"+segnalazione.tipologia+"</h5>" +
														"</div>"+
														"<div>Nome WiFi: "+segnalazione.SSID+"</div>" +
														"<div id='segn-id' style='display:none' value='"+segnalazione.id+"'></div>" +
														"<div>Segnalatore: <a id='profile-link' href='profilo.php?segnalatore="+segnalazione.segnalatore+"'>"+segnalazione.segnalatore+"</a></div>" +
														"<div>Rating medio: "+segnalazione.media+" su "+segnalazione.conteggio+" valutazioni</div>" +
														"<form class='rating' id='form-rating'>Valuta:" +
															"<input type='radio' id='star5' name='rating' value='5' /><label class = 'full' for='star5' title='5 stars'></label>" +
															"<input type='radio' id='star4half' name='rating' value='4.5' /><label class='half' for='star4half' title='4.5 stars'></label>" +
															"<input type='radio' id='star4' name='rating' value='4' /><label class = 'full' for='star4' title='4 stars'></label>" +
															"<input type='radio' id='star3half' name='rating' value='3.5' /><label class='half' for='star3half' title='3.5 stars'></label>" +
															"<input type='radio' id='star3' name='rating' value='3' /><label class = 'full' for='star3' title='3 stars'></label>" +
															"<input type='radio' id='star2half' name='rating' value='2.5' /><label class='half' for='star2half' title='2.5 stars'></label>" +
															"<input type='radio' id='star2' name='rating' value='2' /><label class = 'full' for='star2' title='2 stars'></label>" +
															"<input type='radio' id='star1half' name='rating' value='1.5' /><label class='half' for='star1half' title='1.5 stars'></label>" +
															"<input type='radio' id='star1' name='rating' value='1' /><label class = 'full' for='star1' title='1 star'></label>" +
															"<input type='radio' id='starhalf' name='rating' value='0.5' /><label class='half' for='starhalf' title='0.5 stars'></label>" +
														"</form>" +
														"<button style='border: none; margin-left:10px' onclick='rate("+segnalazione.id+")' id='btn-rating' name='btn-rating'>Invia</button>"+
														"<div id='hidden' style='display:none' class='error text-danger'></div>");
								}
								infoWindows[this.infoWindowIndex].open(map, this);
							}
						);
						infoWindows.push(infowindow);
					});
				}						 
			}
		}
	});
	return false;
}

function rate(i) {
	var star = $('input[name="rating"]:checked').val();
	var username = $("#profile-link").text();
	var id_segn = i;
	if (star == null) {
		star = "0";
	}
	$.ajax({
    
		type : 'POST',
		url  : 'segnalazionidb.php',
		data : {id: id_segn, rate: star, segnalatore: username},
		success :  function(response)
		{      
			if(response=="ok"){	
				submitForm();
			}
			else{		
				$("#btn-rating").css("display", "none");
				$("#form-rating").css("display", "none");
				$("#hidden").css("display", "block");
				$("#hidden").html(response);
			}
		}
	});
	return false;
}
