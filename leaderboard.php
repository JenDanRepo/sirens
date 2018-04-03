<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="sirens.css">
<html>
 <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Siren Net Leaderboard</title>
 </head>
<body>

<div class="pagetitle">
    <h1>SFSiren.net</h1>
</div>
<div class="nav_menu">
    <ul>
    <li><a href="./checkins.php">Checkins</a></li>
    <li><a href="./leaderboard.php">Leaderboard</a></li>
    <li><a href="./view_sirens.php">Siren List</a></li>
    <li><a href="./maps.php">User Summary</a></li>
    <li><a href="./about.php">About</a></li>
    </ul>
</div>
    <div class="bodycontent">

        <h2>Leaderboard</h2>
        <small>
        <?php
            $mytimestamp = date('Y-m-d H:i:s');
            echo "As of $mytimestamp";
        ?>
        </small>

        <div class="comtainer">
            <div class="row">
                <div class="col">
                    <h2 class="text-center">
                        Most sirens checked in
                    </h2>
                    <?php

                    require('phpsqlsearch_dbinfo.php');
                    require('php_siren_lib.php');

                    $pdostring = 'mysql:host=' . $servername .';dbname=' . $dbname .';charset=utf8mb4';

                    $db = new PDO($pdostring, $username, $password);
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

                    $stmt = $db->query('select callsign, count(*) as c FROM Checkins GROUP BY callsign ORDER BY c desc');
                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Table Head for sirens!
                    echo '<table class="table table-sm">';
                    echo '<thead class="thead-dark">
                            <tr>
                                <th>Rank</th>
                                <th>Callsign</th>
                                <th>Name</th>
                                <th>Checkins</th>
                            </tr>
                          </thead>';

                    // Table Rows!
                    $rank = 1;
                    while ($row = array_shift($results)){
                        $callsign = $row['callsign'];
                        
                        $user = get_user_from_callsign($callsign);
                        $qty = $row['c']; // c stands for "count" or "quantity of checkins"
                        echo "<tr><td>$rank</td><td><a href=\"./maps.php?callsign=$callsign\">$callsign</a></td> <td>$user</td> <td>$qty</td></tr>";
                        $rank++;
                    } 

                    echo "</table>";

                    ?>
                </div> <!--End of class col-->
                <div class="col">
                    <h2 class="text-center">
                        Different sirens checked
                    </h2>
                    <?php
                        echo '<table class="table table-sm">';
                        echo '<thead class="thead-dark">
                                <tr>
                                    <th>Rank</th>
                                    <th>Number</th>
                                    <th>Callsign</th>
                                    <th>Name</th>
                                </tr>
                              </thead>';
                        // require('phpsqlsearch_dbinfo.php');
                        // require('php_siren_lib.php');

                        echo "<tbody>";
                        $pdostring = 'mysql:host=' . $servername .';dbname=' . $dbname .';charset=utf8mb4';

                        $db = new PDO($pdostring, $username, $password);
                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

                        $stmt = $db->query('SELECT count(DISTINCT siren) AS Count, callsign FROM Checkins GROUP BY callsign Order By Count desc');
                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        $rank = 1;

                        echo "<tbody>";
                        while ($row = array_shift($results)){
                            $count = $row['Count'];
                            $callsign = $row['callsign'];
                            
                            $user = get_user_from_callsign($callsign);
                            $qty = $row['c']; // c stands for "count" or "quantity of checkins"
                            echo "<tr>
                                    <td>$rank</td>
                                    <td>$count</td>
                                    <td><a href=\"./maps.php?callsign=$callsign\">$callsign</a></td>
                                    <td>$user</td>
                                </tr>";
                            $rank++;
                        } 
                        echo "</tbody>";
                        echo "</table>";
                    ?>
                    
                </div> <!--End of class col-->
             </div> <!-- End of class row-->
        </div> <!--End of class container-->
    </div> <!--End of class=bodycontent -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>