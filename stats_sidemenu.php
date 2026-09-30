	<div id="menusidenav" class="col-2" style="background-color:#D2D2D2">
		<br><br><br><br>
		<p id="currentyear" class="menuheader">
		<?php $curYear = date('Y');echo $curYear; ?>
		</p>
		<p id="currslots" class="menuitemlink">
		<?php
			include 'db_setup.php';
			
			$seasonsFound = false;
			$selectCurr = "SELECT bt.team_name AS team_name, bt.team_id AS team_id FROM bowlleagues bl JOIN bowlteams bt ON bl.league_id=bt.league_id WHERE bl.year=$curYear";
			$result =mysqli_query($link, $selectCurr);
			while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) 
				{
				$seasonsFound=true;
				$seasonName = $row['team_name'];
				$teamID = $row['team_id'];
				echo '<a href="bowl_season.php?team=' . $teamID . '">' . $seasonName . '</a><br><br>';
				}
				
			if ($seasonsFound==false)
				{
				echo 'None<br><br>';
				}					
		?>
		</p><br>
		<p id="lastyear" class="menuheader"><?php echo $curYear-1;?></p>
		<p id="lastslots" class="menuitemlink">
		<?php
			$seasonsFound = false;
			$prevYear = $curYear-1;
			$selectCurr = "SELECT bt.team_name AS team_name, bt.team_id AS team_id FROM bowlleagues bl JOIN bowlteams bt ON bl.league_id=bt.league_id WHERE bl.year=$prevYear";
			$result =mysqli_query($link, $selectCurr);
			while ($row=mysqli_fetch_array($result, MYSQLI_ASSOC)) 
				{
				$seasonsFound=true;
				$seasonName = $row['team_name'];
				$teamID = $row['team_id'];
				echo '<a href="bowl_season.php?team=' . $teamID . '">' . $seasonName . '</a><br><br>';
				}
				
			if ($seasonsFound==false)
				{
				echo 'None<br><br>';
				}					
		?>

		</p><br>
		<p class="menuheader">All Time - Do not work Yet</p>
		<p class="menuitemlink"><a href="statsalltime.php?league=Mens">Career Stats</a></p>

		<br>
		<p class="menuheader">Other Pages</p>
		<p class="menuitemlink"><a href="../Softball/attendance_home.php">Attendance</a></p>
		<p class="menuitemlink"><a href="site_updates.php">Site Updates</a></p>
		<br><br><br>
	</div>