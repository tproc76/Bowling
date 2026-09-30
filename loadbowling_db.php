<?php
include 'db_setup.php';

if(isset($_POST['save_week']))
	{
	$date=$_POST['date'];
	$team=$_POST['team'];
	$lane=$_POST['lane'];
	$opp=$_POST['opp'];
	$bowlers=(int)$_POST['bowlers'];
	$games=(int)$_POST['games'];

	$jsonData=$_POST['bowldata'];
	
	$matrixDataMatrix=json_decode($jsonData, true);
	$matrixData = $matrixDataMatrix['dataMatrix'];
	
	$sqlString = "SELECT * FROM bowlweek WHERE team_id='$team' AND datetime='$date'";
	
	$result = mysqli_query($link, $sqlString);
	
	if (mysqli_num_rows($result) == 0)
		{
		$sqlInsert = "INSERT INTO bowlweek VALUES(default,$team,'$date','$opp','$lane')";
		mysqli_query($link, $sqlInsert);
		
		$ret['result'] = "wadded";
		$weekID = mysqli_insert_id($link);
	
		$ret['newWeekID'] = $weekID;
		$ret['bowlers'] = $bowlers;
		$ret['games'] = $games;

		
		if ($matrixData == null)
			{
			$ret['result'] = "failed";
			$ret['message'] = "missing array";
			}
		else
			{
			for ($x = 0; $x < $bowlers; $x++)
				{
				$ret['x'] = $x;
				$playerID = $matrixData[$x][1];
				$ret['playerID'] = $playerID;

				for ($y = 1; $y < $games; $y++)
					{
						//			week_id				MEDIUMINT		NOT NULL,
						//			bowler_id			MEDIUMINT		NOT NULL,
						//			week_game      		TINYINT			NOT NULL,
						//			score	      		TINYINT			NOT NULL,
						//			strikes      		TINYINT			NOT NULL,
						//			spare	      		TINYINT			NOT NULL,
					$score = $matrixData[$x][$y+1];
					if ($score > 0)
						{
						$sqlInsert = "INSERT INTO bowlgame VALUES($weekID,$playerID,$y,$score,-1,-1)";
						$result = mysqli_query($link, $sqlInsert);
						
						if ($result == false)
							{
							$ret['message'] = mysqli_error($link);
							// Set loops to exit
							$x = $bowlers;
							$y = $games;
							}
						else
							{
							$ret['result'] = "success";
							}
						}
					}
				}
			}
		$SQLquery  = "SELECT * FROM bowlweek WHERE team_id = '$team' ORDER BY datetime DESC";

		if ($result = mysqli_query($link, $SQLquery)) 
			{
			while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
				{
				$weeks[] = $row;
				}
			}

		$ret['weeks'] = $weeks;		
		}
	else
		{
		$ret['result'] = "duplicate";
		}
		
	header("Access-Control-Allow-Origin: *");
	echo json_encode($ret);
	exit();
	}
	
if(isset($_POST['delete_week']))
	{
	$weekID=$_POST['week'];
	$teamID=$_POST['team'];
	
	$deleteLeague = "DELETE FROM bowlweek WHERE team_id = '$teamID' AND week_id = '$weekID'";
	
	$result = mysqli_query($link, $deleteLeague);

	$SQLquery  = "SELECT * FROM bowlweek WHERE team_id = '$teamID' ORDER BY datetime DESC";

	if ($result = mysqli_query($link, $SQLquery)) 
		{
		if (mysqli_num_rows($result) > 0)
			{
			while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
				{
				$weeks[] = $row;
				}
			$ret['weeks'] = $weeks;		
			}
		}
		

	$ret['result'] = "success";
	header("Access-Control-Allow-Origin: *");
	echo json_encode($ret);

	exit();
	}

if(isset($_POST['show_week']))
	{
	$weekID=$_POST['week'];
	//$teamID=$_POST['team'];  passed in, but not needed???

	// Assume success, but update below if something isn't right.
	$ret['result'] = "success";
	
	$SQLquery  = "SELECT * FROM bowlweek WHERE week_id = '$weekID'";

	if ($result = mysqli_query($link, $SQLquery)) 
		{
		if (mysqli_num_rows($result) == 1)
			{
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			$ret['week'] = $row;		
			}
		else
			{
			$ret['result'] = "failed:bowlweek";
			}
		}
		
	$SQLquery  = "SELECT * FROM bowlgame WHERE week_id = '$weekID'";

	if ($result = mysqli_query($link, $SQLquery)) 
		{
		if (mysqli_num_rows($result) > 0)
			{
			while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
				{
				$games[] = $row;
				}
			$ret['games'] = $games;		
			}
		else
			{
			$ret['result'] = "failed:bowlgame";
			}
		}

	header("Access-Control-Allow-Origin: *");
	echo json_encode($ret);

	exit();
	}	
?>
