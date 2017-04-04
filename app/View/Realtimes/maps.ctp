<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Simple markers</title>
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>

function initMap() {
  
    var lat = parseFloat(localStorage.lat); 
    var lng = parseFloat(localStorage.lng);
    
    var div = "<div id="+ localStorage.id_map+"></div>";
    var myLatLng = {lat: lat, lng: lng};

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 20,
    center: myLatLng,
    mapTypeId: google.maps.MapTypeId.SATELLITE
  });

  var marker = new google.maps.Marker({
    position: myLatLng,
    map: map,
    title: 'Hello World!'
  });
}

    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAc_ZDEuRczN4De7tl8u56KX-T5L9VfQkw&signed_in=true&callback=initMap"></script>
  </body>
</html>
<?php die(); ?>