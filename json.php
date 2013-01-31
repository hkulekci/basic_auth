<?php
/*
This file is hosted on server to get with ajax from mobile device.

@username 		=> 	session username use before session start
@password		=> 	session password use before session start
@auth			=> 	session use after session start
*/

define('DEBUG', true);
if (DEBUG){
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}


header('Cache-Control: no-cache, must-revalidate'); 
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); 
header('Content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');


include_once("func.php");

@session_start();


$session_started = false;


if (isset( $_REQUEST['username']) && isset($_REQUEST['password'] ) 
		&& trim($_REQUEST['username'])!=="" && trim($_REQUEST['password'])!=="" )
	{
		
		//// SQL control for user
		
		$users_is_logined = mysql_query("SELECT USERID FROM users WHERE `USERNAME`='".sqlcleaner($_REQUEST['username']).
					"' AND `PASSWORD`='".md5($_REQUEST['password'])."';");
		if (DEBUG) echo mysql_error();			
		if (mysql_num_rows($users_is_logined) != 0){
			
			//// Check to control opened session
			while ($t = mysql_fetch_array($users_is_logined)){
			
				$opened_session = mysql_query("DELETE FROM session WHERE `USERID`='".sqlcleaner($t['USERID'])."'");
				
				if ($opened_session){
					echo '';
				}else{
					echo '({ "error":"error code = 303"})';
					exit(1);
				}
			
				$session_id_javascript = sha1( date("m.d.y H:i:s").$t['USERID'] );
			
				$opened_session = mysql_query("INSERT INTO session (`SESSIONID`,`USERID`) VALUES ('".
								$session_id_javascript."','".$t['USERID']."');");
				if (DEBUG) echo mysql_error();	
				if ($opened_session){
					
					//// session for javascript code
					echo '({ "authCode":"'.$session_id_javascript.'","time":"'.date("m.d.y H:i:s").'"})';
					
					//// session for rest of code
					$session_started = true;
					exit(1);
				
				}else{
					echo '({ "error":"error code = 302"})';
					exit(1);
				}
		
				
			
			
			}
			
		}else{
			$session_started = false;
			echo '({ "error":"error code = 301"})';
			exit(1);
		}
		//// return a auth code
		
}


//Session kontrol
if (isset($_REQUEST['auth']) && trim($_REQUEST['auth']) !== "" ){

	$auth_started = false;
	//// SQL control for is auth ok? is it already on database?
	
	$user_is_session_started = mysql_query("SELECT USERID FROM session WHERE `SESSIONID`='".sqlcleaner($_REQUEST['auth'])."';");
	if (DEBUG) echo mysql_error();	
	if (mysql_num_rows($user_is_session_started)){
		$session_started = true;
	}else{
		$session_started = false;
	}

}


if (!$session_started){
	echo '({ "error":"error code = 300"})';
	exit(1);
}

?>

   
      ({
	      "cateogry":[{
	         "precision": "zip",
	         "Latitude":  37.7668,
	         "Longitude": -122.3959,
	         "Address":   "",
	         "City":      "SAN FRANCISCO",
	         "State":     "CA",
	         "Zip":       "94107",
	         "Country":   "US"
	      },
	      {
	         "precision": "zip",
	         "Latitude":  37.371991,
	         "Longitude": -122.026020,
	         "Address":   "",
	         "City":      "SUNNYVALE",
	         "State":     "CA",
	         "Zip":       "94085",
	         "Country":   "US"
	      }]
      })
