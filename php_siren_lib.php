<?php

function get_user_from_callsign($localcallsign){

	// This function accepts a callsign as a string and queries the database to find the 
	// Name recorded most frequently associated with that callsign.

	// For example I usually record myself as "Dan" but sometimes when I first started
	// keeping track, I used my initial: "desl". This function finds what has been used
	// most frequently and returns that.

	require('phpsqlsearch_dbinfo.php');

	$pdostring = 'mysql:host=' . $servername .';dbname=' . $dbname .';charset=utf8mb4';
	$db = new PDO($pdostring, $username, $password);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

	$stmt = $db->prepare("SELECT user, COUNT(*) AS magnitude FROM Checkins WHERE callsign = ? GROUP BY user ORDER BY magnitude DESC LIMIT 1");
	$stmt->execute(array($localcallsign));
	$resulting_user = $stmt->fetchAll(PDO::FETCH_ASSOC);

	return $resulting_user[0]['user'];

}

?>