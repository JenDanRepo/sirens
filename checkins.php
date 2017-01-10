<html>
 <head>
  <title>Siren Net Check-ins</title>
 </head>
<body>

<h1>Siren Net Check-ins</h1>
<?php
$mytimestamp = date('Y-m-d H:i:s');
echo "As of $mytimestamp<br>";
?>

<h4>Add a checkin:</h4>

<form action="add_checkin.php" method="post">
    <table border="0">
    <tr><td>User:</td><td><input type="text" name="user"></td></tr>
    <tr><td>Callsign:</td><td><input type="text" name="callsign"></td></tr>
    <tr><td>Siren:</td><td><input type="text" name="siren"></td></tr>
    <tr><td>
    <input type="radio" name="insideout" value="outdoor" checked> Outdoor
    <input type="radio" name="insideout" value="indoor"> Indoor
    <input type="radio" name="insideout" value="unknown"> Unknown
    </td></tr>
    <tr><td>Location</td><td><input type="text" name="location"></td></tr>
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

// Join in Sirent location description to Checkins table:
// SELECT user, entry_time, siren, callsign, location, tonequality, voicequality, name FROM Checkins T1 LEFT JOIN Sirens T2 on T1.siren = T2.id ORDER BY entry_time
// Figured this out by following this tutorial: http://www.mysqltutorial.org/mysql-inner-join.aspx

//$sql = "Select * FROM Checkins";
//$sql = "SELECT user, entry_time, siren, callsign, location, tonequality, voicequality, name FROM Checkins T1 LEFT JOIN Sirens T2 on T1.siren = T2.id ORDER BY entry_time ASC";

/*
$sql = "SELECT user, entry_time, siren, callsign, location, tonequality, voicequality, name FROM Checkins T1 LEFT JOIN Sirens T2 on T1.siren = T2.id ORDER BY entry_time ASC";

$sql = "SELECT DISTINCT siren, user, entry_time, callsign, location, tonequality, voicequality, name FROM Checkins T1 LEFT JOIN Sirens T2 on T1.siren = T2.id ORDER BY entry_time ASC";

$sql = "SELECT entry_time, siren FROM Checkins WHERE siren = * ORDER BY entry_time DESC LIMIT 1";

// This one actually works. Would be better with a join.
$sql = "SELECT siren, MAX(entry_time) AS entry_time FROM Checkins GROUP BY siren ORDER BY MIN(entry_time) DESC;";
*/

$sql = "SELECT siren, address, MAX(entry_time) AS entry_time, name FROM Checkins T1 LEFT JOIN Sirens T2 on T1.siren = T2.id GROUP BY siren ORDER BY MIN(entry_time) DESC";

$result = $conn->query($sql);

echo "<p>SQL:<br> $sql</p>";
echo "<h3>Most Recent Check Ins For Sirens:</h3>";
echo "<table>";
echo "<th>Time</th> <th>User</th> <th>Callsign</th> <th>Siren</th> <th>Location</th> <th>Tone Quality</th> <th>Voice Quality</th>";
/*
while($row = mysqli_fetch_array($result)) {
    $user = $row['user'];
    $entry_time = $row['entry_time'];
    $siren = $row['siren'];
    $callsign = $row['callsign'];
    $location = $row['location'];
    $tonequality = $row['tonequality'];
    $voicequality = $row['voicequality'];
    echo "<tr><td>$entry_time</td> <td>$user</td> <td>$callsign</td> <td>$siren<br></td> <td>$location</td> <td>$tonequality</td> <td>$voicequality</td></tr>";
} 
*/

