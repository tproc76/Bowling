<?php
include 'db_setup.php';

if(isset($_POST['edit_row']))
{
	$pid=$_POST['row_id'];
	$nickname=$_POST['name_nick'];
	$fullname=$_POST['name_full'];
	$emailname=$_POST['name_email'];
	$notes=$_POST['name_note'];

	mysqli_query($link, "UPDATE bowlers SET nickname='$nickname',fullname='$fullname',email='$emailname',notes='$notes' WHERE bowler_id='$pid'");
	echo "success";
	exit();
}

if(isset($_POST['delete_row']))
	{
	$row_no=$_POST['row_id'];
	
	$findBowlerGames = "SELECT * FROM bowlgame WHERE bowler_id = '$row_no'";
	
	$result = mysqli_query($link, $findBowlerGames);
	
	if (mysqli_num_rows($result) > 0)
		{
		echo "bowlers";
		exit();
		}
	
		
	mysqli_query($link, "DELETE FROM bowlers WHERE bowler_id='$row_no'");
	echo "success";
	exit();
	}

if(isset($_POST['insert_row']))
	{
	$nickname=$_POST['name_nick'];
	$fullname=$_POST['name_full'];
	$emailname=$_POST['name_email'];
	$notes=$_POST['name_note'];
	mysqli_query($link, "INSERT INTO bowlers VALUES(default,'$nickname','$fullname','$emailname','$notes')");
	
	echo mysqli_insert_id($link);
	exit();
	}
?>
