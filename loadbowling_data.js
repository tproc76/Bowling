function addGameColumn(tableId) 
	{
	// 1. Grab the table and all its rows
	var table = document.getElementById(tableId);
	var rows = table.rows;
	var columnCount = rows[0].cells.length;

	// 2. Loop through every row
	for (var i = 0; i < rows.length; i++) 
		{
		if (i === 0) 
			{
			// Create a header cell (<th>) for the first row
			var th = document.createElement('th');
			th.innerHTML = "Game " + columnCount;
			rows[i].appendChild(th);
			} 
		else 
			{
			// Create a standard data cell (<td>) for subsequent rows
			// Passing -1 appends it to the end of the row
			// score is game# _ bowler row
			var newCell = rows[i].insertCell(-1); 
			newCell.innerHTML = "<input type='text' id='score" + columnCount + "_" + i + "' size='5'>";
			}
		}
	}
/*	
function getTableColumnCount(tableId) 
	{	
    var table = document.getElementById(tableId);
    if (!table || table.rows.length === 0) 
		return 0;
    
    var columnCount = 0;
    var firstRowCells = table.rows[0].cells;
    
    for (var i = 0; i < firstRowCells.length; i++) 
		{
        // Adds the colSpan value, defaulting to 1 if no colspan is set
        columnCount += firstRowCells[i].colSpan || 1;
		}
    
    return columnCount;
	}
*/
function add_game()
	{
	addGameColumn("bowlergames");
	}
	
function updateWeekTable(jsonWeekArray,teamIDbox)
	{
	var weekTableStart = "<table id='teamweeks' border='1' cellspacing='1' cellpadding='5' class='center'><tr><th>Date</th><th>Action</th></tr>";
	var weekTableData = "";
	var weekTableEnd = "</table>"
	
	if (jsonWeekArray != null)
		{
		for (var x = 0; x < jsonWeekArray.length; x++)
			{
			weekTableData += "<tr id='row" + jsonWeekArray[x].week_id + "'><td>" + jsonWeekArray[x].datetime + "</td><td>";
			weekTableData += "<button type='button' onclick='showData(" + jsonWeekArray[x].week_id + "," + jsonWeekArray[x].team_id + ")'>Show</button>";
			weekTableData += "<button type='button' onclick='deleteData(" + jsonWeekArray[x].week_id + "," + jsonWeekArray[x].team_id + ")'>Delete</button></td></tr>";
			}
		}
	teamIDbox.outerHTML = weekTableStart + weekTableData + weekTableEnd;
	}
	
function changeLeague(selectelement)
	{	
	var newvalue = selectelement.value;
	
    event.preventDefault();
    var XMLHttpRequestObject = false;
    XMLHttpRequestObject = new XMLHttpRequest();
    
    if (XMLHttpRequestObject) 
		{
		XMLHttpRequestObject.open("GET","http://"+ WEBPATH +"/getleague_db.php?league=" + newvalue);
	
        XMLHttpRequestObject.onreadystatechange=function()
			{

            if (XMLHttpRequestObject.readyState==4 && XMLHttpRequestObject.status==200)
				{
                var result = JSON.parse(XMLHttpRequestObject.responseText);
				
				var teamselect = document.getElementById("teamselect");
				
				var selectText = "";
				
				for (var x = 0; x < result.teams.length; x++ )
					{
					selectText += "<option value='" + result.teams[x].team_id + "' selected>" + result.teams[x].team_name + "</option>";
					}
					
				teamselect.innerHTML = selectText;
				
				var teamlist=document.getElementById("teamselect");
				changeTeam(teamlist);

				delete XMLHttpRequestObject;
				XMLHttpRequestObject = null;					
				} 
			}
        XMLHttpRequestObject.send();
		}
	}
	
	
function changeTeam(selectelement)
	{
	var newvalue = selectelement.value;
	
	event.preventDefault();
	var XMLHttpRequestObject = false;
	XMLHttpRequestObject = new XMLHttpRequest();
	
	if (XMLHttpRequestObject) 
		{
		XMLHttpRequestObject.open("GET","http://"+ WEBPATH +"/getteam_db.php?team=" + newvalue);
	
		XMLHttpRequestObject.onreadystatechange=function()
			{

			if (XMLHttpRequestObject.readyState==4 && XMLHttpRequestObject.status==200)
				{
				try {
					var result = JSON.parse(XMLHttpRequestObject.responseText);
					
					var bowlerTable = document.getElementById("bowlergames");
					
					var tableTopText = "<table id='bowlergames' border='1' cellspacing='1' cellpadding='5' class='center' ><tr><th>NICKNAME</th><th>Game 1</th></tr>";

					var tableBottomText = "</table>";
					
					var tableData = "";
					
					for (var x = 0; x < result.bowlers.length; x++ )
						{
						var num = result.bowlers[x].bowler_id;
						tableData += "<tr id='row" + num + "'><td id='nname" + num +"'>" + result.bowlers[x].nickname + "</td><td id='game" + num;
						tableData += "_1'><input type='text' id='score1_" + num + "'  size='5'></td></tr>";
						}

					bowlerTable.outerHTML = tableTopText + tableData + tableBottomText;
					
					var teamIDbox = document.getElementById("teamweeks");
//					if (result.weeks != null)
						{
						updateWeekTable(result.weeks,teamIDbox);
						}
					}
				catch (error) 
					{
					alert(error.message);
					alert(XMLHttpRequestObject.responseText);
					}
				delete XMLHttpRequestObject;
				XMLHttpRequestObject = null;					
				} 
			}
		XMLHttpRequestObject.send();
		}
	}
		
