<?php
require "config.php";
$mytimestamp = date('Y-m-d H:i:s');
//echo "Timestamp is: $mytimestamp<br>";

require('phpsqlsearch_dbinfo.php');
//echo "loaded phpsqlsearch_dbinfo.php";

if ($LS->isLoggedIn() != 1){
    header('Location: http://sfsiren.net/login.php');
    die();
} 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
} else {
	//echo "<p>DB seems to be working as user: $username.</p>";
}

// Form that submits to this script is in add_checkin.php

$user = mysqli_real_escape_string($conn, $_POST['user']);
$callsign = strtoupper(mysqli_real_escape_string($conn, $_POST['callsign']));
$siren = mysqli_real_escape_string($conn, $_POST['siren']);
$location = mysqli_real_escape_string($conn, $_POST['location']);
$tonequality = mysqli_real_escape_string($conn, $_POST['tonequality']);
$voicequality = mysqli_real_escape_string($conn, $_POST['voicequality']);
$insideout = mysqli_real_escape_string($conn, $_POST['insideout']);
$entry_time = $mytimestamp;


if ( $siren == '' ){
    $siren = 0;
}

$sql="INSERT INTO Checkins (user, callsign, siren, location, tonequality, voicequality, entry_time, insideout, net) VALUES (\"$user\", \"$callsign\", \"$siren\", \"$location\", \"$tonequality\", \"$voicequality\", \"$entry_time\", \"$insideout\", (SELECT id FROM Nets WHERE start_time < NOW() AND NOW() < end_time) )";

//echo "SQL Statement: $sql<br><br>";

if (mysqli_query($conn, $sql)) {
    header('Location: checkins.php');
    // header('Location: http://sfsiren.net/checkins.php');
    die();
    echo "New record created successfully";
    echo "Back to <a href=\"./checkins.php\">Checkins Page</a>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

?>

<html>
 <head>
  <title>PHP Test</title>
 </head>
<body>


</body>
</html>
