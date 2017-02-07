<html>
<title>Siren Report</title>
<body>
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

$siren_number = mysqli_real_escape_string($conn, $_GET['number']);

echo "<h2>Siren $siren_number</h2>";

$mytimestamp = date('Y-m-d H:i:s');
echo "Timestamp is: $mytimestamp<br>";

/*
echo "
<a href="./leaderboard.php">Leaderboard</a>
<a href="./view_sirens.php">Siren List</a>
<a href="./user.php">User Summary</a>
<a href="./siren.php">Siren</a>
<a href="./hello.php">Hello</a>
";
*/



// SQL for siren info
$sql = "SELECT * FROM Sirens WHERE number = \"$siren_number\" LIMIT 1";

//echo "SQL: $sql<br>";

$result = $conn->query($sql);
$siren_string="";

while($row = mysqli_fetch_array($result)) {
    // $user = $row['user'];
    $number = $row['number'];
    $name = $row['name'];
    $language = $row['language'];
    $address = $row['address'];
    $city = $row['city'];
    $state = $row['state'];
    $zip = $row['zip'];
    $lat  = $row['lat'];
    $lng = $row['lng'];

    //$siren_string = "<tr>";
    $siren_string = "<table>";
    $siren_string = $siren_string . "<tr><td>Number: $number</td>";
    $siren_string = $siren_string . "<tr><td>Name: $name</td>";
    $siren_string = $siren_string . "<tr><td>Language: $language</td>";
    $siren_string = $siren_string . "<tr><td>Address: $address</td>";
    $siren_string = $siren_string . "<tr><td>City: $city</td>";
    $siren_string = $siren_string . "<tr><td>State: $state</td>";
    $siren_string = $siren_string . "<tr><td>Zip: $zip</td>";
    $siren_string = $siren_string . "<tr><td>Lat: $lat</td>";
    $siren_string = $siren_string . "<tr><td>Long: $lng</td>";
    $siren_string = $siren_string . "</table>";
}

//echo "Siren Info:</br>";
echo "<h3>Info</h3>";
echo $siren_string;

echo "<h3>Siren $siren_number Check-ins:</h3>";

$sql = "SELECT * FROM Checkins WHERE siren=\"$siren_number\" ORDER BY entry_time DESC";
$result = $conn->query($sql);

$error = mysqli_error($conn);
//echo "Error: $error";

$counter = 0;

while($row = mysqli_fetch_array($result)) {

    $counter++;
    $entry_time = $row['entry_time'];
    $siren = $row['siren'];
    $callsign = $row['callsign'];
    $location = $row['location'];
    $tonequality = $row['tonequality'];
    $voicequality = $row['voicequality'];
    $insideout = $row['insideout'];

/*
$user_sql = "SELECT user, COUNT(*) AS magnitude FROM Checkins WHERE callsign = \"$callsign\" GROUP BY user ORDER BY magnitude DESC LIMIT 1";
        $user_result = $conn->query($user_sql);
        $user_row=mysqli_fetch_array($user_result);
    
    $user= $user_row['user'];
*/

    $datastring = $datastring."<tr><td>$entry_time</td> <td>$user</td> <td><a href=\"./user.php?callsign=$callsign\">$callsign</a></td> <td>$siren<br></td> <td>$location</td> <td>$tonequality</td> <td>$voicequality</td><td>$insideout</td></tr>";
} 

echo "Checkins: $counter";
echo "<br><br>";
echo "<table>";
echo "<th>Time</th> <th>User</th> <th>Callsign</th> <th>Siren</th> <th>Location</th> <th>Tone Quality</th> <th>Voice Quality</th> <th>Inside/Outside</th>";
echo "$datastring";
echo "</table>";


?>


</body>
</html>
