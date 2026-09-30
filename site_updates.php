<!DOCTYPE html>
<html>
    <head>
        <title>Bowling Site Changes</title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="softball,proctor" />
        
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="bootstrap-4.0.0-alpha.6-dist/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="page_format.css">
       
		<style type="text/css">
		   .centerText{
			   text-align: center;
			}
		</style>
		<!-- Menu CSS Stuff -->
		<link rel="stylesheet" type="text/css" href="menu_leftside.css">
		
		
    </head>
    <!-- slide-toggle-menu -->
    <body>
	<div class="container-fluid">
	<div class="row">		
		<br>
		
		<!-- Side MENU Start -->
		<?php
			include 'stats_sidemenu.php';
		?>
		<!-- Side MENU End -->

		<!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
		<div id="main" class="col-10">		
			<!--top-header-->
			<div class="row justify-content-md-center">
				<h1 id="pageheader">Bowling Site Changes ad Updates</h1>
			</div>	
			<BR><BR>
			<p align="center">The list shows the history of changes starting during the 2026 Offseason.</p>

			<table border="0" width="99%">
			  <tr>
				<td valign="middle" align="center" width="10%"></td>
				<td valign="middle" align="center" width="80%"><u>2026 OffSeason</u></td>
				<td valign="middle" align="center" width="10%"></td>
			  </tr>
			  <tr>
				<td valign="middle" align="center" width="10%"></td>
				<td valign="middle" align="left" width="80%"> 
					<ol>
						<li>Site Created</li>
					</ol>
				</td>
				<td valign="middle" align="center" width="10%"></td>
			  </tr>
			  <tr>
				<td valign="middle" align="center" width="10%"></td>
				<td valign="middle" align="center" width="80%"> &nbsp;</td>
				<td valign="middle" align="center" width="10%"></td>
			  </tr>
			</table>
			
			<br>
			<br>
			<br>
			
			<div class="row justify-content-md-center">
				<a href="mailto:proc@comcast.net" pbzloc="0">Email me</a>
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

