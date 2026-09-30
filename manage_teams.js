function edit_team(id)
	{
	var name=document.getElementById("tname"+id).innerHTML;
	var details=document.getElementById("gdet"+id).checked;
	var opponent=document.getElementById("vsopp"+id).checked;

	var tempHtml = "";
	
	document.getElementById("tname"+id).innerHTML="<input type='text' id='ename"+id+"' value='"+name+"'>";
	
	tempHtml = "<input type='checkbox' id='egdet"+id+"'";
	if (details == true)
		{
		tempHtml += " checked ";
		}
	tempHtml += ">";
	document.getElementById("game_det"+id).innerHTML=tempHtml;

	tempHtml = "<input type='checkbox' id='evsopp"+id+"'";
	if (opponent == true)
		{
		tempHtml += " checked ";
		}
	tempHtml += ">";
	document.getElementById("vs_opp"+id).innerHTML=tempHtml;
	
	document.getElementById("edit_button"+id).style.display="none";
	document.getElementById("save_button"+id).style.display="block";
	}

function save_team(id)
	{
	var tname=document.getElementById("ename"+id).value;
	var details=document.getElementById("egdet"+id).checked;
	var opponent=document.getElementById("evsopp"+id).checked;

	$.ajax
		({
		type:'post',
		url:'manage_teams_db.php',
		data:
			{
			edit_team:'edit_team',
			row_id:id,
			team_name:tname,
			team_gdet:details,
			team_vsopp:opponent
			},
		success:function(response) 
			{
			if(response=="success")
				{
				var tnum=id;
				var table=document.getElementById("bowlerteams");
				var table_len=(table.rows.length)-2;
				var vso_checked = "";
				var gd_checked = "";
				
				if (details == true)
					{
					gd_checked = " checked ";
					}

				if (opponent == true)
					{
					vso_checked = " checked ";
					}
				
				document.getElementById("tname"+id).innerHTML=tname;
				document.getElementById("game_det"+id).innerHTML="<input type='checkbox' id='gdet"+tnum+"' " + gd_checked + " class='checkbox-readonly'>";
				document.getElementById("vs_opp"+id).innerHTML="<input type='checkbox' id='vsopp"+tnum+"' " + vso_checked + " class='checkbox-readonly'>";
							
				document.getElementById("edit_button"+id).style.display="block";
				document.getElementById("save_button"+id).style.display="none";				
				}
			}
		});
	}

function delete_team(id)
	{
	$.ajax
		({
		type:'post',
		url:'manage_teams_db.php',
		data:
			{
			delete_team:'delete_team',
			row_id:id
			},
		success:function(response) 
			{
			if(response=="success")
				{
				var row=document.getElementById("row"+id);
				row.parentNode.removeChild(row);
				}
			else if (response=="teams")
				{
				alert('Team still used in Bowling Table');
				}
			else
				{
				alert('General Failure');
				}
			}
		});
	}

function insert_team()
	{
	var tname=document.getElementById("new_team").value;
	var gdetails=document.getElementById("new_gdet").checked;
	var vsopp=document.getElementById("new_vsopp").checked;
	var leaguedrop=document.getElementById("leagueselect");
	var league=leaguedrop.value;

	$.ajax
		({
		type:'post',
		url:'manage_teams_db.php',
		data:
			{
			insert_team:'insert_team',
			team_name:tname,
			team_gdet:gdetails,
			team_vsopp:vsopp,
			team_league:league
			},
		success:function(response) 
			{
			var respNum = parseInt(response);
			if(respNum > 0)
				{
				var tnum=response;
				var table=document.getElementById("bowlerteams");
				var table_len=(table.rows.length)-2;
				var vso_checked = "";
				var gd_checked = "";
				
				if (gdetails == true)
					{
					gd_checked = " checked ";
					}

				if (vsopp == true)
					{
					vso_checked = " checked ";
					}
				
				var insertRow = "<tr id='row"+tnum+"'><td id='tname"+tnum+"'>"+tname+"</td><td style='text-align: center;'><input type='checkbox' id='gdet"+tnum+"' " + gd_checked + " class='checkbox-readonly'></td>" + 
								  "<td style='text-align: center;'><input type='checkbox' id='vs_opp"+tnum+"' " + vso_checked + " class='checkbox-readonly'></td>"+
								  "<td><input type='button' class='edit_button' id='edit_button"+tnum+"' value='edit' onclick='edit_team("+tnum+"');> "+
									"<input type='button' class='save_button' id='save_button"+tnum+"' value='save' onclick='save_team("+tnum+"'); style='display: none;'> "+
									"<input type='button' class='delete_button' id='delete_button"+tnum+"' value='delete' onclick='delete_team("+tnum+"');></td></tr>";
				var row = table.insertRow(table_len).outerHTML=insertRow;

				document.getElementById("new_team").value="";
				document.getElementById("new_gdet").checked=false;
				document.getElementById("new_vsopp").checked=false;
				}
			else
				{
				var msgResponse = document.getElementById("message");
				msgResponse.innerText = response;
				}
			}
		});
	}

