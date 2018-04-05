<?php

$mytimestamp = date('Y-m-d H:i:s');
echo "Timestamp is: $mytimestamp<br>";

require('phpsqlsearch_dbinfo.php');

$pdostring = 'mysql:host=' . $servername .';dbname=' . $dbname .';charset=utf8mb4';

//echo "Pdostring = $pdostring";

$db = new PDO($pdostring, $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

foreach($db->query('SELECT * FROM Checkins') as $row) {
    echo $row['callsign'].' '.$row['siren']; //etc...
}

echo "<p>Next Query</p>";

$callsign = "KK6VNY";
$user = "Dan";

$stmt = $db->prepare("SELECT * FROM Checkins WHERE callsign=? AND user=?");
$stmt->execute(array($callsign, $user));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

while ($row = array_shift($rows)){
	echo $row['callsign'];
	echo $row['siren'];
	echo $row['user'];
}


?>