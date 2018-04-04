<?php
    require('sirens_template.php');
    sirenHeader();
?>

        <h2>Leaderboard</h2>
        <small>
        <?php
            $mytimestamp = date('Y-m-d H:i:s');
            echo "As of $mytimestamp";
        ?>
        </small>

        <div class="comtainer-fluid">
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-md-6 col-lg-4 ">
                    <h2 class="text-center">
                        Most Sirens
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
                <div class="col-lg-4 col-md-6">
                    <h2 class="text-center">
                        Unique Sirens
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
<?php
    sirenFooter();
?>