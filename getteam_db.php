<?php

//Softball DB
include 'db_setup.php';

/* return name of current default database */
if ($result = mysqli_query($link, "SELECT DATABASE()")) {
    $row = mysqli_fetch_row($result);
    //printf("Default database is %s.\n", $row[0]);
    if ($row[0] != DB_DB) {
        printf("Connect failed: Wrong Database %s\n");
        exit();
    }
    mysqli_free_result($result);
}

$teamsBowlers = array();
$team_num = $_GET["team"];

header('Content-Type: application/json; charset=utf-8', true,200);

$SQLquery  = "SELECT * FROM bowlteams WHERE team_id=$team_num ";

$result = mysqli_query($link, $SQLquery);

$teamInfo = mysqli_fetch_array($result,MYSQLI_ASSOC);

$SQLquery  = "SELECT * FROM teambowlers tb JOIN bowlers b ON tb.bowler_id=b.bowler_id WHERE tb.team_id=$team_num";

if ($result = mysqli_query($link, $SQLquery)) 
	{
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
		{
        $teamsBowlers[] = $row;
        }
    }
	
$SQLquery  = "SELECT * FROM bowlweek WHERE team_id = '$team_num' ORDER BY datetime DESC";

if ($result = mysqli_query($link, $SQLquery)) 
	{
	if (mysqli_num_rows($result) > 0)
		{
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
			{
			$weeks[] = $row;
			}
		$teamData['weeks'] = $weeks;		
		}
	}
	
$teamData['data'] = $teamInfo;
$teamData['bowlers'] = $teamsBowlers;

header("Access-Control-Allow-Origin: *");
echo json_encode($teamData);

// Close connection
mysqli_close($link);
?>
