<?php
include 'db_setup.php';

if(isset($_POST['edit_team']))
{
	$tid=$_POST['row_id'];
	$teamname=$_POST['team_name'];
	$gamedets=$_POST['team_gdet'];
	$vsopp=$_POST['team_vsopp'];

	$gd = 0;
	$vso = 0;
	
	if ($gamedets == "true")
		{
		$gd = 1;
		}
		
	if ($vsopp == "true")
		{
		$vso = 1;
		}

	mysqli_query($link, "UPDATE bowlteams SET team_name='$teamname',game_details='$gd',versus_opp='$vso',updated=CURRENT_TIMESTAMP WHERE team_id='$tid'");
	echo "success";
	exit();
}

if(isset($_POST['delete_team']))
	{
	$row_no=$_POST['row_id'];
	
	$findBowlerGames = "SELECT * FROM bowlweek WHERE team_id = '$row_no'";
	
	$result = mysqli_query($link, $findBowlerGames);
	
	if (mysqli_num_rows($result) > 0)
		{
		echo "teams";
		exit();
		}
		
	mysqli_query($link, "DELETE FROM bowlteams WHERE team_id='$row_no'");
	echo "success";
	exit();
	}

if(isset($_POST['insert_team']))
	{
	$teamname=$_POST['team_name'];
	$gamedetails=$_POST['team_gdet'];
	$vsopp=$_POST['team_vsopp'];
	$leagueid=$_POST['team_league'];
	$gd = 0;
	$vso = 0;
	
	if ($gamedetails == "true")
		{
		$gd = 1;
		}
		
	if ($vsopp == "true")
		{
		$vso = 1;
		}
	
	$sqlString = "INSERT INTO bowlteams VALUES(default,'$teamname','$gd','$vso','$leagueid', CURRENT_TIMESTAMP)";
	mysqli_query($link, $sqlString);
	
	echo mysqli_insert_id($link);
	exit();
	}

if(isset($_POST['insert_league']))
	{
	$leaguename=$_POST['league_name'];	
	$location = $_POST['league_loc'];
	$year = $_POST['league_year'];

	$sqlString = "INSERT INTO bowlleagues VALUES(default,'$leaguename','$location',$year, CURRENT_TIMESTAMP)";
	mysqli_query($link, $sqlString);
		
	echo mysqli_insert_id($link);
	exit();
	}
	
if(isset($_POST['delete_league']))
	{
	$row_no=$_POST['row_id'];
	
	$checkLeague = "SELECT * FROM bowlteams WHERE league_id = '$row_no'";
	
	$result = mysqli_query($link, $checkLeague);
	
	if (mysqli_num_rows($result) > 0)
		{
		echo "teams";
		exit();
		}
		
	mysqli_query($link, "DELETE FROM bowlleagues WHERE league_id='$row_no'");
	echo "success";
	exit();
	}
	
if(isset($_POST['edit_league']))
{
	$lid=$_POST['row_id'];
	$lname=$_POST['league_name'];
	$location=$_POST['league_loc'];
	$year=$_POST['league_year'];

	mysqli_query($link, "UPDATE bowlleagues SET league_name='$lname',location='$location',year='$year',updated=CURRENT_TIMESTAMP WHERE league_id='$lid'");
	echo "success";
	exit();
}

?>
