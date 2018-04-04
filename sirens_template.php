<?php 
	
	function sirenHeader($title){

		echo '<!DOCTYPE html>
							<html>
							 <head>
							    <meta charset="utf-8">
							    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
							    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
							    <link rel="stylesheet" type="text/css" href="sirens.css">
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
    ';
	}

	function sirenFooter(){
		echo '    </div> <!--End of class=bodycontent -->
								<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
								<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
								<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
								</body>
								</html>
								';

	}





 ?>