<!DOCTYPE html>
<html>
	<head>
        <title>League/Team View and Edit Page</title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="bowling,proctor" />

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
		<script type="text/javascript" src="dist-js/jquery-3.2.1.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script type="text/javascript" src="bowling_standard.js"></script>
		<script type="text/javascript" src="manage_teams.js"></script>
		
		<style>
		  .checkbox-readonly {
			pointer-events: none; /* Disables clicks */
			opacity: 1; /* Keeps normal appearance (optional) */
		  }
		</style>
	</head>
<body>

<?php
include 'db_setup.php';


?>

<!--top-header-->
<div class="row justify-content-md-center">
	<h1 id="pageheader">Bowling League List</h1>
	<BR><BR>
	<select name='leaguelist' id='leagueselect' onchange="changeLeague(this)">
			<?php 
				$dispLeague = 1;
				$dispLeageName = "";
				$curYear = date('Y');						
				$result =mysqli_query($link, "SELECT * FROM bowlleagues ORDER BY year");
				$selectOption = "";
				
				while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) 
					{
					$lid = $row['league_id'];
					$lname = $row['league_name'];
					$lyear = $row['year'];
					$selectOption .= "<option value='$lid' selected>$lname - $lyear</option>";
					$dispLeague = $lid;
					$dispLeageName = "$lname - $lyear";
					$dispLocation = $row['location'];
					}						
		
				$selectOption .= "</select>";
				echo $selectOption;
				
			?>
	</select>
</div>
	<br>
<div class="row justify-content-md-center">
	<table id="addleageue" border='1' cellspacing='1' cellpadding='5' class='center' >
		<tr>
			<th>LEAGUE NAME</th>
			<th>LOCATION</th>
			<th>YEAR</th>
			<th></th>
		</tr>
		
		<tr>
			<td id="lname"><?php echo $lname ?></td>
			<td id="llocation"><?php echo $dispLocation ?></td>
			<td id="lyear"><?php echo $lyear ?></td>
			<td>
					<input type='button' class="edit_button" id="ledit_button" value="edit" onclick="edit_league('<?php echo $lid;?>');">
					<input type='button' class="save_button" id="lsave_button" value="save" onclick="save_league('<?php echo $lid;?>');" style="display: none;">
					<input type='button' class="delete_button" id="ldelete_button" value="delete" onclick="delete_league('<?php echo $lid;?>');">
			</td>
		</tr>
		<tr>
			<td><input type="text" id="new_league"></td>
			<td><input type="text" id="new_location"></td>
			<td><input type="text" id="new_year"></td>
			<td><input type='button' value='Insert League' onclick="insert_league();"></td>
		</tr>
	</table>

</div>	

<!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
<div id="main" class="main">		
		
<br>

<div class="row justify-content-md-center">
	<h1 id="Leagueheader"><?php echo $dispLeageName ?> Team List</h1>
</div>
	<BR><BR>
<div class="row justify-content-md-center">
	<table id="bowlerteams" border='1' cellspacing='1' cellpadding='5' class='center' >
		<tr>
			<th>TEAM NAME</th>
			<th>GAME DETAILS</th>
			<th>VS OPPONENET</th>
			<th></th>
		</tr>
		<?php
			$leagueQuery = "SELECT * FROM bowlteams where league_id = '$dispLeague'";
			$result =mysqli_query($link, $leagueQuery);
			while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) 
				{
				?>
				<tr id="row<?php echo $row['team_id'];?>">
					<td id="tname<?php echo $row['team_id'];?>"><?php echo $row['team_name'];?></td>
					<td id="game_det<?php echo $row['team_id'];?>" style="text-align: center;">
						<input type="checkbox" id="gdet<?php echo $row['team_id'];?>" name="gamedet<?php echo $row['team_id']; ?>" 
							<?php
							if ($row['game_details'] != 0)
								{
								echo ' checked ';
								}
							?>
							class="checkbox-readonly">
					</td>
					<td id="vs_opp<?php echo $row['team_id'];?>" style="text-align: center;">
						<input type="checkbox" id="vsopp<?php echo $row['team_id'];?>" name="vs_opponent<?php echo $row['team_id']; ?>" 
						<?php
							if ($row['versus_opp'] != 0)
								{
								echo ' checked ';
								}
							?>
							class="checkbox-readonly" >	
					</td>
					<td>
					<input type='button' class="edit_button" id="edit_button<?php echo $row['team_id'];?>" value="edit" onclick="edit_team('<?php echo $row['team_id'];?>');">
					<input type='button' class="save_button" id="save_button<?php echo $row['team_id'];?>" value="save" onclick="save_team('<?php echo $row['team_id'];?>');" style="display: none;">
					<input type='button' class="delete_button" id="delete_button<?php echo $row['team_id'];?>" value="delete" onclick="delete_team('<?php echo $row['team_id'];?>');">
					</td>
			</tr>
		<?php
				}

		?>

		<tr id="new_row">
			 <td><input type="text" id="new_team"></td>
			 <td style="text-align: center;"><input type="checkbox" id="new_gdet"></td>
			 <td style="text-align: center;"><input type="checkbox" id="new_vsopp"></td>
			 <td><input type="button" value="Insert Row" onclick="insert_team();"></td>
		</tr>
		<tr>
			<td colspan="4" id ="message"></td>
		</tr>
	</table>
</div>
	<br>
<div class="row justify-content-md-center">
	<a href = "maintainance_bowl.php">Return to Maintainance</a>
	<br>
</div>
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