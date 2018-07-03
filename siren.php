<?php
    require('sirens_template.php');
    sirenHeader("Siren " . $_GET['number'] . " Details");
?>
<?php

require('phpsqlsearch_dbinfo.php');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
} /*else {
	echo "<p>DB seems to be working as user: $username.</p>";
} */

$siren_number = mysqli_real_escape_string($conn, $_GET['number']);

echo "<h2>Detail for Siren $siren_number</h2>";

$mytimestamp = date('Y-m-d H:i:s');
echo "<!--Timestamp is: $mytimestamp<br>-->";

if ($siren_number == ""){

    echo "<h3>You have to pick a siren</h3>";

    $sql = "SELECT * FROM Sirens" or die(mysqli_error());
    $result = $conn->query($sql);

        echo '<table class="table table-sm">';
        echo '<thead>';
        echo '<tr class="thead-dark">';
        echo "
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
        echo '</thead>';
        echo '<tbody>';

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

        echo "</tbody>";
        echo "</table>";

        mysqli_close($conn);

        exit;


}







// SQL for siren info
$sql = "SELECT * FROM Sirens WHERE number = \"$siren_number\" LIMIT 1";

$result = $conn->query($sql);
$siren_string="";

while($row = mysqli_fetch_array($result)) {
    // $user = $row['user'];
    $number = $row['number'];
    $name = $row['name'];
    $language = $row['language'];
    $address = $row['address'];
    $city = $row['city'];
    $state = $row['state'];
    $zip = $row['zip'];
    $lat  = $row['lat'];
    $lng = $row['lng'];

    $siren_string = "<table>";
    $siren_string = '<table class="table table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th>Siren Info
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
    $siren_string = $siren_string . "<tr><td>Number: $number</td>";
    $siren_string = $siren_string . "<tr><td>Name: $name</td>";
    $siren_string = $siren_string . "<tr><td>Language: $language</td>";
    $siren_string = $siren_string . "<tr><td>Address: $address</td>";
    $siren_string = $siren_string . "<tr><td>City: $city</td>";
    $siren_string = $siren_string . "<tr><td>State: $state</td>";
    $siren_string = $siren_string . "<tr><td>Zip: $zip</td>";
    $siren_string = $siren_string . "<tr><td>Lat: $lat</td>";
    $siren_string = $siren_string . "<tr><td>Long: $lng</td>";
    $siren_string = $siren_string . "</tbody>
                                    </table>";
}

echo $siren_string;

// Siren Leaderboard

echo "<h3>Check-in Leaders</h3>";

$user = "";

$sql = "SELECT callsign, COUNT(*) AS magnitude FROM Checkins WHERE siren = \"$siren_number\"  GROUP BY user ORDER BY magnitude DESC";

$result = $conn->query($sql);

$leadstring = '<table class="table table-sm">';
$leadstring = $leadstring . '<thead class="thead-dark">';
$leadstring = $leadstring . "<tr><th>Callsign</th><th>Name</th><th>Check-ins</th>";
$leadstring = $leadstring . '</thead>';
while($row = mysqli_fetch_array($result)) {
    $callsign = $row['callsign'];
    $magnitude = $row['magnitude'];
    // get the user's name too

    $user_sql = "SELECT user, COUNT(*) AS magnitude FROM Checkins WHERE callsign = \"$callsign\" GROUP BY user ORDER BY magnitude DESC LIMIT 1";
        $user_result = $conn->query($user_sql);
        $user_row=mysqli_fetch_array($user_result);
    
    $user= $user_row['user'];

    $leadstring = $leadstring . "<tr>";
    $leadstring = $leadstring . "<td><a href=\"./maps.php?callsign=$callsign\">$callsign</a></td>";
    $leadstring = $leadstring . "<td>$user</td>";
    $leadstring = $leadstring . "<td>$magnitude</td>";
    $leadstring = $leadstring . "</tr>";

}
$leadstring = $leadstring . "</table>";

echo $leadstring;
// End Siren Leaderboard


echo "<h3>Check-ins:</h3>";

$sql = "SELECT * FROM Checkins WHERE siren=\"$siren_number\" ORDER BY entry_time DESC";
$result = $conn->query($sql);

$error = mysqli_error($conn);
//echo "Error: $error";

$counter = 0;

while($row = mysqli_fetch_array($result)) {

    $counter++;
    $entry_time = $row['entry_time'];
    $siren = $row['siren'];
    $callsign = $row['callsign'];
    $location = $row['location'];
    $tonequality = $row['tonequality'];
    $voicequality = $row['voicequality'];
    $insideout = $row['insideout'];


    $user_sql = "SELECT user, COUNT(*) AS magnitude FROM Checkins WHERE callsign = \"$callsign\" GROUP BY user ORDER BY magnitude DESC LIMIT 1";
        $user_result = $conn->query($user_sql);
        $user_row=mysqli_fetch_array($user_result);
    
    $user= $user_row['user'];


    $datastring = $datastring."<tr><td>$entry_time</td> <td>$user</td> <td><a href=\"./maps.php?callsign=$callsign\">$callsign</a></td> <td>$siren<br></td> <td>$location</td> <td>$tonequality</td> <td>$voicequality</td><td>$insideout</td></tr>";
} 

echo "Checkins: $counter";
echo "<br><br>";
echo '<table class="table table-sm">';
        echo '<thead>';
        echo '<tr class="thead-dark">';
echo "<th>Time</th> <th>User</th> <th>Callsign</th> <th>Siren</th> <th>Location</th> <th>Tone Quality</th> <th>Voice Quality</th> <th>Inside/Outside</th>";
echo "</thead>";
echo '<tbody>';
echo "$datastring";
echo '</tbody>';
echo "</table>";


?>


<?php
    sirenFooter();
?>
