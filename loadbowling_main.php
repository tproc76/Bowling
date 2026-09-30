<!DOCTYPE html>
<html>
	<head>
        <title>Save Bowling Results</title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="bowling,proctor" />

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
		<script type="text/javascript" src="dist-js/jquery-3.2.1.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script type="text/javascript" src="bowling_standard.js"></script>
		<script type="text/javascript" src="loadbowling_data.js"></script>
		
		<style>

		</style>
	</head>
<body>

<?php
include 'db_setup.php';


?>

<!--top-header-->
<div class="row justify-content-md-center">
	<h1 id="pageheader">Bowling League </h1>
	<br>
	<select name='leaguelist' id='leagueselect' onchange="changeLeague(this)">
			<?php 
				$dispLeague = 1;
				$dispLeageName = "";
				$curYear = date('Y');						
				$result =mysqli_query($link, "SELECT * FROM bowlleagues ORDER BY year");
				$selectLeagueOption = "";
				
				while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) 
					{
					$lid = $row['league_id'];
					$lname = $row['league_name'];
					$lyear = $row['year'];
					$selectLeagueOption .= "<option value='$lid' selected>$lname - $lyear</option>";
					$dispLeague = $lid;
					$dispLeageName = "$lname - $lyear";
					$dispLocation = $row['location'];
					}						
		
				$selectLeagueOption .= "</select>";
				echo $selectLeagueOption;
				
			?>
	</select>
	<br>
	<br>

</div>	

<!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
<div id="main" class="main">		
		
<br>
<div class="row justify-content-md-center">

	<h1 id="Leagueheader"><?php echo $dispLeageName ?> Team List</h1>
	<select name='teamlist' id='teamselect' onchange="changeTeam(this)">
	
		<?php
			$dispTeam = 1;		
			$teamQuery = "SELECT * FROM bowlteams where league_id = '$dispLeague'";
			$result =mysqli_query($link, $teamQuery);
			$selectTeamOption = "";
			while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) 
				{
				$tid = $row['team_id'];
				$tname = $row['team_name'];
				$selectTeamOption .= "<option value='$tid' selected>$tname</option>";
				$dispTeam = $tid;
				}
			$selectTeamOption .= "</select>";
			echo $selectTeamOption;
		?>
</div>	
	<BR><BR>
<div class="row justify-content-md-center">

			<input type="datetime-local" id="bowldate">
			Lane<input type='text' id="lane" size="5">
			<input type="button" value="Add Game" onclick="add_game();">
</div>
	<BR><BR>
<div class="row justify-content-md-center">
	<table id="bowlergames" border='1' cellspacing='1' cellpadding='5' class='center' >
		<tr>
			<th>NICKNAME</th>
			<th>Game 1</th>
		</tr>
		<?php
			$bowlerQuery = "SELECT * FROM teambowlers tb JOIN bowlers b ON tb.bowler_id=b.bowler_id WHERE team_id = '$dispTeam'";
			$result =mysqli_query($link, $bowlerQuery);
			$cnt = 1;
			while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) 
				{
				?>
				<tr id="row<?php echo $row['bowler_id'];?>">
					<td id="nname<?php echo $row['bowler_id'];?>"><?php echo $row['nickname'];?></td>
					
					<td>
						<input type='text' id="score1_<?php echo $cnt; $cnt++;?>" size="5">
					</td>
				</tr>
		<?php
				}

		?>


	</table>
</div>
	<br>
<div class="row justify-content-md-center">
	<p id ="message"></p>
	<br>
	<input type="button" value="Save Data" onclick="save_data()";>
</div>
	<br><br>
<div class="row justify-content-md-center">
	<table id="teamweeks" border='1' cellspacing='1' cellpadding='5' class='center' >
		<tr>
			<th>Date</th>
			<th>Action</th>
		</tr>
		<?php
			$bowlerQuery = "SELECT * FROM bowlweek WHERE team_id = '$dispTeam'";
			$result =mysqli_query($link, $bowlerQuery);
			while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) 
				{
				?>
				<tr id="row<?php echo $row['week_id'];?>">
					<td id="date<?php echo $row['week_id'];?>"><?php echo $row['datetime'];?></td>
					
					<td>
						<button type='button' onclick='showData(<?php echo $row['week_id'];?>,<?php echo $dispTeam;?>)'>Show</button>
						<button type='button' onclick='deleteData(<?php echo $row['week_id'];?>,<?php echo $dispTeam;?>)'>Delete</button>
					</td>
				</tr>
		<?php
				}

		?>
	</table>
</div>
	<br><br>
<div class="row justify-content-md-center">
	<a href = "maintainance_bowl.php">Return to Maintainance</a>
</div>
	<br>
	<div class="footer">
		<?php  
		$fullfilename = $_SERVER['REQUEST_URI']; 
		$fileparts = explode("?",basename($fullfilename));
		$filename = $fileparts[0];
		//echo $filename;
		//echo filemtime($filename);
		
		date_default_timezone_set('US/Eastern');
		// checking last time the contents of
		// a file were changed and formatting
		// the output of the date 
		//echo "Version:".date("y.md.Hi", filemtime($filename));
		echo "Updated: ".date("F d Y H:i:s", filemtime($filename));
		?>
	</div>	

</body>
</html>