while($row = mysqli_fetch_array($result)) {
    //$user = $row['user'];
    $entry_time = $row['entry_time'];
    $siren = $row['siren'];

        $newsql = "SELECT * FROM Checkins WHERE siren = $siren ORDER BY entry_time DESC LIMIT 1";
        $newresult = $conn->query($newsql);

        $newrow = mysqli_fetch_array($newresult);

    $user = $newrow['user'];
    $callsign = $newrow['callsign'];
    $location = $newrow['location'];
    $tonequality = $newrow['tonequality'];
    $voicequality = $newrow['voicequality'];
    echo "<tr><td>$entry_time</td> <td>$user</td> <td>$callsign</td> <td>$siren<br></td> <td>$location</td> <td>$tonequality</td> <td>$voicequality</td></tr>";
} 

echo "</table>";

$error = mysqli_error($conn);
echo "Error: $error";

//echo "If you got here without errors, things are working.";

// Print out the Checkins Table Info:
$sql = "SELECT * FROM Checkins";

$result = $conn->query($sql);

echo "<p>SQL:<br> $sql</p>";
echo "<h3>Checkins Table:</h3>";
echo "<table>";
echo "<th>Time</th> <th>User</th> <th>Callsign</th> <th>Siren</th> <th>Location</th> <th>Tone Quality</th> <th>Voice Quality</th>";

while($row = mysqli_fetch_array($result)) {
    $user = $row['user'];
    $entry_time = $row['entry_time'];
    $siren = $row['siren'];
    $callsign = $row['callsign'];
    $location = $row['location'];
    $tonequality = $row['tonequality'];
    $voicequality = $row['voicequality'];
    echo "<tr><td>$entry_time</td> <td>$user</td> <td>$callsign</td> <td>$siren<br></td> <td>$location</td> <td>$tonequality</td> <td>$voicequality</td></tr>";
} 

echo "</table>";

$error = mysqli_error($conn);
echo "Error: $error";




mysqli_close($conn);

echo "<p>Checkins<pre>
+----+--------------+---------------------+-------+----------+------------------------------+--------------+--------------+
| id | user         | entry_time          | siren | callsign | location                     | tonequality  | voicequality |
+----+--------------+---------------------+-------+----------+------------------------------+--------------+--------------+
|  1 | desl         | 2016-12-22 11:57:12 |    36 | KK6VNY   | Caesar Chavez and S Van Ness | Loud & Clear | Loud & Clear |
|  2 | Ham Radio Op | 2016-12-22 20:52:55 |    12 | KF6IHL   | Going banans                 | Awesome      | Sweet        |
|  3 | Homo Erectus | 2016-12-22 23:52:40 |    12 | KF6IHL   | Going banans                 | Awesome      | Sweet        |
|  4 | Homo Erectus | 2016-12-22 23:56:15 |     1 | KF6IHL   | the park                     | Awesome      | Sweet        |
|  5 | Shaggy       | 2016-12-22 23:56:34 |     2 | KK6vny   | your mom                     | Awesome      | Sweet        |
|  6 | Bob          | 2016-12-23 14:55:09 |     2 | KKBOB    | 1st & Market                 | Good         | Lousy        |
|  7 | Dana         | 2016-12-23 14:57:45 |     1 | KFD123   | Union Square                 | Lousy        | Even Lousier |
+----+--------------+---------------------+-------+----------+------------------------------+--------------+--------------+
</pre>";

echo "<p>Sirens<pre>
+----+--------+-----------------+----------+-----------------+---------------+-------+------+-----------+-------------+
| id | number | name            | language | address         | city          | state | zip  | lat       | lng         |
+----+--------+-----------------+----------+-----------------+---------------+-------+------+-----------+-------------+
|  1 |      1 | 22nd & Carolina | English  | 22nd & Carolina | San Francisco | CA    | NULL | 37.757240 | -122.400002 |
|  2 |      2 | Presidio West   | English  | Fake Address    | San Francisco | CA    | NULL | 37.793571 | -122.473541 |
+----+--------+-----------------+----------+-----------------+---------------+-------+------+-----------+-------------+
</pre>";

/*
SELECT *,
    ROW_NUMBER() OVER (PARTITION BY ID ORDER BY siren desc) as rn    
    FROM Checkins;
*/
?>

</body>
</html>

