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



// Make a list of sirens

$stmt = $db->prepare('SELECT number, address, CONCAT(number," - ",name) as name, lat, lng, language FROM Sirens');
$stmt->execute();
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
  $newnode->setAttribute("type", $row['language']);
}


echo $dom->saveXML();
?>


