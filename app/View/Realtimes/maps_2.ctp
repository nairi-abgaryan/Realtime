<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<meta charset="utf-8">
<title>Simple icons</title>
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
   
    <a href="maps_2" target="_blank" style="background: #666;text-decoration: none;color: #fff;height: 20px;">new window</a>

    <div id="map">
        
    </div>
    <script>

// This example adds a marker to indicate the position of Bondi Beach in Sydney,
// Australia.
        function initMap() {
            var modem_ip = localStorage.modem_gps;
            var center = localStorage.center;
            var  obj = JSON.parse(modem_ip);
           
            var pos = center.indexOf(",");
            var lat = center.substr(pos + 1);
            var a = parseFloat(lat);
            var lng = center.substr(0, pos);
            var b = parseFloat(lng);
            if(a > b){
                lng = a;
                lat = b
            }else{
                lng = b;
                lat = a;
            }
         
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 17,
                center: {lat: lat, lng: lng},
                 mapTypeId: google.maps.MapTypeId.SATELLITE
            });


            var marker = {
                fillColor: 'blue',
                fillOpacity: 0.8,
                scale: 1,
                strokeColor: 'gold',
                strokeWeight: 14
            };
            var image = {
                url: '/images/beachflag.png',
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25),
            };
            var center = new google.maps.Marker({
                position: {lat: lat, lng: lng},
                map: map,
                icon: marker
            });
             for (var x in obj) {
                      var attr = obj[x]; 
                    
                       var pos = attr.gps.gps.indexOf(",");
                        var lat = attr.gps.gps.substr(pos + 1);
                        a = parseFloat(lat);
                        var lng = attr.gps.gps.substr(0, pos);
                        b = parseFloat(lng);
                        var beachMarker;
                        if(a > b){
                            lng = a;
                            lat = b
                        }else{
                            lng = b;
                            lat = a;
                        }
                        beachMarker= new google.maps.Marker({
                                position: {lat: lat, lng: lng},
                                map: map,
                                icon: image
                            });
                }
             
          
           
        }

    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApObSLleEhMf0VOBBtdnLNIPLEOgQt7lw&signed_in=true&callback=initMap"></script>

        <?php die();?>