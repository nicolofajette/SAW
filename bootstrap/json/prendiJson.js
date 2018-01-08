$jQ = jQuery.noConflict();
$jQ.getJSON('http://dati.comune.genova.it/sites/default/files/WIFI.geojson',
function(err, data) {
  if (err != null) {
    alert('Something went wrong: ' + err);
  } else {
    alert('Your query count: ' + data.query.count);
  }
});