<!DOCTYPE html>
<html>
    <head>
        <title>Bowling Home Page</title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="softball,proctor" />
        
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
		<!-- Chart JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
		<style>
			.center-text {
			  text-align: center;
			}

			.main-content {
					  display: flex;
					  flex-direction: column;
					  align-items: center;
					  justify-content: center;
					  width: 100%;
					  text-align: center;
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
		<div id="main" class="col-10">
				<h1 id="pageheader" class="center-text">Welcome to My Bowling Site</h1>
			<BR><BR>
		
		<!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
			<div class="row justify-content-md-center">
				<img src='images\bowlingmath.jpg' alt='comic1' height='300' width='300'>
			</div>
		</div>
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

