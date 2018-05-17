<?php
    require('sirens_template.php');
    sirenHeader("Siren List");
?>

<?php

$mytimestamp = date('Y-m-d H:i:s');
echo "As of $mytimestamp<br>";

require('phpsqlsearch_dbinfo.php');
require('php_siren_lib.php');

/*
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
} 

// SQL to print out the table

$sql = "SELECT * FROM Sirens" or die(mysqli_error());
$result = $conn->query($sql);
*/

$pdostring = 'mysql:host=' . $servername .';dbname=' . $dbname .';charset=utf8mb4';
$db = new PDO($pdostring, $username, $password);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

echo "
    <iframe src=\"https://www.google.com/maps/d/embed?mid=15r3FQk78LViQYE2N537Gxky_-UY\" width=\"640\" height=\"480\"></iframe>
";


echo '<table class="table table-sm">';
echo '<thead>';
echo '<tr class="thead-dark">
<th>Number</th>
<th>Name</th>
<th>Language</th>
<th>Address</th>
<th>City</th>
<th>State</th>
<th>Zip</th>
<th>Lat</th>
<th>Lng</th>
</tr>
';
echo '</thead>';
echo '<tbody>';

foreach($db->query('SELECT * FROM Sirens') as $row) {
//while($row = mysqli_fetch_array($result)) {
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
echo '</tbody>';
echo "</table>";


//mysqli_close($conn);

?>
<?php
    sirenFooter();
?>