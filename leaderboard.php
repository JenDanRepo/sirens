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
require('php_siren_lib.php');

$pdostring = 'mysql:host=' . $servername .';dbname=' . $dbname .';charset=utf8mb4';

$db = new PDO($pdostring, $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

$stmt = $db->query('select callsign, count(*) as c FROM Checkins GROUP BY callsign ORDER BY c desc');
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<table border=1>";
echo "<th>Callsign</th> <th>Name</th> <th>Number of Checkins</th>";

while ($row = array_shift($results)){
    $callsign = $row['callsign'];
    
    $user = get_user_from_callsign($callsign);
    $qty = $row['c']; // c stands for "count" or "quantity of checkins"
    echo "<tr><td><a href=\"./maps.php?callsign=$callsign\">$callsign</a></td> <td>$user</td> <td>$qty</td></tr>";
} 

echo "</table>";

?>

</body>
</html>