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

<h4>Leaderboard</h4>

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



$sql = "select callsign, count(*) as c FROM Checkins GROUP BY callsign ORDER BY c desc";

$result = $conn->query($sql);

echo "<p>SQL:<br> $sql</p>";
echo "<h3>Most Recent Check Ins For Sirens:</h3>";
echo "<table>";
echo "<th>Callsign</th> <th>Name</th> <th>Number of Checkins</th>";

while($row = mysqli_fetch_array($result)) {
    $callsign = $row['callsign'];
    //$user = $row[''];
    $qty = $row['c'];
    echo "<tr><td>$callsign</td> <td>$user</td> <td>$qty</td></tr>";
} 


echo "</table>";

$error = mysqli_error($conn);
echo "Error: $error";




mysqli_close($conn);


?>

</body>
</html>