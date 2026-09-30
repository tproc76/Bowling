<?php
include 'db_setup.php';

if(isset($_POST['edit_team']))
{
	$tid=$_POST['tesm'];
	$bid=$_POST['bowler'];

	mysqli_query($link, "DELETE FROM teambowlers WHERE team_id='$tid' AND bowler_id='$bid'");
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

if(isset($_POST['update_team']))
{
	$tid=$_POST['tesm'];
	$bowler=$_POST['bowler'];
	$bowler_id = -1;
	
	$findBowler = "SELECT * FROM bowlers WHERE nickname = '$bowler'";
	$result = mysqli_query($link,$findBowler);
	
	if (mysqli_num_rows($result) == 1)
	{
		$row = mysqli_fetch_assoc($result);
		$bowler_id = $row['bowler_id'];
		$fullname = $row['fullname'];
		$ret = "success;" . $bowler_id . ";" . $fullname;
		$teamid = (int)$tid;
		
		$sqlString = "INSERT INTO teambowlers VALUES('$bowler_id', '$teamid', CURRENT_TIMESTAMP)";
		if(mysqli_query($link, $sqlString) == false)
		{
			echo "failure;insert unsuccessful";
			exit();
		}

		echo $ret;
		exit();
	}
	echo "missing;";
	exit();
}
?>
