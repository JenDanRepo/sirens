
<?php

$mytimestamp = date('Y-m-d H:i:s');
//echo "Timestamp is: $mytimestamp<br>";

require('phpsqlsearch_dbinfo.php');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
} /*else {
	echo "<p>DB seems to be working as user: $username.</p>";
} */



//$user = mysqli_real_escape_string($conn, $_POST['user']);
// Note this is different because it's a GET method rather than POST
$callsign = mysqli_real_escape_string($conn, $_GET['callsign']);
/*
$callsign = mysqli_real_escape_string($conn, $_POST['callsign']);
$siren = mysqli_real_escape_string($conn, $_POST['siren']);
$location = mysqli_real_escape_string($conn, $_POST['location']);
$tonequality = mysqli_real_escape_string($conn, $_POST['tonequality']);
$voicequality = mysqli_real_escape_string($conn, $_POST['voicequality']);
$insideout = mysqli_real_escape_string($conn, $_POST['insideout']);
$entry_time = $mytimestamp;
*/

$user_sql = "SELECT user, COUNT(*) AS magnitude FROM Checkins WHERE callsign = \"$callsign\" GROUP BY user ORDER BY magnitude DESC LIMIT 1";
        $user_result = $conn->query($user_sql);
        $user_row=mysqli_fetch_array($user_result);
    
    $user= $user_row['user'];

$sql="SELECT * FROM Checkins WHERE callsign=\"$callsign\" ORDER BY entry_time DESC";

//echo "SQL Statement: $sql<br><br>";


$result = $conn->query($sql);

$counter = 0;

while($row = mysqli_fetch_array($result)) {
    $counter++;
    // $user = $row['user'];
    $entry_time = $row['entry_time'];
    $siren = $row['siren'];
    $callsign = $row['callsign'];
    $location = $row['location'];
    $tonequality = $row['tonequality'];
    $voicequality = $row['voicequality'];
    $insideout = $row['insideout'];
    //echo "<tr><td>$entry_time</td> <td>$user</td> <td>$callsign</td> <td>$siren<br></td> <td>$location</td> <td>$tonequality</td> <td>$voicequality</td></tr>";
    //echo "<br>$user<br>$entry_time<br>$siren<br>$callsign<br>$location<br>$tonequality<br>$voicequality<br>";
    $datastring = $datastring."<tr><td>$entry_time</td> <td>$user</td> <td>$callsign</td> <td>$siren<br></td> <td>$location</td> <td>$tonequality</td> <td>$voicequality</td><td>$insideout</td></tr>";
} 

echo "<h3>User Summary for $user</h3>";
echo "Checkins: $counter";
echo "<br><br>";
echo "<table>";
echo "<th>Time</th> <th>User</th> <th>Callsign</th> <th>Siren</th> <th>Location</th> <th>Tone Quality</th> <th>Voice Quality</th> <th>Inside/Outside</th>";
echo "$datastring";
echo "</table>";

mysqli_close($conn);

?>

<html>
 <head>
  <title>PHP Test</title>
 </head>
<body>


</body>
</html>
