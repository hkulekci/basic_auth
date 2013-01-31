### Basic Js Authorization Example (Non-Secure)

This example is useful to get information with a session key (auth) after authorize your session with username and password.


### Description:

Firstly, username and password information sent to system. 

	var session = '';
	$.getJSON('https://api.example.net/json.php?username='+username+'&password='+password, function(data) {
	    		  
		  alert(data);
			if (data.authCode != undefined){
				session = data.authCode;
				alert(session+'-'+data.authCode);
				alert('session opened');
			}else{
				session = '';
				alert('session not opened');
			}

	});

This connection get back a authorization code. Keep it somewhere to use get some data from server. We use this code to get whatever information like that :

	$.getJSON("https://api.example.net/json.php?auth="+session, function(data) { 

			// user data will be appent to site
		  
	});
	    	
In the example, I did not care safety of information. I just worked simulating system.

Good luck.
		    	
