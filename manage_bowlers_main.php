<!DOCTYPE html>
<html>
	<head>
        <title>Bowler View and Edit Page</title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="bowling,proctor" />

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
		<script type="text/javascript" src="dist-js/jquery-3.2.1.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script type="text/javascript" src="manage_bowlers.js"></script>
	</head>
<body>

<?php
include 'db_setup.php';

$select =mysqli_query($link, "SELECT * FROM bowlers");
?>

<!--top-header-->
<div class="row justify-content-md-center">
	<h1 id="playerheader">Bowler List</h1>
	<BR><BR>
</div>	

<!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
<div id="main" class="main">		
		
<br>

<div class="row justify-content-md-center">

	<table id="bowlertable" border='1' cellspacing='1' cellpadding='5' class='center' >
		<tr>
			<th>NICK NAME</th>
			<th>FULL NAME</th>
			<th>EMAIL</th>
			<th>NOTES</th>
			<th></th>
		</tr>
	<?php
	while ($row=mysqli_fetch_array($select, MYSQLI_ASSOC)) 
		{
	 ?>
		<tr id="row<?php echo $row['bowler_id'];?>">
			<td id="name_nick<?php echo $row['bowler_id'];?>"><?php echo $row['nickname'];?></td>
			<td id="name_full<?php echo $row['bowler_id'];?>"><?php echo $row['fullname'];?></td>
			<td id="name_email<?php echo $row['bowler_id'];?>"><?php echo $row['email'];?></td>
			<td id="notes<?php echo $row['bowler_id'];?>"><?php echo $row['notes'];?></td>
			<td>
			<input type='button' class="edit_button" id="edit_button<?php echo $row['bowler_id'];?>" value="edit" onclick="edit_row('<?php echo $row['bowler_id'];?>');">
			<input type='button' class="save_button" id="save_button<?php echo $row['bowler_id'];?>" value="save" onclick="save_row('<?php echo $row['bowler_id'];?>');" style="display: none;">
			<input type='button' class="delete_button" id="delete_button<?php echo $row['bowler_id'];?>" value="delete" onclick="delete_row('<?php echo $row['bowler_id'];?>');">
			</td>
		</tr>
	<?php
		}
	?>

		<tr id="new_row">
			 <td><input type="text" id="new_nickname"></td>
			 <td><input type="text" id="new_fullname"></td>
			 <td><input type="text" id="new_email"></td>
			 <td><input type="text" id="new_note"></td>
			 <td><input type="button" value="Insert Row" onclick="insert_row();"></td>
		</tr>
	</table>
</div>
	<br>
	<div class="row justify-content-md-center">
	<a href = "maintainance_bowl.php">Return to Maintainance</a>
	</div>
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