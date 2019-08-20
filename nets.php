<?php
  require('sirens_template.php');
  sirenHeader("Net Summary");
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
<?php
  $netdate = $_GET['netdate'];
  echo "<h3>Summary of $netdate</h3>";

  require('phpsqlsearch_dbinfo.php');
  require('php_siren_lib.php');

  
  if($netdate == ""){
    echo "Display a list of nets";
    $pdostring = 'mysql:host=' . $servername .';dbname=' . $dbname .';charset=utf8mb4';
    $db = new PDO($pdostring, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $sql = "SELECT Nets.control_callsign AS netcontrol, Nets.net_date AS netdate, ? as foo FROM Nets";

    $stmt = $db->prepare($sql);
    $stmt->execute(['a']);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<table class="table table-sm">'
          . '<thead class="thead-dark">'
          . "<tr>"
            . "<th>Date</th>"
            . "<th>Net Control</th>"
          . "</tr>"
          . '</thead>'
          ;
    while ($row = array_shift($rows)){
      $netdate = $row['netdate'];
      $netcontrol = $row['netcontrol'];

      echo '<tr>'
              . "<td> <a href=\"nets.php?netdate=$netdate\"> $netdate </a> </td>"
              . "<td> $netcontrol </td>"
            . '</tr>';
    }
    echo "</table>";

    sirenFooter();
  }
?>

<p>
Green = Checked in during this net, Red = Not checked in during this net.
    
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
    },
    person:{
      mycolor: 'blue'
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

    var netdate = getQuery("netdate");
    var sirenxml = "phpsqlsearch_genxmlNet.php";

    if (netdate !== ""){
        sirenxml = sirenxml.concat("?netdate=", netdate);
    } else {
        sirenxml = sirenxml.concat("?netdate=nobody");
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
<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtRIxwlNll1t441LlLKtSGZP2zCerjWgc&callback=initMap">
  </script>
</div> <!-- End of id=map-->

    <?php

        $mytimestamp = date('Y-m-d H:i:s');
        //echo "Timestamp is: $mytimestamp<br>";

        $pdostring = 'mysql:host=' . $servername .';dbname=' . $dbname .';charset=utf8mb4';
        $db = new PDO($pdostring, $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $callsign = $_GET['callsign'];


        if ($callsign == ""){
            $callsign = "nobody";
        }


        $user = get_user_from_callsign($callsign);
        $net = 2;
        

        $sql = <<<EOT
        SELECT 
          Checkins.user, 
          Checkins.entry_time, 
          Checkins.siren, 
          CONCAT(Checkins.siren, ' - ', Sirens.`name`) AS 'siren_slug', 
          Checkins.callsign, 
          Checkins.location, 
          Checkins.tonequality, 
          Checkins.voicequality, 
          Checkins.insideout, 
          Checkins.net AS 'net', 
          Sirens.`NAME` AS 'siren_name' 
        FROM Checkins
        LEFT JOIN Sirens 
          ON Checkins.`siren` = Sirens.`number`
        WHERE net=? 
        ORDER BY callsign ASC
EOT;
        // echo "SQL Statement: $sql<br><br>";
        // $stmt->execute(array($callsign));
        $stmt = $db->prepare($sql);
        $stmt->execute([$net]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $counter = 0;
        while ($row = array_shift($rows)){
            $counter++;
            $username = $row['user'];
            $entry_time = $row['entry_time'];
            $siren = $row['siren'];
            $callsign = $row['callsign'];
            $location = $row['location'];
            $tonequality = $row['tonequality'];
            $voicequality = $row['voicequality'];
            $insideout = $row['insideout'];
            $siren_slug = $row['siren_slug'];
            $siren_name = $row['siren_name'];

            $datastring = $datastring. "<tr>"
                                        ."<td> <a href=\"maps.php?callsign=$callsign\"> $callsign </a> </td>"
                                        ."<td> $username </td>"
                                        ."<td><a href=\"siren.php?number=" . $siren . "\">$siren_slug </a></td>"
                                        ."<td>$location</td>"
                                        ."<td>$tonequality</td>"
                                        ."<td>$voicequality</td>"
                                        ."<td>$insideout</td>"
                                      ."</tr>";
        } 

        echo "<h3>Net Summary for $netdate</h3>";
        echo "Siren Checkins: $counter";
        echo "<br><br>";
        echo '<table class="table table-sm">';
        echo '<thead class="thead-dark">';
        echo '<tr>';
        // echo "<th>Time</th> <th>Siren</th> <th>Siren Location</th> <th>Reported Location</th> <th>Tone Quality</th> <th>Voice Quality</th> <th>Inside/Outside</th>";
        // echo "<th>Time</th> <th>Siren</th> <th>Reported Location</th> <th>Tone Quality</th> <th>Voice Quality</th> <th>Inside/Outside</th>";
        echo "<th>Callsign</th> <th>Name</th> <th>Siren</th> <th>Reporter Location</th> <th>Tone Quality</th> <th>Voice Quality</th> <th>Inside/Outside</th>";

        echo '<tr>';
        echo "$datastring";
        echo "</table>";

        //mysqli_close($conn);

        ?>
<?php
  sirenFooter();
?>