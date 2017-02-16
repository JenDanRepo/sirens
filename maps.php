<!DOCTYPE html >
<!-- Based on this example: https://developers.google.com/maps/documentation/javascript/mysql-to-maps -->
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>User Page</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 90%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>

  <body>
    <div id="header">
        <h3>User Has checked into</h3>
    </div>
    <div id="controller">
    a button for me, a button for everyone, a box and a button for search<br>
    Me = Green, Someone = Yellow, Nobody = Red
    </div>
    <div id="map"></div>

    <script>
      var customLabel = {
        checked: {
          label: 'C'
        },
        someone: {
            label: 'S'
        },
        unchecked: {
          label: 'N'
        }
      };
     var customColor = {
        checked: {
          mycolor: 'green'
        },
        someone: {
            mycolor: 'yellow'
        },
        unchecked: {
          mycolor: 'red'
        }
      };

        // a function I found:
        // http://stackoverflow.com/questions/7095574/google-maps-api-3-custom-marker-color-for-default-dot-marker
            function pinSymbol(color) {
              return {
                path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z',
                fillColor: color,
                fillOpacity: 1,
                strokeColor: '#000',
                strokeWeight: 1,
                scale: 1,
                labelOrigin: new google.maps.Point(0, -29)
              };
            }
        // end of function

        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(37.77, -122.42),
          zoom: 12
        });
        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file

        function getQuery(name){
            if(name=(new RegExp('[?&amp;]'+encodeURIComponent(name)+'=([^&amp;]*)')).exec(location.search))
                return decodeURIComponent(name[1]);
            }
 
        var callsign = getQuery("callsign");
        var sirenxml = "phpsqlsearch_genxml.php";

        if (callsign !== ""){
            sirenxml = sirenxml.concat("?callsign=", callsign);
        } ;

        // old url: https://storage.googleapis.com/mapsdevsite/json/mapmarkers2.xml
          downloadUrl(sirenxml, function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var name = markerElem.getAttribute('name');
              var address = markerElem.getAttribute('address');
              var type = markerElem.getAttribute('type');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));

              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = name
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));

              var text = document.createElement('text');
              text.textContent = address
              infowincontent.appendChild(text);
              var icon = customLabel[type] || {};
              var foo = customColor[type] || {};
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                icon: pinSymbol(foo.mycolor),
                //icon: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png',
                label: icon.label
              });
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });
            });
          });
        }



      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtRIxwlNll1t441LlLKtSGZP2zCerjWgc&callback=initMap">
    </script>
  </body>
</html>






<!--html>
<title>Siren Report</title>
<body>
<a href="./checkins.php">Checkins</a>
<a href="./leaderboard.php">Leaderboard</a>
<a href="./view_sirens.php">Siren List</a>
<a href="./user.php">User Summary</a>
<a href="./siren.php">Siren</a>
<a href="./hello.php">Hello</a>
<?php

require('phpsqlsearch_dbinfo.php');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
} /*else {
	echo "<p>DB seems to be working as user: $username.</p>";
} */


?>


</body>
</html-->

