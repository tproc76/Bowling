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

$leagueteams = array();
$league_num = $_GET["league"];

header('Content-Type: application/json; charset=utf-8', true,200);

$SQLquery  = "SELECT * FROM bowlleagues h WHERE league_id=$league_num ";

$result = mysqli_query($link, $SQLquery);

$leagueInfo = mysqli_fetch_array($result,MYSQLI_ASSOC);

$SQLquery  = "SELECT * FROM bowlteams WHERE league_id=$league_num";

if ($result = mysqli_query($link, $SQLquery)) 
	{
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
		{
        $leagueteams[] = $row;
        }
    }

$leagueData['data'] = $leagueInfo;
$leagueData['teams'] = $leagueteams;
	
header("Access-Control-Allow-Origin: *");
echo json_encode($leagueData);

// Close connection
mysqli_close($link);
?>
