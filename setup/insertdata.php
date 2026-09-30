<?php
include 'db_setup.php';

header('Content-Type: application/json; charset=utf-8', true,200);
// $Create_BowlerTable = "CREATE TABLE bowlers(
								//bowler_id			MEDIUMINT		NOT NULL AUTO_INCREMENT,
								//nickname       		VARCHAR(25)		NOT NULL,
								//fullname			VARCHAR(50)		NOT NULL,
								//email				VARCHAR(50),
								//notes				VARCHAR(50),
								//CONSTRAINT PK_Bowlers PRIMARY KEY (bowler_id))";

$insertBowlers 	 = "INSERT INTO bowlers VALUES(default, 'Tim', 		 'Tim Proctor',     'proc@comcast.net', '');";
$insertBowlers	.= "INSERT INTO bowlers VALUES(default, 'Jeremy',    'Jeremy Fathers',  'jfathers@hotmail.com', NULL);";
$insertBowlers	.= "INSERT INTO bowlers VALUES(default, 'Mauricio',  'Mauricio Wallis', 'mauriciowallis943@gmail.com', NULL);";
$insertBowlers	.= "INSERT INTO bowlers VALUES(default, 'Brynn',     'Brynn Schaadt',   'brynnschaadt@gmail.com', NULL);";
$insertBowlers	.= "INSERT INTO bowlers VALUES(default, 'Andrew',    'Andrew LaPlaunt',  NULL, NULL);";

if(mysqli_multi_query($link, $insertBowlers) == false){
    echo "ERROR: Could not execute. " . mysqli_error($link) . "<br>";
}
do{} while(mysqli_more_results($link) && mysqli_next_result($link)); // flush multi_queries


$insertLeague	 = "INSERT INTO bowlleagues VALUES(default, 'Rec', 'All Star Lanes', 2024, CURRENT_TIMESTAMP)";

if(mysqli_multi_query($link, $insertLeague) == false){
    echo "ERROR: Could not execute. " . mysqli_error($link) . "<br>";
}
do{} while(mysqli_more_results($link) && mysqli_next_result($link)); // flush multi_queries

$findLeagueID = "SELECT * FROM bowlleagues where league_name = 'Rec' AND year = 2024";
$result = mysqli_query($link, $findLeagueID);

$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
$leagueid = $row['league_id'];
$insertBowlingTeam = "INSERT INTO bowlteams VALUES(default, 'Fun', false, false, $leagueid, CURRENT_TIMESTAMP)";

if(mysqli_multi_query($link, $insertBowlingTeam) == false){
    echo "ERROR: Could not execute. " . mysqli_error($link) . "<br>";
}
do{} while(mysqli_more_results($link) && mysqli_next_result($link)); // flush multi_queries

$insertBowlerLogin 	 = "INSERT INTO bowl_login VALUES(default, 'Tim Proctor',     'proc@comcast.net',  	'admin',	'938fc3247653b3132bb6d0ebeaf7f7e013745fc272f4c7c89c32a9cc2431f9c5', CURRENT_TIMESTAMP);";

if(mysqli_multi_query($link, $insertBowlerLogin) == false){
    echo "ERROR: Could not execute. " . mysqli_error($link) . "<br>";
}
do{} while(mysqli_more_results($link) && mysqli_next_result($link)); // flush multi_queries

echo "Complete";
 
// Close connection
mysqli_close($link);
?>
