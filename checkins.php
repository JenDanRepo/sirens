<?php
    require('sirens_template.php');
    sirenHeader("Checkins");
?>

<?php
$mytimestamp = date('Y-m-d H:i:s');
// echo "<p>As of $mytimestamp<br>";
?>

<div class="row">
    <div class="col-lg-2">
      <h4>Add a checkin</h4>
    </div>
    <div class="col-lg-3">
        <form action="add_checkin.php" method="post" class="border border-primary rounded" style="padding: 4px;">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group row">
                        <label for="inputCallsign" class="col-lg-4 col-form-label">Callsign</label>
                        <div class="col-lg-6">
                            <input type="text" name="callsign" placeholder="callsign" id="inputCallsign" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputUser" class="col-lg-4 col-form-label">User</label>
                        <div class="col-lg-6">
                            <input type="text" name="user" placeholder="user" id="inputUser" class="form-control">
                        </div>
                    </div>


                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="insideout" id="inlineRadio1" value="outdoor" checked>
                        <label class="form-check-label" for="inlineRadio1">Outdoor</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="insideout" id="inlineRadio2" value="indoor">
                        <label class="form-check-label" for="inlineRadio2">Indoor</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="insideout" id="inlineRadio3" value="unknown">
                        <label class="form-check-label" for="inlineRadio3">Unknown</label>
                    </div>



                    <div class="form-group row">
                        <label for="inputSiren" class="col-lg-4 col-form-label">Siren</label>
                        <div class="col-lg-6">
                            <input type="text" name="siren" placeholder="00" id="inputSiren" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputToneQuality" class="col-lg-4 col-form-label">Tone Quality</label>
                        <div class="col-lg-6">
                            <input type="text" name="tonequality" value="Loud & Clear" id="inputToneQuality" class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputVoiceQuality" class="col-lg-4 col-form-label">Voice Quality</label>
                        <div class="col-lg-6">
                            <input type="text" name="voicequality" value="Loud & Clear" id="inputVoiceQuality" class="form-control">
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary"/>
                </div>
            </div>
        </form>
    </div>
</div>

<!--form action="add_checkin.php" method="post" border=1>
    <table>
    <tr><td>Callsign:</td><td><input type="text" name="callsign"></td></tr>
    <tr><td>User:</td><td><input type="text" name="user"></td></tr>
    <tr><td>
    <input type="radio" name="insideout" value="outdoor" checked> Outdoor
    <input type="radio" name="insideout" value="indoor"> Indoor
    <input type="radio" name="insideout" value="unknown"> Unknown
    </td></tr>
    <tr><td>Location</td><td><input type="text" name="location"></td></tr>
    <tr><td>Siren:</td><td><input type="text" name="siren"></td></tr>
    <tr><td>Tone Quality</td><td><input type="text" name="tonequality" value="Loud & Clear"></td></tr>
    <tr><td>Voice Quality</td><td><input type="text" name="voicequality" value="Loud & Clear"></td></tr>
    </table>
    <input type="submit">

</form-->

<h4>Previous Checkins</h4>
<?php

require('phpsqlsearch_dbinfo.php');
require('php_siren_lib.php');

$pdostring = 'mysql:host=' . $servername .';dbname=' . $dbname .';charset=utf8mb4';

$db = new PDO($pdostring, $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

echo "<h3>Most Recent Check Ins For Sirens:</h3>";
echo '<table class="table table-sm">';
echo '<thead>';
echo '<tr class="thead-dark">
        <th>Time</th>
        <th>User</th>
        <th>Callsign</th>
        <th>Siren</th>
        <th>Person\'s Location</th>
        <th>Tone Quality</th>
        <th>Voice Quality</th>
      </tr>';
echo '</thead>';
echo '<tbody>';

foreach($db->query('SELECT siren, address, MAX(entry_time) AS entry_time, name FROM Checkins T1 LEFT JOIN Sirens T2 on T1.siren = T2.id GROUP BY siren ORDER BY MIN(entry_time) DESC') as $row) {
  
    $entry_time = $row['entry_time'];
    $siren = $row['siren'];

        $stmt = $db->prepare("SELECT * FROM Checkins WHERE siren = ? ORDER BY entry_time DESC LIMIT 1");
        $stmt->execute(array($siren));
        $newrow = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $user = $newrow[0]['user'];
    $callsign = $newrow[0]['callsign'];
    $location = $newrow[0]['location'];
    $tonequality = $newrow[0]['tonequality'];
    $voicequality = $newrow[0]['voicequality'];

    echo "<tr><td>$entry_time</td> <td>$user</td> <td><a href=\"./maps.php?callsign=$callsign\">$callsign</a></td> <td><a href=\"./siren.php?number=$siren\">$siren</a><br></td> <td>$location</td> <td>$tonequality</td> <td>$voicequality</td></tr>";
} 

echo '</tbody>';
echo "</table>";

echo "<h3>Checkins Table:</h3>";
echo "<table border=1>";
echo "<th>Time</th> <th>User</th> <th>Callsign</th> <th>Siren</th> <th>Person's Location</th> <th>Tone Quality</th> <th>Voice Quality</th>";

foreach($db->query('SELECT * FROM Checkins') as $row) {
//while($row = mysqli_fetch_array($result)) {
    $user = $row['user'];
    $entry_time = $row['entry_time'];
    $siren = $row['siren'];
    $callsign = $row['callsign'];
    $location = $row['location'];
    $tonequality = $row['tonequality'];
    $voicequality = $row['voicequality'];
    echo "<tr><td>$entry_time</td> <td>$user</td> <td><a href=\"./maps.php?callsign=$callsign\">$callsign</a></td> <td><a href=\"./siren.php?number=$siren\">$siren</a><br></td> <td>$location</td> <td>$tonequality</td> <td>$voicequality</td></tr>";
} 

echo "</table>";

?>

<?php
    sirenFooter();
?>