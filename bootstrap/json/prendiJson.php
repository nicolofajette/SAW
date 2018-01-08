<html>
    <head>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0W3mlTakNctxFJL2RRks8FRIbvFsoENY"></script>
    </head>
	<body>
	<button id="get-data">clicca</button>
	<div id="pippo"></div>
	</body>
	<script type="text/javascript" language="JavaScript">
	$('#get-data').click(function () {
		$.getJSON('wifi.geojson', function (data) {
			$.each(data.features, function (key, val) {
					$( "#pippo" ).append( "<p>"+val.properties.TIPO+"</p>" );
						var latlng = val.geometry.coordinates[1]+","+val.geometry.coordinates[0];
							$.post( "json.php", { geoloc: latlng, SSID: val.properties.NOME, tipo:"pubblico "+val.properties.TIPO.toLowerCase()+""} );
					});				
		});
	});
	</script>
</html>
	