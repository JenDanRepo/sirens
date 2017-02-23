<html>
 <head>
  <title>Siren Net Check-ins</title>
 </head>
<body>

<h1>SFSiren.net</h1>
    <a href="./checkins.php">Checkins</a>
    <a href="./leaderboard.php">Leaderboard</a>
    <a href="./view_sirens.php">Siren List</a>
    <a href="./maps.php">User Summary</a>
    <a href="./about.php">About</a>
    <hr>

<h3>Checkins</h3>
<?php
$mytimestamp = date('Y-m-d H:i:s');
echo "<p>As of $mytimestamp<br>";
?>

<h4>Add a checkin:</h4>

<form action="add_checkin.php" method="post" border=1>
    <table border="0">
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

</form>

<h4>Previous Checkins</h4>
<?php

require('phpsqlsearch_dbinfo.php');
require('php_siren_lib.php');

$pdostring = 'mysql:host=' . $servername .';dbname=' . $dbname .';charset=utf8mb4';

$db = new PDO($pdostring, $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

echo "<h3>Most Recent Check Ins For Sirens:</h3>";
echo "<table border=1>";
echo "<th>Time</th> <th>User</th> <th>Callsign</th> <th>Siren</th> <th>Person's Location</th> <th>Tone Quality</th> <th>Voice Quality</th>";

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
    echo "<tr><td>$entry_time</td> <td>$user</td> <td><a href=\"./user.php?callsign=$callsign\">$callsign</a></td> <td><a href=\"./siren.php?number=$siren\">$siren</a><br></td> <td>$location</td> <td>$tonequality</td> <td>$voicequality</td></tr>";
} 

echo "</table>";

?>

</body>
</html>

