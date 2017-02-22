<html>
 <head>
  <title>PHP Test</title>
 </head>
<body>
<h1>SFSiren.net</h1>
    <a href="./checkins.php">Checkins</a>
    <a href="./leaderboard.php">Leaderboard</a>
    <a href="./view_sirens.php">Siren List</a>
    <a href="./maps.php">User Summary</a>
    <a href="./about.php">About</a>
<hr>
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

// SQL to print out the table

$sql = "SELECT * FROM Sirens" or die(mysqli_error());
$result = $conn->query($sql);
echo "
    <iframe src=\"https://www.google.com/maps/d/embed?mid=15r3FQk78LViQYE2N537Gxky_-UY\" width=\"640\" height=\"480\"></iframe>
";


echo "
<table border=1>
<tr>
<th>number</th>
<th>name</th>
<th>language</th>
<th>address</th>
<th>city</th>
<th>state</th>
<th>zip</th>
<th>lat</th>
<th>lng</th>
</tr>
";

while($row = mysqli_fetch_array($result)) {
    $id = $row['id'];
    $number = $row['number'];
    $name = $row['name'];
    $language = $row['language'];
    $address = $row['address'];
    $city = $row['city'];
    $state = $row['state'];
    $zip = $row['zip'];
    $lat = $row['lat'];
    $lng = $row['lng'];
    echo "<tr>";
    //echo "<br>$name<br> $lat<br> $lng<br>";
    //echo "<td> $id</td>";
    echo "<td> <a href=\"./siren.php?number=$number\">$number</a></td>";
    echo "<td> <a href=\"./siren.php?number=$number\">$name</a></td>";
    echo "<td> $language</td>";
    echo "<td> $address</td>";
    echo "<td> $city</td>";
    echo "<td> $state</td>";
    echo "<td> $zip</td>";
    echo "<td> $lat</td>";
    echo "<td> $lng</td>";
    echo "</tr>";
} 

echo "</table>";


mysqli_close($conn);

?>

</body>
</html>
