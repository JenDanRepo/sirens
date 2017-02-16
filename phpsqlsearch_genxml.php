<?php
header("Content-type: text/xml");
require("phpsqlsearch_dbinfo.php");

// Get parameters from URL
//$center_lat = $_GET["lat"];


// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
} 
$callsign = mysqli_real_escape_string($conn, $_GET['callsign']);

$sql = "SELECT number, address, CONCAT(number,\" - \",name) as name, lat, lng FROM Sirens WHERE number IN (SELECT siren FROM Checkins)";

// Find Sirens that $callsign has checked
// should only do if callsign is not null

if ($callsign !== ""){

  $sql = "SELECT number, address, CONCAT(number,\" - \",name) as name, lat, lng FROM Sirens WHERE number IN (SELECT siren FROM Checkins WHERE callsign = \"$callsign\")";

  $result = $conn->query($sql) or die(mysqli_error());

  // Iterate through the rows, adding XML nodes for each
  while ($row = mysqli_fetch_array($result)){
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
$sql = "SELECT number, address, CONCAT(number,\" - \",name) as name, lat, lng FROM Sirens WHERE number IN (SELECT siren FROM Checkins WHERE callsign <> \"$callsign\")";

$result = $conn->query($sql) or die(mysqli_error());

// Iterate through the rows, adding XML nodes for each
while ($row = mysqli_fetch_array($result)){
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("id", $row['number']);
  $newnode->setAttribute("name", $row['name']);
  $newnode->setAttribute("address", $row['address']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("type", "someone");
  //echo "we're in the loop<br>";
}

// Find sirens that have not been checked
$sql = "SELECT number, address, CONCAT(number,\" - \",name) as name, lat, lng FROM Sirens WHERE number NOT IN (SELECT siren FROM Checkins)";

$result = $conn->query($sql) or die(mysqli_error());

while ($row = mysqli_fetch_array($result)){
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("id", $row['number']);
  $newnode->setAttribute("name", $row['name']);
  $newnode->setAttribute("address", $row['address']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("type", "unchecked");
  //echo "we're in the loop<br>";
}

echo $dom->saveXML();
?>


