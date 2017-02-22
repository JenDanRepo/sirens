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

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
} /*else {
	echo "<p>DB seems to be working as user: $username.</p>";
}*/

// Print most recent checkin for sirens with records

$sql = "SELECT siren, address, MAX(entry_time) AS entry_time, name FROM Checkins T1 LEFT JOIN Sirens T2 on T1.siren = T2.id GROUP BY siren ORDER BY MIN(entry_time) DESC";

$result = $conn->query($sql) or die(mysqli_error());

// echo "<p>SQL:<br> $sql</p>";
echo "<h3>Most Recent Check Ins For Sirens:</h3>";
echo "<table border=1>";
echo "<th>Time</th> <th>User</th> <th>Callsign</th> <th>Siren</th> <th>Person's Location</th> <th>Tone Quality</th> <th>Voice Quality</th>";


while($row = mysqli_fetch_array($result)) {
    //$user = $row['user'];
    $entry_time = $row['entry_time'];
    $siren = $row['siren'];

        $newsql = "SELECT * FROM Checkins WHERE siren = $siren ORDER BY entry_time DESC LIMIT 1";
        $newresult = $conn->query($newsql) or die(mysqli_error());

        $newrow = mysqli_fetch_array($newresult);

    $user = $newrow['user'];
    $callsign = $newrow['callsign'];
    $location = $newrow['location'];
    $tonequality = $newrow['tonequality'];
    $voicequality = $newrow['voicequality'];

    echo "<tr><td>$entry_time</td> <td>$user</td> <td><a href=\"./user.php?callsign=$callsign\">$callsign</a></td> <td><a href=\"./siren.php?number=$siren\">$siren</a><br></td> <td>$location</td> <td>$tonequality</td> <td>$voicequality</td></tr>";
} 

echo "</table>";

$error = mysqli_error($conn);
echo "Error: $error";

// End printing most recent check in by siren


// Print out the complete Checkins Table Info:

$sql = "SELECT * FROM Checkins";

$result = $conn->query($sql) or die(mysqli_error());

echo "<h3>Checkins Table:</h3>";
echo "<table border=1>";
echo "<th>Time</th> <th>User</th> <th>Callsign</th> <th>Siren</th> <th>Person's Location</th> <th>Tone Quality</th> <th>Voice Quality</th>";

while($row = mysqli_fetch_array($result)) {
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


//$error = mysqli_error($conn);
//echo "Error: $error";

mysqli_close($conn);

?>

</body>
</html>

