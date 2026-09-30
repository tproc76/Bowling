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

$team_num = $_GET["team"];

header('Content-Type: application/json; charset=utf-8', true,200);

$SQLquery  = "SELECT * FROM bowlteams WHERE team_id=$team_num ";

$result = mysqli_query($link, $SQLquery);

$teamData['team'] = mysqli_fetch_array($result,MYSQLI_ASSOC);;

$SQLquery  = "SELECT * FROM teambowlers tb JOIN bowlers b ON tb.bowler_id=b.bowler_id WHERE team_id=$team_num ORDER BY b.bowler_id ASC";

if ($result = mysqli_query($link, $SQLquery)) 
	{
	if (mysqli_num_rows($result) > 0)
		{
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
			{
			$bowlers[] = $row;
			}
		$teamData['bowlers'] = $bowlers;		
		}
	}

$SQLquery  = "SELECT t.team_id,t.team_name,b.bowler_id,b.fullname,b.nickname,w.week_id,DATE(w.datetime) AS week_date,COUNT(g.week_game) AS games_played,SUM(g.score) AS total_score,ROUND(AVG(g.score), 2) AS week_average " .
				"FROM bowlgame g JOIN bowlers b ON g.bowler_id = b.bowler_id " .
				"JOIN bowlweek w ON g.week_id = w.week_id " .
				"JOIN bowlteams t ON w.team_id = t.team_id " .
				"WHERE t.team_id = '$team_num' " .
				"GROUP BY b.bowler_id,b.fullname,b.nickname,w.week_id,DATE(w.datetime) " .
				"ORDER BY w.datetime ASC, b.bowler_id ASC";
	
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

header("Access-Control-Allow-Origin: *");
echo json_encode($teamData);

// Close connection
mysqli_close($link);
?>
