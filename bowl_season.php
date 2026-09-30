<!DOCTYPE html>
<html>
    <head>
        <title>Season Bowling Scores Page</title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="softball,proctor" />
        
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
		<!-- Chart JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
       
		<style type="text/css">
		   .centerText{
			   text-align: center;
			}
		  /* Styles the table, headers, and cells */
		  table, th, td {
			border: 1px solid black;
		  }
		  /* Merges double borders into a clean single line */
		  table {
			border-collapse: collapse;
			width: 100%;
		  }
		  /* Optional: Adds space inside cells for readability */
		  th, td {
			padding: 10px;
			text-align: left;
		  }

		</style>
		<!-- Menu CSS Stuff -->
		<link rel="stylesheet" type="text/css" href="menu_leftside.css">
		
		<script type="text/javascript" src="bowling_standard.js"></script>
    </head>
    <!-- slide-toggle-menu -->
    <body>
	
	<div class="container-fluid">
	<div class="row">
		
		<!-- Side MENU Start -->
		<?php
			include 'stats_sidemenu.php';
		?>
		<!-- Side MENU End -->
		
        <!--top-header-->
		
		<!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
		<div id="main" class="col-10">
			<div class="row justify-content-md-center">
				<h1 id="pageheader">Bowling Scores<BR>Team Name</h1>
			</div>	
			<BR>
			<div class="row justify-content-md-center">
				<table width="80%" border='0' cellspacing='1' cellpadding='2' class='center' id='teamscores'>
					<col width="50%">
					<col width="25%">
					<col width="25%">
					<tr>
						<td style='text-align:center'>Week</td>
						<td style='text-align:center'>Bowler1</td>
						<td style='text-align:center'>Bowler2</td>

					</tr>
					<tr>
						<td style='text-align:center'>Today</td>
						<td style='text-align:center'>0</td>
						<td style='text-align:center'>0</td>
					</tr>
				</table>
			
		</div>
			<br><br>
        <script id="seasonname" dataname=  
		<?php
			$seasonsFound = false;
			$prevYear = $curYear-1;
			$selectCurr = "SELECT MAX(team_id) AS team FROM bowlteams";
			$result =mysqli_query($link, $selectCurr);
			while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) 
				{
				$seasonsFound=true;
				$seasonName = $row['team'];
				
				echo '"' . $seasonName . '" ';
				}
				
			if ($seasonsFound==false)
				{
				echo '0';
				}					
		?>
		src="bowl_season.js"></script>
		
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script type="text/javascript" src="dist-js/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="dist-js/popper.min.js"></script>
		<script type="text/javascript" src="dist-js/tether.min.js"></script>
		<script type="text/javascript" src="dist-js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

	</div>
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

