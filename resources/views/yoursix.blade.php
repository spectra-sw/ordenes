<html>
<head>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
	<p>Trigger IO</p>
	
    <script type="text/javascript">    	  
	  async function loginUser() {
		var pass = $("#user_pass").val();
		var user = $("#user_id").val();
		var call = 'login';
		var arg = {"call" : call, "pass" : pass ,  "user" : user};		
 		return $.get("apiyoursix", { arg },function(data) {
				var obj = JSON.parse(data);
				if (obj.hasOwnProperty('sid')) {
					return obj.sid;
				}
				else {
					console.log ("Failed to login. " + obj.error);
					return false;
				}
		});
	  }
	  
	  async function trigger(row, portid, state, mac) {
		var sid = await loginUser();
		if (sid !== undefined && sid !== false) {
			var tmp = JSON.parse(sid);
			if (tmp.hasOwnProperty('sid')) {				
					var call = "trigger";
					var arg = {"call" : call , "sid" : tmp.sid , "portid" : portid, "state" : state, "mac" : mac};
					
					$.get("apiyoursix", { arg },function(data) {					
						var obj = JSON.parse(data);
						if (obj.feedback.error[0].code === 0) {
							var new_state_text = "Yes";
							var new_state = 1;

							if (state == 1) {
								new_state_text = "No";
								new_state = 0;
							}
							var table = document.getElementById("io_buttons");
							table.rows[row].cells[3].innerHTML = new_state_text;
							table.rows[row].cells[4].innerHTML = '<input type="button" name="button_' + portid + '" value="Trigger" onclick="trigger('+row+','+portid+','+new_state +',&quot;'+mac+'&quot;)">';
						} 
						else {
							alert("Failed to change the state of the output");
						}
					});
				
			}			
		}
	  }
	  
	  async function fetchCap() {		
		var call = "fetch";
		var table = document.getElementById("io_buttons");
		while (table.rows.length > 1) {
			table.deleteRow(1);
		}
		
		var sid = await loginUser();
		if (sid !== undefined && sid !== false) {
			var tmp = JSON.parse(sid);
			if (tmp.hasOwnProperty('sid')) {				
				var arg = {"call" : call , 'sid' : tmp.sid };
				$.get("apiyoursix", { arg },function(data) {
					var obj = JSON.parse(data);
					if (obj.hasOwnProperty('devices')) {
						var table = document.getElementById("io_buttons");
						for (var op = 0; op < obj.devices.length; op++) {
							var row = table.insertRow();
							var cell1 = row.insertCell(0);
							var cell2 = row.insertCell(1);

							if (obj.devices[op].outputs.length > 0)
							{
								cell1.innerHTML = obj.devices[op].device;
								if (obj.devices[op].online == 1) {
									cell2.innerHTML = "Yes";
									for (var output = 0; output < obj.devices[op].outputs.length; output++) {
									var row = table.insertRow();
									var cell1 = row.insertCell(0);
									var cell2 = row.insertCell(1);
									var cell3 = row.insertCell(2);
									var cell4 = row.insertCell(3);
									var cell5 = row.insertCell(4);

									cell3.innerHTML = obj.devices[op].outputs[output].name;
									if (obj.devices[op].outputs[output].state == 1) {
										cell4.innerHTML = "Yes";
									}
									else {
										cell4.innerHTML = "No";
									}
										cell5.innerHTML = '<input type="button" name="button_' + obj.devices[op].outputs[output].id + '" value="Trigger" onclick="trigger('+row.rowIndex+','+obj.devices[op].outputs[output].id+','+obj.devices[op].outputs[output].state +',&quot;'+obj.devices[op].device+'&quot;)">';
									}
								}
								else {
									cell2.innerHTML = "No";
								}
							}
						}
					}
					else {
						alert("No devices available for user.");
					}
				});
			}
		}		
	  }	  
    </script>
		
		<form id="user_information" name="user_information">
		<table id="registration">
		<!--<tr><td>User id</td><td><input type="text" id="user_id" name="user_id" ></td></tr>
		<tr><td>User password</td><td><input type="password" id="user_pass" name="user_pass" ></td></tr>-->
		<tr><td><input type="button" id="fetch_cap" name="fetch_cap" value="Fetch ports" onclick="fetchCap();"></td></tr>
		</table>
		
		</form>
		<table id="io_buttons" name="io_buttons">
		<tr>
			<th>Device</th>
			<th>Online</th>
			<th>Output name</th>		
			<th>Active</th>
			<th>Trigger</th>
		</tr>
		</table>
</body>
</html>