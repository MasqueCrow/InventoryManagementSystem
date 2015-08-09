function useridchecktaken(){
	var userid = $('#userid').val();

	// Create our XMLHttpRequest object
		var hr1 = new XMLHttpRequest();
		// Create some variables we need to send to our PHP file
		var url1 = "serversidevalidation.php";
		var vars4 = "username="+userid;
		hr4.open("POST", url1, true);
		// Set content type header information for sending url encoded variables in the request
		hr1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		// Access the onreadystatechange event for the XMLHttpRequest object
		hr1.onreadystatechange = function() {
			if(hr1.readyState == 4 && hr1.status == 200) {
				var return_data = hr1.responseText;
					return return_data;
			}
		}
		// Send the data to PHP now... and wait for response to update the status div
		hr4.send(vars4); // Actually execute the request
		$('#useridErr').html("<p style='color:orange'>Processing...</p>");
}

function checkname(){
	var str = $('#name').val();
	if (str.length < 5){
		$('#nameErr').html("<p style='color:red'>Name too short</p>");
	}else{
		if(/^[a-zA-Z0-9-]*$/.test(str) == false) {
			$('#nameErr').html("<p style='color:red'>No Special Characters Allowed</p>");
		}else{
		$('#nameErr').html("<p style='color:#14ff00'>Name Valid</p>");
		return true;
		}
	}
}



function checkuserid(){
var userid = $('#userid').val();
if (userid.length < 8){
		$('#useridErr').html("<p style='color:red'>Min 8 Characters Alphanumeric</p>");
	}else{
		if(/^[a-zA-Z0-9-]*$/.test(userid) == false && /^\s+$/.test(userid == true)) {
			$('#useridErr').html("<p style='color:red'>No Special Characters or Spaces Allowed</p>");
		}else{
			if(useridchecktaken()){
				$('#useridErr').html("<p style='color:#14ff00'>UserID Valid</p>");
				return true;
			}else{
				$('#useridErr').html("<p style='color:red'>UserID Already Taken</p>");
			}
		}
	}

}

function checkpass(){
	var str = $('#pass').val();
	if (str.length < 8){
		$('#passErr').html("<p style='color:red'>Min 8 Characters Alphanumeric</p>");
	}else{
		if(/^[a-zA-Z0-9-]*$/.test(str) == false || /^\s+$/.test(userid == true)) {
			$('#passErr').html("<p style='color:red'>No Special Characters or Spaces Allowed</p>");
		}else{
		$('#passErr').html("<p style='color:#14ff00'>Password Valid</p>");
		return true;
		}
	}
}

function checkcfmpass(){
	var value1 = $('#pass').val();
	var value2 = $('#cfmpass').val();
	if(value1 == value2){
		$('#cfmpassErr').html("<p style='color:#14ff00'>Password Confirmed</p>");
		return true;
	}else{
		$('#cfmpassErr').html("<p style='color:red'>Re-type Password</p>");
		
	}
}

function checkselection(){
	var value1 = $('#aclvl').val();
	if(value1 > 0){
		$('#aclvlErr').html("<p style='color:#14ff00'>Level Selected</p>");
		return true;
	}else{
		$('#aclvlErr').html("<p style='color:red'>Please Select Access Level</p>");
	}
}

function checkcontact(){
	var contact = $('#contact').val();
	if (contact.length < 8){
		$('#contactErr').html("<p style='color:red'>Min 8 numbers</p>");
	}else{
		if(/^[a-zA-Z0-9-]*$/.test(contact) == false || /^\s+$/.test(contact == true)) {
			$('#contactErr').html("<p style='color:red'>No Special Characters or Spaces Allowed</p>");
		}else{
		$('#contactErr').html("<p style='color:#14ff00'>Number Valid</p>");
		return true;
		}
	}
}



function registeruser(){
	if(checkselection() || checkcfmpass() || checkpass() || checkuserid() || checkname() || checkcontact()){
		var name = $('#name').val();
		var userid = $('#userid').val();
		var pass = $('#pass').val();
		var aclvl = $('#aclvl').val();
		var contact = $('#contct').val();
	// Create our XMLHttpRequest object
		var hr1 = new XMLHttpRequest();
		// Create some variables we need to send to our PHP file
		var url1 = "../admininformation/handleRegAcc.php";
		var vars4 = "username="+userid+"password="+pass+"name="+name+"contact="+contact+"accesslevel="+aclvl;
		hr4.open("POST", url1, true);
		// Set content type header information for sending url encoded variables in the request
		hr1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		// Access the onreadystatechange event for the XMLHttpRequest object
		hr1.onreadystatechange = function() {
			if(hr1.readyState == 4 && hr1.status == 200) {
				var return_data = hr1.responseText;
					return return_data;
			}
		}
		// Send the data to PHP now... and wait for response to update the status div
		hr4.send(vars4); // Actually execute the request
		$('#useridErr').html("<p style='color:orange'>Processing...</p>");
	
	
	}else{
	alert('Please Make Sure All Fields Are Valid');
	}
}