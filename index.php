<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Seacrh</title>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
	<script>

	$(document).ready(function(){
		var session = '';
		
		var getKeys = (function(obj){
	        var keys = "";
	        for(var key in obj){
	            keys += (key) + " - " + eval ('obj.'+key) + "<br>";
	        }
	        return keys;
	    });


	    $('.get_result').click(function(){
			
	    	if ( session == '' ){

				var username = prompt('Please enter your username to view this page!',' ');
				var password = prompt('Please enter your password to view this page!',' ');

				
				$.getJSON('http://api.example.net/json.php?username='+username+'&password='+password, function(data) {
		    		  
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
			}else{

				$.getJSON("http://api.example.net/json.php?auth="+session, function(data) { 

						// user data will be appent to site
		    		  var items = [];

		    		  $.each(data.cateogry, function(key, val) {
		    		    items.push('<li id="' + key + '">' + getKeys(val) + '</li>');
		    		  });

		    		  $('<ul/>', {
		    		    'class': 'my-new-list',
		    		    html: items.join('')
		    		  }).appendTo('.result');
		    		  
		    	});
				
			}
			
	    });
	    
		
	    
	});
	</script>
</head>
<body>
<input type="button" class="get_result" value="get">
<div class="result"></div>
<div class="result2"></div>

</body>

</html>