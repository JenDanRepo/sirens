<?php
  require('sirens_template.php');
  sirenHeader("User Details");

  require('phpsqlsearch_dbinfo.php');
?>

<style>
  /* Always set the map height explicitly to define the size of the div
   * element that contains the map. */
  #map {
    /*height: 60%;
    width:  50%;*/
    height: 500px;
    width: 500px;
  }
  /* Optional: Makes the sample page fill the window. */
  /*
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
  }
  */

</style>

<h3>User Summary</h3>
<form action="maps.php" method="get" border=1>
  Callsign:<input type="text" name="callsign">
  <input type="submit">
  <br>
</form>
<p>
Green = Checked in by this callsign, Yellow = Checked in by someone, Red = Checked in by nobody.
    
<div id="map">

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
    } else {
        sirenxml = sirenxml.concat("?callsign=nobody");
    };

    // old url: https://storage.googleapis.com/mapsdevsite/json/mapmarkers2.xml
    downloadUrl(sirenxml, function(data) {
      var xml = data.responseXML;
      var markers = xml.documentElement.getElementsByTagName('marker');
      Array.prototype.forEach.call(markers, function(markerElem) {
        var sirenId = markerElem.getAttribute('id');
        var name = markerElem.getAttribute('name');
        var address = markerElem.getAttribute('address');
        var type = markerElem.getAttribute('type');
        var point = new google.maps.LatLng(
            parseFloat(markerElem.getAttribute('lat')),
            parseFloat(markerElem.getAttribute('lng'))
            );

        var infowincontent = document.createElement('div');
        var strong = document.createElement('strong');
        strong.textContent = name
        infowincontent.appendChild(strong);
        infowincontent.appendChild(document.createElement('br'));

        var text = document.createElement('text');
        text.textContent = address
        infowincontent.appendChild(text);
        // var icon = customLabel[type] || {};
        // var icon = markerElem.getAttribute('id') || {};
        var icon = sirenId;
        var foo = customColor[type] || {};
        var marker = new google.maps.Marker({
          map: map,
          position: point,
          icon: pinSymbol(foo.mycolor),
          //icon: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png',
          // label: icon.label
          label: icon
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
<?php
  $api_url = "https://maps.googleapis.com/maps/api/js?&callback=initMap&key=" . $mapsapikey;

  echo <<<EOT
    <script async defer src="$api_url">
    </script>
EOT;
?>

</div> <!-- End of id=map-->

    <?php

        $mytimestamp = date('Y-m-d H:i:s');
        //echo "Timestamp is: $mytimestamp<br>";

        
        require('php_siren_lib.php');

        $pdostring = 'mysql:host=' . $servername .';dbname=' . $dbname .';charset=utf8mb4';
        $db = new PDO($pdostring, $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $callsign = $_GET['callsign'];

        if ($callsign == ""){
            $callsign = "nobody";
        }

        /*
        $user_sql = "SELECT user, COUNT(*) AS magnitude FROM Checkins WHERE callsign = \"$callsign\" GROUP BY user ORDER BY magnitude DESC LIMIT 1";
                $user_result = $conn->query($user_sql);
                $user_row=mysqli_fetch_array($user_result);
            
            $user= $user_row['user'];
        */
        $user = get_user_from_callsign($callsign);

        $sql="SELECT * FROM Checkins WHERE callsign=\"$callsign\" ORDER BY entry_time DESC";

        //echo "SQL Statement: $sql<br><br>";

        //$result = $conn->query($sql);

        $counter = 0;

        $stmt = $db->prepare("SELECT * FROM Checkins WHERE callsign=? ORDER BY entry_time DESC");
        $stmt->execute(array($callsign));
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        while ($row = array_shift($rows)){
            $counter++;
            // $user = $row['user'];
            $entry_time = $row['entry_time'];
            $siren = $row['siren'];
            $callsign = $row['callsign'];
            $location = $row['location'];
            $tonequality = $row['tonequality'];
            $voicequality = $row['voicequality'];
            $insideout = $row['insideout'];

            // $datastring = $datastring."<tr><td>$entry_time</td> <td>$siren</td> <td>Siren Location</td> <td>$location</td> <td>$tonequality</td> <td>$voicequality</td><td>$insideout</td></tr>";
            // $datastring = $datastring."<tr><td>$entry_time</td> <td>$siren</td> <td>$location</td> <td>$tonequality</td> <td>$voicequality</td><td>$insideout</td></tr>";
            $datastring = $datastring. "<tr><td>$entry_time</td> <td><a href=\"siren.php?number=" . $siren . "\">$siren</a></td> <td>$location</td> <td>$tonequality</td> <td>$voicequality</td><td>$insideout</td></tr>";
        } 

        echo "<h3>User Summary for $user ($callsign)</h3>";
        echo "Checkins: $counter";
        echo "<br><br>";
        echo '<table class="table table-sm">';
        echo '<thead class="thead-dark">';
        echo '<tr>';
        // echo "<th>Time</th> <th>Siren</th> <th>Siren Location</th> <th>Reported Location</th> <th>Tone Quality</th> <th>Voice Quality</th> <th>Inside/Outside</th>";
        echo "<th>Time</th> <th>Siren</th> <th>Reported Location</th> <th>Tone Quality</th> <th>Voice Quality</th> <th>Inside/Outside</th>";

        echo '<tr>';
        echo "$datastring";
        echo "</table>";

        //mysqli_close($conn);

        ?>
<?php
  sirenFooter();
?>