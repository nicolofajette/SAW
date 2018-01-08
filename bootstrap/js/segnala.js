var geocoder;
var map;
var Lat;
var Lng;
var markers = [];
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
		placeMarkerAndPanTo(pos);
		map.setCenter(pos);
		map.setZoom(15);
	  }, function() {
		handleLocationError(true, map.getCenter());
	  });
	} else {
	  // Browser doesn't support Geolocation
	  handleLocationError(false, map.getCenter());
	}
	
	map.addListener('click', function(e) {
		placeMarkerAndPanTo(e.latLng);
	});
	
}

function handleLocationError(browserHasGeolocation, pos) {
	document.getElementById("message").style.display = 'block';
	address = document.getElementById("address");
	address.style.borderColor = "#31708f";
}	

function placeMarkerAndPanTo(latLng) {
	//nascondi il marker presente
	clearMarkers(); 
	markers = [];
	
	addMarker(latLng);
	Lat = markers['0'].getPosition().lat();
	Lng = markers['0'].getPosition().lng();
	var input = Lat+","+Lng;
	geocodeLatLng(input, geocoder)
	map.panTo(latLng);
}

function codeAddress() {
	var address = document.getElementById('address').value
	geocoder.geocode( { 'address': address}, function(results, status) {
	  if (status == 'OK') {
		map.setCenter(results[0].geometry.location);
		map.setZoom(15);
		clearMarkers();
		markers = [];
		document.getElementById('geoloc').value = null;
		document.getElementById('address').value = null;
		
	  } else {
		alert('Geolocalizzazione non possibile: ' + status);
	  }
	});
}

function geocodeLatLng(input, geocoder, map) {
	var latlngStr = input.split(',', 2);
	var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
	geocoder.geocode({'location': latlng}, function(results, status) {
	  if (status === 'OK') {
		if (results[0]) {
			 document.getElementById('address').value = results[0].formatted_address;
			 document.getElementById('geoloc').value = input;
		} else {
		  window.alert('Nessun risultato trovato');
		}
	  } else {
		window.alert('Geotraduzione non possibile: ' + status);
	  }
	});
}

function addMarker(location) {
	var marker = new google.maps.Marker({
	  position: location,
	  map: map
	});
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

$('document').ready(function()
{	
    /* validation */
	$("#form-segnala").validate({
		rules: {
			SSID: {
				required: true
			},
			geoloc: {
				required: true
			}
		},
		messages: {
			SSID: {
				required: ""
			},
			geoloc: {
          required: "Marker non posizionato"
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

    /* segnalation submit */
    function submitForm()
    {  
		var data = $('#form-segnala').serialize();
    
		$.ajax({
    
			type : 'POST',
			url  : 'segnaladb.php',
			data : data,
			beforeSend: function()
			{ 
				$("#error-segnala").fadeOut();
			},
			success :  function(response)
			{      
				if(response == "sent"){
					clearMarkers();
					markers = [];
					document.getElementById('geoloc').value = null;
					document.getElementById('address').value = null;
					document.getElementById('SSID').value = null;
					initMap();
					$("#error-segnala").fadeIn(50, function(){ 
						$("#error-segnala").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-ok"></span> &nbsp; Segnalazione completata!</div>');
					});
				}
				else{
			 		$("#error-segnala").fadeIn(1000, function(){      
						$("#error-segnala").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
					});
				}
			}
		});
		return false;
	}
    /* segnalation submit */

	$('[data-toggle="popover"]').popover();   
});