function insert_league()
	{
	var lname=document.getElementById("new_league").value;
	var location=document.getElementById("new_location").value;
	var year=document.getElementById("new_year").value;
	
	$.ajax
		({
		type:'post',
		url:'manage_teams_db.php',
		data:
			{
			insert_league:'insert_league',
			league_name:lname,
			league_loc:location,
			league_year:year
			},
		success:function(response) 
			{
			const selectleague = document.getElementById("leagueselect");
			const newLeague = document.createElement("option");

			newLeague.value = response;
			newLeague.textContent = lname + " - " + year;
			selectleague.appendChild(newLeague);
			
			document.getElementById("new_league").value="";
			document.getElementById("new_location").value="";
			document.getElementById("new_year").value="";
			}
		});
	}
	
function delete_league(lid)
	{
	var lname=document.getElementById("lname").innerHTML;
	var year=document.getElementById("lyear").innerHTML;
	var valueToRemove = lname + " - " + year;

	$.ajax
		({
		type:'post',
		url:'manage_teams_db.php',
		data:
			{
			delete_league:'delete_league',
			row_id:lid
			},
		success:function(response) 
			{
			if(response=="success")
				{
				const selectleague = document.getElementById("leagueselect");
				
				for (let i = 0; i < selectleague.options.length; i++) 
					{
					if (selectleague.options[i].value === lid) 
						{
						selectleague.remove(i);
						if (i > 0)
							{
							selectleague.selectedIndex =i-1;
							}
						else
							{
							var selectionLength = selectleague.length;
							selectleague.selectedIndex = selectionLength-1;
							}
						changeLeague(selectleague);
						break; // Stop the loop once the option is found and removed
						}
					}
				}
			else if (response=="teams")
				{
				alert('Leageue still has Bowling Teams');
				}
			else
				{
				alert('General Failure');
				}
			}
		});
	}
	
function edit_league(id)
	{
	var name=document.getElementById("lname").innerHTML;
	var location=document.getElementById("llocation").innerHTML;
	var year=document.getElementById("lyear").innerHTML;

	var tempHtml = "";
	
	document.getElementById("lname").innerHTML="<input type='text' id='ename"+id+"' value='"+name+"'>";
	
	tempHtml = "<input type='text' id='eloc"+id+"' value='"+location+"'>";
	document.getElementById("llocation").innerHTML=tempHtml;

	tempHtml = "<input type='text' id='eyear"+id+"' value='"+year+"'>";
	document.getElementById("lyear").innerHTML=tempHtml;
	
	document.getElementById("ledit_button").style.display="none";
	document.getElementById("lsave_button").style.display="block";
	}

