

function remove_bowlerfromteam(teamid,bowlerid)
	{

	$.ajax
		({
		type:'post',
		url:'manage_teams_bowlers_db.php',
		data:
			{
			edit_team:'edit_team',
			tesm:teamid,
			bowler:bowlerid
			},
		success:function(response) 
			{
			if(response=="success")
				{
				var delRow = document.getElementById("row"+bowlerid);
				delRow.remove();
				}
			}
		});
	}

function update_bowlingteam(tid)
	{
	var newbox=document.getElementById("new_bowler");
	var nname=newbox.value;
	var message=document.getElementById("message");

	message.innerHTML = "";

	$.ajax
		({
		type:'post',
		url:'manage_teams_bowlers_db.php',
		data:
			{
			update_team:'update_team',
			tesm:tid,
			bowler:nname
			},
		success:function(response) 
			{
			var result = response.indexOf(";");
			var respsum = response.substring(0,result);
			
			if(respsum=="success")
				{
				var bowler_string = response.substring(result+1);
				var endidsemi = bowler_string.indexOf(";");
				var bid=bowler_string.substring(0,endidsemi);
				var fullname = bowler_string.substring(endidsemi+1);
				
				var table=document.getElementById("bowlernames");
				var table_len=(table.rows.length)-1;
				
				var insertRow = "<tr id='row"+bid+"'><td id='nname"+bid+"'>" + nname + "</td><td id='fname"+bid+"'>" + fullname + "</td></tr>";
				var row = table.insertRow(table_len).outerHTML=insertRow;
				newbox.value = "";
				}
			else if(response=="missing")
				{
				message.innerHTML = "Nick Name not found in the database";
				}
			else
				{
				message.innerHTML = response;
				}
				
			}
		});

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
					var result = JSON.parse(XMLHttpRequestObject.responseText);
					
					var bowlerTable = document.getElementById("bowlernames");
					
					var tableTopText = "<table id='bowlernames' border='1' cellspacing='1' cellpadding='5' class='center' ><tr><th>NICKNAME</th><th>FULL NAME</th><th></th></tr>";
					var tableBottomText = "<tr id='new_row'><td><input type='text' id='new_bowler'></td><td colspan='3' id ='updaterow'>";
					tableBottomText += "<input type='button' id='update_button' value='Add Bowlers' onclick='update_bowlingteam(\"newvalue\");'>";
					tableBottomText += "</td></tr><tr><td colspan='4' id ='message'></td></tr></table>";
					
					var tableData = "";
					
					for (var x = 0; x < result.bowlers.length; x++ )
						{
						var num = result.bowlers[x].bowler_id;
						tableData += "<tr id='row" + num + "'><td id='nname" + num +"'>" + result.bowlers[x].nickname + "</td><td id='fname" + num;
						tableData += "'>" + result.bowlers[x].fullname + "</td><td>";
						tableData += "<input type='button' class='delete_button' id='delete_button" + num + "' value='delete' onclick='remove_bowlerfromteam(\"" + newvalue + "\",\"" + num + "\");'></td></tr>";
						}

					bowlerTable.outerHTML = tableTopText + tableData + tableBottomText;

					delete XMLHttpRequestObject;
					XMLHttpRequestObject = null;					
					} 
				}
			XMLHttpRequestObject.send();
			}
		}