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

// Find Sirens that $callsign has checked
// should only do if callsign is not null

if ($callsign !== ""){

  $stmt = $db->prepare('SELECT number, address, CONCAT(number," - ",name) as name, lat, lng FROM Sirens WHERE number IN (SELECT siren FROM Checkins WHERE callsign = ?)');
  $stmt->execute(array($callsign));
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
}


// Find sirens that were checked by someone other than $callsign

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
  $newnode->setAttribute("type", "someone");
}

// Find sirens that have not been checked

foreach($db->query('SELECT number, address, CONCAT(number," - ",name) as name, lat, lng FROM Sirens WHERE number NOT IN (SELECT siren FROM Checkins)') as $row) {
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