function save_league(id)
	{
	var lname=document.getElementById("ename"+id).value;
	var location=document.getElementById("eloc"+id).value;
	var year=document.getElementById("eyear"+id).value;

	$.ajax
		({
		type:'post',
		url:'manage_teams_db.php',
		data:
			{
			edit_league:'edit_league',
			row_id:id,
			league_name:lname,
			league_loc:location,
			league_year:year
			},
		success:function(response) 
			{
			if(response=="success")
				{
				var tnum=id;
				
				document.getElementById("lname").innerHTML=lname;
				document.getElementById("llocation").innerHTML=location;
				document.getElementById("lyear").innerHTML=year;
							
				document.getElementById("ledit_button").style.display="block";
				document.getElementById("lsave_button").style.display="none";

				// Update the name in the dropdown
				selectElement = document.getElementById("leagueselect");
				
				for (var x = 0; x < selectElement.length; x++)
					{
					thisOption = selectElement.options[x];
					
					if (thisOption.value == id)
						{
						var temp = lname+" - "+year;
						thisOption.innerHTML = temp;
						
						document.getElementById("Leagueheader").innerHTML=temp + " Team List";
						break; // Stop the loop once the option is found and removed
						}
					}
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
				
				var name=document.getElementById("lname");
				var location=document.getElementById("llocation");
				var year=document.getElementById("lyear");
				var header=document.getElementById("Leagueheader");
				
				name.innerHTML = result.data.league_name;
				location.innerHTML = result.data.location;
				year.innerHTML = result.data.year;
				header.innerHTML = result.data.league_name + " - " + result.data.year + " Team List";
				
				var tableStart = "<table id='bowlerteams' border='1' cellspacing='1' cellpadding='5' class='center' >";
					tableStart += "<tr><th>TEAM NAME</th><th>GAME DETAILS</th><th>VS OPPONENET</th><th></th></tr>";
					
				var tableEnd = "<tr id='new_row'><td><input type='text' id='new_team'></td><td style='text-align: center;'><input type='checkbox' id='new_gdet'></td>";
					tableEnd += "<td style='text-align: center;'><input type='checkbox' id='new_vsopp'></td><td><input type='button' value='Insert Row' onclick='insert_team();'></td></tr>";
					tableEnd += "<tr><td colspan='4' id='message'></td></tr></table>";
				
				var teamsData = '';
				
				for (var x = 0; x < result.teams.length; x++ )
					{
					teamsData += "<tr id='" + result.teams[x].team_id + "'><td id='tname" + result.teams[x].team_id + "'>" + result.teams[x].team_name + "</td>";
					teamsData += "<td id='game_det" + result.teams[x].team_id + "' style='text-align: center;'>";
					teamsData += "<input type='checkbox' id='gdet" + result.teams[x].team_id + "' name='gamedet" + result.teams[x].team_id + "'";

					if (result.teams[x].game_details != 0)
						{
						teamsData += "	checked ";
						}
					teamsData += " class='checkbox-readonly'></td>";
					teamsData += "<td id='vs_opp" + result.teams[x].team_id + "' style='text-align: center;'>";
					teamsData += "<input type='checkbox' id='vsopp" + result.teams[x].team_id + "' name='vs_opponent" + result.teams[x].team_id + "'"; 
					
					if (result.teams[x].versus_opp != 0)
						{
						teamsData += "	checked ";
						}
					teamsData += " class='checkbox-readonly'></td><td>";
					
					teamsData += "<input type='button' class='edit_button' id='edit_button" + result.teams[x].team_id + "' value='edit' onclick='edit_team(\"" + result.teams[x].team_id + "\")';>";
					teamsData += "<input type='button' class='save_button' id='save_button" + result.teams[x].team_id + "' value='save' onclick='save_team(\"" + result.teams[x].team_id + "\")'; style='display: none;'>";
					teamsData += "<input type='button' class='delete_button' id='delete_button" + result.teams[x].team_id + "' value='delete' onclick='delete_team(\"" + result.teams[x].team_id + "\")';></td></tr>";
					}
					
				var teamtable = document.getElementById("bowlerteams");
				
				teamtable.innerHTML = tableStart + teamsData + tableEnd;
				
				var delButton = document.getElementById("ldelete_button");
				var buttonHtml = "<input type='button' class='delete_button' id='ldelete_button' value='delete' onclick='delete_league(\"" + newvalue + "\");'>";
				delButton.outerHTML = buttonHtml;
				
				delete XMLHttpRequestObject;
				XMLHttpRequestObject = null;					
				} 
			}
        XMLHttpRequestObject.send();
		}
	}
	