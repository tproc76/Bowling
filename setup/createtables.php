<?php
include 'db_setup.php';

$Drop_LeagueTable = 'DROP TABLE bowlleagues';

$Create_LeagueTable = 'CREATE TABLE bowlleagues(
								league_id			SMALLINT		NOT NULL AUTO_INCREMENT,
								league_name			VARCHAR(50)		NOT NULL,
								location			VARCHAR(50)		NOT NULL,
								year                SMALLINT		NOT NULL,
								updated        		TIMESTAMP		DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
								CONSTRAINT PK_League PRIMARY KEY (league_id))';

if(mysqli_query($link, $Drop_LeagueTable)){
    echo "Drop League Table successfully.<br>";
} else{
    echo "ERROR: Could not able to execute. " . mysqli_error($link) . "<BR>";
}

if(mysqli_query($link, $Create_LeagueTable)){
    echo "Create League Table successfully.<br>";
} else{
    echo "ERROR: Could not able to execute. " . mysqli_error($link) . "<BR>";
}

$Drop_TeamTable = 'DROP TABLE bowlteams';

$Create_TeamTable = 'CREATE TABLE bowlteams(
								team_id				MEDIUMINT		NOT NULL AUTO_INCREMENT,
								team_name           VARCHAR(20)		NOT NULL,
								game_details        BOOL			NOT NULL,
								versus_opp    		BOOL			NOT NULL,
								league_id			SMALLINT		NOT NULL,
								updated        		TIMESTAMP		DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
								CONSTRAINT PK_Teams PRIMARY KEY (team_id))';

if(mysqli_query($link, $Drop_TeamTable)){
    echo "Drop Team Table successfully.<br>";
} else{
    echo "ERROR: Could not able to execute. " . mysqli_error($link) . "<BR>";
}

if(mysqli_query($link, $Create_TeamTable)){
    echo "Create Team Table successfully.<br>";
} else{
    echo "ERROR: Could not able to execute. " . mysqli_error($link) . "<BR>";
}

$Drop_BowlerTable = "DROP TABLE bowlers";

$Create_BowlerTable = "CREATE TABLE bowlers(
								bowler_id			MEDIUMINT		NOT NULL AUTO_INCREMENT,
								nickname       		VARCHAR(25)		NOT NULL,
								fullname			VARCHAR(50)		NOT NULL,
								email				VARCHAR(50),
								notes				VARCHAR(50),
								CONSTRAINT PK_Bowlers PRIMARY KEY (bowler_id))";

if(mysqli_query($link, $Drop_BowlerTable)){
    echo "Drop Bowler Table successfully.<br>";
} else{
    echo "ERROR: Could not able to execute. " . mysqli_error($link) . "<BR>";
}

if(mysqli_query($link, $Create_BowlerTable)){
    echo "Create Bowler Table successfully.<br>";
} else{
    echo "ERROR: Could not able to execute. " . mysqli_error($link) . "<BR>";
}

-------------------
$Drop_TeamBowlerTable = "DROP TABLE teambowlers";

$Create_TeamBowlerTable = "CREATE TABLE teambowlers(
								bowler_id			MEDIUMINT		NOT NULL,
								team_id				MEDIUMINT		NOT NULL,
								CONSTRAINT PK_TeamBowlers PRIMARY KEY (bowler_id,team_id))";

if(mysqli_query($link, $Drop_TeamBowlerTable)){
    echo "Drop Team Bowler Table successfully.<br>";
} else{
    echo "ERROR: Could not able to execute. " . mysqli_error($link) . "<BR>";
}

if(mysqli_query($link, $Create_TeamBowlerTable)){
    echo "Create Team Bowler Table successfully.<br>";
} else{
    echo "ERROR: Could not able to execute. " . mysqli_error($link) . "<BR>";
}

-------------

$Drop_WeekTable = "DROP TABLE bowlweek";

$Create_WeekTable = "CREATE TABLE bowlweek(
								week_id				MEDIUMINT		NOT NULL AUTO_INCREMENT,
								team_id             MEDIUMINT		NOT NULL,
								datetime       		TIMESTAMP		NOT NULL,
								opponent			VARCHAR(50)		NOT NULL,
								lane				VARCHAR(50)		NOT NULL,
								CONSTRAINT PK_Week PRIMARY KEY (week_id))";

if(mysqli_query($link, $Drop_WeekTable)){
    echo "Drop Bowl Week Table successfully.<br>";
} else{
    echo "ERROR: Could not able to execute. " . mysqli_error($link) . "<BR>";
}

if(mysqli_query($link, $Create_WeekTable)){
    echo "Create Bowl Week Table successfully.<br>";
} else{
    echo "ERROR: Could not able to execute. " . mysqli_error($link) . "<BR>";
}

$Drop_GameTable = "DROP TABLE bowlgame";

$Create_GameTable = "CREATE TABLE bowlgame(
								week_id				MEDIUMINT		NOT NULL,
								bowler_id			MEDIUMINT		NOT NULL,
								week_game      		TINYINT			NOT NULL,
								score	      		MEDIUMINT		NOT NULL,
								strikes      		TINYINT			NOT NULL,
								spare	      		TINYINT			NOT NULL,
								CONSTRAINT PK_Games PRIMARY KEY (bowler_id,week_id,week_game))";

if(mysqli_query($link, $Drop_GameTable)){
    echo "Drop Game Table successfully.<br>";
} else{
    echo "ERROR: Could not able to execute. " . mysqli_error($link) . "<BR>";
}

if(mysqli_query($link, $Create_GameTable)){
    echo "Create Game Table successfully.<br>";
} else{
    echo "ERROR: Could not able to execute. " . mysqli_error($link) . "<BR>";
}

$Drop_BowlLoginTable = 'DROP TABLE bowl_login';

$Create_BowlLoginTable = 'CREATE TABLE bowl_login(
								player_id			MEDIUMINT		NOT NULL AUTO_INCREMENT,
								name	       		VARCHAR(50)		NOT NULL,
								email				VARCHAR(50)		NOT NULL,
								access				VARCHAR(50)		NOT NULL,
								passhash			VARCHAR(65)		NOT NULL,
								updated        		TIMESTAMP		DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
								CONSTRAINT PK_Login PRIMARY KEY (player_id))';

if(mysqli_query($link, $Drop_BowlLoginTable)){
    echo "Drop Bowler Login Table successfully.<br>";
} else{
    echo "ERROR: Could not able to execute. " . mysqli_error($link);
}

if(mysqli_query($link, $Create_BowlLoginTable)){
    echo "Create Bowler Login Table successfully.<br>";
} else{
    echo "ERROR: Could not able to execute. " . mysqli_error($link);
}

// Close connection
mysqli_close($link);
?>