function save_data()
	{
    var dateField = document.getElementById("bowldate");
	var date = dateField.value;
	var laneField = document.getElementById("lane");
	var lane = laneField.value;
	var table = document.getElementById("bowlergames");
	var rows = table.rows;
	var colcnt = rows[0].cells.length;	
	var teamIDbox = document.getElementById("teamselect");
	var teamID = teamIDbox.value;
	
	if (date.length > 4)
		{
		const inputDate = new Date(date);
		
		if (inputDate.getFullYear() < 2020)
			{
			alert ("Bad Year");
			return;
			}
		}
	else
		{
		alert ("Invalid Date");
		return;
		}
		
	if (lane.length < 0)
		{
		alert ("MIssing Lane");
		return;
		}
		
	var matrix = [];
	
	for (var x = 1; x < rows.length; x++) 
		{
		matrix[x-1] = []; // Initialize the inner array (row)
		matrix[x-1][0] = rows[x].textContent;
		
		var rowID = rows[x].id;
		var bowlerID = rowID.substring(3);
		
		matrix[x-1][1] = bowlerID;
		
		for (var y = 1; y < colcnt; y++) 
			{
			// score is game# _ bowler row
			var boxName = "score" + String(y) + "_" + String(x);
			var scoreBox = document.getElementById(boxName);
			var score = scoreBox.value;
			matrix[x-1][y+1] = score; 
			}
		}
	
	var jsonMatrixStrig = JSON.stringify({ dataMatrix:matrix });
	
	$.ajax
		({
		type:'post',
		url:'loadbowling_db.php',
		data:
			{
			save_week:'save_week',
			date:date,
			team:teamID,
			lane:lane,
			opp:'N/A',
			bowlers:(rows.length-1),
			games:colcnt,
			bowldata:jsonMatrixStrig,
			},
		success:function(response) 
			{
			var results = JSON.parse(response);
			if(results.result=="success")
				{
				var teamIDbox = document.getElementById("teamweeks");
				updateWeekTable(results.weeks,teamIDbox);
/*				var weekTableStart = "<table id='teamweeks' border='1' cellspacing='1' cellpadding='5' class='center'><tr><th>Date</th><th>Action</th></tr>";
				var weekTableData = "";
				var weekTableEnd = "</table>"
				
				for (var x = 0; x < results.weeks.length; x++)
					{
					weekTableData += "<tr id='row" + results.weeks[x].week_id + "'><td>" + results.weeks[x].datetime + "</td><td>";
					weekTableData += "<button type='button' onclick='showData(" + results.weeks[x].week_id + "," + results.weeks[x].team_id + ")'>Show</button>";
					weekTableData += "<button type='button' onclick='deleteData(" + results.weeks[x].week_id + "," + results.weeks[x].team_id + "('>Delete</button></td></tr>";
					}
				teamIDbox.outerHTML = weekTableStart + weekTableData + weekTableEnd;*/
				}
			else if (results.message != null)
				{
				alert(results.message);
				}
			else
				{
				alert("not sucess");
				}
			},
        error: function(xhr, status, error) 
			{
            //callback(error, null);
			alert("error");
			}
		});
	}	
	
function deleteData (weekID, teamID)
	{
	$.ajax
		({
		type:'post',
		url:'loadbowling_db.php',
		data:
			{
			delete_week:'delete_week',
			week:weekID,
			team:teamID,
			},
		success:function(response) 
			{
			var results = JSON.parse(response);
			if(results.result=="success")
				{
				var teamIDbox = document.getElementById("teamweeks");
				updateWeekTable(results.weeks,teamIDbox);

				}
			else if (results.message != null)
				{
				alert(results.message);
				}
			else
				{
				alert("not sucess");
				}
			},
        error: function(xhr, status, error) 
			{
			alert("error");
			}
		});

	}	
	
function showData (weekID, teamID)
	{
	$.ajax
		({
		type:'post',
		url:'loadbowling_db.php',
		data:
			{
			show_week:'show_week',
			week:weekID,
			team:teamID,
			},
		success:function(response) 
			{
			try {
				var results = JSON.parse(response);
				if(results.result=="success")
					{
					var dateField = document.getElementById("bowldate");
					var laneField = document.getElementById("lane");

					dateField.value = results.week.datetime;
					laneField.value = results.week.lane;
/* box names are counter, not player ID.  Maybe change?????
					for (var x = 1; x < results.games.length; x++) 
						{
						// score is game# _ bowler row
						var boxName = "score" + String(results.games[x].week_game) + "_" + String(x);
						var scoreBox = document.getElementById(boxName);
						var score = scoreBox.value;
						matrix[x-1][y+1] = score; 
						}
*/
					}
				else if (results.message != null)
					{
					alert(results.message);
					}
				else
					{
					alert("not sucess");
					}
				}
			catch (error) 
				{
				alert(error.message);
				alert(response);
				}
			},
        error: function(xhr, status, error) 
			{
			alert("error");
			}
		});

	}