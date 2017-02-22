<html>
 <head>
  <title>Siren Net Leaderboard</title>
 </head>
<body>

<h1>SFSiren.net</h1>
        <a href="./checkins.php">Checkins</a>
        <a href="./leaderboard.php">Leaderboard</a>
        <a href="./view_sirens.php">Siren List</a>
        <a href="./maps.php">User Summary</a>
        <a href="./about.php">About</a>
        <hr>

<h3>Leaderboard</h3>

<?php
$mytimestamp = date('Y-m-d H:i:s');
echo "As of $mytimestamp<br>";


require('phpsqlsearch_dbinfo.php');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
} 

$sql = "select callsign, count(*) as c FROM Checkins GROUP BY callsign ORDER BY c desc";

$result = $conn->query($sql);

// echo "<p>SQL:<br> $sql</p>";
echo "<table border=1>";
echo "<th>Callsign</th> <th>Name</th> <th>Number of Checkins</th>";

while($row = mysqli_fetch_array($result)) {
    $callsign = $row['callsign'];
    
    //$user = $row[''];
        $user_sql = "SELECT user, COUNT(*) AS magnitude FROM Checkins WHERE callsign = \"$callsign\" GROUP BY user ORDER BY magnitude DESC LIMIT 1";
        $user_result = $conn->query($user_sql);
        $user_row=mysqli_fetch_array($user_result);
    
    $user= $user_row['user'];
    $qty = $row['c'];
    echo "<tr><td><a href=\"./user.php?callsign=$callsign\">$callsign</a></td> <td>$user</td> <td>$qty</td></tr>";
} 

echo "</table>";

$error = mysqli_error($conn);
echo "Error: $error";

mysqli_close($conn);
?>

</body>
</html>