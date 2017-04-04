<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<script type="text/javascript" src="../js/jquery-1.11.2.min.js"></script>
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

  /* white background and box outline */
.gm-style > div:first-child > div + div > div:last-child > div > div:first-child > div
{
    /* we have to use !important because we are overwritng inline styles */
    background-color: transparent !important;
    box-shadow: none !important;
    width: auto !important;
    height: auto !important;
}

/* arrow colour */
.gm-style > div:first-child > div + div > div:last-child > div > div:first-child > div > div > div
{
    background-color: #003366 !important; 
display:none;
}


.gm-style > div:first-child > div + div > div:last-child > div > div:last-child > img
{
   
}

/* positioning of infowindow */
.gm-style-iw
{
    top: 0px;
    left: 0px;
background:#fff;
}
    
</style>
</head>
<body>
   
    <a href="maps_2" target="_blank" style="background: #666;text-decoration: none;color: #fff;height: 20px;">new window</a>

    <div id="map">
        
    </div>
    <script>

        function initMap() {
        
            var modem_ip = localStorage.station_gps;
            var  obj = JSON.parse(modem_ip);
            var center = obj.center;
            obj = obj.client;
           
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
                                icon: image,

                            });
                            var infowindow = new google.maps.InfoWindow({
                                content: '<div class="mylabel">'+attr.tech.username+'</div>',
                                position: {lat: lat, lng: lng},
                              
                                 map: map,
                            });
                              infowindow.open(map);
                }
             
          
           
        }

    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNM6Az3eDohTWF7nSZvfImMUQBy8A2bZc&signed_in=true&callback=initMap"></script>

        <?php die();?>