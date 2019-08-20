<?php
header("Content-type: text/xml");
require("phpsqlsearch_dbinfo.php");

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

$pdostring = 'mysql:host=' . $servername .';dbname=' . $dbname .';charset=utf8mb4';
$db = new PDO($pdostring, $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

$callsign = $_GET['callsign'];
$netdate = $_GET['netdate'];

// Find Sirens that $callsign has checked
// should only do if callsign is not null



$stmt = $db->prepare('SELECT number, address, CONCAT(number," - ",name) as name, lat, lng FROM Sirens WHERE number IN (SELECT DISTINCT Checkins.siren FROM Checkins JOIN Nets ON Checkins.net = Nets.id WHERE Nets.net_date = ?)');
$stmt->execute(array($netdate));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Iterate through the rows, adding XML nodes for each
while ($row = array_shift($rows)){
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("id", $row['number']);
  $newnode->setAttribute("name", $row['name']);
  $newnode->setAttribute("address", $row['address']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("type", "checked");
  //echo "we're in the loop<br>";
}



// Find locations of siren reporters.

$stmt = $db->prepare('SELECT number, address, CONCAT(number," - ",name) as name, lat, lng FROM Sirens WHERE number IN (SELECT siren FROM Checkins WHERE callsign <> ? AND number NOT IN (SELECT siren from Checkins WHERE callsign = ?))');
$stmt->execute(array($callsign, $callsign));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Iterate through the rows, adding XML nodes for each
while ($row = array_shift($rows)){
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("id", $row['number']);
  $newnode->setAttribute("name", $row['name']);
  $newnode->setAttribute("address", $row['address']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("type", "person");
}

// Find sirens that have not been checked
// sql SELECT Sirens.number FROM Sirens WHERE Sirens.number NOT IN (SELECT DISTINCT Checkins.siren FROM Checkins JOIN Nets ON Checkins.net = Nets.id WHERE Nets.net_date = '2019-07-30'AND Checkins.siren NOT IN (0))

$stmt = $db->prepare('SELECT number, address, CONCAT(number," - ",name) as name, lat, lng FROM Sirens WHERE number IN (SELECT Sirens.number FROM Sirens WHERE Sirens.number NOT IN (SELECT DISTINCT Checkins.siren FROM Checkins JOIN Nets ON Checkins.net = Nets.id WHERE Nets.net_date = ? AND Checkins.siren NOT IN (0)))');
$stmt->execute(array($netdate));
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Iterate through the rows, adding XML nodes for each
while ($row = array_shift($rows)){
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("id", $row['number']);
  $newnode->setAttribute("name", $row['name']);
  $newnode->setAttribute("address", $row['address']); 
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("type", "unchecked");
}

echo $dom->saveXML();
?>


