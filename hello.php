<html>
 <head>
  <title>PHP Test</title>
 </head>
<body>

  <?php
   echo "<p>Hello World</p>" ;
//   phpinfo();

   date_default_timezone_set('America/Los_Angeles');
   $dateandtime = date('m/d/Y h:i:s a', time());
   echo "$dateandtime" ;
  ?>

<?php

require('phpsqlsearch_dbinfo.php');

if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
    echo 'We don\'t have mysqli!!!';
} else {
    echo '<p>Mysqli - Phew we have it!</p>';
}
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
} else {
	echo "<p>DB seems to be working as user: $username.</p>";
}

// SQL to print out the table

$sql = "SELECT * FROM Sirens" or die(mysqli_error());
$result = $conn->query($sql);

while($row = mysqli_fetch_array($result)) {
    $name = $row['name'];
    $lat = $row['lat'];
    $lng = $row['lng'];
    echo "<br>$name<br> $lat<br> $lng<br>";
} 


mysqli_close($conn);

phpinfo();
?>

</body>
</html>
